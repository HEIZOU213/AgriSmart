<x-public-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Flash Message (Tetap) --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                {{-- UBAH 1: Tambahkan padding (p-6) dan gap (gap-8) agar tidak berdempetan --}}
                <div class="flex flex-col md:flex-row p-6 gap-8">

                    {{-- KOLOM KIRI: GAMBAR PRODUK --}}
                    {{-- UBAH 2: Ubah lebar dari w-1/2 menjadi w-1/3 (lebih kecil) --}}
                    <div class="w-full md:w-1/3 relative group">
                        @if($produk->foto_produk)
                            {{-- UBAH 3: Ganti h-[500px] menjadi aspect-square dan tambah rounded --}}
                            <img src="{{ asset('storage/' . $produk->foto_produk) }}" 
                                 alt="{{ $produk->nama_produk }}" 
                                 class="w-full aspect-square object-cover object-center rounded-xl shadow-md transition-transform duration-500 group-hover:scale-105">
                        @else
                            {{-- Placeholder juga dibuat kotak (aspect-square) --}}
                            <div class="w-full aspect-square bg-gray-200 rounded-xl flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-sm font-medium">Gambar Tidak Tersedia</span>
                            </div>
                        @endif
                        
                        {{-- Badge Kategori --}}
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-white/90 backdrop-blur text-green-700 text-xs font-bold rounded-full shadow-lg border border-green-100">
                                {{ $produk->kategoriProduk->nama_kategori ?? 'Tanpa Kategori' }}
                            </span>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: DETAIL PRODUK --}}
                    {{-- UBAH 4: Ubah lebar sisa menjadi w-2/3 (agar seimbang) --}}
                    <div class="w-full md:w-2/3 flex flex-col justify-between">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2 leading-tight">
                                {{ $produk->nama_produk }}
                            </h1>
                            
                            <div class="flex items-baseline mb-6 border-b border-gray-100 pb-6">
                                <p class="text-4xl font-bold text-green-600">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </p>
                                <span class="ml-2 text-xl text-gray-500 font-medium">/ kg</span>
                            </div>

                            {{-- BOX INFORMASI PETANI --}}
                            <div class="bg-blue-50 rounded-xl p-4 mb-6 border border-blue-100">
                                <h3 class="text-xs font-bold text-blue-800 uppercase tracking-wider mb-3 border-b border-blue-200 pb-2">Informasi Penjual</h3>
                                
                                <div class="flex items-center space-x-4">
                                    {{-- Foto Profil --}}
                                    <div class="flex-shrink-0">
                                        @if(isset($produk->user->foto_profil) && $produk->user->foto_profil)
                                            <img class="h-12 w-12 rounded-full object-cover border-2 border-white shadow-sm" 
                                                 src="{{ asset('storage/' . $produk->user->foto_profil) }}" 
                                                 alt="{{ $produk->user->name }}">
                                        @else
                                            <div class="h-12 w-12 rounded-full bg-blue-200 flex items-center justify-center text-blue-600 border-2 border-white shadow-sm">
                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Info Text --}}
                                    <div class="flex-1 min-w-0">
                                        <p class="text-base font-bold text-gray-900 truncate">
                                            {{ $produk->user->name ?? 'Nama Penjual' }}
                                        </p>
                                        <div class="flex items-start mt-1 text-sm text-gray-600">
                                            <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span class="break-words">
                                                {{ $produk->user->alamat ?? 'Lokasi belum diatur.' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-8">
                                <h3 class="text-sm font-semibold text-gray-900 mb-2">Deskripsi Produk</h3>
                                <p class="text-gray-600 leading-relaxed text-sm">
                                    {{ $produk->deskripsi }}
                                </p>
                            </div>
                        </div>

                        {{-- Form Cart --}}
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <form action="{{ route('cart.store', $produk->id) }}" method="POST">
                                @csrf
                                <div class="flex flex-col sm:flex-row items-center gap-4">
                                    <div class="w-full sm:w-1/3">
                                        <label for="jumlah" class="block text-xs font-medium text-gray-500 uppercase mb-1">Jumlah (kg)</label>
                                        <div class="relative">
                                            <input type="number" id="jumlah" name="jumlah" value="1" min="1" max="{{ $produk->stok }}" 
                                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 text-center font-bold text-lg h-12">
                                        </div>
                                    </div>
                                    
                                    <div class="w-full sm:w-2/3">
                                        <label class="block text-xs font-medium text-transparent mb-1">Action</label>
                                        <button type="submit" 
                                                class="w-full flex justify-center items-center px-6 h-12 border border-transparent rounded-lg shadow-md text-base font-bold text-white bg-green-600 hover:bg-green-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:bg-gray-400 disabled:cursor-not-allowed"
                                                {{ $produk->stok <= 0 ? 'disabled' : '' }}>
                                            @if($produk->stok > 0)
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                Masukan Keranjang
                                            @else
                                                Stok Habis
                                            @endif
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-3 text-center sm:text-left">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $produk->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $produk->stok > 0 ? 'Stok Tersedia: ' . $produk->stok . ' kg' : 'Stok Habis' }}
                                    </span>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="mt-8 mb-12">
                <a href="{{ route('produk.index') }}" class="inline-flex items-center text-green-600 hover:text-green-800 font-medium transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Semua Produk
                </a>
            </div>
        </div>
    </div>
</x-public-layout>