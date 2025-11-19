<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Konten Edukasi Baru') }}
            </h2>
            <a href="{{ route('admin.konten-edukasi.index') }}" 
               class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="text-gray-900">
        @if ($errors->any())
            {{-- ... (Error handling tetap sama) ... --}}
        @endif

        {{-- [BARU] Tambahkan enctype untuk upload file --}}
        <form action="{{ route('admin.konten-edukasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf 
            <div class="space-y-4">
                {{-- ... (Form Judul, Kategori, Tipe, Isi, URL Video tetap sama) ... --}}
                <div>
                    <label for="judul" class="block text-sm font-medium text-gray-700">Judul Konten</label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul') }}" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('judul')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="kategori_edukasi_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="kategori_edukasi_id" id="kategori_edukasi_id" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategori as $item)
                            <option value="{{ $item->id }}" {{ old('kategori_edukasi_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_edukasi_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="tipe_konten" class="block text-sm font-medium text-gray-700">Tipe Konten</label>
                    <select name="tipe_konten" id="tipe_konten" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="artikel" {{ old('tipe_konten') == 'artikel' ? 'selected' : '' }}>Artikel</option>
                        <option value="video" {{ old('tipe_konten') == 'video' ? 'selected' : '' }}>Video</option>
                    </select>
                </div>
                <div>
                    <label for="isi_konten" class="block text-sm font-medium text-gray-700">Isi Konten (untuk Artikel)</label>
                    <textarea name="isi_konten" id="isi_konten" rows="10" 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('isi_konten') }}</textarea>
                </div>
                <div>
                    <label for="url_video" class="block text-sm font-medium text-gray-700">URL Video (jika tipe Video)</label>
                    <input type="text" id="url_video" name="url_video" value="{{ old('url_video') }}" 
                           placeholder="https://www.youtube.com/watch?v=xxxx" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                {{-- [BARU] Field upload foto sampul --}}
                <div>
                    <label for="foto_sampul" class="block text-sm font-medium text-gray-700">Foto Sampul (Opsional)</label>
                    <input type="file" id="foto_sampul" name="foto_sampul" 
                           class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    @error('foto_sampul')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Simpan Konten
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>