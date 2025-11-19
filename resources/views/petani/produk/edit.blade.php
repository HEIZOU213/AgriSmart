<x-petani-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Produk Panen') }}
            </h2>
            <a href="{{ route('petani.produk.index') }}" 
               class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Kembali ke Daftar Produk
            </a>
        </div>
    </x-slot>

    <div class="text-gray-900">
        @if ($errors->any())
            {{-- ... (Error handling tetap sama) ... --}}
        @endif

        <form action="{{ route('petani.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf 
            @method('PUT')
            
            <div class="space-y-4">
                {{-- ... (Form Nama, Kategori, Harga, Stok, Deskripsi tetap sama) ... --}}
                
                <div>
                    <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="kategori_produk_id" class="block text-sm font-medium text-gray-700">Kategori Produk</label>
                    <select name="kategori_produk_id" id="kategori_produk_id" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategori as $item)
                            <option value="{{ $item->id }}" {{ old('kategori_produk_id', $produk->kategori_produk_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                        <input type="number" id="harga" name="harga" value="{{ old('harga', $produk->harga) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="stok" class="block text-sm font-medium text-gray-700">Stok (Cth: Kg, Ikat)</label>
                        <input type="number" id="stok" name="stok" value="{{ old('stok', $produk->stok) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Produk</label>
                    <textarea name="deskripsi" id="deskripsi" rows="5" 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                </div>

                {{-- [BARU] Tampilkan foto saat ini dan form ganti foto --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Foto Produk Saat Ini</label>
                    @if($produk->foto_produk)
                        <img src="{{ asset('storage/' . $produk->foto_produk) }}" alt="{{ $produk->nama_produk }}" class="w-32 h-32 object-cover rounded mt-2 shadow">
                    @else
                        <p class="mt-2 text-sm text-gray-500">Tidak ada foto.</p>
                    @endif
                </div>

                <div>
                    <label for="foto_produk" class="block text-sm font-medium text-gray-700">Ganti Foto Produk (Opsional)</label>
                    <input type="file" id="foto_produk" name="foto_produk" 
                           class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    <small class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengganti foto.</small>
                    @error('foto_produk')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                {{-- ... (Tombol Simpan tetap sama) ... --}}
                <div class="flex justify-end">
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-petani-layout>