<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\DetailPesanan;
use App\Models\Pesanan; // <-- Tambah import Pesanan
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class DashboardController extends Controller
{
    public function index()
    {
        $petaniId = Auth::id();

        // 1. Dapatkan ID produk petani
        $produkIds = Produk::where('user_id', $petaniId)->pluck('id');

        // 2. Hitung statistik
        $stats = [
            'total_products' => Produk::where('user_id', $petaniId)->count(),
            
            // [FIXED] Total Barang Terjual (Hanya hitung item dari pesanan sukses)
            'total_sales_items' => DetailPesanan::whereIn('produk_id', $produkIds)
                ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
                ->whereIn('pesanan.status', ['paid', 'shipping', 'done'])
                ->sum('detail_pesanan.jumlah'), // Sum quantity of successful items
            
            // Total Pendapatan Kotor (Logika ini sudah benar, memfilter status sukses)
            'total_revenue' => DetailPesanan::whereIn('produk_id', $produkIds)
                ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
                ->whereIn('pesanan.status', ['paid', 'shipping', 'done'])
                ->sum(DB::raw('detail_pesanan.harga_satuan * detail_pesanan.jumlah')), 
            
            // [FIXED] Pesanan Masuk Unik (Hanya hitung pesanan yang aktif/belum dibatalkan)
            'incoming_orders' => Pesanan::whereIn('id', DetailPesanan::whereIn('produk_id', $produkIds)->pluck('pesanan_id')->unique())
                ->where('status', '!=', 'cancelled')
                ->count(),
        ];

        return view('petani.dashboard', compact('stats'));
    }
}