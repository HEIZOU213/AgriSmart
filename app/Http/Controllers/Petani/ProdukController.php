<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // <-- 1. IMPORT FACADE STORAGE
use Illuminate\Support\Facades\Validator;

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

    /**
     * API: Menampilkan List Produk milik Petani yang sedang login
     */
    public function apiIndex(Request $request)
    {
        $user = $request->user();

        // Ambil produk dimana user_id sesuai dengan user yang login
        $produk = Produk::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        // Modifikasi data foto agar URL-nya lengkap (untuk Flutter)
        $produk->transform(function ($item) {
            if ($item->foto_produk && !str_starts_with($item->foto_produk, 'http')) {
                // Pastikan URL gambar lengkap
                $item->foto_produk = url('storage/' . $item->foto_produk);
            }
            return $item;
        });

        return response()->json([
            'success' => true,
            'message' => 'List Produk Petani',
            'data' => $produk
        ]);
    }

    /**
     * API: Tambah Produk Baru
     */
    public function apiStore(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'kategori_produk_id' => 'required', // Bisa ID kategori
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'foto_produk' => 'nullable|image|max:2048', // Max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $data = $request->all();
        $data['user_id'] = $user->id; // Set Pemilik Produk

        // 2. Upload Foto
        if ($request->hasFile('foto_produk')) {
            // Simpan ke folder 'public/produk'
            $path = $request->file('foto_produk')->store('produk', 'public');
            $data['foto_produk'] = $path;
        }

        // 3. Simpan ke Database
        $produk = Produk::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Produk Berhasil Ditambahkan',
            'data' => $produk
        ], 201);
    }

    /**
     * API: Update Produk
     */
    public function apiUpdate(Request $request, $id)
    {
        // 1. Cari Produk
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // 2. Validasi Input (Gunakan Validator yang sudah diimport)
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|string',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'kategori_produk_id' => 'required',
            'foto_produk' => 'nullable|image|max:2048', // Boleh kosong saat update
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            // 3. Update Data Teks
            $produk->nama_produk = $request->nama_produk;
            $produk->deskripsi   = $request->deskripsi;
            $produk->harga       = $request->harga;
            $produk->stok        = $request->stok;
            $produk->kategori_produk_id = $request->kategori_produk_id;

            // 4. Cek Apakah Ada Gambar Baru?
            if ($request->hasFile('foto_produk')) {
                // Hapus gambar lama jika ada (opsional, biar server gak penuh)
                if ($produk->foto_produk && Storage::exists('public/' . $produk->foto_produk)) {
                    Storage::delete('public/' . $produk->foto_produk);
                }

                // Upload gambar baru
                $path = $request->file('foto_produk')->store('produk', 'public');
                $produk->foto_produk = $path;
            }

            $produk->save();

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diupdate',
                'data'    => $produk
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal update: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Hapus Produk
     */
    public function apiDestroy(Request $request, $id)
    {
        $user = $request->user();
        $produk = Produk::where('user_id', $user->id)->where('id', $id)->first();

        if (!$produk) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
        }

        // Hapus file foto
        if ($produk->foto_produk && Storage::disk('public')->exists($produk->foto_produk)) {
            Storage::disk('public')->delete($produk->foto_produk);
        }

        $produk->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk Berhasil Dihapus'
        ]);
    }   
}