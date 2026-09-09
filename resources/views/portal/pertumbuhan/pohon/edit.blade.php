<x-portal-layout portalName="Pertumbuhan" pageTitle="Edit Pohon" :menuItems="$menuItems">
    <div class="max-w-2xl">
        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('portal.pertumbuhan.pohon.index') }}" 
               class="p-2 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-slate-800 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="text-xl font-extrabold text-slate-800">Edit Data Pohon Durian</h2>
                <p class="text-xs text-slate-400">Perbarui identitas, lokasi lahan, fase, dan status kesehatan pohon</p>
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
            <form action="{{ route('portal.pertumbuhan.pohon.update', $pohon) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Kode Pohon <span class="text-red-500">*</span></label>
                        <input type="text" name="kode_pohon" value="{{ old('kode_pohon', $pohon->kode_pohon) }}" required 
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 font-medium font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Nama Varietas <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_varietas" value="{{ old('nama_varietas', $pohon->nama_varietas) }}" required 
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 font-medium">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Lahan</label>
                        <x-custom-dropdown 
                            name="lahan_id" 
                            placeholder="-- Pilih Lahan (Opsional) --" 
                            :options="$lahanList" 
                            :value="old('lahan_id', $pohon->lahan_id)" 
                            searchable 
                        />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Lokasi / Blok Detail</label>
                        <input type="text" name="lokasi" value="{{ old('lokasi', $pohon->lokasi) }}" 
                               placeholder="Contoh: Blok Barat, Baris 2"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 font-medium">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Fase Pertumbuhan *</label>
                        <x-custom-dropdown 
                            name="fase" 
                            :value="old('fase', $pohon->fase)" 
                            :options="[
                                'bibit' => 'Bibit (Baru Tanam)',
                                'vegetatif' => 'Vegetatif (Batang/Daun)',
                                'generatif' => 'Generatif (Bunga/Pentil)',
                                'produktif' => 'Produktif (Siap Panen)'
                            ]" 
                            required 
                        />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Kondisi Kesehatan *</label>
                        <x-custom-dropdown 
                            name="kondisi" 
                            :value="old('kondisi', $pohon->kondisi)" 
                            :options="[
                                'sehat' => 'Sehat (Prima)',
                                'perawatan' => 'Dalam Perawatan',
                                'bermasalah' => 'Bermasalah / Sakit'
                            ]" 
                            required 
                        />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Tanggal Tanam</label>
                        <input type="date" name="tanggal_tanam" value="{{ old('tanggal_tanam', $pohon->tanggal_tanam ? $pohon->tanggal_tanam->format('Y-m-d') : '') }}" 
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm text-slate-800 font-medium">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Catatan Tambahan</label>
                    <textarea name="catatan" rows="3" placeholder="Informasi indukan, tinggi awal tanam, atau riwayat perlakuan bibit..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-green-500 outline-none text-sm resize-none text-slate-800 font-medium">{{ old('catatan', $pohon->catatan) }}</textarea>
                </div>

                <div class="pt-2 flex items-center gap-3">
                    <button type="submit" class="flex-1 py-3.5 bg-green-600 hover:bg-green-700 text-white font-extrabold rounded-2xl shadow-md hover:shadow-lg transition-all text-sm">
                        Perbarui Data Pohon
                    </button>
                    <a href="{{ route('portal.pertumbuhan.pohon.index') }}" class="px-5 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-2xl text-sm transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-portal-layout>
