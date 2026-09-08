<x-portal-layout portalName="Manajemen Kebun" pageTitle="Hasil Panen" :menuItems="$menuItems">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Hasil Panen Durian</h2>
            <p class="text-xs text-slate-500 mt-1">Catatan hasil panen durian yang terhubung langsung dengan pohon dan lahan kebun</p>
        </div>
        <a href="{{ route('portal.manajemen.panen.create') }}" 
           class="inline-flex items-center justify-center px-4 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold rounded-xl shadow-sm transition-all flex-shrink-0 self-start sm:self-auto">
            + Catat Hasil Panen
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
                        <th class="px-5 py-4 whitespace-nowrap">Tanggal</th>
                        <th class="px-5 py-4 whitespace-nowrap">Varietas & Pohon</th>
                        <th class="px-5 py-4 whitespace-nowrap">Lahan</th>
                        <th class="px-5 py-4 whitespace-nowrap">Hasil (Kg)</th>
                        <th class="px-5 py-4 whitespace-nowrap">Estimasi Nilai</th>
                        <th class="px-5 py-4 text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($panen as $p)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-5 py-4 text-xs font-semibold text-slate-600">
                            {{ $p->tanggal_panen ? $p->tanggal_panen->format('d M Y') : '-' }}
                        </td>
                        <td class="px-5 py-4">
                            <div class="font-extrabold text-slate-800 text-sm">{{ $p->varietas }}</div>
                            @if($p->pohon)
                                <div class="text-xs text-purple-700 mt-0.5 flex items-center gap-1 font-mono">
                                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                    Pohon: {{ $p->pohon->kode_pohon }}
                                </div>
                            @else
                                <div class="text-[11px] text-slate-400 mt-0.5 italic">Panen Kolektif</div>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-slate-700 text-xs font-medium">
                            {{ $p->lahan->nama_lahan ?? 'Kebun Utama' }}
                        </td>
                        <td class="px-5 py-4">
                            <span class="font-black text-slate-900 text-sm">{{ number_format($p->jumlah_kg, 1, ',', '.') }}</span> 
                            <span class="text-xs text-slate-500 font-semibold">Kg</span>
                        </td>
                        <td class="px-5 py-4 text-xs">
                            @if($p->harga_per_kg)
                                <div class="font-extrabold text-emerald-700">Rp {{ number_format($p->jumlah_kg * $p->harga_per_kg, 0, ',', '.') }}</div>
                                <div class="text-[11px] text-slate-400">@ Rp {{ number_format($p->harga_per_kg, 0, ',', '.') }}/Kg</div>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('petani.produk.create', ['varietas' => $p->varietas, 'stok' => (int)$p->jumlah_kg, 'harga' => $p->harga_per_kg ?: 100000]) }}" 
                                   title="Jual ke Marketplace"
                                   class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    Jual di Toko
                                </a>

                                <a href="{{ route('portal.manajemen.panen.edit', $p) }}" 
                                   title="Edit Data Panen"
                                   class="p-1.5 bg-slate-50 hover:bg-blue-600 text-slate-600 hover:text-white rounded-xl text-xs font-bold transition-all shadow-sm inline-flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>

                                <form action="{{ route('portal.manajemen.panen.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Hapus catatan hasil panen ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" title="Hapus Panen"
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
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                            </div>
                            <p class="font-bold text-slate-600">Belum ada catatan panen.</p>
                            <p class="text-xs text-slate-400 mt-1">Catat hasil panen dari pohon durian produktif Anda di sini.</p>
                            <a href="{{ route('portal.manajemen.panen.create') }}" class="inline-block mt-4 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded-xl transition-colors">Catat Sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">
        {{ $panen->links() }}
    </div>
</x-portal-layout>
