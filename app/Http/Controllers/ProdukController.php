<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk; // Pastikan model ini di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class ProdukController extends Controller
{
    /**
     * Menampilkan halaman daftar semua produk (marketplace) dengan fitur pencarian dan filter lengkap.
     */
    public function index(Request $request)
    {
        // Cek ketersediaan kolom tipe_produk secara dinamis (Self-healing jika migrasi tertunda)
        $hasTipeProduk = false;
        try {
            $hasTipeProduk = Schema::hasColumn('produk', 'tipe_produk');
            if (!$hasTipeProduk) {
                Artisan::call('migrate', ['--force' => true]);
                $hasTipeProduk = Schema::hasColumn('produk', 'tipe_produk');
            }
        } catch (\Throwable $e) {
            Log::warning('Migrate/Schema check on produk: ' . $e->getMessage());
        }

        // Query dasar dengan Eager Loading agar performa lebih cepat
        $query = Produk::with(['user', 'kategoriProduk']);

        // 1. Filter Pencarian (Nama Produk atau Nama Penjual)
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_produk', 'like', '%' . $keyword . '%')
                    ->orWhereHas('user', function ($subQ) use ($keyword) {
                        $subQ->where('name', 'like', '%' . $keyword . '%');
                    });
            });
        }

        // 2. Filter Kategori
        if ($request->filled('kategori')) {
            $kat = $request->kategori;
            if (is_numeric($kat)) {
                $query->where('kategori_produk_id', $kat);
            } else {
                $query->whereHas('kategoriProduk', function ($q) use ($kat) {
                    $q->where('nama_kategori', 'like', '%' . $kat . '%')
                      ->orWhere('slug', 'like', '%' . $kat . '%');
                });
            }
        }

        // 2b. Filter Tipe Produk (ready_stock vs booking_panen) - hanya jika kolom tersedia
        if ($hasTipeProduk && $request->filled('tipe_produk') && $request->tipe_produk !== 'all') {
            if ($request->tipe_produk === 'ready_stock') {
                $query->where(function($q) {
                    $q->where('tipe_produk', 'ready_stock')->orWhereNull('tipe_produk');
                });
            } else {
                $query->where('tipe_produk', $request->tipe_produk);
            }
        }

        // 2c. Filter Subkategori (Durian Biasa, Durian Premium, Lempuk, Dodol, Tempoyak, Pancake, Keripik Biji)
        if ($request->filled('subkategori') && !str_starts_with(strtolower($request->subkategori), 'semua')) {
            $sub = strtolower($request->subkategori);
            if (str_contains($sub, 'premium')) {
                $query->where(function ($q) {
                    $q->where('nama_produk', 'like', '%premium%')
                      ->orWhere('nama_produk', 'like', '%musang king%')
                      ->orWhere('nama_produk', 'like', '%black thorn%')
                      ->orWhere('nama_produk', 'like', '%duri hitam%')
                      ->orWhere('nama_produk', 'like', '%bawor%')
                      ->orWhere('nama_produk', 'like', '%ochee%')
                      ->orWhere('nama_produk', 'like', '%grade a%')
                      ->orWhere('harga', '>=', 100000);
                });
            } elseif (str_contains($sub, 'biasa')) {
                $query->where(function ($q) {
                    $q->where('nama_produk', 'like', '%biasa%')
                      ->orWhere('nama_produk', 'like', '%kampung%')
                      ->orWhere('nama_produk', 'like', '%lokal%')
                      ->orWhere('nama_produk', 'like', '%tembaga%')
                      ->orWhere('nama_produk', 'like', '%montong%')
                      ->orWhere(function ($subQ) {
                          $subQ->where('harga', '<', 100000)
                               ->where('nama_produk', 'not like', '%musang king%')
                               ->where('nama_produk', 'not like', '%black thorn%')
                               ->where('nama_produk', 'not like', '%duri hitam%')
                               ->where('nama_produk', 'not like', '%premium%');
                      });
                });
            } elseif (str_contains($sub, 'lempuk')) {
                $query->where('nama_produk', 'like', '%lempuk%');
            } elseif (str_contains($sub, 'dodol')) {
                $query->where('nama_produk', 'like', '%dodol%');
            } elseif (str_contains($sub, 'tempoyak')) {
                $query->where('nama_produk', 'like', '%tempoyak%');
            } elseif (str_contains($sub, 'pancake')) {
                $query->where('nama_produk', 'like', '%pancake%');
            } elseif (str_contains($sub, 'keripik') || str_contains($sub, 'biji') || str_contains($sub, 'bijik')) {
                $query->where(function ($q) {
                    $q->where('nama_produk', 'like', '%keripik%')
                      ->orWhere('nama_produk', 'like', '%biji%')
                      ->orWhere('nama_produk', 'like', '%bijik%');
                });
            } else {
                $query->where('nama_produk', 'like', '%' . $sub . '%');
            }
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
        $kategoris = collect();
        if (Schema::hasTable('kategori_produk')) {
            $kategoris = KategoriProduk::all();
        }

        // Ringkasan Tipe Produk (aman dari error SQL jika kolom belum termigrasi)
        $countTotal = Produk::count();
        $countReadyStock = $countTotal;
        $countBookingPanen = 0;

        if ($hasTipeProduk) {
            try {
                $countReadyStock = Produk::where(function($q) {
                    $q->where('tipe_produk', 'ready_stock')->orWhereNull('tipe_produk');
                })->count();
                $countBookingPanen = Produk::where('tipe_produk', 'booking_panen')->count();
            } catch (\Throwable $e) {
                $countReadyStock = $countTotal;
                $countBookingPanen = 0;
            }
        }

        return view('produk.index', compact('daftarProduk', 'kategoris', 'countReadyStock', 'countBookingPanen', 'countTotal'));
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

    // API: Mengirim daftar produk ke HP dengan FILTER LENGKAP
    public function apiIndex(Request $request)
    {
        // 1. Mulai Query
        $query = Produk::with(['user', 'kategoriProduk']);

        // 2. Filter Pencarian (Nama Produk atau Penjual)
        if ($request->has('q') && $request->q != '') {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_produk', 'like', '%' . $keyword . '%')
                  ->orWhereHas('user', function ($subQ) use ($keyword) {
                      $subQ->where('name', 'like', '%' . $keyword . '%');
                  });
            });
        }

        // 3. Filter Kategori (Mendukung ID atau Nama/Slug Kategori)
        if ($request->has('kategori') && $request->kategori != '') {
            $kat = $request->kategori;
            if (is_numeric($kat)) {
                $query->where('kategori_produk_id', $kat);
            } else {
                $query->whereHas('kategoriProduk', function ($q) use ($kat) {
                    $q->where('nama_kategori', 'like', '%' . $kat . '%')
                      ->orWhere('slug', 'like', '%' . $kat . '%');
                });
            }
        }

        // 3b. Filter Tipe Produk (ready_stock vs booking_panen)
        $hasTipeProduk = Schema::hasColumn('produk', 'tipe_produk');
        if ($hasTipeProduk && $request->has('tipe_produk') && !empty($request->tipe_produk) && $request->tipe_produk !== 'all') {
            if ($request->tipe_produk === 'ready_stock') {
                $query->where(function($q) {
                    $q->where('tipe_produk', 'ready_stock')->orWhereNull('tipe_produk');
                });
            } else {
                $query->where('tipe_produk', $request->tipe_produk);
            }
        }

        // 3c. Filter Subkategori (Durian Biasa, Durian Premium, Lempuk, Dodol, Tempoyak, Pancake, Keripik Biji)
        if ($request->has('subkategori') && !empty($request->subkategori) && !str_starts_with(strtolower($request->subkategori), 'semua')) {
            $sub = strtolower($request->subkategori);
            if (str_contains($sub, 'premium')) {
                $query->where(function ($q) {
                    $q->where('nama_produk', 'like', '%premium%')
                      ->orWhere('nama_produk', 'like', '%musang king%')
                      ->orWhere('nama_produk', 'like', '%black thorn%')
                      ->orWhere('nama_produk', 'like', '%duri hitam%')
                      ->orWhere('nama_produk', 'like', '%bawor%')
                      ->orWhere('nama_produk', 'like', '%ochee%')
                      ->orWhere('nama_produk', 'like', '%grade a%')
                      ->orWhere('harga', '>=', 100000);
                });
            } elseif (str_contains($sub, 'biasa')) {
                $query->where(function ($q) {
                    $q->where('nama_produk', 'like', '%biasa%')
                      ->orWhere('nama_produk', 'like', '%kampung%')
                      ->orWhere('nama_produk', 'like', '%lokal%')
                      ->orWhere('nama_produk', 'like', '%tembaga%')
                      ->orWhere('nama_produk', 'like', '%montong%')
                      ->orWhere(function ($subQ) {
                          $subQ->where('harga', '<', 100000)
                               ->where('nama_produk', 'not like', '%musang king%')
                               ->where('nama_produk', 'not like', '%black thorn%')
                               ->where('nama_produk', 'not like', '%duri hitam%')
                               ->where('nama_produk', 'not like', '%premium%');
                      });
                });
            } elseif (str_contains($sub, 'lempuk')) {
                $query->where('nama_produk', 'like', '%lempuk%');
            } elseif (str_contains($sub, 'dodol')) {
                $query->where('nama_produk', 'like', '%dodol%');
            } elseif (str_contains($sub, 'tempoyak')) {
                $query->where('nama_produk', 'like', '%tempoyak%');
            } elseif (str_contains($sub, 'pancake')) {
                $query->where('nama_produk', 'like', '%pancake%');
            } elseif (str_contains($sub, 'keripik') || str_contains($sub, 'biji') || str_contains($sub, 'bijik')) {
                $query->where(function ($q) {
                    $q->where('nama_produk', 'like', '%keripik%')
                      ->orWhere('nama_produk', 'like', '%biji%')
                      ->orWhere('nama_produk', 'like', '%bijik%');
                });
            } else {
                $query->where('nama_produk', 'like', '%' . $sub . '%');
            }
        }

        // 4. Filter Stok
        if ($request->has('stok')) {
            if ($request->stok == 'tersedia') {
                $query->where('stok', '>', 0);
            } elseif ($request->stok == 'habis') {
                $query->where('stok', '<=', 0);
            }
        } else {
            // Default: Hanya tampilkan yang stoknya ada (Opsional, sesuaikan kebutuhan)
            // $query->where('stok', '>', 0); 
        }

        // 5. Filter Harga (Sortir)
        if ($request->has('harga') && in_array($request->harga, ['asc', 'desc'])) {
            $query->orderBy('harga', $request->harga);
        } else {
            // Default Sort: Terbaru
            $query->latest();
        }

        // 6. Eksekusi
        $produk = $query->get();
        
        return response()->json([
            'success' => true,
            'data' => $produk
        ]);
    }

    /**
     * API: Detail satu produk
     */
    public function apiShow(string $id)
    {
        $produk = Produk::with(['user', 'kategoriProduk'])->find($id);

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        if ($produk->foto_produk && !str_starts_with($produk->foto_produk, 'http')) {
            $produk->foto_produk = url('storage/' . $produk->foto_produk);
        }

        return response()->json([
            'success' => true,
            'data' => $produk
        ]);
    }
}

