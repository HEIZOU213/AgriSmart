<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Kelola Produk Petani') }}
        </h2>
    </x-slot>

    <div class="text-gray-900">
        
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- [BARU] Filter & Pencarian --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 mb-6">
            <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                
                {{-- Search Bar --}}
                <div class="flex-1">
                    <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Cari Produk</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama produk..." 
                            class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                {{-- Filter Petani --}}
                <div class="w-full md:w-1/4">
                    <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Filter Petani</label>
                    <select name="petani_id" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Petani</option>
                        @foreach($petani as $p)
                            <option value="{{ $p->id }}" {{ request('petani_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Kategori --}}
                <div class="w-full md:w-1/4">
                    <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Filter Kategori</label>
                    <select name="kategori_id" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Kategori</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-end gap-2">
                    <button type="submit" class="px-6 py-2.5 bg-green-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition shadow-md">
                        Terapkan
                    </button>
                    
                    @if(request()->hasAny(['search', 'petani_id', 'kategori_id']))
                        <a href="{{ route('admin.products.index') }}" class="px-4 py-2.5 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition" title="Reset Filter">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabel Produk --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-indigo-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Petani (Penjual)</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Harga & Stok</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($products as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-12 w-12 flex-shrink-0">
                                            @if($item->foto_produk)
                                                <img class="h-12 w-12 rounded-lg object-cover border border-gray-200" src="{{ asset('storage/' . $item->foto_produk) }}">
                                            @else
                                                <div class="h-12 w-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 text-xs font-bold">No IMG</div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $item->nama_produk }}</div>
                                            <div class="text-xs text-gray-500">{{ $item->kategoriProduk->nama_kategori }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 font-medium">{{ $item->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-green-600">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                                    <div class="text-xs text-gray-500">Stok: {{ $item->stok }} {{ $item->satuan }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center gap-2">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('admin.products.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 p-2 hover:bg-indigo-50 rounded-lg" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>
                                        
                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini? Tindakan ini tidak bisa dibatalkan.');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 p-2 hover:bg-red-50 rounded-lg" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        <p>Tidak ada produk yang ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-gray-100">
                {{-- Gunakan withQueryString agar filter tidak hilang saat pindah halaman --}}
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>