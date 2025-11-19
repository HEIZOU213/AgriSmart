<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Menampilkan halaman daftar semua produk (marketplace) dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        $query = Produk::orderBy('created_at', 'desc');
        $searchTerm = '';

        // [KODE BARU]: Logika Pencarian
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where('nama_produk', 'like', '%' . $searchTerm . '%')
                  ->orWhere('deskripsi', 'like', '%' . $searchTerm . '%');
        }
        
        $daftarProduk = $query->paginate(12);

        return view('produk.index', [
            'daftarProduk' => $daftarProduk,
            'searchQuery' => $searchTerm // Kirim kata kunci pencarian kembali ke view
        ]);
    }

    /**
     * Menampilkan halaman detail satu produk.
     */
    public function show(string $id)
    {
        // ... (Logika tetap sama)
        $produk = Produk::findOrFail($id);

        return view('produk.show', [
            'produk' => $produk
        ]);
    }
}