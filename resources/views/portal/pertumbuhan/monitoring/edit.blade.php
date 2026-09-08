<x-portal-layout portalName="Pertumbuhan" pageTitle="Edit Monitoring Pohon" :menuItems="$menuItems">
<div class="max-w-2xl">
    <div class="mb-5 flex items-center gap-3">
        <a href="{{ route('portal.pertumbuhan.monitoring.index') }}" class="text-slate-400 hover:text-slate-600">Kembali</a>
        <h2 class="text-lg font-bold text-slate-800">Edit Data Monitoring Pohon</h2>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <form action="{{ route('portal.pertumbuhan.monitoring.update', $monitoring) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Pilih Pohon *</label>
                <x-custom-dropdown 
                    name="pohon_id" 
                    placeholder="-- Pilih Pohon --" 
                    :options="$pohonList" 
                    :value="old('pohon_id', $monitoring->pohon_id)" 
                    searchable 
                    required 
                />
                @error('pohon_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tinggi (cm)</label>
                    <input type="number" name="tinggi_cm" value="{{ old('tinggi_cm', $monitoring->tinggi_cm) }}" step="0.01" min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 outline-none text-sm font-semibold text-slate-800">
                    @error('tinggi_cm')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Diameter Batang (cm)</label>
                    <input type="number" name="diameter_batang" value="{{ old('diameter_batang', $monitoring->diameter_batang) }}" step="0.01" min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 outline-none text-sm font-semibold text-slate-800">
                    @error('diameter_batang')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jumlah Cabang</label>
                    <input type="number" name="jumlah_cabang" value="{{ old('jumlah_cabang', $monitoring->jumlah_cabang) }}" min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 outline-none text-sm font-semibold text-slate-800">
                    @error('jumlah_cabang')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Kondisi *</label>
                    <x-custom-dropdown 
                        name="kondisi" 
                        :value="old('kondisi', $monitoring->kondisi)" 
                        :options="[
                            'sehat' => 'Sehat',
                            'perawatan' => 'Perawatan',
                            'bermasalah' => 'Bermasalah'
                        ]" 
                        required 
                    />
                    @error('kondisi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tanggal *</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $monitoring->tanggal ? $monitoring->tanggal->format('Y-m-d') : '') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 outline-none text-sm font-semibold text-slate-800">
                    @error('tanggal')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Catatan</label>
                <textarea name="catatan" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-400 outline-none text-sm resize-none">{{ old('catatan', $monitoring->catatan) }}</textarea>
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="flex-1 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-colors">Perbarui Monitoring</button>
                <a href="{{ route('portal.pertumbuhan.monitoring.index') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
</x-portal-layout>
