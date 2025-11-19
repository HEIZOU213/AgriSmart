<x-public-layout>
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8 text-center">
                <h1 class="text-4xl font-extrabold text-gray-900">
                    Marketplace AgriSmart
                </h1>
                <p class="mt-2 text-lg text-gray-500">
                    Beli hasil panen segar langsung dari petani kami.
                </p>
            </div>

            {{-- [KODE BARU]: Form Pencarian --}}
            <div class="mb-8 max-w-2xl mx-auto">
                <form action="{{ route('produk.index') }}" method="GET" class="flex">
                    <input type="search" name="q" placeholder="Cari nama produk atau deskripsi..." 
                           value="{{ $searchQuery }}"
                           class="w-full border-gray-300 rounded-l-lg shadow-sm focus:border-green-500 focus:ring-green-500">
                    <button type="submit" 
                            class="px-6 py-2 bg-green-600 text-white font-medium rounded-r-lg hover:bg-green-700">
                        Cari
                    </button>
                </form>
            </div>
            {{-- [AKHIR KODE BARU] --}}

            {{-- Flash Message (tetap sama) --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                    {{ session('error') }}
                </div>
            @endif


            @if(isset($daftarProduk) && !$daftarProduk->isEmpty())
                {{-- Tampilkan pesan hasil pencarian --}}
                @if($searchQuery)
                    <p class="mb-4 text-gray-700">Menampilkan hasil untuk: <strong>"{{ $searchQuery }}"</strong> ({{ $daftarProduk->total() }} produk ditemukan)</p>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($daftarProduk as $item)
                        <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200 flex flex-col">
                            
                            <a href="{{ route('produk.show', $item->id) }}">
                                @if($item->foto_produk)
                                    <img src="{{ asset('storage/' . $item->foto_produk) }}" alt="{{ $item->nama_produk }}" class="h-48 w-full object-cover">
                                @else
                                    <div class="h-48 w-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500">Gambar Produk</span>
                                    </div>
                                @endif
                            </a>
                            
                            <div class="p-4 flex-grow">
                                <p class="text-xs text-gray-500 mb-1">{{ $item->kategoriProduk->nama_kategori }}</p>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1 line-clamp-2">{{ $item->nama_produk }}</h3>
                                <p class="text-xl font-bold text-green-600">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </p>
                                <p class="text-sm text-gray-500 mt-1">Stok: {{ $item->stok }}</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Petani: {{ $item->user->nama }}
                                </p>
                            </div>
                            <div class="p-4 bg-gray-50 border-t border-gray-200">
                                <a href="{{ route('produk.show', $item->id) }}" class="w-full text-center block px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Link Paginasi --}}
                <div class="mt-8">
                    {{-- [KODE BARU] Paginasi tetap membawa parameter pencarian --}}
                    {{ $daftarProduk->appends(['q' => $searchQuery])->links() }}
                </div>
            @else
                <p class="text-center text-gray-500">
                    @if($searchQuery)
                        Maaf, tidak ada produk yang ditemukan untuk kata kunci: <strong>"{{ $searchQuery }}"</strong>.
                    @else
                        Belum ada produk yang dijual.
                    @endif
                </p>
            @endif
        </div>
    </div>
</x-public-layout>