<?php

namespace App\Http\Controllers;

use App\Models\KontenEdukasi;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomepageController extends Controller
{
    /**
     * Menampilkan halaman beranda (homepage)
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Gunakan Cache untuk menyimpan hasil query selama 10 menit (600 detik)
        // dan gunakan eager loading (with('user')) untuk mencegah N+1 Query Problem

        $edukasiTerbaru = Cache::remember('homepage_edukasi', 600, function () {
            return KontenEdukasi::with('user')
                                ->orderBy('created_at', 'desc')
                                ->take(3)
                                ->get();
        });

        $produkTerbaru = Cache::remember('homepage_produk', 600, function () {
            return Produk::with(['user', 'kategoriProduk'])
                                ->orderBy('created_at', 'desc')
                                ->take(4)
                                ->get();
        });

        // ===================== STATS REAL UNTUK HERO SECTION =====================
        $heroStats = Cache::remember('homepage_hero_stats', 600, function () {
            return [
                // Jumlah user dengan role pekebun durian yang terdaftar
                'jumlah_petani'  => User::where('role', 'pekebun')->count(),
                // Jumlah total produk yang tersedia
                'jumlah_produk'  => Produk::count(),
                // Jumlah pesanan yang sudah selesai / diproses / dikirim
                'pesanan_selesai' => Pesanan::whereIn('status', ['paid', 'shipping', 'done'])->count(),
            ];
        });

        // Kirim data ke view 'welcome'
        return view('welcome', [
            'edukasi'    => $edukasiTerbaru,
            'produk'     => $produkTerbaru,
            'heroStats'  => $heroStats,
        ]);
    }
}

