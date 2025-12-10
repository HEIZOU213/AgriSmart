<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    // --- BAGIAN PUBLIK ---

    // 1. [BARU] Menampilkan Halaman Kontak (kontak/index.blade.php)
    public function show()
    {
        // Mengarahkan ke file resources/views/kontak/index.blade.php
        return view('kontak.index');
    }

    // 2. [UPDATE] Simpan Pesan dari Form
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'no_hp' => 'required|string|max:20',
            'subjek' => 'required|string|max:100', // Tambahan validasi untuk field subjek
            'pesan' => 'required|string',
        ]);

        Kontak::create($request->all());

        // Menggunakan back() agar tetap di halaman kontak dan menampilkan alert sukses
        return back()->with('success', 'Pesan Anda berhasil terkirim! Tim kami akan segera menghubungi Anda.');
    }


    // --- BAGIAN ADMIN ---

    // 3. [ADMIN] Lihat Daftar Pesan Masuk
    public function index()
    {
        $pesan = Kontak::orderBy('created_at', 'desc')->paginate(10);

        // Pastikan Anda memiliki view ini untuk admin panel
        return view('admin.kontak.index', compact('pesan'));
    }

    // 4. [ADMIN] Hapus Pesan
    public function destroy($id)
    {
        Kontak::findOrFail($id)->delete();
        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}