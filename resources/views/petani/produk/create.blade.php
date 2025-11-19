<x-petani-layout>
    
    {{-- Slot untuk Judul Halaman --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Produk Panen Baru') }}
            </h2>
            <a href="{{ route('petani.produk.index') }}" 
               class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Kembali ke Daftar Produk
            </a>
        </div>
    </x-slot>

    {{-- Slot untuk Konten Utama --}}
    <div class="text-gray-900">
        
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                <strong>Whoops!</strong> Ada masalah dengan input Anda.<br><br>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('petani.produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf 
            
            <div class="space-y-4">
                <div>
                    <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" id="nama_produk" name="nama_produk" value="{{ old('nama_produk') }}" 
                           placeholder="Cth: Tomat Ceri Segar"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('nama_produk')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kategori_produk_id" class="block text-sm font-medium text-gray-700">Kategori Produk</label>
                    <select name="kategori_produk_id" id="kategori_produk_id" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategori as $item)
                            <option value="{{ $item->id }}" {{ old('kategori_produk_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_produk_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                        <input type="number" id="harga" name="harga" value="{{ old('harga') }}" 
                               placeholder="Cth: 15000"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('harga')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="stok" class="block text-sm font-medium text-gray-700">Stok (Cth: Kg, Ikat)</label>
                        <input type="number" id="stok" name="stok" value="{{ old('stok') }}" 
                               placeholder="Cth: 20"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('stok')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Produk</label>
                    <textarea name="deskripsi" id="deskripsi" rows="5" 
                              placeholder="Jelaskan tentang produk panen Anda..." 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="foto_produk" class="block text-sm font-medium text-gray-700">Foto Produk</label>
                    <input type="file" id="foto_produk" name="foto_produk" 
                           class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    @error('foto_produk')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Simpan Produk
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-petani-layout>