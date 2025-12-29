<?php

namespace App\Http\Controllers;

use App\Models\MarketChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketChatController extends Controller
{
    // API: Kirim Pesan (Umum/Pra-Beli)
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $chat = MarketChat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesan terkirim',
            'data' => $chat
        ], 201);
    }

    // API: Ambil Riwayat Chat dengan Seseorang (Detail Chat)
    public function getMessages($receiverId)
    {
        $myId = Auth::id();

        $chats = MarketChat::where(function ($q) use ($myId, $receiverId) {
                        $q->where('sender_id', $myId)
                          ->where('receiver_id', $receiverId);
                    })
                    ->orWhere(function ($q) use ($myId, $receiverId) {
                        $q->where('sender_id', $receiverId)
                          ->where('receiver_id', $myId);
                    })
                    ->with(['sender', 'receiver']) // Load data user agar tidak null
                    ->orderBy('created_at', 'asc')
                    ->get();

        return response()->json([
            'success' => true,
            'data' => $chats
        ]);
    }

    // API: Ambil Daftar Orang yang pernah Chat (Inbox List)
    public function getChatList()
    {
        $myId = Auth::id();

        // 1. Ambil semua pesan yang melibatkan saya
        $allChats = MarketChat::where('sender_id', $myId)
            ->orWhere('receiver_id', $myId)
            ->with(['sender', 'receiver']) // Eager load relasi
            ->orderBy('created_at', 'desc') // Urutkan dari yang terbaru
            ->get();

        // 2. Kelompokkan berdasarkan ID "Lawan Bicara"
        $chatList = $allChats->groupBy(function ($chat) use ($myId) {
            return $chat->sender_id == $myId ? $chat->receiver_id : $chat->sender_id;
        });

        // 3. Format data (DENGAN PENGECEKAN NULL/ANTI CRASH)
        $formattedList = $chatList->map(function ($chats) use ($myId) {
            $lastChat = $chats->first();
            
            // Tentukan siapa lawan bicaranya
            $isMeSender = ($lastChat->sender_id == $myId);
            
            // Ambil objek User lawan bicara
            $otherUser = $isMeSender ? $lastChat->receiver : $lastChat->sender;
            
            // Ambil ID Lawan bicara (langsung dari kolom chat, jaga-jaga kalau usernya null)
            $otherUserId = $isMeSender ? $lastChat->receiver_id : $lastChat->sender_id;

            // [PERBAIKAN UTAMA] Cek apakah User masih ada di database?
            if (!$otherUser) {
                // Jika user sudah dihapus, return data placeholder agar tidak error 500
                return [
                    'user_id' => $otherUserId,
                    'name' => "User Tidak Dikenal", // Nama default
                    'foto_profil' => null,
                    'last_message' => $lastChat->message,
                    'time' => $lastChat->created_at->diffForHumans(),
                    'is_read' => true, // Anggap sudah dibaca
                ];
            }

            // Jika user ada, return data normal
            return [
                'user_id' => $otherUser->id,
                'name' => $otherUser->name,
                'foto_profil' => $otherUser->foto_profil,
                'last_message' => $lastChat->message,
                'time' => $lastChat->created_at->diffForHumans(),
                'is_read' => $isMeSender ? true : $lastChat->is_read,
            ];
        })->values(); // Reset array keys

        return response()->json([
            'success' => true,
            'data' => $formattedList
        ]);
    }
}