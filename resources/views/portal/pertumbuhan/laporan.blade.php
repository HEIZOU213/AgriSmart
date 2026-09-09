<x-portal-layout portalName="Pertumbuhan" pageTitle="Laporan Pertumbuhan" :menuItems="$menuItems">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Laporan & Rekap Pertumbuhan Pohon</h2>
            <p class="text-xs text-slate-500 mt-1">Ringkasan analitik sebaran fase pertumbuhan durian dan status kesehatan pohon</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('portal.pertumbuhan.pohon.create') }}" 
               class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-xl transition-all shadow-sm">
                + Tambah Pohon
            </a>
            <a href="{{ route('portal.pertumbuhan.monitoring.create') }}" 
               class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl transition-all shadow-sm">
                + Catat Monitoring
            </a>
        </div>
    </div>

    @php
        $totalPohonFase = $rekapFase->sum('total') ?: 1;
        $totalPohonKondisi = $rekapKondisi->sum('total') ?: 1;
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Rekap Berdasarkan Fase --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-green-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-base">Sebaran Fase Pertumbuhan</h3>
                        <p class="text-xs text-slate-400">Distribusi pohon berdasarkan tahapan tanam</p>
                    </div>
                </div>
                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg">
                    Total: {{ $rekapFase->sum('total') }} Pohon
                </span>
            </div>

            <div class="space-y-4">
                @php
                    $faseColors = [
                        'bibit' => 'bg-emerald-500',
                        'vegetatif' => 'bg-blue-500',
                        'generatif' => 'bg-amber-500',
                        'produktif' => 'bg-purple-500',
                    ];
                @endphp
                @forelse($rekapFase as $r)
                    @php
                        $pct = round(($r->total / $totalPohonFase) * 100);
                        $color = $faseColors[$r->fase] ?? 'bg-slate-500';
                    @endphp
                    <a href="{{ route('portal.pertumbuhan.pohon.index', ['fase' => $r->fase]) }}" 
                       class="block p-3 rounded-2xl hover:bg-slate-50 transition-all group">
                        <div class="flex items-center justify-between text-xs mb-1.5">
                            <span class="font-bold text-slate-800 group-hover:text-green-600 capitalize flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full {{ $color }}"></span>
                                Fase {{ ucfirst($r->fase) }}
                            </span>
                            <span class="font-extrabold text-slate-900">{{ $r->total }} pohon ({{ $pct }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="{{ $color }} h-2 rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </a>
                @empty
                    <p class="text-xs text-slate-400 text-center py-6">Belum ada data fase pohon.</p>
                @endforelse
            </div>
        </div>

        {{-- Rekap Berdasarkan Kondisi --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-base">Status Kesehatan Pohon</h3>
                        <p class="text-xs text-slate-400">Tingkat kesehatan dan kebutuhan perhatian</p>
                    </div>
                </div>
                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg">
                    Total: {{ $rekapKondisi->sum('total') }} Pohon
                </span>
            </div>

            <div class="space-y-4">
                @php
                    $kondisiColors = [
                        'sehat' => 'bg-green-500',
                        'perawatan' => 'bg-amber-500',
                        'bermasalah' => 'bg-red-500',
                    ];
                @endphp
                @forelse($rekapKondisi as $r)
                    @php
                        $pct = round(($r->total / $totalPohonKondisi) * 100);
                        $color = $kondisiColors[$r->kondisi] ?? 'bg-slate-500';
                    @endphp
                    <a href="{{ route('portal.pertumbuhan.pohon.index', ['kondisi' => $r->kondisi]) }}" 
                       class="block p-3 rounded-2xl hover:bg-slate-50 transition-all group">
                        <div class="flex items-center justify-between text-xs mb-1.5">
                            <span class="font-bold text-slate-800 group-hover:text-green-600 capitalize flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full {{ $color }}"></span>
                                Pohon {{ ucfirst($r->kondisi) }}
                            </span>
                            <span class="font-extrabold text-slate-900">{{ $r->total }} pohon ({{ $pct }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="{{ $color }} h-2 rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </a>
                @empty
                    <p class="text-xs text-slate-400 text-center py-6">Belum ada data kondisi pohon.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-portal-layout>
