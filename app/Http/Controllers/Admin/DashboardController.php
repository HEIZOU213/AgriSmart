<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\KontenEdukasi; // Kita ganti dari Pesanan ke KontenEdukasi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Impor Auth

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik baru yang fokus pada Pengguna dan Konten
        $stats = [
            'total_users' => User::count(),
            'total_petani' => User::where('role', 'petani')->count(),
            'total_konsumen' => User::where('role', 'konsumen')->count(),
            'total_konten_edukasi' => KontenEdukasi::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}