<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $produk->nama_produk }} - AgriSmart</title>

    {{-- FONTS: Plus Jakarta Sans --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- TAILWIND CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js']) 

    {{-- ALPINE JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- CUSTOM STYLE & ANIMATION --}}
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Animasi Blob Background */
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f0fdf4;
        }
        ::-webkit-scrollbar-thumb {
            background: #16a34a;
            border-radius: 5px;
            border: 2px solid #f0fdf4;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #15803d;
        }

        /* Responsive Styles */
        @media (max-width: 640px) {
            .product-grid {
                grid-template-columns: 1fr !important;
            }
            .product-image-container {
                min-height: 250px !important;
            }
            .product-title {
                font-size: 1.5rem !important;
                line-height: 1.3 !important;
            }
            .product-price {
                font-size: 1.75rem !important;
            }
            .main-container {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            .action-section {
                padding: 1rem !important;
            }
            .seller-info {
                padding: 0.75rem !important;
            }
        }

        @media (max-width: 768px) {
            .product-details {
                padding: 1.5rem !important;
            }
            .back-button-text {
                display: none;
            }
            .breadcrumb-separator {
                margin-left: 0.5rem !important;
                margin-right: 0.5rem !important;
            }
            .quantity-input {
                width: 100% !important;
            }
            .cart-button {
                width: 100% !important;
            }
        }

        @media (min-width: 768px) and (max-width: 1024px) {
            .product-grid {
                gap: 1.5rem !important;
            }
            .product-details {
                padding: 2rem !important;
            }
        }

        /* Touch-friendly elements */
        @media (hover: none) and (pointer: coarse) {
            button, 
            [role="button"],
            input[type="submit"],
            input[type="button"] {
                min-height: 44px;
                min-width: 44px;
            }
            
            input[type="number"] {
                font-size: 16px; /* Prevents zoom on iOS */
            }
            
            .quantity-button {
                width: 44px !important;
                height: 44px !important;
            }
        }

        /* Print Styles */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                font-size: 12pt;
                color: #000;
                background: #fff;
            }
        }
    </style>
</head>

<body class="font-sans antialiased text-slate-700 bg-white flex flex-col min-h-screen selection:bg-green-500 selection:text-white">

