<x-portal-layout portalName="Pembibitan" pageTitle="Pengadaan Bibit" :menuItems="$menuItems">
<div class="flex items-center justify-between mb-5">
    <div><h2 class="text-lg font-bold text-slate-800">Pengadaan Bibit</h2><p class="text-sm text-slate-500">Riwayat pembelian dan pengadaan bibit durian</p></div>
    <a href="{{ route('portal.pembibitan.pengadaan.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 shadow-sm transition">+ Catat Pengadaan</a>
</div>
@if(session('success'))<div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-sm font-medium">{{ session('success') }}</div>@endif
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[700px]">
            <thead class="bg-slate-50 border-b border-slate-100"><tr>
                <th class="text-left px-5 py-3 font-semibold text-slate-600 whitespace-nowrap">Supplier</th>
                <th class="text-left px-5 py-3 font-semibold text-slate-600 whitespace-nowrap">Varietas</th>
                <th class="text-left px-5 py-3 font-semibold text-slate-600 whitespace-nowrap">Jumlah</th>
                <th class="text-left px-5 py-3 font-semibold text-slate-600 whitespace-nowrap">Harga/Unit</th>
                <th class="text-left px-5 py-3 font-semibold text-slate-600 whitespace-nowrap">Total</th>
                <th class="text-left px-5 py-3 font-semibold text-slate-600 whitespace-nowrap">Tanggal</th>
                <th class="text-left px-5 py-3 font-semibold text-slate-600 whitespace-nowrap">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pengadaan as $p)
                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-3 font-semibold text-slate-800 whitespace-nowrap">{{ $p->nama_supplier }}</td>
                    <td class="px-5 py-3 whitespace-nowrap">{{ $p->nama_varietas }}</td>
                    <td class="px-5 py-3 whitespace-nowrap">{{ $p->jumlah }}</td>
                    <td class="px-5 py-3 whitespace-nowrap">Rp {{ number_format($p->harga_satuan,0,',','.') }}</td>
                    <td class="px-5 py-3 font-bold text-green-700 whitespace-nowrap">Rp {{ number_format($p->jumlah * $p->harga_satuan,0,',','.') }}</td>
                    <td class="px-5 py-3 text-slate-400 whitespace-nowrap">{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                    <td class="px-5 py-3 whitespace-nowrap">
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('portal.pembibitan.pengadaan.edit', $p) }}" class="text-xs px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 font-semibold">Edit</a>
                            <form action="{{ route('portal.pembibitan.pengadaan.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data pengadaan ini?')">
                                @csrf @method('DELETE')
                                <button class="text-xs px-2.5 py-1 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 font-semibold">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-10 text-center text-slate-400">Belum ada data pengadaan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $pengadaan->links() }}</div>
</x-portal-layout>
