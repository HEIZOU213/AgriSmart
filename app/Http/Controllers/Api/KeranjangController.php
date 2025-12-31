<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keranjang; // Pastikan Model Keranjang sudah ada
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    /**
     * Menghitung total item di keranjang user yang sedang login
     */
    public function count(Request $request)
    {
        $user = $request->user();

        // Menghitung jumlah baris data di tabel keranjangs milik user ini
        $count = DB::table('keranjangs')
                    ->where('user_id', $user->id)
                    ->count();

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }
}