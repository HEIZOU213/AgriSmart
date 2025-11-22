<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    // 1. [PUBLIK] Simpan Pesan dari Halaman Depan
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'no_hp' => 'required|string|max:20',
            'pesan' => 'required|string',
        ]);

        Kontak::create($request->all());

        // Redirect kembali ke bagian #kontak dengan pesan sukses
        return redirect('/#kontak')->with('success', 'Permintaan Anda terkirim! Admin akan segera menghubungi Anda.');
    }

    // 2. [ADMIN] Lihat Daftar Pesan Masuk
    public function index()
    {
        $pesan = Kontak::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.kontak.index', compact('pesan'));
    }

    // 3. [ADMIN] Hapus Pesan
    public function destroy($id)
    {
        Kontak::findOrFail($id)->delete();
        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}