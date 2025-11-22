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

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout.
     */
    public function index()
    {
        $userId = Auth::id();
        $cartItems = Keranjang::where('user_id', $userId)->with('produk.user')->get(); // Eager load produk & pemiliknya

        if ($cartItems->isEmpty()) {
            return redirect()->route('produk.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Hitung total estimasi (semua toko)
        $cart = [];
        $total = 0;

        foreach($cartItems as $item) {
            $cart[$item->produk_id] = [
                "nama" => $item->produk->nama_produk,
                "jumlah" => $item->jumlah,
                "harga" => $item->produk->harga,
                "foto" => $item->produk->foto_produk,
                "petani" => $item->produk->user->nama // Nama Toko/Petani
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
     * Proses Checkout: MEMECAH Pesanan Berdasarkan Petani (Seperti Shopee).
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        
        // Ambil item keranjang beserta data produk dan pemiliknya (petani)
        $cartItems = Keranjang::where('user_id', $userId)->with('produk.user')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('produk.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $request->validate([
            'alamat_kirim' => 'required|string',
        ]);

        // [LOGIKA BARU] Kelompokkan item berdasarkan Petani (user_id pemilik produk)
        $groupedItems = $cartItems->groupBy(function ($item) {
            return $item->produk->user_id;
        });

        DB::beginTransaction();

        try {
            $createdOrders = [];

            // Loop setiap Petani (Toko) untuk membuat Pesanan Terpisah
            foreach ($groupedItems as $petaniId => $items) {
                
                // 1. Hitung Total per Petani & Cek Stok
                $totalPerPetani = 0;
                foreach ($items as $item) {
                    if ($item->produk->stok < $item->jumlah) {
                        DB::rollBack();
                        return redirect()->route('cart.index')
                                         ->with('error', 'Stok untuk produk ' . $item->produk->nama_produk . ' tidak mencukupi!');
                    }
                    $totalPerPetani += $item->produk->harga * $item->jumlah;
                }

                // 2. Buat SATU Pesanan untuk Petani ini
                $pesanan = new Pesanan();
                $pesanan->user_id = $userId;
                // Kode pesanan unik (tambah random string agar tidak bentrok)
                $pesanan->kode_pesanan = 'INV/' . date('Ymd') . '/' . strtoupper(Str::random(6));
                $pesanan->total_harga = $totalPerPetani;
                $pesanan->alamat_kirim = $request->alamat_kirim;
                $pesanan->status = 'pending';
                $pesanan->save();

                $createdOrders[] = $pesanan->kode_pesanan;

                // 3. Simpan Detail Produk untuk Pesanan ini
                foreach ($items as $item) {
                    $detailPesanan = new DetailPesanan();
                    $detailPesanan->pesanan_id = $pesanan->id;
                    $detailPesanan->produk_id = $item->produk_id;
                    $detailPesanan->jumlah = $item->jumlah;
                    $detailPesanan->harga_satuan = $item->produk->harga;
                    $detailPesanan->save();

                    // Kurangi stok
                    $produk = Produk::find($item->produk_id);
                    $produk->stok = $produk->stok - $item->jumlah;
                    $produk->save();
                }
            }

            // 4. Hapus Keranjang setelah semua sukses
            Keranjang::where('user_id', $userId)->delete();

            DB::commit();

            return redirect()->route('konsumen.pesanan.index')
                             ->with('success', 'Berhasil! ' . count($createdOrders) . ' pesanan telah dibuat (dipisahkan per Petani).');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')
                             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}