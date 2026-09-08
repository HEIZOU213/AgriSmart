<x-portal-layout portalName="Pembibitan" pageTitle="Monitoring Bibit" :menuItems="$menuItems">
<div class="flex items-center justify-between mb-5">
    <div><h2 class="text-lg font-bold text-slate-800">Monitoring Bibit</h2><p class="text-sm text-slate-500">Riwayat monitoring pertumbuhan bibit</p></div>
    <a href="{{ route('portal.pembibitan.monitoring.create') }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 shadow-sm transition">+ Catat Monitoring</a>
</div>
@if(session('success'))
    <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-sm font-medium">
        {{ session('success') }}
    </div>
@endif
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left min-w-[700px]">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="px-5 py-3 text-slate-600 font-semibold whitespace-nowrap">Bibit</th>
                    <th class="px-5 py-3 text-slate-600 font-semibold whitespace-nowrap">Tinggi (cm)</th>
                    <th class="px-5 py-3 text-slate-600 font-semibold whitespace-nowrap">Kondisi</th>
                    <th class="px-5 py-3 text-slate-600 font-semibold whitespace-nowrap">Tanggal</th>
                    <th class="px-5 py-3 text-slate-600 font-semibold whitespace-nowrap">Catatan</th>
                    <th class="px-5 py-3 text-slate-600 font-semibold whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
            @forelse($monitoring as $m)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3 font-semibold text-slate-800 whitespace-nowrap">{{ $m->bibit->nama_varietas ?? '-' }} <span class="text-xs text-slate-400">({{ $m->bibit->kode_bibit ?? '' }})</span></td>
                    <td class="px-5 py-3 whitespace-nowrap">{{ $m->tinggi_cm ?? '-' }}</td>
                    <td class="px-5 py-3 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-bold rounded-full {{ $m->kondisi=='sehat' ? 'bg-emerald-100 text-emerald-700' : ($m->kondisi=='kritis' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst(str_replace('_',' ',$m->kondisi)) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-slate-500 whitespace-nowrap">{{ $m->tanggal ? $m->tanggal->format('d M Y') : '-' }}</td>
                    <td class="px-5 py-3 text-slate-400 max-w-xs truncate">{{ $m->catatan ?? '-' }}</td>
                    <td class="px-5 py-3 whitespace-nowrap">
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('portal.pembibitan.monitoring.edit', $m) }}" class="text-xs px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 font-semibold transition">Edit</a>
                            <form action="{{ route('portal.pembibitan.monitoring.destroy', $m) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data monitoring ini?')">
                                @csrf @method('DELETE')
                                <button class="text-xs px-2.5 py-1 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 font-semibold transition">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400">Belum ada data monitoring.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $monitoring->links() }}</div>
</x-portal-layout>
