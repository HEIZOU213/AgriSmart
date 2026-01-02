<?php

namespace App\Http\Controllers;

use App\Models\MarketChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketChatController extends Controller
{
    // API: Kirim Pesan
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
            'is_read' => false, // Default belum dibaca
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesan terkirim',
            'data' => $chat
        ], 201);
    }

    // API: Ambil Riwayat Chat (Detail) + TANDAI DIBACA
    public function getMessages($receiverId)
    {
        $myId = Auth::id();

        // 1. UPDATE status jadi "Dibaca" (Hanya pesan dari DIA ke SAYA)
        MarketChat::where('sender_id', $receiverId)
            ->where('receiver_id', $myId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // 2. Ambil semua chat
        $chats = MarketChat::where(function ($q) use ($myId, $receiverId) {
                $q->where('sender_id', $myId)->where('receiver_id', $receiverId);
            })
            ->orWhere(function ($q) use ($myId, $receiverId) {
                $q->where('sender_id', $receiverId)->where('receiver_id', $myId);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $chats
        ]);
    }

    // API: List Inbox (DENGAN HITUNG UNREAD)
    public function getChatList()
    {
        $myId = Auth::id();

        // 1. Ambil semua pesan
        $allChats = MarketChat::where('sender_id', $myId)
            ->orWhere('receiver_id', $myId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Kelompokkan per User
        $chatList = $allChats->groupBy(function ($chat) use ($myId) {
            return $chat->sender_id == $myId ? $chat->receiver_id : $chat->sender_id;
        });

        // 3. Format Data
        $formattedList = $chatList->map(function ($chats) use ($myId) {
            $lastChat = $chats->first();
            $isMeSender = ($lastChat->sender_id == $myId);
            
            // Tentukan data lawan bicara
            $otherUser = $isMeSender ? $lastChat->receiver : $lastChat->sender;
            $otherUserId = $isMeSender ? $lastChat->receiver_id : $lastChat->sender_id;

            // Jika user terhapus
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

            // --- HITUNG JUMLAH PESAN BELUM DIBACA ---
            // Hitung dari koleksi $chats yang sudah diambil (lebih efisien daripada query ulang)
            $unreadCount = $chats->where('sender_id', $otherUserId) // Dari dia
                                 ->where('receiver_id', $myId)      // Ke saya
                                 ->where('is_read', false)          // Belum dibaca
                                 ->count();
            // ----------------------------------------

            return [
                'user_id' => $otherUser->id,
                'name' => $otherUser->name,
                'foto_profil' => $otherUser->foto_profil,
                'last_message' => $lastChat->message,
                'time' => $lastChat->created_at->format('H:i'), // Format jam lebih rapi
                'unread_count' => $unreadCount, // <--- INI YANG DITUNGGU FLUTTER
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data' => $formattedList
        ]);
    }
}