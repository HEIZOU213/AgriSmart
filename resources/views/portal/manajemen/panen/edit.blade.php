<x-portal-layout portalName="Manajemen Kebun" pageTitle="Edit Panen" :menuItems="$menuItems">
<div class="max-w-2xl">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('portal.manajemen.panen.index') }}" 
           class="p-2 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-slate-800 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Edit Data Panen</h2>
            <p class="text-xs text-slate-500">Perbarui catatan hasil panen durian kebun Anda</p>
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
        <form action="{{ route('portal.manajemen.panen.update', $panen) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Pilih Pohon Sasaran --}}
            <div class="p-4 bg-purple-50/60 border border-purple-100 rounded-2xl">
                <label class="block text-xs font-bold text-purple-900 uppercase tracking-wider mb-2 flex items-center gap-2">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                    Pohon Sumber Panen
                </label>
                <x-custom-dropdown 
                    name="pohon_id" 
                    id="pohon_id" 
                    placeholder="-- Panen Kolektif / Tanpa Spesifik Pohon --" 
                    :options="$pohonList" 
                    :value="old('pohon_id', $panen->pohon_id)" 
                    onchange="onPohonSelected(selectEl)" 
                    searchable 
                />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Lahan Asal</label>
                    <x-custom-dropdown 
                        name="lahan_id" 
                        id="lahan_id" 
                        placeholder="-- Pilih Lahan (Opsional) --" 
                        :options="$lahanList" 
                        :value="old('lahan_id', $panen->lahan_id)" 
                        searchable 
                    />
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Varietas Durian *</label>
                    <input type="text" name="varietas" id="varietas_input" list="varietas_options" value="{{ old('varietas', $panen->varietas) }}" required 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm font-semibold text-slate-800"
                           placeholder="Pilih atau ketik varietas...">
                    <datalist id="varietas_options">
                        @foreach($varietasList ?? [] as $v)
                            <option value="{{ $v }}"></option>
                        @endforeach
                    </datalist>
                    @error('varietas')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Jumlah Panen (Kg) *</label>
                    <input type="number" name="jumlah_kg" value="{{ old('jumlah_kg', $panen->jumlah_kg) }}" step="0.1" min="0.1" required 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm font-black text-slate-800">
                    @error('jumlah_kg')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Estimasi Harga / Kg (Rp)</label>
                    <input type="number" name="harga_per_kg" value="{{ old('harga_per_kg', $panen->harga_per_kg) }}" min="0" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm font-semibold text-slate-800">
                    @error('harga_per_kg')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Tanggal Panen *</label>
                    <input type="date" name="tanggal_panen" value="{{ old('tanggal_panen', $panen->tanggal_panen ? $panen->tanggal_panen->format('Y-m-d') : '') }}" required 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm font-semibold text-slate-800">
                    @error('tanggal_panen')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Catatan Panen</label>
                <textarea name="catatan" rows="3" 
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 resize-none"
                          placeholder="Grade buah, aroma, ketebalan daging...">{{ old('catatan', $panen->catatan) }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="flex-1 py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-xl transition-colors shadow-sm">
                    Perbarui Data Panen
                </button>
                <a href="{{ route('portal.manajemen.panen.index') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function onPohonSelected(select) {
    const selected = select.options[select.selectedIndex];
    if (selected && selected.value) {
        const varietas = selected.getAttribute('data-varietas');
        const lahanId = selected.getAttribute('data-lahan');
        if (varietas) {
            document.getElementById('varietas_input').value = varietas;
        }
        if (lahanId) {
            const lahanSel = document.getElementById('lahan_id');
            if (lahanSel) {
                lahanSel.value = lahanId;
                lahanSel.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }
    }
}
</script>
</x-portal-layout>
