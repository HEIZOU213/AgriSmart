<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-900 leading-tight">
            {{ __('Kelola Produk Pekebun') }}
        </h2>
    </x-slot>

    <div class="py-6">
        
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- [BARU] Filter & Pencarian --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 mb-6">
            <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                
                {{-- Search Bar --}}
                <div class="flex-1">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 block">Cari Produk</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama produk..." 
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 transition placeholder-slate-400">
                        <svg class="w-5 h-5 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                {{-- Filter Pekebun --}}
                <div class="w-full md:w-1/4">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 block">Filter Pekebun</label>
                    <x-custom-dropdown 
                        name="petani_id" 
                        placeholder="Semua Pekebun" 
                        :options="$petani" 
                        :value="request('petani_id')" 
                        searchable 
                    />
                </div>

                {{-- Filter Kategori --}}
                <div class="w-full md:w-1/4">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 block">Filter Kategori</label>
                    <x-custom-dropdown 
                        name="kategori_id" 
                        placeholder="Semua Kategori" 
                        :options="$kategori" 
                        :value="request('kategori_id')" 
                        searchable 
                    />
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-end gap-2">
                    <button type="submit" class="px-6 py-2.5 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition shadow-sm">
                        Terapkan
                    </button>
                    
                    @if(request()->hasAny(['search', 'petani_id', 'kategori_id']))
                        <a href="{{ route('admin.products.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition" title="Reset Filter">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabel Produk --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full min-w-[700px] divide-y divide-slate-200">
                    <thead class="bg-green-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Produk</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Pekebun (Penjual)</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Harga & Stok</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse ($products as $item)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-12 w-12 flex-shrink-0">
                                            @if($item->foto_produk)
                                                <img class="h-12 w-12 rounded-xl object-cover border border-slate-200 shadow-sm" src="{{ asset('storage/' . $item->foto_produk) }}">
                                            @else
                                                <div class="h-12 w-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 text-xs font-bold border border-slate-100">No IMG</div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-slate-900">{{ $item->nama_produk }}</div>
                                            <div class="text-xs text-slate-500 mt-0.5"><span class="bg-green-50 text-green-700 px-2 py-0.5 rounded-md font-medium">{{ $item->kategoriProduk->nama_kategori }}</span></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-900 font-bold">{{ $item->user->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $item->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-green-600">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                                    <div class="text-xs text-slate-500">Stok: {{ $item->stok }} {{ $item->satuan }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center gap-2">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('admin.products.edit', $item->id) }}" class="inline-flex items-center justify-center px-3 py-2 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-lg transition-colors" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                            Edit
                                        </a>
                                        
                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini? Tindakan ini tidak bisa dibatalkan.');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center px-3 py-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg transition-colors" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-slate-50 text-slate-400 p-4 rounded-full mb-3">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        </div>
                                        <p class="font-bold text-slate-900">Tidak ada produk yang ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($products->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                {{-- Gunakan withQueryString agar filter tidak hilang saat pindah halaman --}}
                {{ $products->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
