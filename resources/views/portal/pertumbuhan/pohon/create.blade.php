<x-portal-layout portalName="Pertumbuhan" pageTitle="Tanam Pohon dari Bibit" :menuItems="$menuItems">
    <div class="max-w-2xl">
        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('portal.pertumbuhan.pohon.index') }}" 
               class="p-2 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-slate-800 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="text-xl font-extrabold text-slate-800">Tanam Pohon Durian</h2>
                <p class="text-xs text-slate-500">Pohon diambil langsung dari stok bibit siap tanam di persemaian Pembibitan</p>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-2xl text-red-700 text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <p>&bull; {{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if($bibitSiapTanam->isEmpty())
            {{-- Peringatan jika belum ada bibit siap tanam --}}
            <div class="bg-white rounded-3xl border border-amber-200 shadow-sm p-6 sm:p-8 text-center mb-6">
                <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-lg font-extrabold text-slate-800">Belum Ada Bibit Siap Tanam</h3>
                <p class="text-xs text-slate-500 mt-2 max-w-md mx-auto leading-relaxed">
                    Seluruh pohon di modul Pertumbuhan terhubung dengan bibit di <strong>Portal Pembibitan</strong>. Saat ini belum ada bibit yang berstatus <em>"Siap Tanam"</em> di persemaian Anda.
                </p>
                <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('portal.pembibitan.bibit.index') }}" 
                       class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-xl transition-all shadow-sm">
                        Kelola Bibit di Pembibitan &rarr;
                    </a>
                    <a href="{{ route('portal.pembibitan.pengadaan.create') }}" 
                       class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors">
                        + Pengadaan Bibit Baru
                    </a>
                </div>
            </div>
        @else
            {{-- Form Penanaman Pohon dari Bibit Siap Tanam --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8 mb-6">
                <div class="mb-6 p-4 bg-emerald-50/70 border border-emerald-100 rounded-2xl flex items-start gap-3">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="text-xs text-emerald-800 leading-relaxed">
                        Pilih bibit yang siap tanam. Setelah ditanam, bibit akan <strong>beralih menjadi pohon di kebun lahan</strong>, dan kuota bibit tersebut otomatis berkurang / hilang dari daftar persemaian aktif Pembibitan.
                    </div>
                </div>

                <form action="{{ route('portal.pertumbuhan.pohon.store') }}" method="POST" class="space-y-5" id="form-tanam">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Pilih Bibit Siap Tanam <span class="text-red-500">*</span></label>
                        <x-custom-dropdown 
                            name="bibit_id" 
                            id="bibit_id" 
                            placeholder="-- Pilih Bibit Siap Tanam dari Pembibitan --" 
                            :options="$bibitSiapTanam" 
                            :value="old('bibit_id', request('bibit_id'))" 
                            onchange="updateMaxStok(selectEl)" 
                            searchable 
                            required 
                        />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Lahan Tujuan <span class="text-red-500">*</span></label>
                            <x-custom-dropdown 
                                name="lahan_id" 
                                placeholder="-- Pilih Lahan Kebun --" 
                                :options="$lahanList" 
                                :value="old('lahan_id')" 
                                searchable 
                                required 
                            />
                            @if($lahanList->isEmpty())
                                <p class="text-xs text-red-500 mt-1">Belum ada data lahan. <a href="{{ route('portal.manajemen.lahan.create') }}" class="underline font-bold">Buat lahan</a> terlebih dahulu.</p>
                            @endif
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Jumlah Pohon Ditanam <span class="text-red-500">*</span></label>
                            <input type="number" name="jumlah" id="jumlah_input" value="{{ old('jumlah', 1) }}" min="1" required 
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 font-extrabold">
                            <p class="text-[11px] text-slate-400 mt-1" id="stok-info">Pilih bibit untuk melihat batas kuota</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Tanggal Tanam <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_tanam" value="{{ old('tanggal_tanam', date('Y-m-d')) }}" required 
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 font-medium">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Lokasi / Blok Detail di Lahan</label>
                            <input type="text" name="lokasi" value="{{ old('lokasi') }}" 
                                   placeholder="Contoh: Blok Timur, Baris A1-A5"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Catatan Penanaman</label>
                        <textarea name="catatan" rows="3" placeholder="Informasi jarak tanam (contoh: 10x10 m), perlakuan lubang tanam, atau pupuk dasar..."
                                  class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm resize-none text-slate-800 font-medium">{{ old('catatan') }}</textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-3.5 bg-green-600 hover:bg-green-700 text-white font-extrabold rounded-2xl shadow-md hover:shadow-lg transition-all text-sm" {{ $lahanList->isEmpty() ? 'disabled' : '' }}>
                            Tanam Pohon ke Lahan & Pindahkan dari Pembibitan
                        </button>
                    </div>
                </form>
            </div>

            <script>
                function updateMaxStok(select) {
                    var selected = select.options[select.selectedIndex];
                    var stok = selected.getAttribute('data-stok');
                    var input = document.getElementById('jumlah_input');
                    var info = document.getElementById('stok-info');
                    if (stok) {
                        input.max = stok;
                        if (parseInt(input.value) > parseInt(stok)) input.value = stok;
                        info.textContent = 'Maksimal: ' + stok + ' bibit';
                        info.className = 'text-[11px] text-emerald-600 font-semibold mt-1';
                    } else {
                        input.removeAttribute('max');
                        info.textContent = 'Pilih bibit untuk melihat batas kuota';
                        info.className = 'text-[11px] text-slate-400 mt-1';
                    }
                }
                document.addEventListener('DOMContentLoaded', function() {
                    var sel = document.getElementById('bibit_id');
                    if (sel && sel.value) updateMaxStok(sel);
                });
            </script>
        @endif
    </div>
</x-portal-layout>
