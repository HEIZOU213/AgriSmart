<x-public-layout>
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- [KODE BARU] TAMPILAN FLASH MESSAGE --}}
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
            {{-- [AKHIR KODE BARU] --}}
            
            <div class="flex flex-col md:flex-row gap-8">

                {{-- Kolom Kiri: Gambar Produk --}}
                <div class="w-full md:w-1/2">
                    <div class="bg-white shadow rounded-lg border border-gray-200 overflow-hidden">
                        @if($produk->foto_produk)
                            <img src="{{ asset('storage/' . $produk->foto_produk) }}" alt="{{ $produk->nama_produk }}" class="w-full h-96 object-cover">
                        @else
                            <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">Gambar Produk</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Kolom Kanan: Info Produk & Form Add to Cart --}}
                <div class="w-full md:w-1/2">
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-2">{{ $produk->nama_produk }}</h1>
                    
                    <p class="text-sm text-gray-500 mb-2">
                        Dijual oleh: <span class="font-medium text-gray-700">{{ $produk->user->nama }}</span>
                    </p>
                    <p class="text-sm text-gray-500 mb-4">
                        Kategori: <span class="font-medium text-indigo-600">{{ $produk->kategoriProduk->nama_kategori }}</span>
                    </p>
                    
                    <p class="text-4xl font-bold text-green-600 mb-4">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </p>

                    <div class="mb-4">
                        <p class="text-gray-700">{{ $produk->deskripsi }}</p>
                    </div>

                    <form action="{{ route('cart.store', $produk->id) }}" method="POST">
                        @csrf
                        <div class="flex items-center gap-4 mt-6">
                            <label for="jumlah" class="text-sm font-medium text-gray-700">Jumlah:</label>
                            <input type="number" id="jumlah" name="jumlah" value="1" min="1" max="{{ $produk->stok }}" 
                                   class="w-20 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            
                            <button type="submit" 
                                    class="flex-1 px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                    {{ $produk->stok <= 0 ? 'disabled' : '' }}>
                                {{ $produk->stok <= 0 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
                            </button>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Stok tersisa: {{ $produk->stok }}</p>
                    </form>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-gray-200">
                <a href="{{ route('produk.index') }}" class="text-green-600 hover:text-green-700">
                    &larr; Kembali ke Semua Produk
                </a>
            </div>
        </div>
    </div>
</x-public-layout>