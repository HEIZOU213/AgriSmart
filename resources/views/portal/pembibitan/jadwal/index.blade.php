<x-portal-layout portalName="Pembibitan" pageTitle="Jadwal Perawatan" :menuItems="$menuItems">
<div class="flex items-center justify-between mb-5">
    <div><h2 class="text-lg font-bold text-slate-800">Jadwal Perawatan Bibit</h2></div>
    <a href="{{ route('portal.pembibitan.jadwal.create') }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 shadow-sm transition">+ Buat Jadwal</a>
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
                    <th class="px-5 py-3 text-slate-600 font-semibold whitespace-nowrap">Jenis Perawatan</th>
                    <th class="px-5 py-3 text-slate-600 font-semibold whitespace-nowrap">Tanggal</th>
                    <th class="px-5 py-3 text-slate-600 font-semibold whitespace-nowrap">Status</th>
                    <th class="px-5 py-3 text-slate-600 font-semibold whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
            @forelse($jadwal as $j)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3 font-semibold text-slate-800 whitespace-nowrap">{{ $j->bibit->nama_varietas ?? '-' }}</td>
                    <td class="px-5 py-3 whitespace-nowrap">{{ $j->jenis_perawatan }}</td>
                    <td class="px-5 py-3 text-slate-500 whitespace-nowrap">{{ $j->tanggal_jadwal ? $j->tanggal_jadwal->format('d M Y') : '-' }}</td>
                    <td class="px-5 py-3 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-bold rounded-full {{ $j->status=='selesai' ? 'bg-emerald-100 text-emerald-700' : ($j->status=='batal' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($j->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 whitespace-nowrap">
                        <div class="flex items-center gap-1.5">
                            @if($j->status=='pending')
                            <form action="{{ route('portal.pembibitan.jadwal.selesai',$j) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button class="text-xs px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg hover:bg-emerald-100 font-semibold transition">Tandai Selesai</button>
                            </form>
                            @endif
                            <a href="{{ route('portal.pembibitan.jadwal.edit', $j) }}" class="text-xs px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 font-semibold transition">Edit</a>
                            <form action="{{ route('portal.pembibitan.jadwal.destroy', $j) }}" method="POST" class="inline" onsubmit="return confirm('Hapus jadwal perawatan ini?')">
                                @csrf @method('DELETE')
                                <button class="text-xs px-2.5 py-1 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 font-semibold transition">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">Belum ada jadwal perawatan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $jadwal->links() }}</div>
</x-portal-layout>
