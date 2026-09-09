<x-portal-layout portalName="Pembibitan" pageTitle="Data Bibit" :menuItems="$menuItems">
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
    <div>
        <h2 class="text-lg font-bold text-slate-800">Data Bibit</h2>
        <p class="text-sm text-slate-500">Kelola seluruh data bibit durian Anda</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('portal.pembibitan.pengadaan.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-slate-100 text-slate-700 text-sm font-bold rounded-xl hover:bg-slate-200 transition-colors">
            + Pengadaan
        </a>
        <a href="{{ route('portal.pembibitan.bibit.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white text-sm font-bold rounded-xl hover:bg-green-700 transition-colors">
            + Tambah Bibit
        </a>
    </div>
</div>

@if(session('success'))
    <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-medium">{{ session('success') }}</div>
@endif

{{-- Filter & Search Bar --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 mb-5 flex flex-col md:flex-row items-center justify-between gap-3">
    <div class="flex items-center gap-1.5 overflow-x-auto w-full md:w-auto pb-1 md:pb-0">
        <a href="{{ route('portal.pembibitan.bibit.index') }}" 
           class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition-colors {{ empty($currentStatus) && empty($currentKondisi) ? 'bg-green-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Semua
        </a>
        <a href="{{ route('portal.pembibitan.bibit.index', ['status' => 'aktif']) }}" 
           class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition-colors {{ $currentStatus === 'aktif' ? 'bg-green-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Aktif
        </a>
        <a href="{{ route('portal.pembibitan.bibit.index', ['status' => 'siap_tanam']) }}" 
           class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition-colors {{ $currentStatus === 'siap_tanam' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Siap Tanam
        </a>
        <a href="{{ route('portal.pembibitan.bibit.index', ['status' => 'perawatan']) }}" 
           class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition-colors {{ $currentStatus === 'perawatan' ? 'bg-yellow-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Perawatan
        </a>
        <a href="{{ route('portal.pembibitan.bibit.index', ['kondisi' => 'kritis']) }}" 
           class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition-colors {{ $currentKondisi === 'kritis' ? 'bg-red-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Kritis
        </a>
        <a href="{{ route('portal.pembibitan.bibit.index', ['status' => 'mati']) }}" 
           class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition-colors {{ $currentStatus === 'mati' ? 'bg-slate-700 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Mati
        </a>
        <a href="{{ route('portal.pembibitan.bibit.index', ['status' => 'ditanam']) }}" 
           class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition-colors {{ $currentStatus === 'ditanam' ? 'bg-emerald-700 text-white shadow-sm' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
            Sudah Ditanam
        </a>
    </div>

    <form method="GET" action="{{ route('portal.pembibitan.bibit.index') }}" class="w-full md:w-64 flex items-center">
        @if($currentStatus)<input type="hidden" name="status" value="{{ $currentStatus }}">@endif
        @if($currentKondisi)<input type="hidden" name="kondisi" value="{{ $currentKondisi }}">@endif
        <div class="relative w-full">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari varietas / kode..." 
                   class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[700px]">
            <thead class="bg-slate-50 border-b text-slate-600">
                <tr>
                    <th class="text-left px-5 py-3 font-semibold whitespace-nowrap">Kode</th>
                    <th class="text-left px-5 py-3 font-semibold whitespace-nowrap">Varietas</th>
                    <th class="text-left px-5 py-3 font-semibold whitespace-nowrap">Jumlah</th>
                    <th class="text-left px-5 py-3 font-semibold whitespace-nowrap">Status</th>
                    <th class="text-left px-5 py-3 font-semibold whitespace-nowrap">Kondisi</th>
                    <th class="text-left px-5 py-3 font-semibold whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($bibit as $b)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-5 py-3 font-mono font-bold text-slate-700">{{ $b->kode_bibit }}</td>
                <td class="px-5 py-3 font-semibold text-slate-800">{{ $b->nama_varietas }}</td>
                <td class="px-5 py-3 text-slate-600 font-bold">{{ $b->jumlah }} bibit</td>
                <td class="px-5 py-3">
                    @php $sc=['aktif'=>'bg-green-100 text-green-700','perawatan'=>'bg-yellow-100 text-yellow-700','siap_tanam'=>'bg-blue-100 text-blue-700','mati'=>'bg-red-100 text-red-700','ditanam'=>'bg-emerald-100 text-emerald-800'][$b->status] ?? 'bg-slate-100 text-slate-600' @endphp
                    <span class="px-2 py-1 text-xs font-bold rounded-full {{ $sc }}">
                        {{ $b->status === 'ditanam' ? 'Sudah Ditanam' : str_replace('_',' ',ucfirst($b->status)) }}
                    </span>
                </td>
                <td class="px-5 py-3">
                    @php $cc=['sehat'=>'bg-green-100 text-green-700','kurang_sehat'=>'bg-yellow-100 text-yellow-700','kritis'=>'bg-red-100 text-red-700'][$b->kondisi] ?? '' @endphp
                    <span class="px-2 py-1 text-xs font-bold rounded-full {{ $cc }}">{{ str_replace('_',' ',ucfirst($b->kondisi)) }}</span>
                </td>
                <td class="px-5 py-3">
                    <div class="flex items-center gap-2">
                        @if($b->status === 'siap_tanam' && $b->jumlah > 0)
                        <a href="{{ route('portal.pembibitan.bibit.tanam.create', $b) }}" class="text-xs px-2.5 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700 font-bold shadow-sm">Tanam ke Lahan</a>
                        @endif
                        @if($b->status === 'ditanam')
                        <a href="{{ route('portal.pertumbuhan.pohon.index', ['search' => $b->nama_varietas]) }}" class="text-xs px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg hover:bg-emerald-100 font-semibold flex items-center gap-1">
                            Lihat Pohon &rarr;
                        </a>
                        @endif
                        @if(!in_array($b->status, ['mati', 'ditanam']))
                        <a href="{{ route('portal.pembibitan.monitoring.create', ['bibit_id' => $b->id]) }}" class="text-xs px-2.5 py-1 bg-teal-50 text-teal-700 rounded-lg hover:bg-teal-100 font-semibold">Monitoring</a>
                        @endif
                        <a href="{{ route('portal.pembibitan.bibit.edit', $b) }}" class="text-xs px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 font-semibold">Edit</a>
                        <form action="{{ route('portal.pembibitan.bibit.destroy', $b) }}" method="POST" onsubmit="return confirm('Hapus bibit ini?')">
                            @csrf @method('DELETE')
                            <button class="text-xs px-2.5 py-1 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 font-semibold">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400">Belum ada data bibit. <a href="{{ route('portal.pembibitan.bibit.create') }}" class="text-green-600 font-semibold hover:underline">Tambah sekarang</a></td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>
<div class="mt-4">{{ $bibit->links() }}</div>
</x-portal-layout>
