<x-portal-layout portalName="Pertumbuhan" pageTitle="Data Pohon" :menuItems="$menuItems">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Data Pohon Durian</h2>
            <p class="text-xs text-slate-500 mt-1">Daftar seluruh populasi pohon durian, status fase perkembangan, dan kesehatannya</p>
        </div>
        <a href="{{ route('portal.pertumbuhan.pohon.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-sm transition-all flex-shrink-0 self-start sm:self-auto">
            + Tambah Pohon
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

    {{-- Filter & Search Card --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 mb-6 space-y-4">
        {{-- Kondisi Pills --}}
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-xs font-bold text-slate-400 mr-1 uppercase tracking-wider">Kondisi:</span>
            <a href="{{ route('portal.pertumbuhan.pohon.index', array_merge(request()->except(['kondisi', 'page']))) }}"
               class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all {{ !request('kondisi') ? 'bg-slate-800 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua
            </a>
            <a href="{{ route('portal.pertumbuhan.pohon.index', array_merge(request()->except(['kondisi', 'page']), ['kondisi' => 'sehat'])) }}"
               class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('kondisi') === 'sehat' ? 'bg-green-600 text-white shadow-sm' : 'bg-green-50 text-green-700 hover:bg-green-100' }}">
                Sehat
            </a>
            <a href="{{ route('portal.pertumbuhan.pohon.index', array_merge(request()->except(['kondisi', 'page']), ['kondisi' => 'perawatan'])) }}"
               class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('kondisi') === 'perawatan' ? 'bg-amber-500 text-white shadow-sm' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }}">
                Perawatan
            </a>
            <a href="{{ route('portal.pertumbuhan.pohon.index', array_merge(request()->except(['kondisi', 'page']), ['kondisi' => 'bermasalah'])) }}"
               class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('kondisi') === 'bermasalah' ? 'bg-red-600 text-white shadow-sm' : 'bg-red-50 text-red-700 hover:bg-red-100' }}">
                Bermasalah
            </a>
        </div>

        {{-- Search & Fase Filter Bar --}}
        <form method="GET" action="{{ route('portal.pertumbuhan.pohon.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            @if(request('kondisi'))
                <input type="hidden" name="kondisi" value="{{ request('kondisi') }}">
            @endif

            <div class="sm:col-span-7 relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari varietas, kode pohon, lokasi..."
                       class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:border-green-500 focus:ring-1 focus:ring-emerald-500 outline-none">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <div class="sm:col-span-3">
                <x-custom-dropdown 
                    name="fase" 
                    placeholder="-- Semua Fase --" 
                    :options="[
                        'bibit' => 'Fase Bibit',
                        'vegetatif' => 'Fase Vegetatif',
                        'generatif' => 'Fase Generatif',
                        'produktif' => 'Fase Produktif'
                    ]" 
                    :value="request('fase')" 
                    onchange="selectEl.form.submit()" 
                />
            </div>

            <div class="sm:col-span-2 flex gap-2">
                <button type="submit" class="w-full py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition-colors">
                    Filter
                </button>
                @if(request('search') || request('fase') || request('kondisi'))
                    <a href="{{ route('portal.pertumbuhan.pohon.index') }}" title="Reset Filter"
                       class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-colors flex items-center justify-center">
                        ✕
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left min-w-[750px]">
                <thead class="bg-slate-50/80 border-b border-slate-100 text-slate-600 uppercase text-[11px] tracking-wider font-bold">
                    <tr>
                        <th class="px-5 py-4 whitespace-nowrap">Kode Pohon</th>
                        <th class="px-5 py-4 whitespace-nowrap">Varietas & Lahan</th>
                        <th class="px-5 py-4 whitespace-nowrap">Lokasi</th>
                        <th class="px-5 py-4 whitespace-nowrap">Fase</th>
                        <th class="px-5 py-4 whitespace-nowrap">Kondisi</th>
                        <th class="px-5 py-4 text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pohon as $p)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-5 py-4">
                            <span class="font-mono font-extrabold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-lg text-xs">{{ $p->kode_pohon }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="font-extrabold text-slate-800 text-sm">{{ $p->nama_varietas }}</div>
                            <div class="text-xs text-slate-400 mt-0.5">
                                Lahan: <span class="font-semibold text-slate-600">{{ $p->lahan->nama_lahan ?? 'Kebun Utama' }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-slate-600 text-xs">
                            {{ $p->lokasi ?? '-' }}
                        </td>
                        <td class="px-5 py-4">
                            @php
                                $faseClasses = [
                                    'bibit'     => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'vegetatif' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'generatif' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'produktif' => 'bg-purple-50 text-purple-700 border-purple-200',
                                ];
                            @endphp
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full border {{ $faseClasses[$p->fase] ?? 'bg-slate-50 text-slate-700' }}">
                                {{ ucfirst($p->fase) }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            @if($p->kondisi === 'sehat')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Sehat
                                </span>
                            @elseif($p->kondisi === 'perawatan')
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
                        <td class="px-5 py-4 text-center">
                            <div class="inline-flex items-center gap-1.5">
                                {{-- Tombol Catat Monitoring --}}
                                <a href="{{ route('portal.pertumbuhan.monitoring.create', ['pohon_id' => $p->id]) }}" 
                                   title="Catat Monitoring Pohon Ini"
                                   class="px-2.5 py-1.5 bg-teal-50 hover:bg-teal-600 text-teal-700 hover:text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                                    Monitoring
                                </a>

                                {{-- Tombol Tambah Jadwal --}}
                                <a href="{{ route('portal.pertumbuhan.jadwal.create', ['pohon_id' => $p->id]) }}" 
                                   title="Buat Jadwal Perawatan"
                                   class="px-2.5 py-1.5 bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                                    + Jadwal
                                </a>

                                {{-- Tombol Edit --}}
                                <a href="{{ route('portal.pertumbuhan.pohon.edit', $p) }}" 
                                   title="Edit Pohon"
                                   class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-colors inline-flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('portal.pertumbuhan.pohon.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pohon {{ $p->kode_pohon }} - {{ $p->nama_varietas }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" title="Hapus Pohon"
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
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            </div>
                            <p class="font-bold text-slate-600">Tidak ada pohon durian yang cocok dengan filter ini.</p>
                            <p class="text-xs text-slate-400 mt-1">Coba sesuaikan kata kunci pencarian atau reset filter kondisi/fase.</p>
                            <div class="mt-4 flex items-center justify-center gap-3">
                                <a href="{{ route('portal.pertumbuhan.pohon.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors">Reset Filter</a>
                                <a href="{{ route('portal.pertumbuhan.pohon.create') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-xl transition-colors">Tambah Pohon</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">
        {{ $pohon->links() }}
    </div>
</x-portal-layout>
