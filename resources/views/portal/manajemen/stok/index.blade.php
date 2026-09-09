<x-portal-layout portalName="Manajemen Kebun" pageTitle="Stok Barang" :menuItems="$menuItems">
<div class="flex items-center justify-between mb-5">
    <div><h2 class="text-lg font-bold text-slate-800">Stok Barang</h2></div>
    <a href="{{ route('portal.manajemen.stok.create') }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 shadow-sm transition">+ Tambah Barang</a>
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
                    <th class="px-5 py-3 font-semibold text-slate-600 whitespace-nowrap">Nama Barang</th>
                    <th class="px-5 py-3 font-semibold text-slate-600 whitespace-nowrap">Kategori</th>
                    <th class="px-5 py-3 font-semibold text-slate-600 whitespace-nowrap">Jumlah</th>
                    <th class="px-5 py-3 font-semibold text-slate-600 whitespace-nowrap">Satuan</th>
                    <th class="px-5 py-3 font-semibold text-slate-600 whitespace-nowrap">Harga/Unit</th>
                    <th class="px-5 py-3 font-semibold text-slate-600 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
            @forelse($stok as $s)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3 font-semibold text-slate-800 whitespace-nowrap">{{ $s->nama_barang }}</td>
                    <td class="px-5 py-3 text-slate-500 whitespace-nowrap">{{ $s->kategori }}</td>
                    <td class="px-5 py-3 font-bold whitespace-nowrap {{ $s->jumlah <= 5 ? 'text-red-600' : 'text-slate-800' }}">{{ $s->jumlah }}</td>
                    <td class="px-5 py-3 text-slate-500 whitespace-nowrap">{{ $s->satuan }}</td>
                    <td class="px-5 py-3 text-slate-600 whitespace-nowrap">{{ $s->harga_satuan ? 'Rp '.number_format($s->harga_satuan,0,',','.') : '-' }}</td>
                    <td class="px-5 py-3 whitespace-nowrap">
                        <div class="flex gap-2">
                            <a href="{{ route('portal.manajemen.stok.edit',$s) }}" class="text-xs px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 font-semibold transition">Edit</a>
                            <form action="{{ route('portal.manajemen.stok.destroy',$s) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                @csrf @method('DELETE')
                                <button class="text-xs px-2.5 py-1 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 font-semibold transition">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400">Belum ada stok barang.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $stok->links() }}</div>
</x-portal-layout>
