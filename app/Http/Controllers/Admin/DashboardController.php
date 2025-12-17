<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\KontenEdukasi;
use App\Models\Pesanan; // <--- WAJIB: Tambahkan Model Pesanan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Dasar (User & Konten)
        $totalUsers = User::count();
        $totalPetani = User::where('role', 'petani')->count();
        $totalKonsumen = User::where('role', 'konsumen')->count();
        $totalKonten = KontenEdukasi::count();

        // 2. Statistik Keuangan (LOGIKA BARU)
        
        // A. Hitung Keuntungan Admin (Total kolom admin_fee dari pesanan sukses)
        // Kita hanya hitung yang statusnya 'paid', 'shipping', atau 'done'
        // Jangan hitung yang 'pending' atau 'cancelled'
        $keuntunganAdmin = Pesanan::whereIn('status', ['paid', 'shipping', 'done'])
                                  ->sum('admin_fee');

        // B. Hitung Dana Mengendap (Total saldo milik semua petani)
        // Ini adalah uang fisik yang ada di rekening Admin, tapi milik Petani
        $danaPetani = User::where('role', 'petani')->sum('saldo');

        // Masukkan semua ke array $stats
        $stats = [
            'total_users' => $totalUsers,
            'total_petani' => $totalPetani,
            'total_konsumen' => $totalKonsumen,
            'total_konten_edukasi' => $totalKonten,
            
            // Data Keuangan
            'pendapatan_bersih' => $keuntunganAdmin,
            'uang_titipan' => $danaPetani
        ];

        return view('admin.dashboard', compact('stats'));
    }
}