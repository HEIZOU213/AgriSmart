<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Ambil notifikasi milik user ini
        $notifikasi = Notifikasi::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Opsional: Tandai semua sebagai sudah dibaca
        Notifikasi::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            // --- BAGIAN DEBUG (PENTING) ---
            'debug_user_id' => $user->id,       // Kita butuh angka ini!
            'debug_user_name' => $user->name,   // Sekalian cek namanya
            'debug_user_email' => $user->email, // Sekalian cek emailnya
            // ------------------------------
            'message' => 'Daftar notifikasi berhasil diambil',
            'data' => $notifikasi
        ]);
    }

    // TAMBAHKAN FUNGSI INI
    public function countUnread(Request $request)
    {
        $count = \App\Models\Notifikasi::where('user_id', $request->user()->id)
            ->where('is_read', false) // Cari yang belum dibaca
            ->count();

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }
}