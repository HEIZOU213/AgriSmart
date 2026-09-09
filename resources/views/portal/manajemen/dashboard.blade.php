@php $menuItems = $menuItems ?? []; @endphp
<x-portal-layout portalName="Manajemen Kebun" pageTitle="Dashboard Manajemen" :menuItems="$menuItems">

{{-- Alert Notifikasi --}}
@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-sm font-medium flex items-center justify-between shadow-sm animate-fade-in">
        <div class="flex items-center gap-3">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 flex-shrink-0"></span>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-xs font-bold px-2 py-1">✕</button>
    </div>
@endif

{{-- Header Banner Manajemen --}}
<div class="bg-gradient-to-br from-green-700 via-green-600 to-emerald-600 rounded-3xl p-6 sm:p-8 text-white shadow-lg mb-8 relative overflow-hidden">
    <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Halo, {{ Auth::user()->name }}!</h1>
            <p class="text-green-100/90 text-sm mt-1.5 max-w-xl">
                Pantau kondisi seluruh blok lahan, inventaris saprotan, catatan hasil panen terintegrasi, dan efisiensi biaya operasional kebun Anda secara akurat.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('portal.manajemen.panen.create') }}" 
               class="inline-flex items-center justify-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs sm:text-sm font-bold rounded-xl transition-all shadow-md">
                + Catat Panen
            </a>
            <a href="{{ route('portal.manajemen.jadwal.create') }}" 
               class="inline-flex items-center justify-center px-4 py-2.5 bg-white/15 hover:bg-white/25 text-white text-xs sm:text-sm font-bold rounded-xl backdrop-blur-md transition-all border border-white/20">
                + Buat Jadwal
            </a>
            <a href="{{ route('portal.manajemen.biaya.create') }}" 
               class="inline-flex items-center justify-center px-4 py-2.5 bg-white/15 hover:bg-white/25 text-white text-xs sm:text-sm font-bold rounded-xl backdrop-blur-md transition-all border border-white/20">
                + Catat Biaya
            </a>
        </div>
    </div>
</div>

{{-- 5 Kartu Statistik Interaktif --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
    {{-- 1. Total Lahan & Luas --}}
    <a href="{{ route('portal.manajemen.lahan.index') }}" 
       class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all group flex flex-col justify-between">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            </div>
            <span class="text-xs text-slate-400 group-hover:text-green-600 transition-colors font-semibold">Lihat &rarr;</span>
        </div>
        <div>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $stats['total_lahan'] }} <span class="text-xs font-semibold text-slate-400">Blok</span></div>
            <div class="text-xs font-semibold text-slate-500 mt-1">Total Luas: {{ number_format($stats['total_luas_ha'], 2, ',', '.') }} Ha</div>
        </div>
    </a>

    {{-- 2. Total Pohon di Kebun --}}
    <a href="{{ route('portal.pertumbuhan.pohon.index') }}" 
       class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all group flex flex-col justify-between">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <span class="text-xs text-slate-400 group-hover:text-emerald-600 transition-colors font-semibold">Lihat &rarr;</span>
        </div>
        <div>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ number_format($stats['total_pohon'], 0, ',', '.') }}</div>
            <div class="text-xs font-semibold text-slate-500 mt-1">Pohon Durian di Lahan</div>
        </div>
    </a>

    {{-- 3. Total Panen & Pendapatan --}}
    <a href="{{ route('portal.manajemen.panen.index') }}" 
       class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all group flex flex-col justify-between">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <span class="text-xs text-slate-400 group-hover:text-green-600 transition-colors font-semibold">Lihat &rarr;</span>
        </div>
        <div>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ number_format($stats['total_panen_kg'], 1, ',', '.') }} <span class="text-xs font-semibold text-slate-400">Kg</span></div>
            <div class="text-xs font-semibold text-green-700 mt-1">Bulan ini: Rp {{ number_format($stats['pendapatan_panen'], 0, ',', '.') }}</div>
        </div>
    </a>

    {{-- 4. Biaya Operasional Bulan Ini --}}
    <a href="{{ route('portal.manajemen.biaya.index') }}" 
       class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all group flex flex-col justify-between">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="text-xs text-slate-400 group-hover:text-green-600 transition-colors font-semibold">Lihat &rarr;</span>
        </div>
        <div>
            <div class="text-xl sm:text-2xl font-extrabold text-green-600 tracking-tight">Rp {{ number_format($stats['biaya_bulan_ini'], 0, ',', '.') }}</div>
            <div class="text-xs font-semibold text-slate-500 mt-1">Biaya Operasional Bln Ini</div>
        </div>
    </a>

    {{-- 5. Jadwal Kebun Tertunda --}}
    <a href="{{ route('portal.manajemen.jadwal.index') }}" 
       class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all group flex flex-col justify-between">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="text-xs text-slate-400 group-hover:text-green-600 transition-colors font-semibold">Lihat &rarr;</span>
        </div>
        <div>
            <div class="text-2xl sm:text-3xl font-extrabold text-green-600 tracking-tight">{{ $stats['jadwal_pending'] }}</div>
            <div class="text-xs font-semibold text-slate-500 mt-1">Jadwal Perlu Dilakukan</div>
        </div>
    </a>
