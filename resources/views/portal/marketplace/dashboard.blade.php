@php $menuItems = $menuItems ?? []; @endphp
<x-portal-layout portalName="Marketplace" pageTitle="Dashboard Marketplace" :menuItems="$menuItems">

    {{-- Banner Header --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-green-700 via-green-600 to-emerald-600 p-6 md:p-8 text-white shadow-lg mb-6">
        <div class="relative z-10 max-w-2xl">
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Toko dan Penjualan Panen Pekebun</h1>
            <p class="mt-2 text-sm text-emerald-100 leading-relaxed">
                Kelola katalog panen durian segar, pantau pesanan konsumen yang masuk, konfirmasi pengiriman, dan tarik pendapatan langsung ke rekening Anda.
            </p>
            <div class="mt-5 flex flex-wrap gap-2.5">
                <a href="{{ route('petani.produk.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-white text-emerald-800 text-xs font-bold rounded-xl shadow hover:bg-emerald-50 transition">
                    Tambah Produk Baru
                </a>
                <a href="{{ route('petani.pesanan.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-800/60 hover:bg-emerald-800 text-white text-xs font-semibold rounded-xl backdrop-blur-sm border border-emerald-400/30 transition">
                    Pesanan Masuk
                </a>
                <a href="{{ route('petani.scan.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-800/60 hover:bg-emerald-800 text-white text-xs font-semibold rounded-xl backdrop-blur-sm border border-emerald-400/30 transition">
                    Scanner QR Code
                </a>
                <a href="{{ route('petani.midtrans.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-800/60 hover:bg-emerald-800 text-white text-xs font-semibold rounded-xl backdrop-blur-sm border border-emerald-400/30 transition">
                    Midtrans Mandiri
                </a>
                <a href="{{ route('produk.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-800/60 hover:bg-emerald-800 text-white text-xs font-semibold rounded-xl backdrop-blur-sm border border-emerald-400/30 transition">
                    Kunjungi Marketplace
                </a>
            </div>
        </div>
        <div class="absolute -right-6 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
    </div>

    {{-- Midtrans Configuration Alert --}}
    @if(!Auth::user()->hasCustomMidtrans())
        <div class="mb-6 p-4 bg-amber-50 border border-amber-300 rounded-2xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-amber-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <div>
                    <h4 class="font-bold text-amber-900 text-sm">Langkah Pertama: Atur Akun Midtrans Anda</h4>
                    <p class="text-xs text-amber-800 mt-0.5 leading-relaxed">Sebelum dapat menambahkan dan menjual produk, Anda wajib mengisi kredensial akun Midtrans (Server Key, Client Key, Merchant ID). Pembayaran dari konsumen akan langsung masuk ke rekening Anda tanpa perantara.</p>
                </div>
            </div>
            <a href="{{ route('petani.midtrans.index') }}" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 bg-amber-600 text-white text-xs font-bold rounded-xl hover:bg-amber-700 transition flex-shrink-0 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Atur Midtrans Sekarang
            </a>
        </div>
    @endif

    {{-- 5 Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 md:gap-4 mb-6">
        {{-- Total Produk --}}
        <div class="bg-white rounded-2xl p-4 md:p-5 border border-slate-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <span class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">Katalog</span>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-900">{{ $stats['total_produk'] ?? 0 }}</div>
                <div class="text-xs font-semibold text-slate-500 mt-0.5">Total Produk</div>
            </div>
        </div>

        {{-- Terjual --}}
        <div class="bg-white rounded-2xl p-4 md:p-5 border border-slate-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <span class="text-[10px] font-bold uppercase text-emerald-600 tracking-wider">Volume</span>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-900">{{ number_format($stats['total_terjual'] ?? 0, 0, ',', '.') }}</div>
                <div class="text-xs font-semibold text-slate-500 mt-0.5">Total Terjual (Unit)</div>
            </div>
        </div>

        {{-- Pesanan Aktif --}}
        <div class="bg-white rounded-2xl p-4 md:p-5 border border-slate-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-[10px] font-bold uppercase text-green-600 tracking-wider">Proses</span>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-900">{{ $stats['pesanan_aktif'] ?? 0 }}</div>
                <div class="text-xs font-semibold text-slate-500 mt-0.5">Pesanan Aktif</div>
            </div>
        </div>

        {{-- Total Pendapatan --}}
        <div class="bg-white rounded-2xl p-4 md:p-5 border border-slate-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-[10px] font-bold uppercase text-green-600 tracking-wider">Omset</span>
            </div>
            <div>
                <div class="text-xl font-black text-slate-900">Rp {{ number_format($stats['pendapatan'] ?? 0, 0, ',', '.') }}</div>
                <div class="text-xs font-semibold text-slate-500 mt-0.5">Total Pendapatan</div>
            </div>
        </div>

        {{-- Midtrans Gateway Mandiri --}}
        <div class="bg-white rounded-2xl p-4 md:p-5 border border-slate-100 shadow-sm flex flex-col justify-between col-span-2 lg:col-span-1">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <a href="{{ route('petani.midtrans.index') }}" class="text-[10px] font-bold uppercase text-emerald-700 hover:underline">Kelola &rarr;</a>
            </div>
            <div>
                <div class="text-base sm:text-lg font-black text-emerald-700">
                    {{ Auth::user()->hasCustomMidtrans() ? 'Akun Mandiri' : 'Default' }}
                </div>
                <div class="text-xs font-semibold text-slate-500 mt-0.5">Midtrans Gateway</div>
            </div>
        </div>
    </div>

    {{-- 2 Columns: Pesanan Terbaru & Produk Anda --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Column 1: Pesanan Terbaru --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-5 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">Pesanan Terbaru Masuk</h3>
                        <p class="text-[11px] text-slate-400">Transaksi produk toko Anda</p>
                    </div>
                </div>
                <a href="{{ route('petani.pesanan.index') }}" class="text-xs text-emerald-600 font-bold hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            @forelse($pesananTerbaru as $ps)
                @php
                    $statusStyles = [
                        'pending'   => 'bg-green-50 text-green-700 border-green-200',
                        'paid'      => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'shipping'  => 'bg-green-50 text-green-700 border-green-200',
                        'done'      => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'cancelled' => 'bg-green-100 text-green-800 border-green-300',
                    ];
                    $badgeStyle = $statusStyles[$ps->status] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                @endphp
                <div class="flex items-center justify-between gap-3 py-3 border-b border-slate-100 last:border-0 hover:bg-slate-50/50 rounded-xl px-2 transition">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <a href="{{ route('petani.pesanan.show', $ps->id) }}" class="text-xs font-bold text-slate-900 hover:text-emerald-600 font-mono truncate block">
                                {{ $ps->kode_pesanan }}
                            </a>
                            <p class="text-[11px] text-slate-500 truncate">
                                {{ $ps->user->name ?? 'Pelanggan' }} &bull; Rp {{ number_format($ps->total_harga, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-lg border uppercase tracking-wider {{ $badgeStyle }}">
                            {{ $ps->status }}
                        </span>
                        <a href="{{ route('petani.pesanan.show', $ps->id) }}" class="p-1.5 text-slate-400 hover:text-emerald-600 transition" title="Lihat Detail">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <p class="text-sm font-medium">Belum ada pesanan masuk.</p>
                    <p class="text-xs text-slate-400 mt-1">Pesanan dari konsumen akan muncul di sini.</p>
                </div>
            @endforelse
        </div>

        {{-- Column 2: Produk Anda --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-5 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">Produk Anda di Toko</h3>
                        <p class="text-[11px] text-slate-400">Daftar panen aktif dijual</p>
                    </div>
                </div>
                <a href="{{ route('petani.produk.index') }}" class="text-xs text-emerald-600 font-bold hover:underline">
                    Kelola Katalog &rarr;
                </a>
            </div>

            @forelse($produkTerbaru as $pr)
                <div class="flex items-center justify-between gap-3 py-3 border-b border-slate-100 last:border-0 hover:bg-slate-50/50 rounded-xl px-2 transition">
                    <div class="flex items-center gap-3 min-w-0">
                        @if($pr->foto_produk)
                            <img src="{{ asset('storage/' . $pr->foto_produk) }}" class="w-11 h-11 rounded-xl object-cover bg-slate-100 flex-shrink-0" alt="{{ $pr->nama_produk }}">
                        @else
                            <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div class="min-w-0">
                            <div class="flex items-center gap-1.5">
                                <p class="text-xs font-bold text-slate-900 truncate">{{ $pr->nama_produk }}</p>
                                @if($pr->tipe_produk === 'booking_panen')
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-md bg-amber-100 text-amber-800 flex-shrink-0">Booking Panen</span>
                                @else
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-md bg-emerald-100 text-emerald-800 flex-shrink-0">Ready Stock</span>
                                @endif
                            </div>
                            <p class="text-[11px] font-bold text-emerald-600 mt-0.5">Rp {{ number_format($pr->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded-lg {{ $pr->stok > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-green-100 text-green-800' }}">
                            Stok: {{ $pr->stok }}
                        </span>
                        <a href="{{ route('petani.produk.edit', $pr->id) }}" class="text-xs font-semibold text-green-600 hover:text-green-800 transition">
                            Edit
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <p class="text-sm font-medium">Belum ada produk yang dijual.</p>
                    <p class="text-xs text-slate-400 mt-1">Mulai tambahkan hasil panen durian Anda sekarang.</p>
                </div>
            @endforelse

            <div class="mt-4 pt-3 border-t border-slate-100">
                <a href="{{ route('petani.produk.create') }}" class="flex items-center justify-center gap-2 w-full py-2.5 text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Produk Baru
                </a>
            </div>
        </div>

    </div>

</x-portal-layout>

