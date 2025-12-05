<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-emerald-900 leading-tight flex items-center gap-2">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('Tambah Konten Edukasi') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Buat artikel atau video baru untuk edukasi petani.</p>
            </div>
            <a href="{{ route('admin.konten-edukasi.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Error Handling Alert --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm animate-pulse">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan input:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.konten-edukasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf 
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- KOLOM KIRI: Form Utama (Judul & Isi) --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                            <div class="p-6 sm:p-8 space-y-6">
                                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Detail Konten</h3>

                                {{-- Input Judul --}}
                                <div>
                                    <label for="judul" class="block text-sm font-bold text-gray-700 mb-2">Judul Konten <span class="text-red-500">*</span></label>
                                    <input type="text" id="judul" name="judul" value="{{ old('judul') }}" 
                                           class="w-full border-gray-300 rounded-xl shadow-sm focus:border-emerald-500 focus:ring-emerald-500 py-3 px-4 text-gray-800 placeholder-gray-400 transition duration-200"
                                           placeholder="Contoh: Teknik Pemupukan Cabai Agar Berbuah Lebat">
                                </div>

                                {{-- Input Isi Konten (Textarea) --}}
                                <div>
                                    <label for="isi_konten" class="block text-sm font-bold text-gray-700 mb-2">Isi Artikel</label>
                                    <div class="relative">
                                        <textarea name="isi_konten" id="isi_konten" rows="15" 
                                                  class="w-full border-gray-300 rounded-xl shadow-sm focus:border-emerald-500 focus:ring-emerald-500 py-3 px-4 text-gray-700 placeholder-gray-400 font-sans leading-relaxed transition duration-200"
                                                  placeholder="Tuliskan materi edukasi secara lengkap di sini...">{{ old('isi_konten') }}</textarea>
                                        <div class="absolute bottom-3 right-3 text-xs text-gray-400 bg-white px-2 rounded pointer-events-none">
                                            Minimal 50 karakter
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: Sidebar (Kategori, Foto, Simpan) --}}
                    <div class="space-y-6">
                        
                        {{-- Card: Pengaturan --}}
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-6 space-y-5">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Pengaturan</h3>
                            
                            {{-- Kategori --}}
                            <div>
                                <label for="kategori_edukasi_id" class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="kategori_edukasi_id" id="kategori_edukasi_id" 
                                            class="w-full border-gray-300 rounded-xl shadow-sm focus:border-emerald-500 focus:ring-emerald-500 py-2.5 px-4 appearance-none bg-white cursor-pointer">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($kategori as $item)
                                            <option value="{{ $item->id }}" {{ old('kategori_edukasi_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{-- Custom Arrow Icon --}}
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Tipe Konten --}}
                            <div>
                                <label for="tipe_konten" class="block text-sm font-semibold text-gray-700 mb-2">Tipe Konten <span class="text-red-500">*</span></label>
                                <select name="tipe_konten" id="tipe_konten" 
                                        class="w-full border-gray-300 rounded-xl shadow-sm focus:border-emerald-500 focus:ring-emerald-500 py-2.5 px-4 cursor-pointer"
                                        onchange="toggleVideoInput()">
                                    <option value="artikel" {{ old('tipe_konten') == 'artikel' ? 'selected' : '' }}>📄 Artikel</option>
                                    <option value="video" {{ old('tipe_konten') == 'video' ? 'selected' : '' }}>🎥 Video</option>
                                </select>
                            </div>

                            {{-- URL Video (Hidden by default using JS) --}}
                            <div id="video_url_container" class="{{ old('tipe_konten') == 'video' ? 'block' : 'hidden' }} transition-all duration-300">
                                <label for="url_video" class="block text-sm font-semibold text-gray-700 mb-2">Link Youtube</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                        </span>
                                    </div>
                                    <input type="text" id="url_video" name="url_video" value="{{ old('url_video') }}" 
                                           class="focus:ring-emerald-500 focus:border-emerald-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-xl py-2.5" 
                                           placeholder="https://youtube.com/...">
                                </div>
                            </div>
                        </div>

                        {{-- Card: Media Gambar --}}
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Gambar Sampul</h3>
                            
                            {{-- Upload Foto Modern (Dashed Box) --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Upload File</label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="foto_sampul" class="flex flex-col items-center justify-center w-full h-40 border-2 border-emerald-300 border-dashed rounded-xl cursor-pointer bg-emerald-50 hover:bg-emerald-100 transition duration-300 group">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-10 h-10 mb-3 text-emerald-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                            <p class="mb-1 text-sm text-gray-500"><span class="font-semibold text-emerald-600">Klik upload</span> atau drag</p>
                                            <p class="text-xs text-gray-400">PNG, JPG (Max. 2MB)</p>
                                        </div>
                                        <input id="foto_sampul" name="foto_sampul" type="file" class="hidden" onchange="previewImage(event)" accept="image/*" />
                                    </label>
                                </div>
                                {{-- Preview Container --}}
                                <div id="preview-container" class="mt-4 hidden">
                                    <p class="text-xs text-gray-500 mb-1">Preview:</p>
                                    <img id="preview-img" class="w-full h-40 object-cover rounded-lg shadow-md border border-gray-200" />
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex flex-col gap-3 pt-2">
                            <button type="submit" 
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all transform hover:scale-[1.02]">
                                Simpan Konten
                            </button>
                            <a href="{{ route('admin.konten-edukasi.index') }}" class="w-full text-center py-3 px-4 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Script JavaScript untuk Interaktivitas --}}
    <script>
        // 1. Toggle URL Video Input
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

        // 2. Image Preview
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('preview-img');
                const container = document.getElementById('preview-container');
                output.src = reader.result;
                container.classList.remove('hidden');
            };
            // Cek apakah ada file yang dipilih
            if(event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        // 3. Jalankan saat load (Untuk mengatasi old input jika validasi gagal)
        document.addEventListener("DOMContentLoaded", function() {
            toggleVideoInput(); 
        });
    </script>
</x-admin-layout>