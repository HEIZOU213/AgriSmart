<x-portal-layout portalName="Pertumbuhan" pageTitle="Fase Pertumbuhan" :menuItems="$menuItems">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Fase Pertumbuhan Pohon Durian</h2>
            <p class="text-xs text-slate-500 mt-1">Klasifikasi populasi pohon berdasarkan tahapan siklus hidup tanaman durian</p>
        </div>
        <a href="{{ route('portal.pertumbuhan.pohon.create') }}" 
           class="inline-flex items-center justify-center px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl shadow-sm transition-all flex-shrink-0 self-start sm:self-auto">
            + Tambah Pohon
        </a>
    </div>

    @php
        $faseMetadata = [
            'bibit' => [
                'title' => 'Fase Bibit (Muda)',
                'desc' => 'Pohon durian yang baru ditanam dari bibit (usia 0 - 1 tahun), butuh naungan dan penyiraman rutin.',
                'color' => 'emerald',
                'badge' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                'dot' => 'bg-emerald-500',
            ],
            'vegetatif' => [
                'title' => 'Fase Vegetatif',
                'desc' => 'Fokus pertumbuhan akar, batang, dahan primer/sekunder, dan kanopi tajuk daun hijau lebat.',
                'color' => 'blue',
                'badge' => 'bg-blue-100 text-blue-800 border-blue-200',
                'dot' => 'bg-blue-500',
            ],
            'generatif' => [
                'title' => 'Fase Generatif',
                'desc' => 'Pohon mulai memunculkan bunga (mata ketam) hingga bakal pentil buah durian.',
                'color' => 'amber',
                'badge' => 'bg-amber-100 text-amber-800 border-amber-200',
                'dot' => 'bg-amber-500',
            ],
            'produktif' => [
                'title' => 'Fase Produktif',
                'desc' => 'Pohon dewasa yang berbuah secara konsisten dan siap panen durian bermutu tinggi.',
                'color' => 'purple',
                'badge' => 'bg-purple-100 text-purple-800 border-purple-200',
                'dot' => 'bg-purple-500',
            ],
        ];
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($pohonPerFase as $fase => $list)
            @php $meta = $faseMetadata[$fase] ?? ['title' => ucfirst($fase), 'desc' => '', 'badge' => 'bg-slate-100 text-slate-700', 'dot' => 'bg-slate-400']; @endphp
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full {{ $meta['dot'] }}"></span>
                                <h3 class="font-bold text-slate-800 text-base">{{ $meta['title'] }}</h3>
                            </div>
                            <p class="text-xs text-slate-400 mt-1 max-w-sm">{{ $meta['desc'] }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-extrabold text-slate-800">{{ $list->count() }}</span>
                            <span class="text-xs font-semibold text-slate-400 block">pohon</span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        @forelse($list as $p)
                            <div class="p-3 rounded-2xl bg-slate-50/70 hover:bg-slate-100/70 transition-colors flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="font-extrabold text-slate-800 text-xs truncate">{{ $p->nama_varietas }}</div>
                                    <div class="text-[11px] text-slate-500 mt-0.5 flex items-center gap-2">
                                        <span class="font-mono text-slate-600 font-bold">{{ $p->kode_pohon }}</span>
                                        <span>&bull;</span>
                                        <span>{{ $p->lokasi ?? ($p->lahan->nama_lahan ?? 'Kebun Utama') }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ $p->kondisi === 'sehat' ? 'bg-green-100 text-green-700' : ($p->kondisi === 'bermasalah' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                        {{ ucfirst($p->kondisi) }}
                                    </span>
                                    <a href="{{ route('portal.pertumbuhan.monitoring.create', ['pohon_id' => $p->id]) }}" 
                                       title="Catat Monitoring"
                                       class="p-1.5 bg-white hover:bg-teal-50 text-teal-700 border border-slate-200 rounded-lg text-xs font-bold transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </a>
                                    <a href="{{ route('portal.pertumbuhan.pohon.edit', $p) }}" 
                                       title="Edit Pohon"
                                       class="p-1.5 bg-white hover:bg-slate-200 text-slate-600 border border-slate-200 rounded-lg text-xs font-bold transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 text-center py-6">Tidak ada pohon di fase ini.</p>
                        @endforelse
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('portal.pertumbuhan.pohon.index', ['fase' => $fase]) }}" class="text-xs font-bold text-slate-600 hover:text-emerald-700 flex items-center gap-1">
                        Lihat Semua Data Pohon Fase Ini &rarr;
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</x-portal-layout>
