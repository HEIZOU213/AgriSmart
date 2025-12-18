<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk; // Pastikan model ini di-import
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Menampilkan halaman daftar semua produk (marketplace) dengan fitur pencarian dan filter lengkap.
     */
    public function index(Request $request)
    {
        // Query dasar dengan Eager Loading agar performa lebih cepat
        $query = Produk::with(['user', 'kategoriProduk']);

        // 1. Filter Pencarian (Nama Produk atau Nama Penjual)
        if ($request->has('q') && $request->q) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_produk', 'like', '%' . $keyword . '%')
                    ->orWhereHas('user', function ($subQ) use ($keyword) {
                        $subQ->where('name', 'like', '%' . $keyword . '%');
                    });
            });
        }

        // 2. Filter Kategori
        if ($request->has('kategori') && $request->kategori) {
            $query->where('kategori_produk_id', $request->kategori);
        }

        // 3. Filter Harga (Sortir)
        if ($request->has('harga') && in_array($request->harga, ['asc', 'desc'])) {
            $query->orderBy('harga', $request->harga);
        } else {
            // Default sort jika tidak ada filter harga (Terbaru)
            $query->latest();
        }

        // 4. Filter Stok
        if ($request->has('stok')) {
            if ($request->stok == 'tersedia') {
                $query->where('stok', '>', 0);
            } elseif ($request->stok == 'habis') {
                $query->where('stok', '<=', 0);
            }
        }

        // Eksekusi query dengan pagination
        $daftarProduk = $query->paginate(12)->withQueryString(); // withQueryString() agar filter tetap ada saat pindah halaman

        // Ambil data kategori untuk dropdown filter di view
        $kategoris = KategoriProduk::all();

        return view('produk.index', compact('daftarProduk', 'kategoris'));
    }

    /**
     * Menampilkan halaman detail satu produk.
     */
    public function show(string $id)
    {
        $produk = Produk::findOrFail($id);

        return view('produk.show', [
            'produk' => $produk
        ]);
    }

    // API: Mengirim daftar produk ke HP
    public function apiIndex()
    {
        // Ambil semua produk beserta data petaninya
        $produk = Produk::with('user')->where('stok', '>', 0)->get();
        
        return response()->json([
            'success' => true,
            'data' => $produk
        ]);
    }
}