<x-navbar />

    {{-- MAIN CONTENT --}}
    <main class="flex-1 pt-20 md:pt-24 pb-8 md:pb-12 relative overflow-hidden">

        <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 relative z-10">
            
            {{-- TOMBOL KEMBALI --}}
            <div class="mb-4 md:mb-6">
                <nav class="flex items-center text-sm font-medium text-slate-500">
                    {{-- Link Balik (Dengan Ikon) --}}
                    <a href="{{ route('produk.index') }}" class="group flex items-center hover:text-green-600 transition-colors duration-200 p-1 md:p-0">
                        <span class="back-button-text md:inline">Daftar Produk</span>
                    </a>

                    {{-- Separator (Chevron) --}}
                    <svg class="w-4 h-4 mx-2 md:mx-3 text-slate-300 breadcrumb-separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>

                    {{-- Halaman Aktif (Nama Produk) --}}
                    <span class="text-green-600 font-semibold truncate max-w-[120px] xs:max-w-[180px] sm:max-w-md bg-green-50 px-2 py-0.5 rounded-md text-xs md:text-sm" aria-current="page">
                        {{ $produk->nama_produk }}
                    </span>
                </nav>
            </div>

            {{-- FLASH MESSAGE --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" class="mb-4 md:mb-6 p-3 md:p-4 bg-green-100 border border-green-200 text-green-800 rounded-xl md:rounded-2xl flex justify-between items-center shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 md:w-6 md:h-6 mr-2 md:mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="font-medium text-sm md:text-base">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-green-600 hover:text-green-800 ml-2">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" class="mb-4 md:mb-6 p-3 md:p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl md:rounded-2xl flex justify-between items-center shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 md:w-6 md:h-6 mr-2 md:mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-medium text-sm md:text-base">{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-red-600 hover:text-red-800 ml-2">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            {{-- MAIN PRODUCT CARD --}}
            <div class="bg-white rounded-2xl md:rounded-3xl border border-slate-200 md:border-slate-300 overflow-hidden shadow-sm md:shadow-md">
                <div class="product-grid grid grid-cols-1 md:grid-cols-12 gap-0 md:gap-6 lg:gap-8">

                    {{-- KOLOM KIRI: GAMBAR (Lebar 5/12 - Full Bleed) --}}
                    <div class="md:col-span-5 bg-slate-100 relative group h-full product-image-container">
                        
                        {{-- Container Gambar (Full Width & Height) --}}
                        <div class="relative w-full h-full min-h-[250px] sm:min-h-[300px] md:min-h-full">
                            @if($produk->foto_produk)
                                <img src="{{ asset('storage/' . $produk->foto_produk) }}" 
                                     alt="{{ $produk->nama_produk }}" 
                                     class="w-full h-full object-cover absolute inset-0 transform group-hover:scale-105 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-100 absolute inset-0">
                                    <svg class="w-16 h-16 md:w-20 md:h-20 mb-2 md:mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-xs md:text-sm font-medium">Gambar Tidak Tersedia</span>
                                </div>
                            @endif

                            {{-- Badge Kategori --}}
                            <div class="absolute top-3 left-3 md:top-4 md:left-4">
                                <span class="px-3 py-1 md:px-4 md:py-1.5 bg-green-600 text-white text-xs font-bold uppercase tracking-wider rounded-lg shadow-md">
                                    {{ $produk->kategoriProduk->nama_kategori ?? 'Umum' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: DETAIL (Lebar 7/12) --}}
                    <div class="md:col-span-7 p-4 md:p-6 lg:p-8 xl:p-10 flex flex-col justify-between product-details">
                        <div>
                            {{-- Header Title & Price --}}
                            <div class="flex flex-col sm:flex-row justify-between items-start gap-3 md:gap-4 mb-4 md:mb-6">
                                <div class="w-full sm:w-auto">
                                    <h1 class="product-title text-xl sm:text-2xl md:text-3xl font-bold text-slate-800 tracking-tight leading-snug break-words">
                                        {{ $produk->nama_produk }}
                                    </h1>
                                </div>
                                <div class="text-left sm:text-right w-full sm:w-auto">
                                    <p class="text-xs md:text-sm text-slate-400 mb-1">Harga per {{ $produk->satuan ?? 'kg' }}</p>
                                    <p class="product-price text-2xl md:text-3xl font-bold text-green-600 tracking-tight">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Separator --}}
                            <div class="h-px bg-slate-100 w-full mb-4 md:mb-6"></div>

                            {{-- INFORMASI PENJUAL (Card Style) --}}
                            <div class="bg-white border border-slate-200 rounded-xl p-3 md:p-4 mb-4 md:mb-6 shadow-sm hover:shadow-md transition-shadow seller-info">
                                <div class="flex items-center gap-3 md:gap-4">
                                    <div class="flex-shrink-0">
                                        @if(isset($produk->user->foto_profil) && $produk->user->foto_profil)
                                            <img class="h-12 w-12 md:h-14 md:w-14 rounded-full object-cover border-2 border-green-100" src="{{ asset('storage/' . $produk->user->foto_profil) }}" alt="{{ $produk->user->name }}">
                                        @else
                                            <div class="h-12 w-12 md:h-14 md:w-14 rounded-full bg-green-100 flex items-center justify-center text-green-600 border-2 border-white">
                                                <svg class="h-6 w-6 md:h-7 md:w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm md:text-base font-bold text-slate-900 truncate">{{ $produk->user->name ?? 'AgriSmart Member' }}</p>
                                        <div class="flex items-center mt-1 text-xs md:text-sm text-slate-500">
                                            <svg class="w-3 h-3 md:w-4 md:h-4 text-green-500 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            <span class="truncate">{{ $produk->user->alamat ?? 'Lokasi tidak tersedia' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-6 md:mb-8">
                                <h3 class="text-xs md:text-sm font-bold text-slate-900 mb-2">Deskripsi Produk</h3>
                                <div class="prose prose-sm prose-green text-slate-600 leading-relaxed max-w-none">
                                    <p class="text-sm md:text-base">{{ $produk->deskripsi }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- ACTION SECTION (Cart Form) --}}
                        <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200 mt-auto">
                            <form action="{{ route('cart.store', $produk->id) }}" method="POST">
                                @csrf
                                <div class="flex flex-col sm:flex-row items-end gap-4">
                                    
                                    {{-- Input Jumlah --}}
                                    <div class="w-full sm:w-1/3">
                                        <label for="jumlah" class="block text-xs font-bold text-slate-500 uppercase mb-2">Jumlah ({{ $produk->satuan ?? 'kg' }})</label>
                                        <div class="relative flex items-center">
                                            <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="absolute left-0 w-10 h-full text-slate-500 hover:text-green-600 bg-transparent rounded-l-lg touch-manipulation">
                                                -
                                            </button>
                                            <input type="number" id="jumlah" name="jumlah" value="1" min="1" max="{{ $produk->stok }}" 
                                                   class="w-full pl-10 pr-10 border-slate-300 rounded-xl shadow-sm focus:border-green-500 focus:ring-green-500 text-center font-bold text-lg h-12">
                                            <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="absolute right-0 w-10 h-full text-slate-500 hover:text-green-600 bg-transparent rounded-r-lg touch-manipulation">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                    
                                    {{-- Tombol Beli --}}
                                    <div class="w-full sm:w-2/3">
                                        <button type="submit" 
                                                class="w-full flex justify-center items-center h-12 px-6 rounded-xl shadow-lg shadow-green-600/30 text-base font-bold text-white transition-all duration-300 
                                                {{ $produk->stok > 0 ? 'bg-green-600 hover:bg-green-700 hover:scale-[1.02] active:scale-95' : 'bg-slate-400 cursor-not-allowed' }}"
                                                {{ $produk->stok <= 0 ? 'disabled' : '' }}>
                                            
                                            @if($produk->stok > 0)
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                + Keranjang
                                            @else
                                                Stok Habis
                                            @endif
                                        </button>
                                    </div>
                                </div>
                                
                                {{-- Status Stok --}}
                                <div class="mt-4 flex items-center justify-between sm:justify-start sm:gap-4 text-sm font-medium text-slate-600">
                                    <span>
                                        {{ $produk->stok > 0 ? 'Tersedia: ' . $produk->stok . ' ' . ($produk->satuan ?? 'kg') : 'Stok Habis' }}
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- ========== FOOTER SECTION ========== -->
    <x-footer />

    <!-- ========== BACK TO TOP BUTTON ========== -->
    <x-back-button />

</body>
</html>