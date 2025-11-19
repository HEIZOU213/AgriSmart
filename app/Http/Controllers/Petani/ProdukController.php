<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // <-- 1. IMPORT FACADE STORAGE

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar produk milik petani yang sedang login.
     */
    public function index()
    {
        $produk = Produk::where('user_id', Auth::id()) 
                        ->with('kategoriProduk')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
                            
        return view('petani.produk.index', ['produk' => $produk]);
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        $kategori = KategoriProduk::all();
        return view('petani.produk.create', ['kategori' => $kategori]);
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input (tetap sama)
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_produk_id' => 'required|exists:kategori_produk,id',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = null; // Inisialisasi path

        // 2. --- [TAMBAHAN] LOGIKA UPLOAD FILE ---
        if ($request->hasFile('foto_produk')) {
            // Simpan file di 'storage/app/public/produk'
            // dan 'path' akan berisi 'produk/namafile.jpg'
            $path = $request->file('foto_produk')->store('produk', 'public');
        }

        // 3. Buat dan simpan data
        $produk = new Produk();
        $produk->user_id = Auth::id();
        $produk->kategori_produk_id = $request->kategori_produk_id;
        $produk->nama_produk = $request->nama_produk;
        $produk->deskripsi = $request->deskripsi;
        $produk->harga = $request->harga;
        $produk->stok = $request->stok;
        $produk->foto_produk = $path; // <-- 4. SIMPAN PATH FOTO
        $produk->save();

        return redirect()->route('petani.produk.index')
                         ->with('success', 'Produk panen berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail produk (opsional untuk petani).
     */
    public function show(string $id)
    {
        // ... (Logika tetap sama)
    }

    /**
     * Menampilkan form untuk mengedit produk.
     */
    public function edit(string $id)
    {
        $produk = Produk::where('user_id', Auth::id())->findOrFail($id);
        $kategori = KategoriProduk::all();
        
        return view('petani.produk.edit', [
            'produk' => $produk,
            'kategori' => $kategori
        ]);
    }

    /**
     * Memperbarui data produk di database.
     */
    public function update(Request $request, string $id)
    {
        $produk = Produk::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            // ... (Validasi tetap sama)
        ]);

        $path = $produk->foto_produk; // Ambil path foto yang lama

        // 1. --- [TAMBAHAN] LOGIKA UPDATE FILE ---
        if ($request->hasFile('foto_produk')) {
            
            // 2. Hapus foto lama jika ada
            if ($produk->foto_produk) {
                Storage::disk('public')->delete($produk->foto_produk);
            }

            // 3. Simpan foto baru
            $path = $request->file('foto_produk')->store('produk', 'public');
        }

        // 4. Update data produk
        $produk->kategori_produk_id = $request->kategori_produk_id;
        $produk->nama_produk = $request->nama_produk;
        $produk->deskripsi = $request->deskripsi;
        $produk->harga = $request->harga;
        $produk->stok = $request->stok;
        $produk->foto_produk = $path; // <-- 5. SIMPAN PATH BARU (atau path lama jika tidak ganti)
        $produk->save();

        return redirect()->route('petani.produk.index')
                         ->with('success', 'Produk panen berhasil diperbarui.');
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy(string $id)
    {
        $produk = Produk::where('user_id', Auth::id())->findOrFail($id);
        
        // 1. --- [TAMBAHAN] HAPUS FILE FOTO ---
        if ($produk->foto_produk) {
            Storage::disk('public')->delete($produk->foto_produk);
        }
        
        // 2. Hapus data dari database
        $produk->delete();

        return redirect()->route('petani.produk.index')
                         ->with('success', 'Produk panen berhasil dihapus.');
    }
}