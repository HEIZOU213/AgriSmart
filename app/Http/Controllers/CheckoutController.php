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

        // 1. Ambil ID Keranjang yang dipilih dari form Cart (checkbox name="selected[]")
        $selectedCartIds = $request->input('selected', []);

        // Validasi: Jika tidak ada item yang dipilih, kembalikan ke keranjang
        if (empty($selectedCartIds)) {
            return redirect()->route('cart.index')->with('error', 'Silakan pilih produk yang ingin dibeli terlebih dahulu.');
        }

        // 2. Ambil Data Keranjang berdasarkan ID yang dipilih saja
        $cartItems = Keranjang::where('user_id', $userId)
            ->whereIn('id', $selectedCartIds) // Filter berdasarkan checkbox
            ->with('produk.user')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Produk yang dipilih tidak ditemukan.');
        }

        // 3. Siapkan data untuk View Checkout
        $cart = [];
        $total = 0;

        foreach ($cartItems as $item) {
            // Validasi Stok Real-time (Mencegah checkout jika stok habis saat itu juga)
            if ($item->jumlah > $item->produk->stok) {
                return redirect()->route('cart.index')
                    ->with('error', "Stok untuk produk {$item->produk->nama_produk} tidak mencukupi.");
            }

            $cart[] = [
                "id" => $item->id, // ID Keranjang (Penting untuk dilempar ke Store)
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

        $user = Auth::user();

        // Kirim $selectedCartIds string agar bisa dimasukkan ke input hidden di view checkout
        return view('checkout.index', [
            'cart' => $cart,
            'user' => $user,
            'total' => $total,
            'selectedCartIds' => $selectedCartIds // Kirim ini ke view untuk diproses di store()
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
            'selected_cart_ids' => 'required|array', // Pastikan view checkout mengirim array ini
            'selected_cart_ids.*' => 'exists:keranjangs,id'
        ]);

        // 1. Ambil item keranjang HANYA yang dipilih user di halaman sebelumnya
        $selectedIds = $request->input('selected_cart_ids');

        $cartItems = Keranjang::where('user_id', $userId)
            ->whereIn('id', $selectedIds)
            ->with('produk.user')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada produk yang diproses.');
        }

        // 2. Kelompokkan item berdasarkan Petani (User ID pemilik produk)
        $groupedItems = $cartItems->groupBy(function ($item) {
            return $item->produk->user_id;
        });

        DB::beginTransaction();

        try {
            $createdOrders = [];

            // Loop setiap Petani untuk membuat Pesanan Terpisah
            foreach ($groupedItems as $petaniId => $items) {

                // A. Hitung Total per Petani & Cek Stok
                $totalPerPetani = 0;
                foreach ($items as $item) {
                    // Cek Stok Terakhir (Concurrency check)
                    if ($item->produk->stok < $item->jumlah) {
                        DB::rollBack();
                        return redirect()->route('cart.index')
                            ->with('error', 'Stok untuk produk ' . $item->produk->nama_produk . ' sudah habis terjual oleh orang lain!');
                    }
                    $totalPerPetani += $item->produk->harga * $item->jumlah;
                }

                // --- LOGIKA KOMISI (10%) ---
                $adminFee = $totalPerPetani * 0.10;
                $sellerIncome = $totalPerPetani - $adminFee;

                // B. Buat Data Pesanan Master
                $pesanan = new Pesanan();
                $pesanan->user_id = $userId;
                // Generate Kode Unik: INV/YYYYMMDD/RANDOM
                $pesanan->kode_pesanan = 'INV/' . date('Ymd') . '/' . strtoupper(Str::random(6));
                $pesanan->total_harga = $totalPerPetani;
                $pesanan->alamat_kirim = $request->alamat_kirim;

                // Simpan data komisi
                $pesanan->admin_fee = $adminFee;
                $pesanan->seller_income = $sellerIncome;

                $pesanan->status = 'pending';
                $pesanan->save();

                // C. Simpan Detail Produk & POTONG STOK
                foreach ($items as $item) {
                    $detailPesanan = new DetailPesanan();
                    $detailPesanan->pesanan_id = $pesanan->id;
                    $detailPesanan->produk_id = $item->produk_id;
                    $detailPesanan->jumlah = $item->jumlah;
                    $detailPesanan->harga_satuan = $item->produk->harga;
                    $detailPesanan->save();

                    // [PENTING] Stok dipotong di sini (Booking Stok)
                    $produk = Produk::find($item->produk_id);
                    $produk->decrement('stok', $item->jumlah);
                }

                // --- INTEGRASI MIDTRANS ---
                // Setup Konfigurasi Midtrans
                Config::$serverKey = config('services.midtrans.server_key');
                Config::$isProduction = config('services.midtrans.is_production', false);
                Config::$isSanitized = true;
                Config::$is3ds = true;

                $params = [
                    'transaction_details' => [
                        'order_id' => $pesanan->kode_pesanan, // Gunakan string INV/...
                        'gross_amount' => (int) $totalPerPetani,
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
                    // Jika Midtrans gagal, kita tetap buat order tapi tanpa token (bisa retry nanti)
                    // Atau rollback jika token wajib ada
                }

                $createdOrders[] = $pesanan->kode_pesanan;
            }

            // 3. Hapus Item dari Keranjang (Hanya yang dipilih)
            Keranjang::where('user_id', $userId)
                ->whereIn('id', $selectedIds)
                ->delete();

            DB::commit();

            return redirect()->route('konsumen.pesanan.index')
                ->with('success', 'Berhasil! ' . count($createdOrders) . ' pesanan dibuat. Silakan lakukan pembayaran pada masing-masing pesanan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index') // Redirect ke cart jika gagal
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Callback dari Midtrans (Webhook)
     */
    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $orderId = $request->order_id; // Format: INV/...

            $pesanan = Pesanan::with('detailPesanan.produk')
                ->where('kode_pesanan', $orderId)
                ->first();

            if (!$pesanan)
                return response()->json(['message' => 'Order not found'], 404);

            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                if ($pesanan->status != 'paid') {
                    $pesanan->update(['status' => 'paid']);

                    // Tambah Saldo Petani (Penjual)
                    // Asumsi 1 pesanan hanya milik 1 petani (sesuai logika store)
                    $produkPertama = $pesanan->detailPesanan->first()->produk;
                    if ($produkPertama && $produkPertama->user) {
                        $petani = $produkPertama->user;
                        $petani->increment('saldo', $pesanan->seller_income);
                    }
                }
            } elseif ($request->transaction_status == 'expire' || $request->transaction_status == 'cancel' || $request->transaction_status == 'deny') {
                if ($pesanan->status != 'cancelled') {
                    // Pengembalian Stok (Restock)
                    foreach ($pesanan->detailPesanan as $detail) {
                        $produk = $detail->produk;
                        $produk->increment('stok', $detail->jumlah);
                    }
                    $pesanan->update(['status' => 'cancelled']);
                }
            }

            return response()->json(['message' => 'Callback processed']);
        }

        return response()->json(['message' => 'Invalid signature'], 400);
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
                // Kembalikan Stok
                foreach ($pesanan->detailPesanan as $detail) {
                    $detail->produk->increment('stok', $detail->jumlah);
                }

                $pesanan->status = 'cancelled';
                $pesanan->save();

                DB::commit();
                return redirect()->back()->with('success', 'Pesanan dibatalkan. Stok dikembalikan.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Gagal membatalkan pesanan.');
            }
        }

        return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan.');
    }

    // ================= API SECTION (Mobile) =================

    public function apiProcess(Request $request)
    {
        // ... (Biarkan sama seperti sebelumnya atau sesuaikan jika Mobile juga butuh partial checkout)
        // Jika mobile juga butuh partial checkout, tambahkan parameter 'selected_cart_ids' di sini

        $request->validate([
            'alamat_pengiriman' => 'required|string',
        ]);

        $user = Auth::user();

        // Logika sederhana: ambil semua keranjang (default behavior mobile app)
        $carts = Keranjang::with('produk')->where('user_id', $user->id)->get();

        if ($carts->isEmpty()) {
            return response()->json(['message' => 'Keranjang kosong'], 400);
        }

        // ... Sisa logika API sama dengan sebelumnya ...
        // (Pastikan menggunakan DB Transaction seperti di method store)

        // Contoh singkat:
        $totalHarga = 0;
        foreach ($carts as $cart)
            $totalHarga += $cart->produk->harga * $cart->jumlah;

        $order = Pesanan::create([
            'user_id' => $user->id,
            'kode_pesanan' => 'INV/' . date('Ymd') . '/' . strtoupper(Str::random(6)),
            'alamat_kirim' => $request->alamat_pengiriman,
            'status' => 'pending',
            'total_harga' => $totalHarga,
        ]);

        // Pindahkan ke detail & hapus keranjang...
        // ...

        return response()->json(['success' => true, 'data' => $order]);
    }
}