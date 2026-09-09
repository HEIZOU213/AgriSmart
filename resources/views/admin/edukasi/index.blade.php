<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            {{-- Judul Halaman --}}
            <div>
                <h2 class="font-bold text-xl text-slate-900 leading-tight">
                    {{ __('Manajemen Edukasi') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Kelola artikel, tips budidaya, dan video tutorial perkebunan durian.</p>
            </div>

            {{-- Tombol Tambah --}}
            <a href="{{ route('admin.konten-edukasi.create') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-xl text-sm font-bold hover:bg-green-700 transition-colors shadow-sm">
                + Tambah Konten
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" class="mb-6 flex items-center p-4 bg-green-50 border border-green-200 rounded-xl shadow-sm">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3 text-green-700 font-bold text-sm">{{ session('success') }}</div>
                <button @click="show = false" class="ml-auto text-green-400 hover:text-green-600 focus:outline-none">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        {{-- Search Bar & Filters Container (Card Style) --}}
        <div class="mb-6 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" class="block w-full pl-10 pr-3 py-2.5 rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 sm:text-sm transition placeholder-slate-400" placeholder="Cari judul artikel atau video...">
                </div>
                
                {{-- Filter Dropdown --}}
                <div class="w-full sm:w-56">
                    <x-custom-dropdown 
                        name="filter_kategori" 
                        placeholder="Semua Kategori" 
                        :options="$kategori ?? []" 
                    />
                </div>
            </div>
        </div>

        {{-- Main Table Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full min-w-[700px] divide-y divide-slate-200">
                    <thead class="bg-green-50/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Foto / Media</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Detail Konten</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Kategori & Tipe</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse ($konten as $item)
                            <tr class="hover:bg-slate-50 transition-colors duration-200 group">
                                {{-- Kolom Foto --}}
                                <td class="px-6 py-4 whitespace-nowrap w-32">
                                    <div class="flex-shrink-0 h-20 w-28 relative rounded-xl overflow-hidden shadow-sm border border-slate-200 group-hover:border-green-300 transition">
                                        @if($item->foto_sampul)
                                            <img class="h-full w-full object-cover" src="{{ asset('storage/' . $item->foto_sampul) }}" alt="{{ $item->judul }}">
                                        @else
                                            <div class="h-full w-full bg-slate-50 flex flex-col items-center justify-center text-slate-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        {{-- Badge Video Overlay --}}
                                        @if($item->tipe_konten == 'video')
                                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                                                <div class="bg-white/90 rounded-full p-1 shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-green-600"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" /></svg>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                {{-- Kolom Info Utama --}}
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-base font-bold text-slate-800 line-clamp-2 group-hover:text-green-700 transition" title="{{ $item->judul }}">{{ $item->judul }}</span>
                                        
                                        <div class="flex items-center gap-3 mt-2">
                                            <span class="text-xs text-slate-500 flex items-center bg-slate-100 px-2 py-0.5 rounded-md">
                                                <svg class="w-3 h-3 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                {{ $item->user->nama ?? 'Admin' }}
                                            </span>
                                            <span class="text-xs text-slate-400 flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                {{ $item->created_at->format('d M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kolom Kategori --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col items-start gap-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700">
                                            {{ $item->kategoriEdukasi->nama_kategori }}
                                        </span>
                                        
                                        @if($item->tipe_konten == 'video')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-slate-100 text-slate-600 border border-slate-200">
                                                VIDEO
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-slate-100 text-slate-600 border border-slate-200">
                                                ARTIKEL
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Kolom Aksi --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('admin.konten-edukasi.edit', $item->id) }}" 
                                           class="inline-flex items-center justify-center px-3 py-2 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-lg transition-colors" 
                                           title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                            Edit
                                        </a>
                                        
                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.konten-edukasi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus konten ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center justify-center px-3 py-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg transition-colors" 
                                                    title="Hapus">
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
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-green-50 text-green-600 rounded-xl p-4 mb-4">
                                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-900">Belum ada konten</h3>
                                        <p class="text-slate-500 mt-1">Mulailah dengan menambahkan materi edukasi baru.</p>
                                        <a href="{{ route('admin.konten-edukasi.create') }}" class="mt-6 inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-xl text-sm font-bold hover:bg-green-700 transition-colors shadow-sm">
                                            Buat Konten Sekarang
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination Footer --}}
            @if($konten->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                {{ $konten->links() }}
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
