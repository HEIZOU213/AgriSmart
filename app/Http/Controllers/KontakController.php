<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    // --- BAGIAN PUBLIK ---

    // 1. Menampilkan Halaman Kontak
    public function show()
    {
        return view('kontak.index');
    }

    // 2. [PERBAIKAN] Simpan Pesan dari Form
    public function store(Request $request)
    {
        // Validasi disesuaikan dengan database (tanpa subjek)
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'no_hp' => 'required|string|max:20',
            'pesan' => 'required|string',
        ]);

        // Simpan ke database
        // Menggunakan array spesifik agar lebih aman daripada $request->all()
        Kontak::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'pesan' => $request->pesan,
        ]);

        return back()->with('success', 'Pesan Anda berhasil terkirim! Tim kami akan segera menghubungi Anda.');
    }


    // --- BAGIAN ADMIN ---

    // 3. Lihat Daftar Pesan Masuk
    public function index()
    {
        $pesan = Kontak::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.kontak.index', compact('pesan'));
    }

    // 4. Hapus Pesan
    public function destroy($id)
    {
        Kontak::findOrFail($id)->delete();
        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}