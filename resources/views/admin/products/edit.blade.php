<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            Edit Produk: {{ $product->nama_produk }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama Produk --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
                <input type="text" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="grid grid-cols-2 gap-6">
                {{-- Kategori --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                    <select name="kategori_produk_id" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ $product->kategori_produk_id == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- Harga --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp)</label>
                    <input type="number" name="harga" value="{{ old('harga', $product->harga) }}" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                {{-- Stok --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Stok</label>
                    <input type="number" name="stok" value="{{ old('stok', $product->stok) }}" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                {{-- Satuan (Readonly - opsional) --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Satuan</label>
                    <input type="text" value="{{ $product->satuan }}" class="w-full rounded-lg border-gray-300 bg-gray-100 cursor-not-allowed" readonly>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('deskripsi', $product->deskripsi) }}</textarea>
            </div>

            {{-- Foto (Opsional) --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Ganti Foto (Opsional)</label>
                @if($product->foto_produk)
                    <img src="{{ asset('storage/' . $product->foto_produk) }}" class="h-20 w-20 object-cover rounded-lg mb-3 border">
                @endif
                <input type="file" name="foto_produk" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-indigo-100">
            </div>

            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-green-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</x-admin-layout>