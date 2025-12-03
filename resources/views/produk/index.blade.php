<x-public-layout>
    
    {{-- 
       HERO SECTION KHUSUS MARKETPLACE
       Note: Saya menambahkan class '-mt-20 lg:-mt-24' untuk menarik section ini ke atas
       agar menutupi celah putih, dan menambah padding-top agar teks tidak tertutup navbar.
    --}}
    <div class="relative bg-gray-900 pt-32 pb-20 lg:pt-40 lg:pb-28 -mt-20 lg:-mt-24">
        {{-- Gambar Latar Belakang --}}
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1488459716781-31db52582fe9?q=80&w=2070&auto=format&fit=crop" alt="Marketplace Background" class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-gray-50"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4 drop-shadow-lg">
                Marketplace <span class="text-green-400">AgriSmart</span>
            </h1>
            <p class="text-lg text-gray-200 max-w-2xl mx-auto mb-8 font-medium">
                Temukan hasil panen terbaik langsung dari petani. Segar, berkualitas, dan harga terjangkau.
            </p>

            {{-- Form Pencarian Modern --}}
            <div class="max-w-xl mx-auto">
                <form action="{{ route('produk.index') }}" method="GET" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="search" name="q" placeholder="Cari sayuran, buah, atau nama petani..." 
                           value="{{ $searchQuery ?? '' }}"
                           class="w-full pl-12 pr-28 py-4 border-0 bg-white/95 backdrop-blur text-gray-900 rounded-full shadow-2xl focus:ring-4 focus:ring-green-500/50 focus:bg-white transition-all text-base placeholder-gray-500">
                    <button type="submit" 
                            class="absolute right-2 top-2 bottom-2 px-6 bg-green-600 text-white font-bold rounded-full hover:bg-green-700 transition-colors shadow-lg">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- CONTENT GRID --}}
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="mb-8 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm flex justify-between items-center">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(isset($daftarProduk) && !$daftarProduk->isEmpty())
                
                @if(isset($searchQuery) && $searchQuery)
                    <div class="mb-6 text-gray-600">
                        Menampilkan hasil pencarian untuk <span class="font-bold text-gray-900">"{{ $searchQuery }}"</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($daftarProduk as $item)
                        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col h-full hover:-translate-y-1">
                            <a href="{{ route('produk.show', $item->id) }}" class="relative aspect-[4/3] overflow-hidden bg-gray-200 block">
                                @if($item->foto_produk)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($item->foto_produk) }}" 
                                         alt="{{ $item->nama_produk }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                <div class="absolute top-3 left-3">
                                    <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-green-700 text-xs font-bold rounded-full shadow-sm uppercase tracking-wide">
                                        {{ $item->kategoriProduk->nama_kategori }}
                                    </span>
                                </div>
                            </a>
                            
                            <div class="p-5 flex flex-col flex-grow">
                                <div class="mb-1">
                                    <p class="text-xs text-gray-500 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        {{ $item->user->nama }}
                                    </p>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-green-600 transition-colors">
                                    <a href="{{ route('produk.show', $item->id) }}">
                                        {{ $item->nama_produk }}
                                    </a>
                                </h3>
                                <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                                    <div>
                                        <p class="text-xs text-gray-500">Harga</p>
                                        <p class="text-xl font-extrabold text-green-600">
                                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">Stok</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $item->stok }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('produk.show', $item->id) }}" 
                                   class="mt-4 w-full py-2.5 bg-gray-900 text-white text-sm font-bold rounded-lg hover:bg-green-600 transition-colors text-center shadow-sm">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $daftarProduk->appends(['q' => $searchQuery ?? ''])->links() }}
                </div>
            @else
                <div class="text-center py-20">
                    <div class="bg-white rounded-full p-6 w-24 h-24 mx-auto mb-4 shadow-sm flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900">Produk tidak ditemukan</h3>
                </div>
            @endif
        </div>
    </div>
</x-public-layout>