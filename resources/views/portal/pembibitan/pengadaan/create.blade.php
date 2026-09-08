<x-portal-layout portalName="Pembibitan" pageTitle="Catat Pengadaan" :menuItems="$menuItems">
<div class="max-w-2xl">
    <div class="mb-5 flex items-center gap-3">
        <a href="{{ route('portal.pembibitan.pengadaan.index') }}" 
           class="p-2 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-slate-800 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Catat Pengadaan Bibit</h2>
            <p class="text-xs text-slate-500">Pencatatan pembelian atau pasokan bibit baru dari mitra/penangkar</p>
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
        <form action="{{ route('portal.pembibitan.pengadaan.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nama Supplier / Penangkar *</label>
                    @php
                        $supOpts = [];
                        foreach(($supplierList ?? []) as $s) { $supOpts[$s] = $s; }
                        $supOpts['__custom__'] = 'Tulis Supplier Baru...';
                    @endphp
                    <x-custom-dropdown 
                        name="nama_supplier" 
                        id="supplier_select" 
                        placeholder="-- Pilih Supplier / Penangkar --" 
                        :options="$supOpts" 
                        :value="old('nama_supplier')" 
                        searchable 
                        customWrapId="supplier_custom_wrap" 
                        customInputId="supplier_custom_input" 
                        required 
                    />
                    <div id="supplier_custom_wrap" class="mt-2 {{ old('nama_supplier_custom') ? '' : 'hidden' }}">
                        <input type="text" name="nama_supplier_custom" id="supplier_custom_input" value="{{ old('nama_supplier_custom') }}" 
                               class="w-full px-4 py-2 rounded-xl border border-emerald-300 focus:border-green-500 outline-none text-sm text-slate-800" 
                               placeholder="Ketik nama supplier baru...">
                    </div>
                    @error('nama_supplier')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Varietas Bibit *</label>
                    @php
                        $vOpts = [];
                        foreach(($varietasList ?? []) as $v) { $vOpts[$v] = $v; }
                        $vOpts['__custom__'] = 'Tulis Varietas Baru...';
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

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jumlah (Bibit) *</label>
                    <input type="number" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" required 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm font-black text-slate-800">
                    @error('jumlah')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Harga / Unit (Rp) *</label>
                    <input type="number" name="harga_satuan" value="{{ old('harga_satuan', 50000) }}" min="0" required 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm font-semibold text-slate-800">
                    @error('harga_satuan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tanggal Pengadaan *</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm font-semibold text-slate-800">
                    @error('tanggal')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Catatan Pengadaan</label>
                <textarea name="catatan" rows="3" 
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 resize-none" 
                          placeholder="Nomor invoice, batch kedatangan, nomor garansi/sertifikasi...">{{ old('catatan') }}</textarea>
            </div>

            <button type="submit" class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-colors shadow-sm">
                Simpan Pengadaan Bibit
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

document.querySelector('form').addEventListener('submit', function(e) {
    const sSel = document.getElementById('supplier_select');
    const sInp = document.getElementById('supplier_custom_input');
    if (sSel.value === '__custom__' && sInp.value.trim() !== '') {
        sSel.options[sSel.selectedIndex].value = sInp.value.trim();
    }

    const vSel = document.getElementById('varietas_select');
    const vInp = document.getElementById('varietas_custom_input');
    if (vSel.value === '__custom__' && vInp.value.trim() !== '') {
        vSel.options[vSel.selectedIndex].value = vInp.value.trim();
    }
});
</script>
</x-portal-layout>
