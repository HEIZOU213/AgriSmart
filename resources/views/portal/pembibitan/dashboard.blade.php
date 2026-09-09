@php $menuItems = $menuItems ?? []; @endphp
<x-portal-layout portalName="Pembibitan" pageTitle="Dashboard Pembibitan" :menuItems="$menuItems">

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

{{-- Header Banner --}}
<div class="bg-gradient-to-br from-green-700 via-green-600 to-emerald-600 rounded-3xl p-6 sm:p-8 text-white shadow-lg mb-8 relative overflow-hidden">
    <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="text-emerald-100/90 text-sm mt-1.5 max-w-xl">
                Kelola siklus persemaian bibit, pantau kondisi kesehatan, jadwalkan perawatan rutin, dan siapkan bibit unggul Anda untuk ditanam.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('portal.pembibitan.pengadaan.create') }}" 
               class="inline-flex items-center justify-center px-4 py-2.5 bg-white/15 hover:bg-white/25 text-white text-xs sm:text-sm font-bold rounded-xl backdrop-blur-md transition-all border border-white/20 shadow-sm">
                + Pengadaan Bibit
            </a>
            <a href="{{ route('portal.pembibitan.bibit.create') }}" 
               class="inline-flex items-center justify-center px-5 py-2.5 bg-white text-emerald-800 hover:bg-emerald-50 text-xs sm:text-sm font-extrabold rounded-xl transition-all shadow-md hover:shadow-lg">
                + Tambah Bibit
            </a>
        </div>
    </div>
</div>

{{-- 5 Kartu Statistik Interaktif --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
    {{-- 1. Total Bibit --}}
    <a href="{{ route('portal.pembibitan.bibit.index') }}" 
       class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all group flex flex-col justify-between">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            </div>
            <span class="text-xs text-slate-400 group-hover:text-green-600 transition-colors font-semibold">Lihat &rarr;</span>
        </div>
        <div>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ number_format($stats['total_bibit'], 0, ',', '.') }}</div>
            <div class="text-xs font-semibold text-slate-500 mt-1">Total Bibit Hidup</div>
        </div>
    </a>

    {{-- 2. Bibit Aktif --}}
    <a href="{{ route('portal.pembibitan.bibit.index', ['status' => 'aktif']) }}" 
       class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all group flex flex-col justify-between">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="text-xs text-slate-400 group-hover:text-green-600 transition-colors font-semibold">Lihat &rarr;</span>
        </div>
        <div>
            <div class="text-2xl sm:text-3xl font-extrabold text-green-700 tracking-tight">{{ number_format($stats['bibit_aktif'], 0, ',', '.') }}</div>
            <div class="text-xs font-semibold text-slate-500 mt-1">Fase Persemaian Aktif</div>
        </div>
    </a>

    {{-- 3. Bibit Sehat --}}
    <a href="{{ route('portal.pembibitan.bibit.index', ['kondisi' => 'sehat']) }}" 
       class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all group flex flex-col justify-between">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            <span class="text-xs text-slate-400 group-hover:text-emerald-600 transition-colors font-semibold">Lihat &rarr;</span>
        </div>
        <div>
            <div class="text-2xl sm:text-3xl font-extrabold text-emerald-700 tracking-tight">{{ number_format($stats['bibit_sehat'], 0, ',', '.') }}</div>
            <div class="text-xs font-semibold text-slate-500 mt-1">Kondisi Sehat Prima</div>
        </div>
    </a>

    {{-- 4. Dalam Perawatan --}}
    <a href="{{ route('portal.pembibitan.bibit.index', ['status' => 'perawatan']) }}" 
       class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all group flex flex-col justify-between">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
            </div>
            <span class="text-xs text-slate-400 group-hover:text-green-600 transition-colors font-semibold">Lihat &rarr;</span>
        </div>
        <div>
            <div class="text-2xl sm:text-3xl font-extrabold text-green-600 tracking-tight">{{ number_format($stats['bibit_perawatan'], 0, ',', '.') }}</div>
            <div class="text-xs font-semibold text-slate-500 mt-1">Dalam Perawatan Khusus</div>
        </div>
    </a>

    {{-- 5. Siap Tanam --}}
    <a href="{{ route('portal.pembibitan.bibit.index', ['status' => 'siap_tanam']) }}" 
       class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all group flex flex-col justify-between col-span-2 sm:col-span-1">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 13l4 4L19 7"/></svg>
            </div>
            <span class="text-xs text-slate-400 group-hover:text-emerald-600 transition-colors font-semibold">Tanam &rarr;</span>
        </div>
        <div>
            <div class="text-2xl sm:text-3xl font-extrabold text-emerald-600 tracking-tight">{{ number_format($stats['bibit_siap_tanam'], 0, ',', '.') }}</div>
            <div class="text-xs font-semibold text-slate-500 mt-1">Siap Pindah ke Lahan</div>
        </div>
    </a>
