<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\Auth;

class MarketplacePortalController extends Controller
{
    private function menuItems(): array
    {
        return [
            ['icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>', 'label' => 'Dashboard',         'route' => 'portal.marketplace.dashboard',    'match' => 'portal.marketplace.dashboard'],
            ['icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>', 'label' => 'Kelola Produk',     'route' => 'petani.produk.index',             'match' => 'petani.produk.*'],
            ['icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>', 'label' => 'Pesanan Masuk',     'route' => 'petani.pesanan.index',            'match' => 'petani.pesanan.*'],
            ['icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>', 'label' => 'Scanner QR',         'route' => 'petani.scan.index',               'match' => 'petani.scan.*'],
            ['icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>', 'label' => 'Midtrans Saya',     'route' => 'petani.midtrans.index',           'match' => 'petani.midtrans.*'],
            ['icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>', 'label' => 'Chat',              'route' => 'chat.index',                      'match' => 'chat.*'],
            ['icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>', 'label' => 'Lihat Marketplace', 'route' => 'produk.index',                    'match' => 'produk.*'],
        ];
    }

    public function dashboard()
    {
        $userId    = Auth::id();
        $produkIds = Produk::where('user_id', $userId)->pluck('id');
        $pesananIds = DetailPesanan::whereIn('produk_id', $produkIds)->pluck('pesanan_id')->unique();

        $stats = [
            'total_produk'   => Produk::where('user_id', $userId)->count(),
            'total_terjual'  => (int) DetailPesanan::whereIn('produk_id', $produkIds)
                ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
                ->whereIn('pesanan.status', ['paid', 'shipping', 'done'])
                ->sum('detail_pesanan.jumlah'),
            'pesanan_aktif'  => Pesanan::whereIn('id', $pesananIds)
                ->whereIn('status', ['pending', 'paid', 'shipping'])
                ->count(),
            'pesanan_masuk'  => Pesanan::whereIn('id', $pesananIds)
                ->whereNotIn('status', ['cancelled'])
                ->count(),
            'pendapatan'     => (float) DetailPesanan::whereIn('produk_id', $produkIds)
                ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
                ->whereIn('pesanan.status', ['paid', 'shipping', 'done'])
                ->sum(\Illuminate\Support\Facades\DB::raw('detail_pesanan.harga_satuan * detail_pesanan.jumlah')),
            'saldo'          => (float) (Auth::user()->saldo ?? 0),
            'saldo_dompet'   => (float) (Auth::user()->saldo ?? 0),
        ];

        $produkTerbaru = Produk::where('user_id', $userId)->latest()->take(5)->get();
        $pesananTerbaru = Pesanan::whereIn('id', $pesananIds)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('portal.marketplace.dashboard', [
            'menuItems'      => $this->menuItems(),
            'stats'          => $stats,
            'produkTerbaru'  => $produkTerbaru,
            'pesananTerbaru' => $pesananTerbaru,
        ]);
    }
}