</div>

{{-- Main Content Grid: Jadwal & Panen Terbaru --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    {{-- Jadwal Kebun Mendatang --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-7 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-800 text-base">Jadwal Kebun Perlu Tindakan</h3>
                        <p class="text-xs text-slate-400">Kegiatan operasional pending yang terdekat</p>
                    </div>
                </div>
                <a href="{{ route('portal.manajemen.jadwal.index') }}" class="text-xs font-bold text-green-600 hover:text-green-700">Semua &rarr;</a>
            </div>

            <div class="space-y-3">
                @forelse($jadwalMendatang as $j)
                <div class="p-3.5 rounded-2xl bg-slate-50/70 border border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-slate-50 transition-colors">
                    <div class="min-w-0 flex-1">
                        <div class="font-extrabold text-slate-800 text-sm truncate">{{ $j->jenis_aktivitas }}</div>
                        <div class="flex items-center gap-2 mt-1 text-xs text-slate-500 font-medium">
                            <span class="text-green-600 font-semibold">{{ $j->lahan->nama_lahan ?? 'Semua Lahan' }}</span>
                            <span>&bull;</span>
                            <span>{{ $j->tanggal ? $j->tanggal->format('d M Y') : '-' }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 flex-shrink-0">
                        <form action="{{ route('portal.manajemen.jadwal.selesai', $j) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" title="Tandai Selesai" 
                                    class="px-2.5 py-1 bg-emerald-100 hover:bg-emerald-600 text-emerald-700 hover:text-white rounded-lg text-xs font-bold transition-colors">
                                Selesai
                            </button>
                        </form>
                        <a href="{{ route('portal.manajemen.jadwal.edit', $j) }}" title="Edit"
                           class="p-1 text-slate-400 hover:text-green-600 hover:bg-white rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <div class="w-10 h-10 rounded-xl bg-slate-50 text-green-100/90 mx-auto flex items-center justify-center mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-xs text-slate-400 font-medium">Tidak ada jadwal pending saat ini.</p>
                </div>
                @endforelse
            </div>
        </div>
        <a href="{{ route('portal.manajemen.jadwal.create') }}" 
           class="mt-4 w-full py-2.5 bg-slate-50 hover:bg-green-50 text-slate-600 hover:text-green-700 font-bold text-xs rounded-xl text-center border border-slate-200/80 transition-all block">
            + Tambah Agenda Jadwal Baru
        </a>
    </div>

    {{-- Hasil Panen Terkini --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-7 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-800 text-base">Hasil Panen Terkini</h3>
                        <p class="text-xs text-slate-400">Pencatatan buah durian yang siap dipasarkan</p>
                    </div>
                </div>
                <a href="{{ route('portal.manajemen.panen.index') }}" class="text-xs font-bold text-green-600 hover:text-green-700">Semua &rarr;</a>
            </div>

            <div class="space-y-3">
                @forelse($panenTerbaru as $p)
                <div class="p-3.5 rounded-2xl bg-green-50/40 border border-green-100/60 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-green-50/70 transition-colors">
                    <div class="min-w-0 flex-1">
                        <div class="font-extrabold text-slate-800 text-sm flex items-center gap-2">
                            <span>{{ $p->varietas }}</span>
                            @if($p->pohon)
                                <span class="text-[10px] font-mono font-bold px-1.5 py-0.5 rounded bg-green-100 text-green-700">{{ $p->pohon->kode_pohon }}</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 mt-1 text-xs text-slate-500 font-medium">
                            <span>{{ $p->lahan->nama_lahan ?? 'Kebun Utama' }}</span>
                            <span>&bull;</span>
                            <span class="font-bold text-slate-700">{{ number_format($p->jumlah_kg, 1, ',', '.') }} Kg</span>
                            @if($p->harga_per_kg)
                                <span>&bull;</span>
                                <span class="text-emerald-700 font-extrabold">Rp {{ number_format($p->jumlah_kg * $p->harga_per_kg, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('petani.produk.create', ['varietas' => $p->varietas, 'stok' => (int)$p->jumlah_kg, 'harga' => $p->harga_per_kg ?: 100000]) }}" 
                           class="px-2.5 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm inline-flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            Jual di Toko
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <div class="w-10 h-10 rounded-xl bg-slate-50 text-green-100/90 mx-auto flex items-center justify-center mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <p class="text-xs text-slate-400 font-medium">Belum ada panen yang tercatat baru-baru ini.</p>
                </div>
                @endforelse
            </div>
        </div>
        <a href="{{ route('portal.manajemen.panen.create') }}" 
           class="mt-4 w-full py-2.5 bg-green-50 hover:bg-green-100 text-green-700 font-bold text-xs rounded-xl text-center border border-green-200 transition-all block">
            Catat Hasil Panen Baru
        </a>
    </div>
</div>

{{-- Secondary Content Grid: Kondisi Lahan & Peringatan Stok --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Kondisi Blok Lahan --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-7">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-800 text-base">Kondisi Blok Lahan</h3>
                    <p class="text-xs text-slate-400">Status kesiapan dan populasi pohon per blok</p>
                </div>
            </div>
            <a href="{{ route('portal.manajemen.lahan.index') }}" class="text-xs font-bold text-green-600 hover:text-green-700">Kelola Lahan &rarr;</a>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($lahanList as $l)
            <div class="py-3.5 flex items-center justify-between gap-3">
                <div>
                    <div class="font-extrabold text-slate-800 text-sm">{{ $l->nama_lahan }}</div>
                    <div class="text-xs text-slate-400 mt-0.5">
                        Luas: {{ $l->luas_ha }} Ha &bull; {{ $l->jumlah_pohon ?? 0 }} Pohon Durian
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $l->kondisi == 'baik' ? 'bg-emerald-100 text-emerald-700' : ($l->kondisi == 'buruk' ? 'bg-green-100 text-green-700' : 'bg-green-100 text-green-700') }}">
                        {{ ucfirst($l->kondisi) }}
                    </span>
                    <a href="{{ route('portal.manajemen.lahan.edit', $l) }}" class="p-1 text-green-100/90 hover:text-green-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    </a>
                </div>
            </div>
            @empty
            <p class="text-sm text-slate-400 text-center py-6">Belum ada data lahan yang terdaftar.</p>
            @endforelse
        </div>
    </div>

    {{-- Peringatan Stok Operasional (Sisa <= 5) --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-7">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-800 text-base">Peringatan Stok Operasional</h3>
                    <p class="text-xs text-slate-400">Saprotan & perlengkapan yang menipis (Sisa &le; 5)</p>
                </div>
            </div>
            <a href="{{ route('portal.manajemen.stok.index') }}" class="text-xs font-bold text-green-600 hover:text-green-700">Inventaris Stok &rarr;</a>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($stokMenipis as $s)
            <div class="py-3.5 flex items-center justify-between gap-3">
                <div>
                    <div class="font-extrabold text-slate-800 text-sm">{{ $s->nama_barang }}</div>
                    <div class="text-xs text-slate-400 mt-0.5">Kategori: {{ $s->kategori }}</div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 rounded-full text-xs font-black {{ $s->jumlah <= 0 ? 'bg-green-100 text-green-700' : 'bg-green-100 text-amber-800' }}">
                        {{ $s->jumlah <= 0 ? 'HABIS' : 'Sisa ' . $s->jumlah . ' ' . $s->satuan }}
                    </span>
                    <a href="{{ route('portal.manajemen.stok.edit', $s) }}" class="p-1 text-green-100/90 hover:text-green-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-6">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 mx-auto flex items-center justify-center mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <p class="text-xs text-slate-500 font-semibold">Semua persediaan sarana produksi dalam kondisi aman.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
</x-portal-layout>
