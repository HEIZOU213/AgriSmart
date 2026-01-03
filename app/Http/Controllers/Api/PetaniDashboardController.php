<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// PENTING: Gunakan Model agar sinkron dengan Checkout
use App\Models\Produk;
use App\Models\DetailPesanan;
use App\Models\Pesanan;

class PetaniDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // 1. Ambil ID semua produk milik petani yang sedang login
        $produkIds = Produk::where('user_id', $user->id)->pluck('id');

        // ==================================================================
        // LOGIKA PERHITUNGAN DATA (MENGGUNAKAN MODEL)
        // ==================================================================

        // A. Total Produk Aktif
        $totalProduk = Produk::where('user_id', $user->id)->count();

        // B. Total Barang Terjual
        // Logic: Hitung jumlah barang di detail_pesanan yang status pesanannya SUKSES
        // Status sukses: paid, shipping, done, completed, shipped, confirmed
        $totalTerjual = DetailPesanan::whereIn('produk_id', $produkIds)
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
            ->whereIn('pesanan.status', ['paid', 'shipping', 'done', 'completed', 'shipped', 'confirmed']) 
            ->sum('detail_pesanan.jumlah'); 

        // C. Total Pendapatan Bersih
        // Logic: Hitung (harga * jumlah) dari pesanan sukses
        $pendapatan = DetailPesanan::whereIn('produk_id', $produkIds)
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
            ->whereIn('pesanan.status', ['paid', 'shipping', 'done', 'completed', 'shipped', 'confirmed'])
            ->sum(DB::raw('detail_pesanan.harga_satuan * detail_pesanan.jumlah'));

        // D. Pesanan Masuk (Aktif)
        // Logic: Hitung pesanan yang statusnya BUKAN cancelled (termasuk pending)
        $pesananBaru = Pesanan::whereIn('id', DetailPesanan::whereIn('produk_id', $produkIds)->pluck('pesanan_id')->unique())
            ->where('status', '!=', 'cancelled') 
            ->count();

        return response()->json([
            'success' => true,
            'message' => 'Data dashboard berhasil diambil',
            'data' => [
                'total_produk'  => $totalProduk,
                'total_terjual' => (int) $totalTerjual,
                'pendapatan'    => (int) $pendapatan,
                'pesanan_baru'  => $pesananBaru,
            ]
        ]);
    }
}