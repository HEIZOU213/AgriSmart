<x-portal-layout portalName="Manajemen Kebun" pageTitle="Laporan Manajemen" :menuItems="$menuItems">
    <div class="mb-6">
        <h2 class="text-xl font-extrabold text-slate-800">Laporan & Analisis Manajemen Kebun</h2>
        <p class="text-xs text-slate-500 mt-1">Ikhtisar komprehensif performa panen, struktur biaya operasional, dan estimasi laba rugi kebun</p>
    </div>

    {{-- Ringkasan Finansial & Produksi (4 Kartu) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Total Panen --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Hasil Panen</span>
                <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-black text-slate-900">{{ number_format($totalPanen, 1, ',', '.') }} <span class="text-sm font-bold text-slate-400">Kg</span></div>
            <p class="text-xs text-slate-400 mt-1">Akumulasi seluruh blok kebun</p>
        </div>

        {{-- Estimasi Pendapatan --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Nilai Panen</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-black text-emerald-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            <p class="text-xs text-slate-400 mt-1">Berdasarkan estimasi harga pasar</p>
        </div>

        {{-- Total Biaya --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Biaya Operasional</span>
                <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-black text-rose-600">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</div>
            <p class="text-xs text-slate-400 mt-1">Pupuk, obat, tenaga kerja & sarana</p>
        </div>

        {{-- Laba / Rugi --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Estimasi Laba Bersih</span>
                <div class="w-8 h-8 rounded-xl {{ $labaRugi >= 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
            </div>
            <div class="text-2xl font-black {{ $labaRugi >= 0 ? 'text-emerald-700' : 'text-rose-700' }}">
                Rp {{ number_format($labaRugi, 0, ',', '.') }}
            </div>
            <p class="text-xs text-slate-400 mt-1">{{ $labaRugi >= 0 ? 'Margin Keuntungan Positif' : 'Pengeluaran melebihi nilai panen' }}</p>
        </div>
    </div>

    {{-- Detail Grid: Panen per Varietas & Biaya per Jenis --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Panen per Varietas --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-7">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="font-extrabold text-slate-800 text-base">Produksi Durian per Varietas</h3>
                    <p class="text-xs text-slate-400">Rincian bobot hasil panen dan perkiraan nilai</p>
                </div>
                <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-purple-50 text-purple-700">{{ $panenPerVarietas->count() }} Varietas</span>
            </div>

            <div class="space-y-3">
                @forelse($panenPerVarietas as $p)
                <div class="p-4 rounded-2xl bg-slate-50/70 border border-slate-100 flex items-center justify-between">
                    <div>
                        <div class="font-extrabold text-slate-800 text-sm">{{ $p->varietas }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">
                            Estimasi Nilai: <span class="text-emerald-700 font-semibold">Rp {{ number_format($p->total_nilai, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-base font-black text-slate-900">{{ number_format($p->total_kg, 1, ',', '.') }}</span>
                        <span class="text-xs font-bold text-slate-500">Kg</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-slate-400 text-xs font-medium">Belum ada data panen yang tercatat.</div>
                @endforelse
            </div>
        </div>

        {{-- Biaya per Jenis --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-7">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="font-extrabold text-slate-800 text-base">Alokasi Biaya Operasional</h3>
                    <p class="text-xs text-slate-400">Distribusi pengeluaran berdasarkan pos beban</p>
                </div>
                <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-rose-50 text-rose-700">{{ $biayaPerJenis->count() }} Pos Biaya</span>
            </div>

            <div class="space-y-3">
                @forelse($biayaPerJenis as $b)
                <div class="p-4 rounded-2xl bg-slate-50/70 border border-slate-100 flex items-center justify-between">
                    <div>
                        <div class="font-extrabold text-slate-800 text-sm">{{ $b->jenis_biaya }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">
                            @if($totalBiaya > 0)
                                Kontribusi: {{ number_format(($b->total_biaya / $totalBiaya) * 100, 1) }}%
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-base font-black text-rose-600">Rp {{ number_format($b->total_biaya, 0, ',', '.') }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-slate-400 text-xs font-medium">Belum ada pengeluaran yang dicatat.</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Tren Bulanan --}}
    @if($panenPerBulan->isNotEmpty())
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-7">
        <h3 class="font-extrabold text-slate-800 text-base mb-1">Tren Panen Bulanan</h3>
        <p class="text-xs text-slate-400 mb-5">Rekapitulasi total panen buah durian (Kg) per bulan</p>
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-3">
            @php
            $bulanNames = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'];
            @endphp
            @foreach($panenPerBulan as $pb)
            <div class="p-4 rounded-2xl bg-purple-50/50 border border-purple-100/60 text-center">
                <span class="text-xs font-bold text-purple-700 block uppercase">{{ $bulanNames[$pb->bulan] ?? ('Bln '.$pb->bulan) }}</span>
                <span class="text-lg font-black text-slate-800 mt-1 block">{{ number_format($pb->total_kg, 1) }}</span>
                <span class="text-[11px] font-semibold text-slate-400">Kg</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</x-portal-layout>
