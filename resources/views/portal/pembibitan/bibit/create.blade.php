<x-portal-layout portalName="Pembibitan" pageTitle="Tambah Bibit" :menuItems="$menuItems">
<div class="max-w-2xl">
    <div class="mb-5 flex items-center gap-3">
        <a href="{{ route('portal.pembibitan.bibit.index') }}" 
           class="p-2 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-slate-800 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Tambah Data Bibit</h2>
            <p class="text-xs text-slate-500">Registrasi bibit durian baru ke dalam sistem inventaris persemaian</p>
        </div>
    </div>

    {{-- Callout 1 Bibit = 1 Kode Tag --}}
    <div class="mb-5 p-4 bg-emerald-50/80 border border-emerald-200 rounded-2xl flex items-start gap-3 text-xs text-emerald-900 shadow-sm">
        <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0 mt-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <span class="font-extrabold block text-emerald-950">Prinsip Ketertelusuran (1 Tag = 1 Bibit)</span>
            Satu kode tag bibit mewakili 1 tanaman bibit durian secara individual. Ketika bibit ini ditanam ke lahan, tag ini akan langsung bertransformasi menjadi 1 pohon durian di kebun Anda.
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
        <form action="{{ route('portal.pembibitan.bibit.store') }}" method="POST" class="space-y-4">
            @csrf
            {{-- Default 1 bibit per kode tag --}}
            <input type="hidden" name="jumlah" value="1">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Kode Tag Bibit *</label>
                    <input type="text" name="kode_bibit" value="{{ old('kode_bibit') }}" required 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none text-sm font-semibold text-slate-800"
                           placeholder="Contoh: BBT-MK-001">
                    @error('kode_bibit')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Varietas Durian *</label>
                    @php
                        $vOpts = [];
                        foreach(($varietasList ?? []) as $v) { $vOpts[$v] = $v; }
                        $vOpts['__custom__'] = 'Tulis Varietas Lain...';
                    @endphp
                    <x-custom-dropdown 
                        name="nama_varietas" 
                        id="varietas_select" 
                        placeholder="-- Pilih Varietas Durian --" 
                        :options="$vOpts" 
                        :value="old('nama_varietas')" 
                        searchable 
                        customWrapId="varietas_custom_wrap" 
                        customInputId="varietas_custom_input" 
                        required 
                    />
                    <div id="varietas_custom_wrap" class="mt-2 {{ old('nama_varietas_custom') ? '' : 'hidden' }}">
                        <input type="text" name="nama_varietas_custom" id="varietas_custom_input" value="{{ old('nama_varietas_custom') }}" 
                               class="w-full px-4 py-2 rounded-xl border border-emerald-300 focus:border-green-500 outline-none text-sm text-slate-800" 
                               placeholder="Ketik nama varietas baru...">
                    </div>
                    @error('nama_varietas')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Asal Benih / Metode Perbanyakan</label>
                @php
                    $abOpts = [];
                    foreach(($asalBenihList ?? []) as $ab) { $abOpts[$ab] = $ab; }
                    $abOpts['__custom__'] = 'Tulis Asal Benih Lain...';
                @endphp
                <x-custom-dropdown 
                    name="asal_benih" 
                    id="asal_benih_select" 
                    placeholder="-- Pilih Asal / Metode Benih (Opsional) --" 
                    :options="$abOpts" 
                    :value="old('asal_benih')" 
                    searchable 
                    customWrapId="asal_custom_wrap" 
                    customInputId="asal_custom_input" 
                />
                <div id="asal_custom_wrap" class="mt-2 {{ old('asal_benih_custom') ? '' : 'hidden' }}">
                    <input type="text" name="asal_benih_custom" id="asal_custom_input" value="{{ old('asal_benih_custom') }}" 
                           class="w-full px-4 py-2 rounded-xl border border-emerald-300 focus:border-green-500 outline-none text-sm text-slate-800" 
                           placeholder="Ketik asal benih...">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Status *</label>
                    <x-custom-dropdown 
                        name="status" 
                        :value="old('status', 'aktif')" 
                        :options="[
                            'aktif' => 'Aktif',
                            'perawatan' => 'Perawatan',
                            'siap_tanam' => 'Siap Tanam',
                            'mati' => 'Mati'
                        ]" 
                        required 
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Kondisi Kesehatan *</label>
                    <x-custom-dropdown 
                        name="kondisi" 
                        :value="old('kondisi', 'sehat')" 
                        :options="[
                            'sehat' => 'Sehat',
                            'kurang_sehat' => 'Kurang Sehat',
                            'kritis' => 'Kritis'
                        ]" 
                        required 
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tanggal Semai</label>
                    <input type="date" name="tanggal_semai" value="{{ old('tanggal_semai', date('Y-m-d')) }}" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm font-semibold text-slate-800">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Catatan Tambahan</label>
                <textarea name="catatan" rows="3" 
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 resize-none" 
                          placeholder="Nomor sertifikat benih, catatan media tanam, dll...">{{ old('catatan') }}</textarea>
            </div>

            <button type="submit" class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-colors shadow-sm">
                Simpan Data Bibit (1 Bibit)
            </button>
        </form>
    </div>
</div>

<script>
function toggleCustomField(select, wrapId, inputId) {
    const wrap = document.getElementById(wrapId);
    const input = document.getElementById(inputId);
    if (select.value === '__custom__') {
        wrap.classList.remove('hidden');
        input.focus();
        input.required = true;
    } else {
        wrap.classList.add('hidden');
        input.required = false;
    }
}

// Ensure form submits custom values if selected
document.querySelector('form').addEventListener('submit', function(e) {
    const vSel = document.getElementById('varietas_select');
    const vInp = document.getElementById('varietas_custom_input');
    if (vSel.value === '__custom__' && vInp.value.trim() !== '') {
        vSel.options[vSel.selectedIndex].value = vInp.value.trim();
    }

    const abSel = document.getElementById('asal_benih_select');
    const abInp = document.getElementById('asal_custom_input');
    if (abSel.value === '__custom__' && abInp.value.trim() !== '') {
        abSel.options[abSel.selectedIndex].value = abInp.value.trim();
    }
});
</script>
</x-portal-layout>
