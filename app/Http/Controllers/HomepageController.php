<?php

namespace App\Http\Controllers;

use App\Models\KontenEdukasi;
use App\Models\Produk;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    /**
     * Menampilkan halaman beranda (homepage)
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1. Ambil 3 konten edukasi terbaru
        $edukasiTerbaru = KontenEdukasi::orderBy('created_at', 'desc')
                                    ->take(3)
                                    ->get();

        // 2. Ambil 4 produk terbaru
        $produkTerbaru = Produk::orderBy('created_at', 'desc')
                                ->take(4)
                                ->get();

        // 3. Kirim data ke view 'welcome'
        return view('welcome', [
            'edukasi' => $edukasiTerbaru,
            'produk' => $produkTerbaru,
        ]);
    }
}