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
     * Tampilkan halaman checkout.
     */
    public function index()
    {
        $userId = Auth::id();
        $cartItems = Keranjang::where('user_id', $userId)->with('produk.user')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('produk.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $cart = [];
        $total = 0;

        foreach($cartItems as $item) {
            $cart[$item->produk_id] = [
                "nama" => $item->produk->nama_produk,
                "jumlah" => $item->jumlah,
                "harga" => $item->produk->harga,
                "foto" => $item->produk->foto_produk,
                "petani" => $item->produk->user->nama
            ];
            $total += $item->produk->harga * $item->jumlah;
        }

        $user = Auth::user();

        return view('checkout.index', [
            'cart' => $cart,
            'user' => $user,
            'total' => $total
        ]);
    }

    /**
     * Proses Checkout: MEMECAH Pesanan & GENERATE MIDTRANS TOKEN
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        
        // Ambil item keranjang beserta data produk dan pemiliknya
        $cartItems = Keranjang::where('user_id', $userId)->with('produk.user')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('produk.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $request->validate([
            'alamat_kirim' => 'required|string',
        ]);

        // Kelompokkan item berdasarkan Petani
        $groupedItems = $cartItems->groupBy(function ($item) {
            return $item->produk->user_id;
        });

        DB::beginTransaction();

        try {
            $createdOrders = [];

            // Loop setiap Petani untuk membuat Pesanan Terpisah
            foreach ($groupedItems as $petaniId => $items) {
                
                // 1. Hitung Total per Petani & Cek Stok
                $totalPerPetani = 0;
                foreach ($items as $item) {
                    // Cek Stok Sebelum Checkout
                    if ($item->produk->stok < $item->jumlah) {
                        DB::rollBack();
                        return redirect()->route('cart.index')
                            ->with('error', 'Stok untuk produk ' . $item->produk->nama_produk . ' tidak mencukupi!');
                    }
                    $totalPerPetani += $item->produk->harga * $item->jumlah;
                }

                // --- [PERBAIKAN] LOGIKA KOMISI (10%) ---
                $adminFee = $totalPerPetani * 0.10; 
                $sellerIncome = $totalPerPetani - $adminFee;

                // 2. Buat Data Pesanan
                $pesanan = new Pesanan();
                $pesanan->user_id = $userId;
                $pesanan->kode_pesanan = 'INV/' . date('Ymd') . '/' . strtoupper(Str::random(6));
                $pesanan->total_harga = $totalPerPetani;
                $pesanan->alamat_kirim = $request->alamat_kirim;
                
                // Simpan data komisi ke database
                $pesanan->admin_fee = $adminFee;       
                $pesanan->seller_income = $sellerIncome;
                
                $pesanan->status = 'pending';
                $pesanan->save(); 

                // 3. Simpan Detail Produk & POTONG STOK
                foreach ($items as $item) {
                    $detailPesanan = new DetailPesanan();
                    $detailPesanan->pesanan_id = $pesanan->id;
                    $detailPesanan->produk_id = $item->produk_id;
                    $detailPesanan->jumlah = $item->jumlah;
                    $detailPesanan->harga_satuan = $item->produk->harga;
                    $detailPesanan->save();

                    // [PENTING] Stok dipotong di sini (Booking Stok)
                    // Nanti dikembalikan di 'callback' atau 'cancelOrder' jika batal
                    $produk = Produk::find($item->produk_id);
                    $produk->stok = $produk->stok - $item->jumlah;
                    $produk->save();
                }

                // --- INTEGRASI MIDTRANS ---
                Config::$serverKey = config('services.midtrans.server_key');
                Config::$isProduction = config('services.midtrans.is_production', false); // Fix baca config
                Config::$isSanitized = true;
                Config::$is3ds = true;

                $params = [
                    'transaction_details' => [
                        'order_id' => $pesanan->id, // Gunakan ID Database (Integer) agar aman
                        'gross_amount' => (int) $totalPerPetani, // Pastikan Integer
                    ],
                    'customer_details' => [
                        'first_name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ],
                ];

                $snapToken = Snap::getSnapToken($params);
                $pesanan->snap_token = $snapToken;
                $pesanan->save();

                $createdOrders[] = $pesanan->kode_pesanan;
            }

            // 4. Hapus Keranjang setelah sukses
            Keranjang::where('user_id', $userId)->delete();

            DB::commit();

            return redirect()->route('konsumen.pesanan.index')
                             ->with('success', 'Berhasil! ' . count($createdOrders) . ' pesanan dibuat. Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')
                             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * [PERBAIKAN] LOGIKA UPDATE STATUS, ISI SALDO, & PENGEMBALIAN STOK
     */
    public function callback(Request $request)
    {
        $orderId = $request->query('order_id');

        if ($orderId) {
            // [PENTING] Load relasi detailPesanan & produk untuk pengembalian stok
            $pesanan = Pesanan::with('detailPesanan.produk')->find($orderId);

            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production', false);
            Config::$isSanitized = true;
            Config::$is3ds = true;

            try {
                // Cek status real-time ke server Midtrans
                $status = \Midtrans\Transaction::status($orderId);

                // === KONDISI 1: SUKSES BAYAR ===
                if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                    
                    if ($pesanan->status != 'paid') {
                        $pesanan->status = 'paid';
                        $pesanan->save();
                        
                        // Tambah Saldo Petani
                        $produkPertama = $pesanan->detailPesanan->first()->produk;
                        $petani = $produkPertama->user;
                        $petani->saldo += $pesanan->seller_income;
                        $petani->save();

                        return redirect()->route('konsumen.pesanan.show', $pesanan->id)
                            ->with('success', 'Pembayaran Berhasil! Pesanan diproses.');
                    }
                } 
                
                // === [BARU] KONDISI 2: GAGAL / EXPIRE / BATAL ===
                // Jika user tidak jadi bayar dan waktu habis, kembalikan stok
                else if ($status->transaction_status == 'cancel' || 
                         $status->transaction_status == 'deny' || 
                         $status->transaction_status == 'expire') {
                    
                    if ($pesanan->status != 'cancelled') {
                        
                        // LOGIKA PENGEMBALIAN STOK (RESTOCK)
                        foreach ($pesanan->detailPesanan as $detail) {
                            $produk = $detail->produk;
                            $produk->stok += $detail->jumlah; // Stok dikembalikan
                            $produk->save();
                        }

                        $pesanan->status = 'cancelled';
                        $pesanan->save();
                    }

                    return redirect()->route('konsumen.pesanan.index')
                        ->with('error', 'Pesanan dibatalkan/kadaluarsa. Stok telah dikembalikan.');
                }
                
                // === KONDISI 3: PENDING ===
                else if ($status->transaction_status == 'pending') {
                     return redirect()->route('konsumen.pesanan.show', $pesanan->id)
                        ->with('warning', 'Pembayaran masih diproses. Silakan refresh nanti.');
                }

            } catch (\Exception $e) {
                return redirect()->route('konsumen.pesanan.show', $pesanan->id)
                    ->with('error', 'Gagal verifikasi pembayaran. Coba lagi nanti.');
            }
        }
        
        return redirect()->route('konsumen.pesanan.index');
    }

    /**
     * [BARU] FUNCTION BATALKAN PESANAN MANUAL (SECURITY LAYERED)
     */
    public function cancelOrder($id)
    {
        // Cari pesanan milik user yang login
        $pesanan = Pesanan::with('detailPesanan.produk')
                    ->where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        // [SECURITY] Hanya boleh batal jika status masih PENDING
        if ($pesanan->status == 'pending') {
            
            DB::beginTransaction();
            try {
                // 1. KEMBALIKAN STOK
                foreach ($pesanan->detailPesanan as $detail) {
                    $produk = $detail->produk;
                    $produk->stok += $detail->jumlah;
                    $produk->save();
                }

                // 2. Ubah Status
                $pesanan->status = 'cancelled';
                $pesanan->save();

                DB::commit();

                return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan. Stok produk telah dikembalikan.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Gagal membatalkan pesanan.');
            }
        }

        return redirect()->back()->with('error', 'Pesanan sudah diproses, tidak dapat dibatalkan.');
    }
}   