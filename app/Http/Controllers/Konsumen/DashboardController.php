<?php

namespace App\Http\Controllers\Konsumen;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $stats = [
            'total_orders' => Pesanan::where('user_id', $userId)->count(),
            'total_spent' => Pesanan::where('user_id', $userId)->where('status', 'done')->sum('total_harga'),
            'orders_pending' => Pesanan::where('user_id', $userId)->where('status', 'pending')->count(),
            'last_order' => Pesanan::where('user_id', $userId)->orderBy('created_at', 'desc')->first(),
        ];

        return view('konsumen.dashboard', compact('stats'));
    }
}