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

        if ($role === 'user') {
            $pesananIds = Pesanan::where('user_id', $userId)->pluck('id');
        } elseif ($role === 'pekebun') {
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

    // --- METODE API ALIAS (Untuk mobile app Flutter) ---
    public function apiIndex()
    {
        $userId = Auth::id();
        $role = Auth::user()->role ?? 'user';
        $pesananIds = [];

        if ($role === 'user') {
            $pesananIds = Pesanan::where('user_id', $userId)->pluck('id');
        } elseif ($role === 'pekebun') {
            $produkIds = Produk::where('user_id', $userId)->pluck('id');
            $pesananIds = DetailPesanan::whereIn('produk_id', $produkIds)->pluck('pesanan_id');
        } else {
            $pesananIds = Pesanan::pluck('id');
        }

        $chats = Pesanan::whereIn('id', $pesananIds)
                        ->whereHas('pesanOrders')
                        ->with(['user', 'detailPesanan.produk.user'])
                        ->orderBy('updated_at', 'desc')
                        ->get();

        return response()->json(['success' => true, 'data' => $chats]);
    }

    public function apiGetMessages($id)
    {
        return $this->getMessages($id);
    }

    public function apiSendMessage(Request $request)
    {
        $request->validate([
            'pesanan_id' => 'required',
            'body' => 'required|string'
        ]);

        return $this->sendMessage($request, $request->pesanan_id);
    }

    // 6. API untuk cek notifikasi realtime (Support Pekebun & Konsumen)
    public function checkNotifications()
    {
        $user = auth('sanctum')->user() ?: auth('web')->user() ?: Auth::user() ?: request()->user();
        $data = [
            'success' => true,
            'chat' => 0,
            'pesanan' => 0,   // Pekebun & Konsumen
            'keranjang' => 0, // Khusus Konsumen
            'latest_chat' => null,
        ];

        if ($user) {
            // 1. Chat Masuk (Semua Role menggunakan MarketChat yang aktif)
            try {
                $data['chat'] = \App\Models\MarketChat::where('receiver_id', $user->id)
                    ->where('is_read', false)
                    ->count();

                $latest = \App\Models\MarketChat::where('receiver_id', $user->id)
                    ->where('is_read', false)
                    ->with('sender:id,name,foto_profil')
                    ->orderBy('id', 'desc')
                    ->first();

                if ($latest) {
                    $data['latest_chat'] = [
                        'id' => $latest->id,
                        'sender_id' => $latest->sender_id,
                        'sender_name' => $latest->sender ? $latest->sender->name : 'Pengguna AgriSmart',
                        'message' => $latest->message,
                        'created_at' => $latest->created_at ? $latest->created_at->toIso8601String() : date('c'),
                    ];
                }
            } catch (\Exception $e) {}

            // 2. Data Khusus Berdasarkan Role
            if ($user->role === 'pekebun') {
                $petaniId = $user->id;
                // Pesanan Masuk untuk Pekebun (Pesanan baru yang belum dilihat atau berstatus pending/paid)
                try {
                    $produkIds = \App\Models\Produk::where('user_id', $petaniId)->pluck('id');
                    $data['pesanan'] = \App\Models\Pesanan::whereHas('detailPesanan', function($q) use ($produkIds) {
                        $q->whereIn('produk_id', $produkIds);
                    })->where(function($q) {
                        $q->where('is_seen', false)
                          ->orWhere('status', 'pending');
                    })->count();
                } catch (\Exception $e) {}
            } elseif ($user->role === 'user') {
                // Hitung Isi Keranjang
                try {
                    $data['keranjang'] = \App\Models\Keranjang::where('user_id', $user->id)->count();
                } catch (\Exception $e) {}

                // Pesanan untuk Konsumen (Pesanan belum dilihat atau notifikasi order belum dibaca)
                try {
                    $unseenPesanan = \App\Models\Pesanan::where('user_id', $user->id)
                        ->where('is_seen', false)
                        ->where('konsumen_arsip', false)
                        ->count();

                    $unreadNotif = \App\Models\Notifikasi::where('user_id', $user->id)
                        ->where('is_read', false)
                        ->count();

                    $data['pesanan'] = max($unseenPesanan, $unreadNotif);
                } catch (\Exception $e) {}
            }
        }

        return response()->json($data);
    }

    // 7. API Tandai Pesanan Sudah Dilihat (Clear Badge Pesanan)
    public function markOrdersSeen()
    {
        $user = Auth::user() ?: request()->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        try {
            if ($user->role === 'pekebun') {
                $petaniId = $user->id;
                $produkIds = \App\Models\Produk::where('user_id', $petaniId)->pluck('id');
                \App\Models\Pesanan::whereHas('detailPesanan', function($q) use ($produkIds) {
                    $q->whereIn('produk_id', $produkIds);
                })->where('is_seen', false)->update(['is_seen' => true]);
            } else {
                \App\Models\Pesanan::where('user_id', $user->id)
                    ->where('is_seen', false)
                    ->update(['is_seen' => true]);

                \App\Models\Notifikasi::where('user_id', $user->id)
                    ->where('is_read', false)
                    ->update(['is_read' => true]);
            }
        } catch (\Exception $e) {}

        return response()->json(['success' => true, 'message' => 'Pesanan berhasil ditandai telah dilihat']);
    }
}

