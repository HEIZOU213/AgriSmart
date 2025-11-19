<?php

namespace App\Http\Controllers\Konsumen;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    /**
     * Menampilkan daftar riwayat pesanan (YANG BELUM DIARSIP).
     */
    public function index()
    {
        $pesanan = Pesanan::where('user_id', Auth::id())
                        ->where('konsumen_arsip', false) // <-- [FIX] Hanya tampilkan yang belum diarsip
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
                            
        return view('konsumen.pesanan.index', ['pesanan' => $pesanan]);
    }

    /* (Metode create, store, edit, update tetap abort(404)) */
    public function create() { abort(404); }
    public function store(Request $request) { abort(404); }
    public function edit(string $id) { abort(404); }
    public function update(Request $request, string $id) { abort(404); }


    /**
     * Menampilkan detail satu pesanan.
     */
    public function show(string $id)
    {
        $pesanan = Pesanan::where('user_id', Auth::id())
                        ->with(['detailPesanan.produk']) 
                        ->findOrFail($id);
        
        $pesanLog = \App\Models\PesanOrder::where('pesanan_id', $id)
                                    ->with('user')
                                    ->orderBy('created_at', 'asc')
                                    ->get();
                        
        return view('konsumen.pesanan.show', [
            'pesanan' => $pesanan,
            'pesanLog' => $pesanLog
        ]);
    }

    /**
     * [FIX] Meng-ARSIPKAN pesanan (bukan menghapus).
     */
    public function destroy(string $id)
    {
        // 1. Ambil pesanan, pastikan milik user yang login
        $pesanan = Pesanan::where('user_id', Auth::id())->findOrFail($id);

        // 2. Ubah status 'konsumen_arsip' menjadi true
        $pesanan->konsumen_arsip = true;
        $pesanan->save();

        return redirect()->route('konsumen.pesanan.index')
                         ->with('success', 'Riwayat pesanan ' . $pesanan->kode_pesanan . ' berhasil diarsipkan.');
    }
}