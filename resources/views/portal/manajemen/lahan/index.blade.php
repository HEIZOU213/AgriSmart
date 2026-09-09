<x-portal-layout portalName="Manajemen Kebun" pageTitle="Data Lahan" :menuItems="$menuItems">
<div class="flex items-center justify-between mb-5">
    <div><h2 class="text-lg font-bold text-slate-800">Data Lahan</h2></div>
    <a href="{{ route('portal.manajemen.lahan.create') }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 shadow-sm transition">+ Tambah Lahan</a>
</div>
@if(session('success'))
    <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-sm font-medium">
        {{ session('success') }}
    </div>
@endif
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($lahan as $l)
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 hover:shadow-md transition">
            <div class="flex items-start justify-between mb-3">
                <h3 class="font-bold text-slate-800">{{ $l->nama_lahan }}</h3>
                <span class="px-2 py-1 text-xs font-bold rounded-full {{ $l->kondisi=='baik' ? 'bg-emerald-100 text-emerald-700' : ($l->kondisi=='buruk' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                    {{ ucfirst($l->kondisi) }}
                </span>
            </div>
            <div class="grid grid-cols-2 gap-2 text-sm mb-4">
                <div>
                    <p class="text-xs text-slate-400">Luas</p>
                    <p class="font-bold text-slate-700">{{ $l->luas_ha }} ha</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Jumlah Pohon</p>
                    <p class="font-bold text-slate-700">{{ $l->jumlah_pohon ?? 0 }}</p>
                </div>
            </div>
            @if($l->lokasi)
                <p class="text-xs text-slate-400 mb-3">{{ $l->lokasi }}</p>
            @endif
            <div class="flex gap-2">
                <a href="{{ route('portal.manajemen.lahan.edit',$l) }}" class="flex-1 text-center text-xs py-1.5 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 font-semibold transition">Edit</a>
                <form action="{{ route('portal.manajemen.lahan.destroy',$l) }}" method="POST" onsubmit="return confirm('Hapus lahan ini?')" class="flex-1">
                    @csrf @method('DELETE')
                    <button class="w-full text-xs py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 font-semibold transition">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-3 text-center py-10 text-slate-400">
            Belum ada data lahan. <a href="{{ route('portal.manajemen.lahan.create') }}" class="text-emerald-600 font-semibold hover:underline">Tambah sekarang</a>
        </div>
    @endforelse
</div>
<div class="mt-4">{{ $lahan->links() }}</div>
</x-portal-layout>
