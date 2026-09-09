<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-900 leading-tight">
            Edit Produk: <span class="text-green-700">{{ $product->nama_produk }}</span>
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Nama Produk --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nama Produk</label>
                    <input type="text" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" class="w-full rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 transition py-2.5">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Kategori --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Kategori</label>
                        <x-custom-dropdown 
                            name="kategori_produk_id" 
                            :options="$kategori" 
                            :value="old('kategori_produk_id', $product->kategori_produk_id)" 
                            searchable 
                            required 
                        />
                    </div>
                    {{-- Harga --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Harga (Rp)</label>
                        <input type="number" name="harga" value="{{ old('harga', $product->harga) }}" class="w-full rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 transition py-2.5">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Stok --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Stok</label>
                        <input type="number" name="stok" value="{{ old('stok', $product->stok) }}" class="w-full rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 transition py-2.5">
                    </div>
                    {{-- Satuan (Readonly - opsional) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Satuan</label>
                        <input type="text" value="{{ $product->satuan }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-500 cursor-not-allowed py-2.5" readonly>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" class="w-full rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 transition py-2.5">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                </div>

                {{-- Foto (Opsional) --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Ganti Foto (Opsional)</label>
                    @if($product->foto_produk)
                        <img src="{{ asset('storage/' . $product->foto_produk) }}" class="h-20 w-20 object-cover rounded-xl mb-3 border border-slate-200 shadow-sm">
                    @endif
                    <input type="file" name="foto_produk" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition">
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t border-slate-100 mt-6">
                    <a href="{{ route('admin.products.index') }}" class="px-6 py-2.5 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