</div>

{{-- Main Grid --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    {{-- KARTU 1: Jadwal Perawatan (Hari Ini & Perlu Tindakan) --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-base">Jadwal Perawatan Perlu Tindakan</h3>
                        <p class="text-xs text-slate-400">Jadwal yang belum diselesaikan</p>
                    </div>
                </div>
                <a href="{{ route('portal.pembibitan.jadwal.index') }}" class="text-xs text-emerald-600 font-bold hover:underline">Lihat Semua</a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($jadwalHariIni as $j)
                <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 group">
                    <div class="flex items-start gap-3 min-w-0">
                        @php
                            $isOverdue = $j->tanggal_jadwal && $j->tanggal_jadwal->isPast() && !$j->tanggal_jadwal->isToday();
                            $isToday = $j->tanggal_jadwal && $j->tanggal_jadwal->isToday();
                        @endphp
                        <span class="mt-1.5 w-2.5 h-2.5 rounded-full flex-shrink-0 {{ $isOverdue ? 'bg-red-500' : ($isToday ? 'bg-emerald-500' : 'bg-blue-400') }}"></span>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-slate-800 truncate group-hover:text-emerald-700 transition-colors">{{ $j->jenis_perawatan }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Bibit: <span class="font-semibold text-slate-700">{{ $j->bibit->nama_varietas ?? 'Bibit #' . $j->bibit_id }}</span> 
                                <span class="text-slate-400">({{ $j->bibit->kode_bibit ?? '-' }})</span>
                            </p>
                            <div class="mt-1 flex items-center gap-2">
                                @if($isOverdue)
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-red-100 text-red-700">Terlewat ({{ $j->tanggal_jadwal->format('d M Y') }})</span>
                                @elseif($isToday)
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-emerald-100 text-emerald-700">Hari Ini</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-600">{{ $j->tanggal_jadwal ? $j->tanggal_jadwal->format('d M Y') : '-' }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-1.5 flex-shrink-0">
                        <form action="{{ route('portal.pembibitan.jadwal.selesai', $j) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" title="Tandai Selesai"
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Selesai
                            </button>
                        </form>
                        <a href="{{ route('portal.pembibitan.jadwal.edit', $j) }}" 
                           title="Edit Jadwal"
                           class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-colors inline-flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                        <form action="{{ route('portal.pembibitan.jadwal.destroy', $j) }}" method="POST" class="inline" onsubmit="return confirm('Hapus jadwal perawatan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" title="Hapus Jadwal"
                                    class="p-1.5 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white rounded-xl text-xs font-bold transition-all shadow-sm inline-flex items-center justify-center">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-300 mx-auto flex items-center justify-center mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-xs font-semibold text-slate-500">Tidak ada jadwal perawatan yang tertunda.</p>
                    <a href="{{ route('portal.pembibitan.jadwal.create') }}" class="inline-block mt-3 text-xs font-bold text-emerald-600 hover:underline">Buat Jadwal Baru</a>
                </div>
                @endforelse
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-slate-100">
            <a href="{{ route('portal.pembibitan.jadwal.create') }}" class="w-full py-2.5 rounded-xl border border-dashed border-slate-200 hover:border-emerald-400 text-slate-500 hover:text-emerald-700 text-xs font-bold flex items-center justify-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Jadwal Perawatan Bibit
            </a>
        </div>
    </div>

    {{-- KARTU 2: Bibit Perhatian Khusus --}}
    <div class="bg-white rounded-3xl border border-red-100 shadow-sm p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-base">Bibit Perlu Perhatian</h3>
                        <p class="text-xs text-red-500 font-medium">Kondisi kritis atau kurang sehat</p>
                    </div>
                </div>
                <a href="{{ route('portal.pembibitan.bibit.index', ['kondisi' => 'kritis']) }}" class="text-xs text-red-600 font-bold hover:underline">Kelola Data</a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($bibitPerhatian as $b)
                <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-start gap-3 min-w-0">
                        <span class="mt-1.5 w-2.5 h-2.5 rounded-full flex-shrink-0 {{ $b->kondisi === 'kritis' ? 'bg-red-500' : 'bg-amber-500' }}"></span>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-slate-800 truncate">{{ $b->nama_varietas }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">Kode: <span class="font-mono text-slate-700 font-bold">{{ $b->kode_bibit }}</span> &bull; Stok: <span class="font-bold text-slate-700">{{ $b->jumlah }}</span> bibit</p>
                            <div class="mt-1">
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold {{ $b->kondisi === 'kritis' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700' }}">
                                    Kondisi: {{ ucfirst(str_replace('_', ' ', $b->kondisi)) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-1.5 flex-shrink-0">
                        <a href="{{ route('portal.pembibitan.monitoring.create', ['bibit_id' => $b->id]) }}" 
                           class="px-2.5 py-1.5 bg-teal-50 hover:bg-teal-600 text-teal-700 hover:text-white rounded-xl text-xs font-bold transition-all shadow-sm" title="Catat Monitoring untuk bibit ini">
                            Monitoring
                        </a>
                        <a href="{{ route('portal.pembibitan.bibit.edit', $b) }}" 
                           title="Edit Bibit"
                           class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-colors inline-flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                        <form action="{{ route('portal.pembibitan.bibit.destroy', $b) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data bibit ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" title="Hapus Bibit"
                                    class="p-1.5 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white rounded-xl text-xs font-bold transition-all shadow-sm inline-flex items-center justify-center">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-500 mx-auto flex items-center justify-center mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-xs font-bold text-slate-700">Kondisi Bibit Sangat Baik</p>
                    <p class="text-xs text-slate-400 mt-0.5">Tidak ada bibit dalam kondisi kritis atau sakit.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-slate-100">
            <a href="{{ route('portal.pembibitan.monitoring.create') }}" class="w-full py-2.5 rounded-xl border border-dashed border-slate-200 hover:border-green-400 text-slate-500 hover:text-green-700 text-xs font-bold flex items-center justify-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Catat Pemeriksaan Monitoring Bibit
            </a>
        </div>
    </div>

    {{-- KARTU 3: Monitoring Terbaru --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-base">Monitoring Perkembangan Terbaru</h3>
                        <p class="text-xs text-slate-400">Catatan tinggi & kondisi terkini bibit</p>
                    </div>
                </div>
                <a href="{{ route('portal.pembibitan.monitoring.index') }}" class="text-xs text-green-600 font-bold hover:underline">Lihat Semua</a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($aktivitasTerbaru as $m)
                <div class="py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-start gap-3 min-w-0">
                        <span class="mt-1.5 w-2.5 h-2.5 rounded-full flex-shrink-0 {{ $m->kondisi === 'sehat' ? 'bg-emerald-500' : ($m->kondisi === 'kritis' ? 'bg-red-500' : 'bg-amber-400') }}"></span>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-slate-800 truncate">
                                {{ $m->bibit->nama_varietas ?? 'Bibit #' . $m->bibit_id }}
                                <span class="text-xs font-normal text-slate-400">({{ $m->bibit->kode_bibit ?? '-' }})</span>
                            </p>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Kondisi: <span class="font-semibold text-slate-700 capitalize">{{ str_replace('_',' ',$m->kondisi) }}</span>
                                &bull; {{ $m->tanggal ? \Carbon\Carbon::parse($m->tanggal)->format('d M Y') : '-' }}
                            </p>
                            @if($m->catatan)
                                <p class="text-[11px] text-slate-400 mt-0.5 italic truncate">"{{ $m->catatan }}"</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-2 flex-shrink-0">
                        @if($m->tinggi_cm)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-extrabold bg-slate-50 text-slate-700 border border-slate-100">
                            {{ $m->tinggi_cm }} cm
                        </span>
                        @endif
                        <a href="{{ route('portal.pembibitan.monitoring.edit', $m) }}" 
                           title="Edit Monitoring"
                           class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-colors inline-flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                        <form action="{{ route('portal.pembibitan.monitoring.destroy', $m) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data monitoring ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" title="Hapus Monitoring"
                                    class="p-1.5 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white rounded-xl text-xs font-bold transition-all shadow-sm inline-flex items-center justify-center">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <p class="text-xs text-slate-400">Belum ada riwayat monitoring bibit.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-slate-100">
            <a href="{{ route('portal.pembibitan.monitoring.create') }}" class="text-xs font-bold text-green-600 hover:text-green-700 flex items-center justify-center gap-1.5">
                Input Data Monitoring Bibit Baru
            </a>
        </div>
    </div>

    {{-- KARTU 4: Riwayat Pengadaan Terbaru & Pintasan --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-base">Pengadaan Bibit Terkini</h3>
                        <p class="text-xs text-slate-400">Pencatatan bibit masuk & supplier</p>
                    </div>
                </div>
                <a href="{{ route('portal.pembibitan.pengadaan.index') }}" class="text-xs text-green-600 font-bold hover:underline">Lihat Semua</a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($pengadaanTerbaru as $p)
                <div class="py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-slate-800 truncate">{{ $p->nama_varietas }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">Supplier: <span class="font-semibold text-slate-700">{{ $p->nama_supplier }}</span> &bull; {{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</p>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <div class="text-right">
                            <span class="inline-block font-extrabold text-sm text-green-700">+{{ $p->jumlah }} Bibit</span>
                            <div class="text-[11px] text-slate-400">Rp {{ number_format($p->jumlah * $p->harga_satuan, 0, ',', '.') }}</div>
                        </div>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('portal.pembibitan.pengadaan.edit', $p) }}" 
                               title="Edit Pengadaan"
                               class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-colors inline-flex items-center justify-center">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </a>
                            <form action="{{ route('portal.pembibitan.pengadaan.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data pengadaan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Hapus Pengadaan"
                                        class="p-1.5 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white rounded-xl text-xs font-bold transition-all shadow-sm inline-flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <p class="text-xs text-slate-400">Belum ada catatan pengadaan bibit.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('portal.pembibitan.pengadaan.create') }}" class="text-xs font-bold text-green-600 hover:text-green-700 flex items-center gap-1">
                Catat Pengadaan Baru
            </a>
            <a href="{{ route('portal.pembibitan.laporan') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-1">
                Buka Laporan &rarr;
            </a>
        </div>
    </div>
</div>

{{-- Akses Cepat (Quick Access Grid) --}}
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="font-extrabold text-slate-800 text-lg">Pintasan & Akses Cepat</h3>
            <p class="text-xs text-slate-400 mt-0.5">Menu pintasan untuk alur kerja operasional pembibitan</p>
        </div>
        <span class="text-xs px-3 py-1 bg-slate-100 text-slate-600 font-bold rounded-full">5 Menu Utama</span>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        {{-- 1. Tambah Bibit --}}
        <a href="{{ route('portal.pembibitan.bibit.create') }}" 
           class="p-5 rounded-2xl bg-emerald-50/60 hover:bg-emerald-100/60 border border-emerald-100 transition-all group flex flex-col justify-between">
            <div class="w-12 h-12 rounded-xl bg-white text-emerald-600 flex items-center justify-center shadow-sm mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div>
                <span class="block text-sm font-extrabold text-slate-900 group-hover:text-emerald-800">Tambah Bibit</span>
                <span class="text-[11px] text-slate-500 mt-0.5 block">Registrasi batch bibit baru</span>
            </div>
        </a>

        {{-- 2. Catat Monitoring --}}
        <a href="{{ route('portal.pembibitan.monitoring.create') }}" 
           class="p-5 rounded-2xl bg-green-50/60 hover:bg-green-100/60 border border-green-100 transition-all group flex flex-col justify-between">
            <div class="w-12 h-12 rounded-xl bg-white text-green-600 flex items-center justify-center shadow-sm mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <span class="block text-sm font-extrabold text-slate-900 group-hover:text-green-800">Monitoring</span>
                <span class="text-[11px] text-slate-500 mt-0.5 block">Catat kondisi & tinggi bibit</span>
            </div>
        </a>

        {{-- 3. Buat Jadwal --}}
        <a href="{{ route('portal.pembibitan.jadwal.create') }}" 
           class="p-5 rounded-2xl bg-green-50/60 hover:bg-green-100/60 border border-green-100 transition-all group flex flex-col justify-between">
            <div class="w-12 h-12 rounded-xl bg-white text-green-600 flex items-center justify-center shadow-sm mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <span class="block text-sm font-extrabold text-slate-900 group-hover:text-green-800">Buat Jadwal</span>
                <span class="text-[11px] text-slate-500 mt-0.5 block">Jadwalkan siram & pupuk</span>
            </div>
        </a>

        {{-- 4. Pengadaan Bibit --}}
        <a href="{{ route('portal.pembibitan.pengadaan.create') }}" 
           class="p-5 rounded-2xl bg-green-50/60 hover:bg-green-100/60 border border-green-100 transition-all group flex flex-col justify-between">
            <div class="w-12 h-12 rounded-xl bg-white text-green-600 flex items-center justify-center shadow-sm mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <span class="block text-sm font-extrabold text-slate-900 group-hover:text-green-800">Pengadaan</span>
                <span class="text-[11px] text-slate-500 mt-0.5 block">Beli dari supplier bibit</span>
            </div>
        </a>

        {{-- 5. Laporan & Statistik --}}
        <a href="{{ route('portal.pembibitan.laporan') }}" 
           class="p-5 rounded-2xl bg-green-50/60 hover:bg-green-100/60 border border-green-100 transition-all group flex flex-col justify-between col-span-2 sm:col-span-1">
            <div class="w-12 h-12 rounded-xl bg-white text-green-600 flex items-center justify-center shadow-sm mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <div>
                <span class="block text-sm font-extrabold text-slate-900 group-hover:text-green-800">Laporan</span>
                <span class="text-[11px] text-slate-500 mt-0.5 block">Statistik & rekap persemaian</span>
            </div>
        </a>
    </div>
</div>

</x-portal-layout>
