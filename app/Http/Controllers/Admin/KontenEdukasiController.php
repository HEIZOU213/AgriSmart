<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontenEdukasi;
use App\Models\KategoriEdukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // <-- 1. IMPORT FACADE STORAGE

class KontenEdukasiController extends Controller
{
    /**
     * Menampilkan daftar (index) konten edukasi.
     */
    public function index()
    {
        $konten = KontenEdukasi::with('kategoriEdukasi', 'user')
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
                            
        return view('admin.edukasi.index', ['konten' => $konten]);
    }

    /**
     * Menampilkan form untuk membuat konten baru.
     */
    public function create()
    {
        $kategori = KategoriEdukasi::all();
        return view('admin.edukasi.create', ['kategori' => $kategori]);
    }

    /**
     * Menyimpan konten baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input (tambah validasi foto)
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_edukasi_id' => 'required|exists:kategori_edukasi,id',
            'isi_konten' => 'required|string',
            'tipe_konten' => 'required|in:artikel,video',
            'url_video' => 'nullable|url',
            'foto_sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // <-- VALIDASI BARU
        ]);

        $path = null;

        // 2. --- [TAMBAHAN] LOGIKA UPLOAD FILE ---
        if ($request->hasFile('foto_sampul')) {
            // Simpan file di 'storage/app/public/edukasi'
            $path = $request->file('foto_sampul')->store('edukasi', 'public');
        }

        // 3. Buat dan simpan data
        $konten = new KontenEdukasi();
        $konten->user_id = auth()->id();
        $konten->kategori_edukasi_id = $request->kategori_edukasi_id;
        $konten->judul = $request->judul;
        $konten->slug = Str::slug($request->judul);
        $konten->isi_konten = $request->isi_konten;
        $konten->tipe_konten = $request->tipe_konten;
        $konten->url_video = $request->url_video;
        $konten->foto_sampul = $path; // <-- 4. SIMPAN PATH FOTO
        $konten->save();

        return redirect()->route('admin.konten-edukasi.index')
                         ->with('success', 'Konten edukasi berhasil ditambahkan.');
    }

    // ... (Metode 'show' tetap sama)
    public function show(string $id) { /* ... */ }


    /**
     * Menampilkan form untuk mengedit konten.
     */
    public function edit(string $id)
    {
        $konten = KontenEdukasi::findOrFail($id);
        $kategori = KategoriEdukasi::all();
        
        return view('admin.edukasi.edit', [
            'konten' => $konten,
            'kategori' => $kategori
        ]);
    }

    /**
     * Memperbarui data konten di database.
     */
    public function update(Request $request, string $id)
    {
        $konten = KontenEdukasi::findOrFail($id);

        // 1. Validasi input (tambah validasi foto)
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_edukasi_id' => 'required|exists:kategori_edukasi,id',
            'isi_konten' => 'required|string',
            'tipe_konten' => 'required|in:artikel,video',
            'url_video' => 'nullable|url',
            'foto_sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // <-- VALIDASI BARU
        ]);

        $path = $konten->foto_sampul; // Ambil path foto lama

        // 2. --- [TAMBAHAN] LOGIKA UPDATE FILE ---
        if ($request->hasFile('foto_sampul')) {
            // Hapus foto lama jika ada
            if ($konten->foto_sampul) {
                Storage::disk('public')->delete($konten->foto_sampul);
            }
            // Simpan foto baru
            $path = $request->file('foto_sampul')->store('edukasi', 'public');
        }

        // 3. Update data konten
        $konten->kategori_edukasi_id = $request->kategori_edukasi_id;
        $konten->judul = $request->judul;
        $konten->slug = Str::slug($request->judul);
        $konten->isi_konten = $request->isi_konten;
        $konten->tipe_konten = $request->tipe_konten;
        $konten->url_video = $request->url_video;
        $konten->foto_sampul = $path; // <-- 4. SIMPAN PATH BARU (atau lama)
        $konten->save();

        return redirect()->route('admin.konten-edukasi.index')
                         ->with('success', 'Konten edukasi berhasil diperbarui.');
    }

    /**
     * Menghapus konten dari database.
     */
    public function destroy(string $id)
    {
        $konten = KontenEdukasi::findOrFail($id);
        
        // 1. --- [TAMBAHAN] HAPUS FILE FOTO ---
        if ($konten->foto_sampul) {
            Storage::disk('public')->delete($konten->foto_sampul);
        }
        
        // 2. Hapus data dari database
        $konten->delete();

        return redirect()->route('admin.konten-edukasi.index')
                         ->with('success', 'Konten edukasi berhasil dihapus.');
    }
}