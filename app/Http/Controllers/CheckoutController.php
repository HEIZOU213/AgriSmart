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
                $pesanan->kode_pesanan = 'INV/' . date('Ymd') . '/' . strtoupper(Str::random(6));
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

                $pesanan->snap_token = Snap::getSnapToken($params);
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

        if ($hashed !== $request->signature_key) {
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
     * Batalkan Pesanan Manual oleh User
     */
    public function cancelOrder($id)
    {
        $pesanan = Pesanan::with('detailPesanan.produk')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($pesanan->status == 'pending') {
            DB::beginTransaction();
            try {
                foreach ($pesanan->detailPesanan as $detail) {
                    $detail->produk->increment('stok', $detail->jumlah);
                }
                $pesanan->status = 'cancelled';
                $pesanan->save();
                DB::commit();
                return redirect()->back()->with('success', 'Pesanan dibatalkan.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Gagal membatalkan pesanan.');
            }
        }
        return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan.');
    }
    
     // ================= API SECTION (Mobile & IoT) =================

    public function apiProcess(Request $request)
    {
        // Validasi Input API
        $request->validate([
            'alamat_pengiriman' => 'required|string',
            // 'catatan' => 'nullable|string', 
        ]);

        $userId = Auth::id();

        // 2. Ambil Data Keranjang
        // PENTING: Load relasi 'produk.user' untuk grouping berdasarkan petani
        // Untuk Mobile App, saat ini kita anggap Checkout All (semua cart)
        $cartItems = Keranjang::where('user_id', $userId)->with('produk.user')->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Keranjang kosong'], 400);
        }

        // 3. GROUPING: Pisahkan item berdasarkan ID Petani (User ID pemilik produk)
        // Ini agar jika beli dari 2 petani, jadi 2 Pesanan berbeda.
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

            // Loop setiap kelompok petani
            foreach ($groupedItems as $petaniId => $items) {
                
                // A. Hitung Total per Petani & Cek Stok
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
                
                $adminFee = $totalPerPetani * 0.10; // 10% Fee
                $sellerIncome = $totalPerPetani - $adminFee;

                // B. Buat Order Baru (Satu Order per Petani)
                $pesanan = Pesanan::create([
                    'user_id' => $userId,
                    'kode_pesanan' => 'INV/' . date('Ymd') . '/' . strtoupper(Str::random(6)),
                    'alamat_kirim' => $request->alamat_pengiriman,
                    'status' => 'pending',
                    'total_harga' => $grandTotal,
                    'admin_fee' => $adminFee,       // Simpan fee
                    'seller_income' => $sellerIncome, // Simpan pendapatan bersih petani
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
                    $produk->decrement('stok', $item->jumlah);
                }

                // D. Generate Midtrans Token untuk Pesanan Ini
                $params = [
                    'transaction_details' => [
                        'order_id' => $pesanan->kode_pesanan, // PENTING: Gunakan kode_pesanan (INV/..) bukan ID agar konsisten dengan Callback
                        'gross_amount' => (int) $grandTotal, // Wajib Integer
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
                    // Jika gagal connect ke Midtrans, biarkan null dulu atau handle error
                }

                $createdOrders[] = $pesanan;
            }

            // E. Hapus Keranjang setelah semua berhasil
            Keranjang::where('user_id', $userId)->delete();

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
}