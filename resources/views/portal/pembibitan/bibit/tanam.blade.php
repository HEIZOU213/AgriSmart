<x-portal-layout portalName="Pembibitan" pageTitle="{{ $pageTitle }}" :menuItems="$menuItems">
<div class="max-w-2xl mx-auto">
    <div class="mb-5 flex items-center gap-3">
        <a href="{{ route('portal.pembibitan.bibit.index') }}" 
           class="p-2 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-slate-800 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Tanam Bibit ke Lahan</h2>
            <p class="text-xs text-slate-500">Pindahkan bibit siap tanam dari persemaian menjadi pohon di kebun lahan</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-6">
        <div class="p-6 border-b border-slate-100 bg-emerald-50/40">
            <div class="flex items-center justify-between">
                <div>
                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-700">Siap Tanam</span>
                    <h3 class="text-lg font-extrabold text-slate-800 mt-2">{{ $bibit->nama_varietas }}</h3>
                    <p class="text-xs font-mono text-slate-500">Kode: {{ $bibit->kode_bibit }}</p>
                </div>
                <div class="text-right">
                    <span class="text-3xl font-black text-emerald-600">{{ $bibit->jumlah }}</span>
                    <span class="text-xs text-slate-400 block font-semibold">Bibit Tersedia</span>
                </div>
            </div>
            <div class="mt-4 p-3 bg-white/80 rounded-2xl border border-emerald-100 text-xs text-emerald-800 flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Bibit yang ditanam akan otomatis dibuatkan data pohon di <strong>Portal Pertumbuhan</strong>, dan kuota bibit ini akan berkurang/hilang dari persemaian aktif.</span>
            </div>
        </div>

        <form action="{{ route('portal.pembibitan.bibit.tanam.store', $bibit) }}" method="POST" class="p-6 sm:p-8 space-y-5">
            @csrf
            
            @if($errors->any())
                <div class="p-4 bg-red-50 text-red-600 rounded-2xl text-xs mb-4 space-y-1">
                    @foreach($errors->all() as $err)
                        <p>&bull; {{ $err }}</p>
                    @endforeach
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @if($bibit->jumlah == 1)
                    <input type="hidden" name="jumlah" value="1">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Bibit yang Ditanam</label>
                        <div class="px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-bold text-emerald-800 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            1 Bibit Individual ({{ $bibit->kode_bibit }})
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Tag bibit ini akan bertransformasi menjadi pohon</p>
                    </div>
                @else
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Jumlah Ditanam <span class="text-red-500">*</span></label>
                        <input type="number" name="jumlah" value="{{ old('jumlah', $bibit->jumlah) }}" min="1" max="{{ $bibit->jumlah }}" required 
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm font-bold text-slate-800">
                        <p class="text-[11px] text-slate-400 mt-1">Maksimal: {{ $bibit->jumlah }} bibit</p>
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Lahan Tujuan <span class="text-red-500">*</span></label>
                    <x-custom-dropdown 
                        name="lahan_id" 
                        placeholder="-- Pilih Lahan --" 
                        :options="$lahanList" 
                        :value="old('lahan_id')" 
                        searchable 
                        required 
                    />
                    @if($lahanList->isEmpty())
                        <p class="text-xs text-red-500 mt-1">Anda belum memiliki lahan. <a href="{{ route('portal.manajemen.lahan.create') }}" class="underline font-bold">Buat lahan</a> terlebih dahulu.</p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Tanggal Tanam <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_tanam" value="{{ old('tanggal_tanam', date('Y-m-d')) }}" required 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Lokasi / Blok Detail</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Blok Timur, Baris 1-5"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 font-medium">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Catatan Penanaman</label>
                <textarea name="catatan" rows="3" placeholder="Informasi lubang tanam, pemupukan dasar, atau perlakuan awal..."
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm resize-none text-slate-800 font-medium">{{ old('catatan') }}</textarea>
            </div>

            <button type="submit" class="w-full py-3.5 bg-green-600 hover:bg-green-700 text-white font-extrabold rounded-2xl shadow-md hover:shadow-lg transition-all text-sm" {{ $lahanList->isEmpty() ? 'disabled' : '' }}>
                Konfirmasi Tanam & Pindahkan ke Pertumbuhan
            </button>
        </form>
    </div>
</div>
</x-portal-layout>
