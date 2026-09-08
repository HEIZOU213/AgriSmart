<x-portal-layout portalName="Pertumbuhan" pageTitle="Edit Jadwal Perawatan" :menuItems="$menuItems">
<div class="max-w-2xl">
    <div class="mb-5 flex items-center gap-3">
        <a href="{{ route('portal.pertumbuhan.jadwal.index') }}" class="text-slate-400 hover:text-slate-600">Kembali</a>
        <h2 class="text-lg font-bold text-slate-800">Edit Jadwal Perawatan Pohon</h2>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <form action="{{ route('portal.pertumbuhan.jadwal.update', $jadwal) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Pilih Pohon *</label>
                <x-custom-dropdown 
                    name="pohon_id" 
                    placeholder="-- Pilih Pohon --" 
                    :options="$pohonList" 
                    :value="old('pohon_id', $jadwal->pohon_id)" 
                    searchable 
                    required 
                />
                @error('pohon_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jenis Perawatan *</label>
                <input type="text" name="jenis_perawatan" value="{{ old('jenis_perawatan', $jadwal->jenis_perawatan) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 outline-none text-sm font-semibold text-slate-800" placeholder="Contoh: Pemupukan, Penyiraman, Pemangkasan">
                @error('jenis_perawatan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tanggal Jadwal *</label>
                    <input type="date" name="tanggal_jadwal" value="{{ old('tanggal_jadwal', $jadwal->tanggal_jadwal ? $jadwal->tanggal_jadwal->format('Y-m-d') : '') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 outline-none text-sm font-semibold text-slate-800">
                    @error('tanggal_jadwal')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Status *</label>
                    <x-custom-dropdown 
                        name="status" 
                        :value="old('status', $jadwal->status)" 
                        :options="[
                            'pending' => 'Pending',
                            'selesai' => 'Selesai',
                            'batal' => 'Batal'
                        ]" 
                        required 
                    />
                    @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Catatan</label>
                <textarea name="catatan" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-400 outline-none text-sm resize-none">{{ old('catatan', $jadwal->catatan) }}</textarea>
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="flex-1 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-colors">Perbarui Jadwal</button>
                <a href="{{ route('portal.pertumbuhan.jadwal.index') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
</x-portal-layout>
