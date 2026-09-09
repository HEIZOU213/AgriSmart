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
        $totalPetani = User::where('role', 'pekebun')->count();
        $totalKonsumen = User::where('role', 'user')->count();
        $totalKonten = KontenEdukasi::count();

        // 2. Statistik Keuangan Marketplace
        
        // A. Hitung Keuntungan Admin (Total kolom admin_fee dari pesanan sukses)
        $keuntunganAdmin = Pesanan::whereIn('status', ['paid', 'shipping', 'done'])
                                  ->sum('admin_fee');

        // B. Total Volume Transaksi Marketplace (Gross Merchandise Value)
        $volumeTransaksi = Pesanan::whereIn('status', ['paid', 'shipping', 'done'])
                                  ->sum('total_harga');

        // Masukkan semua ke array $stats
        $stats = [
            'total_users' => $totalUsers,
            'total_petani' => $totalPetani,
            'total_konsumen' => $totalKonsumen,
            'total_konten_edukasi' => $totalKonten,
            
            // Data Keuangan
            'pendapatan_bersih' => $keuntunganAdmin,
            'volume_transaksi'  => $volumeTransaksi,
        ];

        return view('admin.dashboard', compact('stats'));
    }
}

