<x-portal-layout portalName="Pembibitan" pageTitle="Catat Monitoring" :menuItems="$menuItems">
<div class="max-w-2xl">
    <div class="mb-5 flex items-center gap-3">
        <a href="{{ route('portal.pembibitan.monitoring.index') }}" 
           class="p-2 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-slate-800 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Catat Monitoring Bibit</h2>
            <p class="text-xs text-slate-500">Pencatatan perkembangan fisik dan kesehatan bibit</p>
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
        <form action="{{ route('portal.pembibitan.monitoring.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Pilih Bibit *</label>
                <x-custom-dropdown 
                    name="bibit_id" 
                    placeholder="-- Pilih Bibit --" 
                    :options="$bibitList" 
                    :value="old('bibit_id', request('bibit_id'))" 
                    searchable 
                    required 
                />
                @error('bibit_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tinggi (cm)</label>
                    <input type="number" name="tinggi_cm" value="{{ old('tinggi_cm') }}" step="0.01" min="0" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 outline-none text-sm font-semibold text-slate-800" 
                           placeholder="Contoh: 45.5">
                    @error('tinggi_cm')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Kondisi Kesehatan *</label>
                    <x-custom-dropdown 
                        name="kondisi" 
                        :value="old('kondisi', 'sehat')" 
                        :options="[
                            'sehat' => 'Sehat (Prima)',
                            'kurang_sehat' => 'Kurang Sehat',
                            'kritis' => 'Kritis'
                        ]" 
                        required 
                    />
                    @error('kondisi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tanggal Pemeriksaan *</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required 
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 outline-none text-sm font-semibold text-slate-800">
                @error('tanggal')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Catatan</label>
                <textarea name="catatan" rows="3" 
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 outline-none text-sm text-slate-800 resize-none" 
                          placeholder="Perkembangan daun baru, kondisi akar, dll...">{{ old('catatan') }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="flex-1 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-colors shadow-sm">
                    Simpan Monitoring
                </button>
                <a href="{{ route('portal.pembibitan.monitoring.index') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
</x-portal-layout>
