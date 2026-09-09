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
     * Menampilkan daftar produk milik pekebun durian yang sedang login.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        // 1. Stats Ringkasan Katalog Petani (sesuai Mobile)
        $baseQuery = Produk::where('user_id', $userId);
        $stats = [
            'total_produk'       => (clone $baseQuery)->count(),
            'ready_stock_count'  => (clone $baseQuery)->where(function($q) {
                $q->where('tipe_produk', 'ready_stock')->orWhereNull('tipe_produk');
            })->count(),
            'booking_panen_count'=> (clone $baseQuery)->where('tipe_produk', 'booking_panen')->count(),
            'total_stok'         => (clone $baseQuery)->sum('stok'),
        ];

        // 2. Query Produk dengan Filter
        $query = Produk::where('user_id', $userId)->with('kategoriProduk');

        // Filter Tipe Produk (Ready Stock vs Booking Panen)
        if ($request->filled('tipe_produk') && $request->tipe_produk !== 'all') {
            if ($request->tipe_produk === 'ready_stock') {
                $query->where(function($q) {
                    $q->where('tipe_produk', 'ready_stock')->orWhereNull('tipe_produk');
                });
            } else {
                $query->where('tipe_produk', $request->tipe_produk);
            }
        }

        // Filter Kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_produk_id', $request->kategori_id);
        }

        // Pencarian Nama / Varietas Produk
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where('nama_produk', 'like', "%{$keyword}%");
        }

        $produk = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $kategoriList = KategoriProduk::all();

        return view('petani.produk.index', [
            'produk'       => $produk,
            'stats'        => $stats,
            'kategoriList' => $kategoriList,
        ]);
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     * Pekebun WAJIB mengisi konfigurasi Midtrans sebelum bisa menambah produk.
     */
    public function create()
    {
        if (!Auth::user()->getMidtransServerKey()) {
            return redirect()->route('petani.midtrans.index')
                ->with('error', 'Konfigurasi pembayaran sistem atau akun Midtrans belum tersedia.');
        }

        $kategori = KategoriProduk::all();
        return view('petani.produk.create', ['kategori' => $kategori]);
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        // Guard: Midtrans wajib dikonfigurasi (Akun sendiri atau Default Sistem)
        if (!Auth::user()->getMidtransServerKey()) {
            return redirect()->route('petani.midtrans.index')
                ->with('error', 'Konfigurasi pembayaran Midtrans belum aktif di sistem atau akun Anda.');
        }

        // 1. Validasi input
        $request->validate([
            'nama_produk'        => 'required|string|max:255',
            'kategori_produk_id' => 'required|exists:kategori_produk,id',
            'deskripsi'          => 'nullable|string',
            'harga'              => 'required|numeric|min:0',
            'stok'               => 'required|integer|min:0',
            'foto_produk'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'tipe_produk'        => 'nullable|string|in:ready_stock,booking_panen',
            'estimasi_panen'     => 'nullable|string|max:255',
        ]);

        $path = null;

        // 2. Upload file foto produk
        if ($request->hasFile('foto_produk')) {
            $path = $request->file('foto_produk')->store('produk', 'public');
        }

        $kategori = KategoriProduk::find($request->kategori_produk_id);
        $satuan = $request->input('satuan') ?: ($kategori?->satuan_default ?? 'pcs');

        // 3. Buat dan simpan data
        $produk = new Produk();
        $produk->user_id = Auth::id();
        $produk->kategori_produk_id = $request->kategori_produk_id;
        $produk->nama_produk = $request->nama_produk;
        $produk->deskripsi = $request->deskripsi;
        $produk->harga = $request->harga;
        $produk->satuan = $satuan;
        $produk->stok = $request->stok;
        $produk->tipe_produk = $request->input('tipe_produk', 'ready_stock');
        $produk->estimasi_panen = $request->input('estimasi_panen');
        $produk->foto_produk = $path;
        $produk->save();

        return redirect()->route('petani.produk.index')
                         ->with('success', 'Produk panen durian berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail produk (opsional untuk pekebun durian).
     */
    public function show(string $id)
    {
        $produk = Produk::where('user_id', Auth::id())->findOrFail($id);
        return redirect()->route('petani.produk.edit', $produk->id);
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
            'nama_produk'        => 'required|string|max:255',
            'kategori_produk_id' => 'required|exists:kategori_produk,id',
            'deskripsi'          => 'nullable|string',
            'harga'              => 'required|numeric|min:0',
            'stok'               => 'required|integer|min:0',
            'foto_produk'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'tipe_produk'        => 'nullable|string|in:ready_stock,booking_panen',
            'estimasi_panen'     => 'nullable|string|max:255',
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
        $kategori = KategoriProduk::find($request->kategori_produk_id);
        $satuan = $request->input('satuan') ?: ($produk->satuan ?: ($kategori?->satuan_default ?? 'pcs'));

        $produk->kategori_produk_id = $request->kategori_produk_id;
        $produk->nama_produk = $request->nama_produk;
        $produk->deskripsi = $request->deskripsi;
        $produk->harga = $request->harga;
        $produk->satuan = $satuan;
        $produk->stok = $request->stok;
        $produk->tipe_produk = $request->input('tipe_produk', $produk->tipe_produk ?? 'ready_stock');
        $produk->estimasi_panen = $request->input('estimasi_panen');
        $produk->foto_produk = $path;
        $produk->save();

        return redirect()->route('petani.produk.index')
                         ->with('success', 'Produk panen durian berhasil diperbarui.');
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
                         ->with('success', 'Produk panen durian berhasil dihapus.');
    }

    /**
     * API: Menampilkan List Produk milik Pekebun yang sedang login
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
            'message' => 'List Produk Pekebun',
            'data' => $produk
        ]);
    }

    /**
     * API: Tambah Produk Baru
     */
    public function apiStore(Request $request)
    {
        // Guard: Midtrans wajib dikonfigurasi (Akun sendiri atau Default Sistem)
        $user = $request->user() ?: Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi login telah berakhir. Silakan login kembali.'
            ], 401);
        }
        if (empty($user->getMidtransServerKey())) {
            return response()->json([
                'success' => false,
                'message' => 'Konfigurasi pembayaran Midtrans belum aktif di sistem. Silakan hubungi admin.'
            ], 422);
        }

        $rules = [
            'nama_produk' => 'required|string|max:255',
            'kategori_produk_id' => 'required|exists:kategori_produk,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'tipe_produk' => 'nullable|string|in:ready_stock,booking_panen',
            'estimasi_panen' => 'nullable|string|max:255',
        ];

        if ($request->hasFile('foto_produk')) {
            $rules['foto_produk'] = 'image|mimes:jpeg,png,jpg,webp|max:3072';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->user();
            $data = $request->except(['foto_produk']);
            $data['user_id'] = $user->id; // Set Pemilik Produk
            $data['tipe_produk'] = $request->input('tipe_produk', 'ready_stock');
            $data['estimasi_panen'] = $request->input('estimasi_panen');
            if (empty($data['satuan'])) {
                $kategori = KategoriProduk::find($data['kategori_produk_id']);
                $data['satuan'] = $kategori?->satuan_default ?? 'pcs';
            }

            // Upload Foto jika ada
            if ($request->hasFile('foto_produk')) {
                $path = $request->file('foto_produk')->store('produk', 'public');
                $data['foto_produk'] = $path;
            }

            // Simpan ke Database
            $produk = Produk::create($data);
            $produk->load(['user', 'kategoriProduk']);

            return response()->json([
                'success' => true,
                'message' => 'Produk Durian Berhasil Ditambahkan',
                'data' => $produk
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan produk: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Update Produk
     */
    public function apiUpdate(Request $request, $id)
    {
        $user = $request->user() ?: Auth::user();

        // 1. Cari Produk milik pekebun yang sedang login (Cegah IDOR)
        $query = Produk::query();
        if ($user && $user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }
        $produk = $query->find($id);

        if (!$produk) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan atau bukan milik Anda'], 404);
        }

        $rules = [
            'nama_produk' => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'kategori_produk_id' => 'required|exists:kategori_produk,id',
            'deskripsi'   => 'nullable|string',
            'tipe_produk' => 'nullable|string|in:ready_stock,booking_panen',
            'estimasi_panen' => 'nullable|string|max:255',
        ];

        if ($request->hasFile('foto_produk')) {
            $rules['foto_produk'] = 'image|mimes:jpeg,png,jpg,webp|max:3072';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Update Data Teks
            $produk->nama_produk = $request->nama_produk;
            $produk->deskripsi   = $request->deskripsi;
            $produk->harga       = $request->harga;
            $produk->stok        = $request->stok;
            $produk->kategori_produk_id = $request->kategori_produk_id;
            if ($request->has('tipe_produk')) {
                $produk->tipe_produk = $request->tipe_produk;
            }
            if ($request->has('estimasi_panen')) {
                $produk->estimasi_panen = $request->estimasi_panen;
            }

            // Cek Apakah Ada Gambar Baru?
            if ($request->hasFile('foto_produk')) {
                // Hapus gambar lama jika ada (opsional, biar server gak penuh)
                if ($produk->foto_produk && Storage::disk('public')->exists($produk->foto_produk)) {
                    Storage::disk('public')->delete($produk->foto_produk);
                }

                $path = $request->file('foto_produk')->store('produk', 'public');
                $produk->foto_produk = $path;
            }

            $produk->save();
            $produk->load(['user', 'kategoriProduk']);

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diperbarui!',
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
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
        }

        if ($user->role !== 'admin' && $produk->user_id != $user->id) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki izin menghapus produk ini'], 403);
        }

        try {
            // Hapus file foto jika ada
            if ($produk->foto_produk && Storage::disk('public')->exists($produk->foto_produk)) {
                Storage::disk('public')->delete($produk->foto_produk);
            }

            $produk->delete();

            return response()->json([
                'success' => true,
                'message' => 'Produk Berhasil Dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus produk: ' . $e->getMessage()
            ], 500);
        }
    }   
}


