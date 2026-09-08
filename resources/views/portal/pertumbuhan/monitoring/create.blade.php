<x-portal-layout portalName="Pertumbuhan" pageTitle="Catat Monitoring" :menuItems="$menuItems">
    <div class="max-w-2xl">
        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('portal.pertumbuhan.monitoring.index') }}" 
               class="p-2 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-slate-800 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="text-xl font-extrabold text-slate-800">Catat Monitoring Pertumbuhan</h2>
                <p class="text-xs text-slate-400">Pengukuran fisik dan evaluasi kondisi pohon durian</p>
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
            <form action="{{ route('portal.pertumbuhan.monitoring.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Pilih Pohon <span class="text-red-500">*</span></label>
                    <x-custom-dropdown 
                        name="pohon_id" 
                        placeholder="-- Pilih Pohon Target --" 
                        :options="$pohonList" 
                        :value="old('pohon_id', request('pohon_id'))" 
                        searchable 
                        required 
                    />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Tinggi Pohon (cm)</label>
                        <input type="number" name="tinggi_cm" value="{{ old('tinggi_cm') }}" step="0.01" placeholder="Contoh: 185.5"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Diameter Batang (cm)</label>
                        <input type="number" name="diameter_batang" value="{{ old('diameter_batang') }}" step="0.01" placeholder="Contoh: 12.4"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Jumlah Cabang</label>
                        <input type="number" name="jumlah_cabang" value="{{ old('jumlah_cabang') }}" placeholder="Contoh: 8"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 font-medium">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Kondisi Pohon <span class="text-red-500">*</span></label>
                        <x-custom-dropdown 
                            name="kondisi" 
                            :value="old('kondisi', 'sehat')" 
                            :options="[
                                'sehat' => 'Sehat (Pertumbuhan normal)',
                                'perawatan' => 'Perawatan (Pemulihan hama/nutrisi)',
                                'bermasalah' => 'Bermasalah (Kering/penyakit/stres)'
                            ]" 
                            required 
                        />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Tanggal Pemeriksaan <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 font-medium">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Catatan Pemeriksaan</label>
                    <textarea name="catatan" rows="3" placeholder="Catatan visual seperti warna daun, tunas baru, serangan hama, dll."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm resize-none text-slate-800 font-medium">{{ old('catatan') }}</textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 bg-teal-600 hover:bg-teal-700 text-white font-extrabold rounded-2xl shadow-md hover:shadow-lg transition-all text-sm">
                        Simpan Data Monitoring
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-portal-layout>
