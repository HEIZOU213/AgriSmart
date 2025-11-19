<?php

namespace App\Http\Controllers;

use App\Models\PesanOrder;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesanOrderController extends Controller
{
    /**
     * Simpan pesan baru yang terikat pada sebuah pesanan.
     */
    public function store(Request $request, $id) // $id adalah pesanan_id
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        // 1. Temukan pesanan
        $pesanan = Pesanan::findOrFail($id);

        // 2. Cek Keamanan: Pastikan user yang login adalah Konsumen atau Petani dari pesanan ini
        $isKonsumen = $pesanan->user_id == Auth::id();

        $isPetani = $pesanan->detailPesanan()
                           ->whereHas('produk', function ($query) {
                               $query->where('user_id', Auth::id());
                           })->exists();

        if (!$isKonsumen && !$isPetani) {
            return redirect()->back()->with('error', 'Anda tidak diizinkan mengirim pesan di pesanan ini.');
        }

        // 3. Simpan Pesan
        PesanOrder::create([
            'pesanan_id' => $id,
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return redirect()->back()->with('success', 'Pesan Anda telah terkirim.');
    }
}