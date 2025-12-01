<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\KategoriProduk;
use App\Models\User; // [BARU] Import Model User untuk list petani
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 1. Tampilkan Semua Produk (Dengan Fitur Cari & Filter)
    public function index(Request $request)
    {
        $query = Produk::with(['user', 'kategoriProduk']);

        // [FITUR BARU] Filter Pencarian Nama Produk
        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        // [FITUR BARU] Filter Berdasarkan Petani
        if ($request->filled('petani_id')) {
            $query->where('user_id', $request->petani_id);
        }

        // [FITUR BARU] Filter Berdasarkan Kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_produk_id', $request->kategori_id);
        }

        $products = $query->latest()->paginate(10);

        // Data untuk Dropdown Filter
        $petani = User::where('role', 'petani')->orderBy('name')->get();
        $kategori = KategoriProduk::all();

        return view('admin.products.index', compact('products', 'petani', 'kategori'));
    }

    // 2. Halaman Edit Produk
    public function edit($id)
    {
        $product = Produk::findOrFail($id);
        $kategori = KategoriProduk::all();
        return view('admin.products.edit', compact('product', 'kategori'));
    }

    // 3. Proses Update
    public function update(Request $request, $id)
    {
        $product = Produk::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'deskripsi' => 'required|string',
            'kategori_produk_id' => 'required|exists:kategori_produks,id',
            'foto_produk' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_produk')) {
            if ($product->foto_produk) {
                Storage::disk('public')->delete($product->foto_produk);
            }
            $data['foto_produk'] = $request->file('foto_produk')->store('produk', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui oleh Admin.');
    }

    // 4. Proses Hapus
    public function destroy($id)
    {
        $product = Produk::findOrFail($id);
        
        if ($product->foto_produk) {
            Storage::disk('public')->delete($product->foto_produk);
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk telah dihapus.');
    }
}