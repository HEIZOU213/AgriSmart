<?php

namespace App\Http\Controllers;

use App\Models\KontenEdukasi; // Impor model
use Illuminate\Http\Request;

class EdukasiController extends Controller
{
    /**
     * Menampilkan halaman daftar semua konten edukasi.
     */
    public function index()
    {
        // Ambil semua konten, urutkan dari yang terbaru, dan paginasi (10 per halaman)
        $daftarEdukasi = KontenEdukasi::orderBy('created_at', 'desc')
                                    ->paginate(10);

        // Kirim data ke view 'edukasi.index'
        return view('edukasi.index', [
            'daftarEdukasi' => $daftarEdukasi
        ]);
    }

    /**
     * Menampilkan halaman detail satu konten edukasi.
     * Kita akan menggunakan 'slug' (dari migrasi) untuk URL yang cantik.
     */
    public function show(string $slug)
    {
        // Cari konten edukasi berdasarkan 'slug'-nya.
        // firstOrFail() akan otomatis menampilkan error 404 jika tidak ditemukan.
        $edukasi = KontenEdukasi::where('slug', $slug)->firstOrFail();

        // Kirim data ke view 'edukasi.show'
        return view('edukasi.show', [
            'edukasi' => $edukasi
        ]);
    }

    // Tambahkan ini di paling bawah EdukasiController
    public function apiIndex()
    {
        // Mengambil semua data edukasi, diurutkan dari yang terbaru
        $data = \App\Models\Edukasi::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}