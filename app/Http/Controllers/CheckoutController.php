<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk user login
use Illuminate\Support\Facades\DB; // Untuk Database Transaction
use Illuminate\Support\Str; // Untuk membuat kode pesanan

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout.
     * Halaman ini hanya bisa diakses jika user sudah login.
     */
    public function index()
    {
        // 1. Ambil keranjang dari session
        $cart = session()->get('cart', []);

        // 2. Jika keranjang kosong, kembalikan ke halaman produk
        if (empty($cart)) {
            return redirect()->route('produk.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // 3. Ambil data user yang sedang login (untuk alamat)
        $user = Auth::user();

        // 4. Hitung total
        $total = 0;
        foreach ($cart as $detail) {
            $total += $detail['harga'] * $detail['jumlah'];
        }

        // 5. Tampilkan view checkout
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
        // 1. Ambil keranjang dari session
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('produk.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // 2. Ambil user yang login
        $user = Auth::user();

        // 3. Validasi input (jika ada alamat baru, dll)
        $request->validate([
            // (Kita asumsikan alamat diambil dari profil user)
            'alamat_kirim' => 'required|string',
        ]);

        // Mulai Database Transaction
        DB::beginTransaction();

        try {
            // --- Langkah A: Cek Stok Produk ---
            $totalHarga = 0;
            foreach ($cart as $id => $detail) {
                $produk = Produk::find($id);
                // Cek apakah stok masih mencukupi
                if ($produk->stok < $detail['jumlah']) {
                    // Jika stok tidak cukup, batalkan transaksi
                    DB::rollBack();
                    return redirect()->route('cart.index')
                                     ->with('error', 'Stok untuk produk ' . $produk->nama_produk . ' tidak mencukupi!');
                }
                $totalHarga += $detail['harga'] * $detail['jumlah'];
            }

            // --- Langkah B: Buat data di tabel 'pesanan' ---
            $pesanan = new Pesanan();
            $pesanan->user_id = $user->id;
            $pesanan->kode_pesanan = 'INV/' . date('Ymd') . '/' . strtoupper(Str::random(6));
            $pesanan->total_harga = $totalHarga; // (Belum termasuk ongkir, dll)
            $pesanan->alamat_kirim = $request->alamat_kirim; // Alamat dari form
            $pesanan->status = 'pending'; // Status awal
            $pesanan->save();

            // --- Langkah C: Buat data di 'detail_pesanan' dan kurangi stok ---
            foreach ($cart as $id => $detail) {
                // 1. Simpan ke detail_pesanan
                $detailPesanan = new DetailPesanan();
                $detailPesanan->pesanan_id = $pesanan->id; // ID dari pesanan yang baru dibuat
                $detailPesanan->produk_id = $id;
                $detailPesanan->jumlah = $detail['jumlah'];
                $detailPesanan->harga_satuan = $detail['harga'];
                $detailPesanan->save();

                // 2. Kurangi stok produk
                $produk = Produk::find($id);
                $produk->stok = $produk->stok - $detail['jumlah'];
                $produk->save();
            }

            // --- Langkah D: Jika semua berhasil, 'commit' transaksi ---
            DB::commit();

            // --- Langkah E: Hapus keranjang dari session ---
            session()->forget('cart');

            // --- Langkah F: Redirect ke halaman riwayat pesanan ---
            return redirect()->route('konsumen.pesanan.index')
                             ->with('success', 'Pesanan Anda dengan kode ' . $pesanan->kode_pesanan . ' telah berhasil dibuat!');

        } catch (\Exception $e) {
            // --- Langkah G: Jika terjadi error, 'rollback' semua perubahan ---
            DB::rollBack();
            
            // Tampilkan pesan error
            return redirect()->route('checkout.index')
                             ->with('error', 'Terjadi kesalahan saat memproses pesanan Anda. Silakan coba lagi.' . $e->getMessage());
        }
    }
}
