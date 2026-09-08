<x-portal-layout portalName="Manajemen Kebun" pageTitle="Catat Panen" :menuItems="$menuItems">
    <div class="max-w-2xl">
        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('portal.manajemen.panen.index') }}" 
               class="p-2 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-slate-800 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="text-xl font-extrabold text-slate-800">Catat Hasil Panen</h2>
                <p class="text-xs text-slate-500">Pencatatan hasil panen buah durian yang terhubung dengan pohon di kebun</p>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-2xl text-red-700 text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <p>&bull; {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8">
            <form action="{{ route('portal.manajemen.panen.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Pilih Pohon Sasaran (Keterkaitan dengan Modul Pertumbuhan) --}}
                <div class="p-4 bg-purple-50/60 border border-purple-100 rounded-2xl">
                    <label class="block text-xs font-bold text-purple-900 uppercase tracking-wider mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                        Pohon Sumber Panen (Dari Modul Pertumbuhan)
                    </label>
                    <x-custom-dropdown 
                        name="pohon_id" 
                        id="pohon_id" 
                        placeholder="-- Pilih Pohon Sasaran (Opsional / Panen Kolektif) --" 
                        :options="$pohonList" 
                        :value="old('pohon_id', request('pohon_id'))" 
                        onchange="onPohonSelected(selectEl)" 
                        searchable 
                    />
                    <p class="text-[11px] text-purple-700/80 mt-1.5">Memilih pohon akan otomatis mengisi varietas dan lahan yang bersangkutan.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Lahan Asal</label>
                        <x-custom-dropdown 
                            name="lahan_id" 
                            id="lahan_id" 
                            placeholder="-- Pilih Lahan (Opsional) --" 
                            :options="$lahanList" 
                            :value="old('lahan_id')" 
                            searchable 
                        />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Varietas Durian <span class="text-red-500">*</span></label>
                        <input type="text" name="varietas" id="varietas_input" list="varietas_options" value="{{ old('varietas') }}" required 
                               placeholder="Pilih atau ketik varietas..."
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 font-semibold">
                        <datalist id="varietas_options">
                            @foreach($varietasList ?? [] as $v)
                                <option value="{{ $v }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Hasil Panen (Kg) <span class="text-red-500">*</span></label>
                        <input type="number" name="jumlah_kg" value="{{ old('jumlah_kg') }}" step="0.01" min="0" required 
                               placeholder="Contoh: 125.5"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 font-extrabold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Estimasi Harga / Kg (Rp)</label>
                        <input type="number" name="harga_per_kg" value="{{ old('harga_per_kg') }}" min="0" step="500" 
                               placeholder="Contoh: 150000"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Tanggal Panen <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_panen" value="{{ old('tanggal_panen', date('Y-m-d')) }}" required 
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 font-medium">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Catatan Kualitas Panen</label>
                    <textarea name="catatan" rows="3" placeholder="Tingkat kematangan (jatuhan alami/petik), kualitas aroma, ketebalan daging buah..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm resize-none text-slate-800 font-medium">{{ old('catatan') }}</textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 bg-purple-600 hover:bg-purple-700 text-white font-extrabold rounded-2xl shadow-md hover:shadow-lg transition-all text-sm">
                        Simpan Hasil Panen
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function onPohonSelected(select) {
            var selected = select.options[select.selectedIndex];
            var varietas = selected.getAttribute('data-varietas');
            var lahanId = selected.getAttribute('data-lahan');
            
            if (varietas) {
                document.getElementById('varietas_input').value = varietas;
            }
            if (lahanId) {
                var lahanSel = document.getElementById('lahan_id');
                if (lahanSel) {
                    lahanSel.value = lahanId;
                    lahanSel.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            var sel = document.getElementById('pohon_id');
            if (sel && sel.value) onPohonSelected(sel);
        });
    </script>
</x-portal-layout>
