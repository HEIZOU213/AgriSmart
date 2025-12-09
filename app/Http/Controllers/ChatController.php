<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\PesanOrder;
use App\Models\Produk;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // 1. Halaman Daftar Chat (Hanya tampilkan yang ada isinya)
    public function index()
    {
        $userId = Auth::id();
        $role = Auth::user()->role;
        $pesananIds = [];

        if ($role === 'konsumen') {
            $pesananIds = Pesanan::where('user_id', $userId)->pluck('id');
        } elseif ($role === 'petani') {
            $produkIds = Produk::where('user_id', $userId)->pluck('id');
            $pesananIds = DetailPesanan::whereIn('produk_id', $produkIds)->pluck('pesanan_id');
        } else { // Admin
            $pesananIds = Pesanan::pluck('id');
        }

        // [PERUBAHAN] Tambahkan whereHas('pesanOrders')
        // Ini akan memfilter: Jika chat kosong/dihapus, pesanan TIDAK akan muncul di list.
        $chats = Pesanan::whereIn('id', $pesananIds)
                        ->whereHas('pesanOrders') 
                        ->with(['user', 'detailPesanan.produk.user'])
                        ->orderBy('updated_at', 'desc')
                        ->get();

        return view('chat.index', compact('chats'));
    }

    // 2. Halaman Ruang Chat
    public function show($id)
    {
        $userId = Auth::id();

        // [LOGIKA BARU] "Tandai Sudah Dibaca" (Mark as Read)
        // Update semua pesan di pesanan ini, yang BUKAN dikirim oleh saya (user yang login)
        // Ubah is_read menjadi true (1)
        PesanOrder::where('pesanan_id', $id)
            ->where('user_id', '!=', $userId) // Hanya pesan lawan bicara
            ->where('is_read', false)      // Yang belum dibaca saja
            ->update(['is_read' => true]);

        $pesanan = Pesanan::findOrFail($id);
        
        return view('chat.show', compact('pesanan'));
    }

    // 3. API: Ambil Pesan
    public function getMessages($id)
    {
        $pesan = PesanOrder::where('pesanan_id', $id)
                           ->with('user')
                           ->orderBy('created_at', 'asc')
                           ->get();
        return response()->json($pesan);
    }

    // 4. API: Kirim Pesan
    public function sendMessage(Request $request, $id)
    {
        $request->validate(['body' => 'required|string']);

        $pesan = PesanOrder::create([
            'pesanan_id' => $id,
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);
        
        // Update timestamp pesanan agar naik ke atas list
        $pesanan = Pesanan::find($id);
        $pesanan->touch(); 

        return response()->json(['status' => 'success', 'data' => $pesan]);
    }

    // 5. Hapus Percakapan
    public function destroy($id)
    {
        // Hapus semua pesan di pesanan ini
        PesanOrder::where('pesanan_id', $id)->delete();

        return redirect()->route('chat.index')->with('success', 'Percakapan berhasil dihapus.');
    }
}