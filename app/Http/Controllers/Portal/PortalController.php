<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortalController extends Controller
{
    public function index()
    {
        $portals = [
            [
                'key'         => 'pembibitan',
                'icon'        => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
                'name'        => 'Pembibitan',
                'description' => 'Manajemen data bibit, penyemaian, pengadaan, dan pencatatan monitoring secara terstruktur.',
                'route'       => route('portal.pembibitan.dashboard'),
                'active'      => true,
                'color'       => 'emerald',
            ],
            [
                'key'         => 'pertumbuhan',
                'icon'        => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>',
                'name'        => 'Pertumbuhan',
                'description' => 'Pemantauan fase pertumbuhan, kondisi pohon, dan pencatatan riwayat perawatan.',
                'route'       => route('portal.pertumbuhan.dashboard'),
                'active'      => true,
                'color'       => 'green',
            ],
            [
                'key'         => 'manajemen',
                'icon'        => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>',
                'name'        => 'Manajemen Kebun',
                'description' => 'Administrasi lahan, kontrol stok operasional, rekap panen, dan evaluasi biaya operasional.',
                'route'       => route('portal.manajemen.dashboard'),
                'active'      => true,
                'color'       => 'emerald',
            ],
            [
                'key'         => 'layanan',
                'icon'        => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path></svg>',
                'name'        => 'Layanan IoT',
                'description' => 'Akses kontrol Smart Garden IoT dan integrasi perangkat keras perkebunan secara langsung.',
                'route'       => route('layanan.index'),
                'active'      => true,
                'color'       => 'green',
            ],
            [
                'key'         => 'edukasi',
                'icon'        => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>',
                'name'        => 'Edukasi',
                'description' => 'Pusat pengetahuan, artikel teknis, dan informasi literasi perkebunan terkini.',
                'route'       => route('edukasi.index'),
                'active'      => true,
                'color'       => 'emerald',
            ],
            [
                'key'         => 'marketplace',
                'icon'        => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
                'name'        => 'Marketplace',
                'description' => 'Sistem transaksi hasil kebun, manajemen pesanan konsumen, dan pelacakan pembayaran.',
                'route'       => route('portal.marketplace.dashboard'),
                'active'      => true,
                'color'       => 'green',
            ],
            [
                'key'         => 'hama',
                'icon'        => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01"></path></svg>',
                'name'        => 'Hama & Penyakit',
                'description' => 'Analisis dan monitoring hama penyakit durian terintegrasi (Sedang dalam pengembangan).',
                'route'       => '#',
                'active'      => false,
                'color'       => 'emerald',
            ],
            [
                'key'         => 'chatbot',
                'icon'        => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>',
                'name'        => 'Asisten Virtual',
                'description' => 'Layanan konsultasi pakar dan bantuan analisis perkebunan (Segera Hadir).',
                'route'       => '#',
                'active'      => false,
                'color'       => 'green',
            ]
        ];

        return view('portal.index', compact('portals'));
    }
}
