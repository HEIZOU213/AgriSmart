<x-portal-layout portalName="Manajemen Kebun" pageTitle="Biaya Operasional" :menuItems="$menuItems">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Biaya Operasional Kebun</h2>
            <p class="text-xs text-slate-500 mt-1">Catat dan pantau seluruh pos pengeluaran operasional kebun durian Anda</p>
        </div>
        <a href="{{ route('portal.manajemen.biaya.create') }}" 
           class="inline-flex items-center justify-center px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl shadow-sm transition-all flex-shrink-0 self-start sm:self-auto">
            + Catat Biaya
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
            <table class="w-full text-sm text-left min-w-[650px]">
                <thead class="bg-slate-50/80 border-b border-slate-100 text-slate-600 uppercase text-[11px] tracking-wider font-bold">
                    <tr>
                        <th class="px-5 py-4 whitespace-nowrap">Tanggal</th>
                        <th class="px-5 py-4 whitespace-nowrap">Pos / Jenis Biaya</th>
                        <th class="px-5 py-4 whitespace-nowrap">Catatan</th>
                        <th class="px-5 py-4 whitespace-nowrap">Jumlah (Rp)</th>
                        <th class="px-5 py-4 text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($biaya as $b)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-5 py-4 text-xs font-semibold text-slate-600">
                            {{ $b->tanggal ? $b->tanggal->format('d M Y') : '-' }}
                        </td>
                        <td class="px-5 py-4">
                            <span class="font-extrabold text-slate-800">{{ $b->jenis_biaya }}</span>
                        </td>
                        <td class="px-5 py-4 text-slate-500 text-xs max-w-xs truncate">
                            {{ $b->catatan ?: '-' }}
                        </td>
                        <td class="px-5 py-4 font-black text-rose-600 text-sm">
                            Rp {{ number_format($b->jumlah, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-4 text-center">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('portal.manajemen.biaya.edit', $b) }}" 
                                   title="Edit Biaya"
                                   class="p-1.5 bg-slate-50 hover:bg-blue-600 text-slate-600 hover:text-white rounded-xl text-xs font-bold transition-all shadow-sm inline-flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>

                                <form action="{{ route('portal.manajemen.biaya.destroy', $b) }}" method="POST" class="inline" onsubmit="return confirm('Hapus catatan pengeluaran biaya ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Biaya"
                                            class="p-1.5 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white rounded-xl text-xs font-bold transition-all shadow-sm inline-flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-slate-400">
                            <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-300 mx-auto flex items-center justify-center mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="font-bold text-slate-600">Belum ada catatan biaya operasional.</p>
                            <p class="text-xs text-slate-400 mt-1">Catat seluruh pengeluaran untuk memantau analisa laba rugi kebun.</p>
                            <a href="{{ route('portal.manajemen.biaya.create') }}" class="inline-block mt-4 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-xl transition-colors">Catat Biaya</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">
        {{ $biaya->links() }}
    </div>
</x-portal-layout>
