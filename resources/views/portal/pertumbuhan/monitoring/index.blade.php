<x-portal-layout portalName="Pertumbuhan" pageTitle="Monitoring Pertumbuhan" :menuItems="$menuItems">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Monitoring Pertumbuhan Pohon</h2>
            <p class="text-xs text-slate-500 mt-1">Riwayat pemeriksaan kondisi fisik, tinggi tanaman, diameter batang, dan kesehatan pohon</p>
        </div>
        <a href="{{ route('portal.pertumbuhan.monitoring.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold rounded-xl shadow-sm transition-all flex-shrink-0 self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            + Catat Monitoring
        </a>
    </div>

    @if(session('success'))
        <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-sm font-medium flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 flex-shrink-0"></span>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-xs font-bold px-2 py-1">✕</button>
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left min-w-[700px]">
                <thead class="bg-slate-50/80 border-b border-slate-100 text-slate-600 uppercase text-[11px] tracking-wider font-bold">
                    <tr>
                        <th class="px-5 py-4 whitespace-nowrap">Pohon</th>
                        <th class="px-5 py-4 whitespace-nowrap">Tanggal</th>
                        <th class="px-5 py-4 whitespace-nowrap">Pengukuran Fisik</th>
                        <th class="px-5 py-4 whitespace-nowrap">Kondisi</th>
                        <th class="px-5 py-4 whitespace-nowrap">Catatan</th>
                        <th class="px-5 py-4 text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($monitoring as $m)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-5 py-4">
                            <div class="font-extrabold text-slate-800 text-sm">{{ $m->pohon->nama_varietas ?? '-' }}</div>
                            <div class="text-xs font-mono text-slate-400 mt-0.5">Kode: {{ $m->pohon->kode_pohon ?? ('#' . $m->pohon_id) }}</div>
                        </td>
                        <td class="px-5 py-4 text-xs font-semibold text-slate-600">
                            {{ $m->tanggal ? $m->tanggal->format('d M Y') : '-' }}
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex flex-wrap items-center gap-1.5 text-xs">
                                @if($m->tinggi_cm)
                                    <span class="px-2 py-0.5 bg-slate-100 rounded-md font-bold text-slate-700">
                                        T: {{ $m->tinggi_cm }} cm
                                    </span>
                                @endif
                                @if($m->diameter_batang)
                                    <span class="px-2 py-0.5 bg-slate-100 rounded-md font-medium text-slate-600">
                                        &Oslash;: {{ $m->diameter_batang }} cm
                                    </span>
                                @endif
                                @if($m->jumlah_cabang)
                                    <span class="px-2 py-0.5 bg-slate-100 rounded-md font-medium text-slate-600">
                                        {{ $m->jumlah_cabang }} cabang
                                    </span>
                                @endif
                                @if(!$m->tinggi_cm && !$m->diameter_batang && !$m->jumlah_cabang)
                                    <span class="text-slate-400 text-xs">-</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            @if($m->kondisi === 'sehat')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Sehat
                                </span>
                            @elseif($m->kondisi === 'perawatan')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Perawatan
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Bermasalah
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-xs text-slate-500 max-w-xs truncate">
                            {{ $m->catatan ?? '-' }}
                        </td>
                        <td class="px-5 py-4 text-center">
                            <div class="inline-flex items-center gap-1.5">
                                <a href="{{ route('portal.pertumbuhan.monitoring.edit', $m) }}" 
                                   title="Edit Monitoring"
                                   class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-colors inline-flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                                <form action="{{ route('portal.pertumbuhan.monitoring.destroy', $m) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data monitoring ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" title="Hapus Monitoring"
                                            class="p-1.5 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white rounded-xl text-xs font-bold transition-all shadow-sm inline-flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                            <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-300 mx-auto flex items-center justify-center mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <p class="font-bold text-slate-600">Belum ada data monitoring pohon.</p>
                            <p class="text-xs text-slate-400 mt-1">Catat perkembangan tinggi batang, diameter, dan kesehatan pohon durian Anda.</p>
                            <a href="{{ route('portal.pertumbuhan.monitoring.create') }}" class="inline-block mt-4 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl transition-colors">Catat Sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">
        {{ $monitoring->links() }}
    </div>
</x-portal-layout>
