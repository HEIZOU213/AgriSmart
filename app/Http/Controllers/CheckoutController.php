<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Keranjang; // [PENTING] Gunakan Model Keranjang
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout.
     */
    public function index()
    {
        // [FIX] Ambil keranjang dari DATABASE, bukan Session
        $userId = Auth::id();
        $cartItems = Keranjang::where('user_id', $userId)->with('produk')->get();

        // Konversi format agar sesuai dengan tampilan view
        $cart = [];
        $total = 0;

        foreach($cartItems as $item) {
            $cart[$item->produk_id] = [
                "nama" => $item->produk->nama_produk,
                "jumlah" => $item->jumlah,
                "harga" => $item->produk->harga,
                "foto" => $item->produk->foto_produk
            ];
            $total += $item->produk->harga * $item->jumlah;
        }

        // [FIX] Cek apakah hasil query database kosong
        if (empty($cart)) {
            return redirect()->route('produk.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Ambil data user untuk alamat
        $user = Auth::user();

        return view('checkout.index', [
            'cart' => $cart,
            'user' => $user,
            'total' => $total
        ]);
    }

    /**
     * Proses dan simpan pesanan ke database.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        
        // [FIX] Ambil data dari Database lagi untuk validasi akhir
        $cartItems = Keranjang::where('user_id', $userId)->with('produk')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('produk.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $request->validate([
            'alamat_kirim' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            // --- Langkah A: Hitung Total & Cek Stok ---
            $totalHarga = 0;
            foreach ($cartItems as $item) {
                if ($item->produk->stok < $item->jumlah) {
                    DB::rollBack();
                    return redirect()->route('cart.index')
                                     ->with('error', 'Stok untuk produk ' . $item->produk->nama_produk . ' tidak mencukupi!');
                }
                $totalHarga += $item->produk->harga * $item->jumlah;
            }

            // --- Langkah B: Buat Pesanan ---
            $pesanan = new Pesanan();
            $pesanan->user_id = $userId;
            $pesanan->kode_pesanan = 'INV/' . date('Ymd') . '/' . strtoupper(Str::random(6));
            $pesanan->total_harga = $totalHarga;
            $pesanan->alamat_kirim = $request->alamat_kirim;
            $pesanan->status = 'pending';
            $pesanan->save();

            // --- Langkah C: Simpan Detail & Kurangi Stok ---
            foreach ($cartItems as $item) {
                // Simpan ke detail_pesanan
                $detailPesanan = new DetailPesanan();
                $detailPesanan->pesanan_id = $pesanan->id;
                $detailPesanan->produk_id = $item->produk_id;
                $detailPesanan->jumlah = $item->jumlah;
                $detailPesanan->harga_satuan = $item->produk->harga;
                $detailPesanan->save();

                // Kurangi stok produk
                $produk = Produk::find($item->produk_id);
                $produk->stok = $produk->stok - $item->jumlah;
                $produk->save();
            }

            // --- Langkah D: Hapus Keranjang dari DATABASE ---
            Keranjang::where('user_id', $userId)->delete(); // [FIX] Hapus dari DB

            DB::commit();

            return redirect()->route('konsumen.pesanan.index')
                             ->with('success', 'Pesanan Anda dengan kode ' . $pesanan->kode_pesanan . ' telah berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')
                             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}