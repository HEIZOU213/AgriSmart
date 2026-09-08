<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-slate-900 leading-tight">
                    {{ __('Edit Konten Edukasi') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Perbarui konten edukasi seputar budidaya durian.</p>
            </div>
            <a href="{{ route('admin.konten-edukasi.index') }}" 
               class="text-sm font-bold text-slate-500 hover:text-green-600 transition-colors">
                &larr; Kembali ke Daftar Konten
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        
        {{-- Error Handling Alert --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 p-4 rounded-xl shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Terdapat kesalahan pada input Anda:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.konten-edukasi.update', $konten->id) }}" method="POST" enctype="multipart/form-data">
            @csrf 
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- KOLOM KIRI: Informasi Utama --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-4 mb-4">Detail Konten</h3>

                        {{-- Input Judul --}}
                        <div>
                            <label for="judul" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Judul Konten</label>
                            <input type="text" id="judul" name="judul" value="{{ old('judul', $konten->judul) }}" 
                                   class="w-full rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 py-3 px-4 text-slate-900 transition placeholder-slate-400"
                                   placeholder="Contoh: Cara Menanam Cabai Rawit Anti Gagal">
                        </div>

                        {{-- Input Isi Konten (Textarea) --}}
                        <div>
                            <label for="isi_konten" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Isi Artikel</label>
                            <div class="relative">
                                <textarea name="isi_konten" id="isi_konten" rows="12" 
                                          class="w-full rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 py-3 px-4 text-slate-900 transition placeholder-slate-400 font-sans leading-relaxed"
                                          placeholder="Tuliskan materi edukasi di sini...">{{ old('isi_konten', $konten->isi_konten) }}</textarea>
                                <div class="absolute bottom-3 right-3 text-xs text-slate-400 pointer-events-none">
                                    Markdown Supported
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: Meta Data & Media --}}
                <div class="space-y-6">
                    
                    {{-- Card: Pengaturan --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
                        <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-4">Pengaturan</h3>
                        
                        {{-- Kategori --}}
                        <div>
                            <label for="kategori_edukasi_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Kategori</label>
                            <x-custom-dropdown 
                                name="kategori_edukasi_id" 
                                id="kategori_edukasi_id" 
                                placeholder="-- Pilih Kategori --" 
                                :options="$kategori" 
                                :value="old('kategori_edukasi_id', $konten->kategori_edukasi_id)" 
                                searchable 
                                required 
                            />
                        </div>

                        {{-- Tipe Konten --}}
                        <div>
                            <label for="tipe_konten" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tipe Konten</label>
                            <x-custom-dropdown 
                                name="tipe_konten" 
                                id="tipe_konten" 
                                :options="[
                                    'artikel' => '📄 Artikel',
                                    'video' => '🎥 Video'
                                ]" 
                                :value="old('tipe_konten', $konten->tipe_konten)" 
                                onchange="toggleVideoInput()" 
                                required 
                            />
                        </div>

                        {{-- URL Video (Kondisional via JS sederhana atau default tampil) --}}
                        <div id="video_url_container" class="{{ old('tipe_konten', $konten->tipe_konten) == 'video' ? 'block' : 'hidden' }}">
                            <label for="url_video" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">URL Youtube</label>
                            <input type="text" id="url_video" name="url_video" value="{{ old('url_video', $konten->url_video) }}" 
                                   class="block w-full rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 sm:text-sm py-2.5 transition" 
                                   placeholder="https://youtube.com/...">
                        </div>
                    </div>

                    {{-- Card: Media Gambar --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                        <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-4 mb-4">Media Sampul</h3>
                        
                        {{-- Foto Saat Ini --}}
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Foto Saat Ini</label>
                            @if($konten->foto_sampul)
                                <div class="relative w-full h-40 rounded-xl overflow-hidden group shadow-sm border border-slate-200">
                                    <img src="{{ asset('storage/' . $konten->foto_sampul) }}" alt="{{ $konten->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition duration-300"></div>
                                </div>
                            @else
                                <div class="w-full h-24 bg-slate-50 rounded-xl border border-dashed border-slate-300 flex items-center justify-center text-slate-400">
                                    <span class="text-sm font-medium">Belum ada foto</span>
                                </div>
                            @endif
                        </div>

                        {{-- Upload Foto Baru --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Ganti Foto (Opsional)</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="foto_sampul" class="flex flex-col items-center justify-center w-full h-32 border-2 border-green-200 border-dashed rounded-xl cursor-pointer bg-green-50 hover:bg-green-100 transition duration-300">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <p class="mb-1 text-sm text-slate-500"><span class="font-bold text-green-600">Klik upload</span> atau drag</p>
                                        <p class="text-xs text-slate-400">PNG, JPG (Max. 2MB)</p>
                                    </div>
                                    <input id="foto_sampul" name="foto_sampul" type="file" class="hidden" onchange="previewImage(event)" />
                                </label>
                            </div>
                            {{-- Preview Script --}}
                            <div id="preview-container" class="mt-4 hidden">
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Preview Foto Baru:</p>
                                <img id="preview-img" class="w-full h-32 object-cover rounded-xl shadow-sm border border-slate-200" />
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex flex-col gap-3 pt-2">
                        <button type="submit" 
                                class="w-full flex justify-center py-3 px-4 rounded-xl shadow-sm text-sm font-bold text-white bg-green-600 hover:bg-green-700 transition-colors">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.konten-edukasi.index') }}" class="w-full text-center py-3 px-4 rounded-xl border border-slate-200 text-slate-700 font-bold hover:bg-slate-50 transition">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Script Sederhana untuk Toggle Video & Preview Image --}}
    <script>
        function toggleVideoInput() {
            const tipe = document.getElementById('tipe_konten').value;
            const container = document.getElementById('video_url_container');
            if(tipe === 'video') {
                container.classList.remove('hidden');
                container.classList.add('block');
            } else {
                container.classList.add('hidden');
                container.classList.remove('block');
            }
        }

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('preview-img');
                const container = document.getElementById('preview-container');
                output.src = reader.result;
                container.classList.remove('hidden');
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-admin-layout>
