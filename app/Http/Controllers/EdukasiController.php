<?php

namespace App\Http\Controllers;

use App\Models\KontenEdukasi; // Pastikan menggunakan Model yang BENAR
use Illuminate\Http\Request;

class EdukasiController extends Controller
{
    // ==========================================
    // BAGIAN WEB (Blade Template)
    // ==========================================

    /**
     * Menampilkan halaman daftar semua konten edukasi (Web).
     */
    public function index()
    {
        // Ambil semua konten, urutkan dari yang terbaru, dan paginasi (10 per halaman)
        $daftarEdukasi = KontenEdukasi::with(['kategoriEdukasi', 'user']) // Eager load relasi biar cepat
                                      ->orderBy('created_at', 'desc')
                                      ->paginate(10);

        // Kirim data ke view 'edukasi.index'
        return view('edukasi.index', [
            'daftarEdukasi' => $daftarEdukasi
        ]);
    }

    /**
     * Menampilkan halaman detail satu konten edukasi (Web).
     */
    public function show(string $slug)
    {
        // Cari konten edukasi berdasarkan 'slug'-nya.
        $edukasi = KontenEdukasi::with(['kategoriEdukasi', 'user'])
                                ->where('slug', $slug)
                                ->firstOrFail();

        // Kirim data ke view 'edukasi.show'
        return view('edukasi.show', [
            'edukasi' => $edukasi
        ]);
    }

    // ==========================================
    // BAGIAN API (Untuk Aplikasi Flutter)
    // ==========================================

    /**
     * API: List Semua Artikel
     */
    public function apiIndex()
    {
        try {
            // Ambil data terbaru beserta relasi kategorinya
            // 'kategoriEdukasi' dan 'user' adalah nama fungsi relasi di model KontenEdukasi
            $data = KontenEdukasi::with(['kategoriEdukasi', 'user'])->latest()->get();

            // Format ulang data agar sesuai dengan Flutter
            $formattedData = $data->map(function ($item) {
                return [
                    'id'          => $item->id,
                    'judul'       => $item->judul,
                    'slug'        => $item->slug,
                    
                    // Kolom Database Anda
                    'isi_konten'  => $item->isi_konten,   
                    'foto_sampul' => $item->foto_sampul,  
                    'tipe_konten' => $item->tipe_konten, 
                    'url_video'   => $item->url_video,    
                    
                    // Relasi: Ambil nama kategori (jika ada)
                    'kategori'    => $item->kategoriEdukasi ? $item->kategoriEdukasi->nama_kategori : 'Umum',
                    
                    // Relasi: Ambil nama penulis (jika ada)
                    'penulis'     => $item->user ? $item->user->name : 'Admin',
                    
                    'created_at'  => $item->created_at,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'List Data Edukasi',
                'data'    => $formattedData
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * API: Detail Satu Artikel (Berdasarkan Slug)
     * Digunakan jika Flutter perlu fetch ulang detail (opsional) atau share link.
     */
    public function apiShow($slug) // Bisa ganti $id jika mau cari by ID
    {
        // Cari data + relasi
        // Jika Flutter mengirim ID, ganti ->where('slug', $slug) menjadi ->find($id)
        $item = KontenEdukasi::with(['kategoriEdukasi', 'user'])->where('slug', $slug)->first();

        if ($item) {
            $formattedItem = [
                'id'          => $item->id,
                'judul'       => $item->judul,
                'slug'        => $item->slug,
                'isi_konten'  => $item->isi_konten,
                'foto_sampul' => $item->foto_sampul,
                'tipe_konten' => $item->tipe_konten,
                'url_video'   => $item->url_video,
                'kategori'    => $item->kategoriEdukasi ? $item->kategoriEdukasi->nama_kategori : 'Umum',
                'penulis'     => $item->user ? $item->user->name : 'Admin',
                'created_at'  => $item->created_at,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Detail Edukasi',
                'data'    => $formattedItem
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan',
        ], 404);
    }
}