<?php

namespace App\Http\Controllers;

use App\Models\MarketChat;
use App\Models\User;
use App\Models\Produk; // [BARU] Import Model Produk
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache; 
use Carbon\Carbon; 

class MarketChatController extends Controller
{
    // ... (Fungsi getChatList TETAP SAMA) ...
    public function getChatList()
    {
        // ... (Kode Lama, Tidak Berubah) ...
        $myId = Auth::id();
        $allChats = MarketChat::where('sender_id', $myId)
            ->orWhere('receiver_id', $myId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get();

        $chatList = $allChats->groupBy(function ($chat) use ($myId) {
            return $chat->sender_id == $myId ? $chat->receiver_id : $chat->sender_id;
        });

        $formattedList = $chatList->map(function ($chats) use ($myId) {
            $lastChat = $chats->first();
            $isMeSender = ($lastChat->sender_id == $myId);
            $otherUser = $isMeSender ? $lastChat->receiver : $lastChat->sender;
            $otherUserId = $isMeSender ? $lastChat->receiver_id : $lastChat->sender_id;

            if (!$otherUser) {
                return [
                    'user_id' => $otherUserId,
                    'name' => "User Tidak Dikenal",
                    'foto_profil' => null,
                    'last_message' => $lastChat->message,
                    'time' => $lastChat->created_at->diffForHumans(), 
                    'unread_count' => 0, 
                ];
            }

            $unreadCount = $chats->where('sender_id', $otherUserId)
                                 ->where('receiver_id', $myId)
                                 ->where('is_read', false)
                                 ->count();

            return [
                'user_id' => $otherUser->id,
                'name' => $otherUser->name,
                'foto_profil' => $otherUser->foto_profil, 
                'last_message' => $lastChat->message,
                'time' => $lastChat->created_at->format('H:i'),
                'unread_count' => $unreadCount,
            ];
        })->values(); 

        return view('chat.index', [
            'chats' => $formattedList
        ]);
    }

    // [UPDATE] Fungsi show ditambahkan Request untuk menangkap text prefilled DAN back_url
    public function show(Request $request, $userId)
    {
        $receiver = User::findOrFail($userId);
        
        // [BARU] Ambil pesan dari URL parameter (jika ada)
        $prefilledText = $request->query('text', '');

        // [BARU] Tangkap URL untuk tombol kembali
        // Jika 'back_url' ada di URL, pakai itu. Jika tidak, default ke halaman List Chat.
        $backUrl = $request->query('back_url', route('chat.index'));

        return view('chat.show', compact('receiver', 'prefilledText', 'backUrl'));
    }

    // [BARU] Fungsi Jembatan untuk Chat dari Produk
    public function chatWithProduct($id)
    {
        $myId = Auth::id();

        // 1. Cari Produk berdasarkan ID
        $produk = Produk::findOrFail($id);
        
        // 2. Ambil ID Pemilik Produk (Petani)
        $sellerId = $produk->user_id;

        // 3. Cek agar tidak chat diri sendiri
        if ($sellerId == $myId) {
            return back()->with('error', 'Tidak bisa mengirim pesan ke produk sendiri.');
        }

        // 4. Siapkan pesan pembuka
        $message = "Halo, saya tertarik dengan produk *{$produk->nama_produk}*. Apakah stok masih tersedia?";

        // 5. REDIRECT ke route 'chat.show' yang sudah ada
        // Membawa userId penjual, text pesan, DAN back_url ke halaman produk
        return redirect()->route('chat.show', [
            'userId' => $sellerId,
            'text' => $message,
            'back_url' => route('produk.show', $id) // <--- Logika kembali ke halaman produk
        ]);
    }

    // ... (Fungsi sendMessage UPDATE FITUR REPLY) ...
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'reply_to_id' => 'nullable|exists:market_chats,id' // Validasi baru
        ]);

        $chat = MarketChat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'reply_to_id' => $request->reply_to_id, // Simpan reply ID
            'is_read' => false,
        ]);

        // Load relasi reply agar response JSON lengkap (opsional tapi bagus untuk UI instant)
        $chat->load('replyTo.sender');

        return response()->json([
            'success' => true,
            'message' => 'Pesan terkirim',
            'data' => $chat
        ], 201);
    }

    // =========================================================================
    // PERBAIKAN LOGIKA STATUS & WAKTU + LOAD REPLY
    // =========================================================================

    public function getMessages($receiverId)
    {
        $myId = Auth::id();

        // 1. UPDATE status jadi "Dibaca" (TETAP SAMA)
        MarketChat::where('sender_id', $receiverId)
            ->where('receiver_id', $myId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // 2. Ambil Chat (UPDATE: Load Relasi Reply)
        $chats = MarketChat::where(function ($q) use ($myId, $receiverId) {
                $q->where('sender_id', $myId)->where('receiver_id', $receiverId);
            })
            ->orWhere(function ($q) use ($myId, $receiverId) {
                $q->where('sender_id', $receiverId)->where('receiver_id', $myId);
            })
            // Tambahkan 'replyTo.sender' untuk menampilkan nama orang yang direply
            ->with(['sender:id,name', 'receiver:id,name', 'replyTo.sender:id,name']) 
            ->orderBy('created_at', 'asc') 
            ->get();

        // 3. LOGIKA CEK STATUS ONLINE (TETAP SAMA)
        $receiver = User::find($receiverId);
        $isOnline = false;
        $statusText = "Offline";

        if ($receiver && $receiver->last_seen) {
            // A. Cek Status Online Standar (Toleransi 2 menit)
            if ($receiver->last_seen->gt(Carbon::now()->subMinutes(2))) {
                $isOnline = true;
                $statusText = "Online";
            } 
            
            // B. Cek Override Cache
            if (Cache::has('user-force-offline-' . $receiverId)) {
                $isOnline = false;
            }

            // C. Format Teks (Jika Offline)
            if (!$isOnline) {
                $lastSeen = $receiver->last_seen;
                if ($lastSeen->isToday()) {
                    $statusText = "Terakhir dilihat hari ini pukul " . $lastSeen->format('H:i');
                } elseif ($lastSeen->isYesterday()) {
                    $statusText = "Terakhir dilihat kemarin pukul " . $lastSeen->format('H:i');
                } else {
                    $statusText = "Terakhir dilihat " . $lastSeen->format('d/m/y H:i');
                }
            }
        }

        return response()->json([
            'success' => true,
            'data' => $chats,
            'user_status' => [
                'is_online' => $isOnline,
                'text' => $statusText
            ]
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate'); 
    }

    // ... (Fungsi setOffline TETAP SAMA) ...
    public function setOffline()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->last_seen = Carbon::now();
            $user->save();
            Cache::put('user-force-offline-' . $user->id, true, Carbon::now()->addMinutes(2));
        }

        return response()->json(['success' => true, 'status' => 'offline']);
    }
}