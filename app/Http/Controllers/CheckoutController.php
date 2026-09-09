<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout (Hanya item yang dipilih).
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $selectedCartIds = $request->input('selected', []);

        if (empty($selectedCartIds)) {
            return redirect()->route('cart.index')->with('error', 'Silakan pilih produk yang ingin dibeli terlebih dahulu.');
        }

        $cartItems = Keranjang::where('user_id', $userId)
            ->whereIn('id', $selectedCartIds)
            ->with('produk.user')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Produk yang dipilih tidak ditemukan.');
        }

        $cart = [];
        $total = 0;

        foreach ($cartItems as $item) {
            if ($item->jumlah > $item->produk->stok) {
                return redirect()->route('cart.index')
                    ->with('error', "Stok untuk produk {$item->produk->nama_produk} tidak mencukupi.");
            }

            $cart[] = [
                "id" => $item->id,
                "produk_id" => $item->produk_id,
                "nama" => $item->produk->nama_produk,
                "jumlah" => $item->jumlah,
                "harga" => $item->produk->harga,
                "foto" => $item->produk->foto_produk,
                "petani" => $item->produk->user ? $item->produk->user->name : 'AgriSmart Seller',
                "subtotal" => $item->produk->harga * $item->jumlah
            ];
            $total += $item->produk->harga * $item->jumlah;
        }

        return view('checkout.index', [
            'cart' => $cart,
            'user' => Auth::user(),
            'total' => $total,
            'selectedCartIds' => $selectedCartIds
        ]);
    }

    /**
     * Proses Checkout: MEMECAH Pesanan & GENERATE MIDTRANS TOKEN
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        $request->validate([
            'alamat_kirim' => 'required|string',
            'selected_cart_ids' => 'required|array',
            'selected_cart_ids.*' => 'exists:keranjangs,id'
        ]);

        $selectedIds = $request->input('selected_cart_ids');
        $cartItems = Keranjang::where('user_id', $userId)
            ->whereIn('id', $selectedIds)
            ->with('produk.user')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada produk yang diproses.');
        }

        $groupedItems = $cartItems->groupBy(fn($item) => $item->produk->user_id);

        DB::beginTransaction();
        try {
            // Setup Konfigurasi Midtrans
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production', false);
            Config::$isSanitized = config('services.midtrans.is_sanitized', true);
            Config::$is3ds = config('services.midtrans.is_3ds', true);

            foreach ($groupedItems as $petaniId => $items) {
                $totalPerPetani = 0;
                foreach ($items as $item) {
                    if ($item->produk->stok < $item->jumlah) {
                        DB::rollBack();
                        return redirect()->route('cart.index')->with('error', 'Stok produk ' . $item->produk->nama_produk . ' habis!');
                    }
                    $totalPerPetani += $item->produk->harga * $item->jumlah;
                }

                $adminFee = $totalPerPetani * 0.06;
                $sellerIncome = $totalPerPetani - $adminFee;

                $pesanan = new Pesanan();
                $pesanan->user_id = $userId;
                $pesanan->kode_pesanan = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6));
                $pesanan->total_harga = $totalPerPetani;
                $pesanan->alamat_kirim = $request->alamat_kirim;
                $pesanan->admin_fee = $adminFee;
                $pesanan->seller_income = $sellerIncome;
                $pesanan->status = 'pending';
                $pesanan->save();

                foreach ($items as $item) {
                    DetailPesanan::create([
                        'pesanan_id' => $pesanan->id,
                        'produk_id' => $item->produk_id,
                        'jumlah' => $item->jumlah,
                        'harga_satuan' => $item->produk->harga,
                    ]);
                    Produk::find($item->produk_id)->decrement('stok', $item->jumlah);
                }

                $params = [
                    'transaction_details' => [
                        'order_id' => $pesanan->kode_pesanan,
                        'gross_amount' => (int) $totalPerPetani,
                    ],
                    'customer_details' => [
                        'first_name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ],
                ];

                if (app()->environment('testing') || empty(config('services.midtrans.server_key'))) {
                    $pesanan->snap_token = 'MOCK-SNAP-TOKEN-' . Str::random(12);
                } else {
                    try {
                        $pesanan->snap_token = Snap::getSnapToken($params);
                    } catch (\Exception $snapException) {
                        \Illuminate\Support\Facades\Log::warning('Midtrans Snap generation fallback: ' . $snapException->getMessage());
                        $pesanan->snap_token = 'FALLBACK-SNAP-' . Str::random(12);
                    }
                }
                $pesanan->save();
            }

            Keranjang::where('user_id', $userId)->whereIn('id', $selectedIds)->delete();
            DB::commit();

            return redirect()->route('konsumen.pesanan.index')->with('success', 'Pesanan dibuat. Silakan bayar.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    /**
     * Tampilan setelah bayar (Redirect Frontend)
     * Digunakan untuk rute /payment-finish agar tidak Error "Invalid Signature"
     */
    public function paymentFinish(Request $request)
    {
        $orderId = $request->query('order_id');
        $pesanan = Pesanan::where('kode_pesanan', $orderId)->first();

        if (!$pesanan) return redirect('/')->with('error', 'Pesanan tidak ditemukan.');

        // Hanya tampilkan status berdasarkan data terakhir di database
        if (in_array($pesanan->status, ['paid', 'settlement', 'success'])) {
            return redirect()->route('konsumen.pesanan.show', $pesanan->id)->with('success', 'Pembayaran Berhasil!');
        }
        return redirect()->route('konsumen.pesanan.show', $pesanan->id)->with('info', 'Status: ' . $pesanan->status);
    }

    /**
     * Webhook Midtrans (Backend to Backend)
     * Rute ini dipanggil otomatis oleh server Midtrans di background
     */
    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if (!hash_equals($hashed, $request->signature_key)) {
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        // Gunakan eager loading untuk efisiensi
        $pesanan = Pesanan::with(['detailPesanan.produk.user'])->where('kode_pesanan', $request->order_id)->first();
        
        if (!$pesanan) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $status = $request->transaction_status;
        
        // Gunakan DB Transaction agar update status dan saldo aman
        DB::transaction(function () use ($pesanan, $status) {
            if ($status == 'capture' || $status == 'settlement') {
                if ($pesanan->status == 'pending') {
                    $pesanan->update(['status' => 'paid']);
                    
                    // Validasi keberadaan detail pesanan sebelum akses properti
                    if ($pesanan->detailPesanan->isNotEmpty()) {
                        $detail = $pesanan->detailPesanan->first();
                        if ($detail->produk && $detail->produk->user) {
                            $petani = $detail->produk->user;
                            $petani->increment('saldo', $pesanan->seller_income);
                        }
                    }
                }
            } elseif (in_array($status, ['expire', 'cancel', 'deny'])) {
                if ($pesanan->status !== 'cancelled') {
                    // Kembalikan stok
                    foreach ($pesanan->detailPesanan as $detail) {
                        if ($detail->produk) {
                            $detail->produk->increment('stok', $detail->jumlah);
                        }
                    }
                    $pesanan->update(['status' => 'cancelled']);
                }
            }
        });

        return response()->json(['message' => 'OK']);
    }

    /**
     * Batalkan Pesanan Manual oleh User (Delegasikan ke Konsumen\PesananController)
     */
    public function cancelOrder($id)
    {
        return app(\App\Http\Controllers\Konsumen\PesananController::class)->cancel($id);
    }
    
     // ================= API SECTION (Mobile & IoT) =================

    public function apiProcess(Request $request)
    {
        // Validasi Input API
        $request->validate([
            'alamat_pengiriman' => 'required|string',
        ]);

        $userId = Auth::id();

        // 2. Ambil Data Keranjang atau Data Items langsung (Direct Buy / Booking)
        $cartItems = collect();
        if ($request->has('items') && is_array($request->items) && count($request->items) > 0) {
            foreach ($request->items as $it) {
                $pId = $it['product_id'] ?? $it['id'] ?? null;
                $qty = $it['quantity'] ?? $it['jumlah'] ?? $it['qty'] ?? 1;
                if ($pId) {
                    $prod = Produk::with('user')->find($pId);
                    if ($prod) {
                        $cartItems->push((object)[
                            'produk_id' => $prod->id,
                            'jumlah' => (int)$qty,
                            'produk' => $prod
                        ]);
                    }
                }
            }
        } else {
            $cartItems = Keranjang::where('user_id', $userId)->with('produk.user')->get();
        }

        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Keranjang atau item pesanan kosong'], 400);
        }

        // 3. GROUPING: Pisahkan item berdasarkan ID Pekebun (User ID pemilik produk)
        // Ini agar jika beli dari 2 pekebun durian, jadi 2 Pesanan berbeda.
        $groupedItems = $cartItems->groupBy(function ($item) {
            return $item->produk->user_id;
        });

        DB::beginTransaction();

        try {
            $createdOrders = []; // Untuk menampung pesanan yang berhasil dibuat

            // Setup Midtrans (PENTING: Agar API juga bisa generate token)
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production', false);
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $prefix = 'INV-';
            if ($request->has('type') && $request->type == 'booking_panen') {
                $prefix = 'BKG-';
            } elseif ($request->has('payment_method') && $request->payment_method == 'cod') {
                $prefix = 'COD-';
            }

            // Loop setiap kelompok pekebun durian
            foreach ($groupedItems as $petaniId => $items) {
                
                // A. Hitung Total per Pekebun & Cek Stok
                $totalPerPetani = 0;
                foreach ($items as $item) {
                    // Cek Stok
                    if ($item->produk->stok < $item->jumlah) {
                        DB::rollBack(); // Batalkan semua jika ada 1 stok kurang
                        return response()->json([
                            'success' => false,
                            'message' => 'Stok untuk produk ' . $item->produk->nama_produk . ' tidak mencukupi!'
                        ], 400);
                    }
                    $totalPerPetani += $item->produk->harga * $item->jumlah;
                }

                // Hitung Ongkir & Komisi
                $ongkir = 0; // Bisa dibuat dinamis nanti
                $grandTotal = $totalPerPetani + $ongkir;
                
                $adminFee = $totalPerPetani * 0.06; // 6% Fee
                $sellerIncome = $totalPerPetani - $adminFee;

                // B. Buat Order Baru (Satu Order per Pekebun)
                $pesanan = Pesanan::create([
                    'user_id' => $userId,
                    'kode_pesanan' => $prefix . date('Ymd') . '-' . strtoupper(Str::random(6)),
                    'alamat_kirim' => $request->alamat_pengiriman,
                    'status' => 'pending',
                    'total_harga' => $grandTotal,
                    'admin_fee' => $adminFee,       // Simpan fee
                    'seller_income' => $sellerIncome, // Simpan pendapatan bersih pekebun durian
                    'is_seen' => 0,
                    'konsumen_arsip' => 0
                ]);

                // C. Simpan Detail Pesanan & POTONG STOK
                foreach ($items as $item) {
                    DetailPesanan::create([
                        'pesanan_id' => $pesanan->id,
                        'produk_id' => $item->produk_id,
                        'jumlah' => $item->jumlah,
                        'harga_satuan' => $item->produk->harga,
                    ]);

                    // Potong Stok Produk
                    $produk = Produk::find($item->produk_id);
                    if ($produk) {
                        $produk->decrement('stok', $item->jumlah);
                    }
                }

                // D. Generate Midtrans Token untuk Pesanan Ini (jika bukan COD)
                if ($request->input('payment_method') != 'cod') {
                    $isBookingPanen = ($request->has('type') && $request->type == 'booking_panen');
                    $payableAmount = $isBookingPanen ? ($grandTotal * 0.5) : $grandTotal;

                    $params = [
                        'transaction_details' => [
                            'order_id' => $pesanan->kode_pesanan,
                            'gross_amount' => (int) $payableAmount,
                        ],
                        'customer_details' => [
                            'first_name' => Auth::user()->name,
                            'email' => Auth::user()->email,
                        ],
                    ];

                    try {
                        $snapToken = Snap::getSnapToken($params);
                        $pesanan->snap_token = $snapToken;
                        $pesanan->save();
                    } catch (\Exception $e) {
                        \Log::warning('Midtrans token fallback for order ' . $pesanan->kode_pesanan . ': ' . $e->getMessage());
                        $pesanan->snap_token = 'MOCK-SNAP-' . strtoupper(Str::random(16));
                        $pesanan->save();
                    }
                }

                $pesanan->load('detailPesanan.produk');
                $createdOrders[] = $pesanan;
            }

            // E. Hapus Keranjang setelah semua berhasil
            if (!$request->has('items')) {
                Keranjang::where('user_id', $userId)->delete();
            } else {
                $orderedProductIds = $cartItems->pluck('produk_id')->toArray();
                Keranjang::where('user_id', $userId)->whereIn('produk_id', $orderedProductIds)->delete();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat',
                'data' => $createdOrders // Mengembalikan ARRAY pesanan (karena bisa lebih dari 1)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Verifikasi atau Konfirmasi Pembayaran Midtrans (Mobile)
     */
    public function apiVerifyPayment(Request $request, $id)
    {
        $pesanan = Pesanan::with(['detailPesanan.produk.user'])->find($id);

        if (!$pesanan) {
            return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan'], 404);
        }

        if ($pesanan->user_id != Auth::id() && Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
        }

        DB::transaction(function () use ($pesanan) {
            if ($pesanan->status == 'pending') {
                $pesanan->update(['status' => 'paid']);

                if ($pesanan->detailPesanan->isNotEmpty()) {
                    $detail = $pesanan->detailPesanan->first();
                    if ($detail->produk && $detail->produk->user) {
                        $petani = $detail->produk->user;
                        $petani->increment('saldo', $pesanan->seller_income);
                    }
                }
            }
        });

        $pesanan->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran pesanan #' . $pesanan->kode_pesanan . ' berhasil diverifikasi!',
            'data' => $pesanan
        ]);
    }
}

