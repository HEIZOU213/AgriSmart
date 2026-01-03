<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ========== SEO META TAGS ========== -->
    <meta name="description" content="Marketplace Pertanian AgriSmart. Temukan hasil panen segar langsung dari petani dengan harga terbaik.">
    <meta name="keywords" content="Marketplace Tani, Jual Sayur, AgriSmart, Petani Digital, Panen Segar">
    <meta property="og:title" content="Marketplace - {{ config('app.name', 'AgriSmart') }}">
    <meta property="og:description" content="Belanja hasil tani segar langsung dari sumbernya.">
    <meta property="og:image" content="{{ asset('images/hero1.png') }}">

    <!-- ========== FAVICON & TITLE ========== -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>Marketplace - {{ config('app.name', 'AgriSmart') }}</title>

    <!-- ========== EXTERNAL STYLESHEETS ========== -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- ========== VITE ASSETS ========== -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- ========== CUSTOM STYLES ========== -->
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Utility untuk AlpineJS */
        [x-cloak] {
            display: none !important;
        }

        /* Custom Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 10px;
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

        /* Custom Animations */
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        /* Text Truncation Utilities (Line Clamp) */
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="font-sans antialiased text-slate-700 bg-green-50 flex flex-col min-h-screen selection:bg-green-500 selection:text-white">

    <!-- ========== NAVIGATION COMPONENT ========== -->
    <x-navbar />

    <main class="flex-1">

        <!-- ========== HERO SECTION ========== -->
        <section class="relative overflow-visible pt-20 pb-10 lg:pt-28 lg:pb-16 bg-slate-50">
            
            <!-- Background Decoration -->
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none overflow-hidden">
                <div class="w-[600px] h-[600px] lg:w-[800px] lg:h-[800px] opacity-5">
                    <div class="w-full h-full animate-[spin_30s_linear_infinite]">
                        <img src="images/nav-logo.png" alt="Background Decorative" class="w-full h-full object-contain">
                    </div>
                </div>
            </div>

            <!-- Hero Content Container -->
            <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">

                <!-- Hero Title & Description -->
                <div class="text-center mb-6" data-aos="fade-up">
                    <span class="inline-block py-1 px-3 rounded-full bg-green-100/50 text-green-700 text-[10px] sm:text-xs font-bold tracking-wider uppercase mb-3 border border-green-200/50 shadow-sm">
                        Marketplace Terpercaya
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 mb-3">
                        Marketplace <span class="text-green-600">Pertanian Terbaik</span>
                    </h2>
                    <p class="text-base text-slate-600 max-w-xl mx-auto mb-6">
                        Temukan hasil panen segar langsung dari petani dengan harga terbaik
                    </p>
                </div>

                <!-- ========== SEARCH & FILTER FORM ========== -->
                <div class="max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                    <form action="{{ route('produk.index') }}" method="GET" class="space-y-3">

                        <!-- Search Input -->
                        <div class="w-full" x-data="{ search: '{{ request('q') }}' }">
                            <div class="flex items-center bg-white rounded-xl border border-gray-200 shadow-sm transition-all duration-200 overflow-hidden p-1">
                                
                                <input type="search" name="q" x-model="search" value="{{ request('q') }}"
                                    placeholder="Cari produk pertanian..."
                                    class="flex-1 pl-4 pr-4 py-2.5 bg-transparent text-slate-700 outline-none border-none focus:border-none focus:ring-0 shadow-none hover:border-none text-sm font-medium placeholder:text-slate-400 [&::-webkit-search-cancel-button]:appearance-none">

                                <!-- Clear Search Button -->
                                <button type="button" x-show="search.length > 0" x-cloak
                                    @click="search = ''; $nextTick(() => { $el.closest('form').submit() })"
                                    class="p-2 text-slate-400 hover:text-green-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>

                                <!-- Submit Button -->
                                <button type="submit"
                                    class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center justify-center shadow-sm"
                                    title="Cari dan Terapkan Filter">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Filter Dropdowns -->
                        <div class="w-full">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 relative z-30">
                                @php
                                    // Helper classes untuk styling dropdown agar konsisten
                                    $btnClass = 'w-full bg-white text-slate-600 text-sm font-medium py-2.5 pl-4 pr-4 rounded-xl text-left shadow-sm flex items-center justify-between transition-all duration-200 cursor-pointer border border-transparent hover:border-gray-200';
                                    $dropdownClass = 'absolute z-50 mt-1.5 w-full bg-white rounded-xl shadow-xl border border-gray-100 max-h-60 overflow-y-auto py-1 custom-scrollbar ring-1 ring-black ring-opacity-5 focus:outline-none';
                                    $itemClass = 'px-4 py-2 text-sm text-slate-600 cursor-pointer transition-colors hover:bg-green-50 hover:text-green-700';
                                    $activeItemClass = 'bg-green-50 text-green-700 font-bold';
                                @endphp

                                <!-- ========== KATEGORI DROPDOWN ========== -->
                                <div class="relative" x-data="{
                                    open: false,
                                    selected: '{{ request('kategori') && isset($kategoris) ? $kategoris->where('id', request('kategori'))->first()->nama_kategori ?? 'Semua Kategori' : 'Semua Kategori' }}',
                                    val: '{{ request('kategori') }}'
                                }" @click.outside="open = false">

                                    <input type="hidden" name="kategori" :value="val">

                                    <button type="button" @click="open = !open" class="{{ $btnClass }}">
                                        <span x-text="selected" class="truncate mr-2"></span>
                                        <svg class="w-4 h-4 text-slate-400 flex-shrink-0 transition-transform duration-200"
                                            :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>

                                    <div x-show="open" x-cloak 
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="{{ $dropdownClass }}">

                                        <div @click="selected = 'Semua Kategori'; val = ''; open = false"
                                            class="{{ $itemClass }}" :class="{ '{{ $activeItemClass }}': val === '' }">
                                            Semua Kategori
                                        </div>

                                        @if (isset($kategoris))
                                            @foreach ($kategoris as $kategori)
                                                <div @click="selected = '{{ $kategori->nama_kategori }}'; val = '{{ $kategori->id }}'; open = false"
                                                    class="{{ $itemClass }}"
                                                    :class="{ '{{ $activeItemClass }}': val == '{{ $kategori->id }}' }">
                                                    {{ $kategori->nama_kategori }}
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <!-- ========== HARGA DROPDOWN ========== -->
                                <div class="relative" x-data="{
                                    open: false,
                                    selected: '{{ request('harga') == 'asc' ? 'Termurah' : (request('harga') == 'desc' ? 'Termahal' : 'Urutkan Harga') }}',
                                    val: '{{ request('harga') }}'
                                }" @click.outside="open = false">

                                    <input type="hidden" name="harga" :value="val">

                                    <button type="button" @click="open = !open" class="{{ $btnClass }}">
                                        <span x-text="selected" class="truncate mr-2"></span>
                                        <svg class="w-4 h-4 text-slate-400 flex-shrink-0 transition-transform duration-200"
                                            :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>

                                    <div x-show="open" x-cloak 
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="{{ $dropdownClass }}">

                                        <div @click="selected = 'Urutkan Harga'; val = ''; open = false"
                                            class="{{ $itemClass }}" :class="{ '{{ $activeItemClass }}': val === '' }">
                                            Urutkan Harga (Default)
                                        </div>
                                        <div @click="selected = 'Termurah'; val = 'asc'; open = false"
                                            class="{{ $itemClass }}" :class="{ '{{ $activeItemClass }}': val === 'asc' }">
                                            Termurah
                                        </div>
                                        <div @click="selected = 'Termahal'; val = 'desc'; open = false"
                                            class="{{ $itemClass }}" :class="{ '{{ $activeItemClass }}': val === 'desc' }">
                                            Termahal
                                        </div>
                                    </div>
                                </div>

                                <!-- ========== STOK DROPDOWN ========== -->
                                <div class="relative" x-data="{
                                    open: false,
                                    selected: '{{ request('stok') == 'tersedia' ? 'Tersedia' : (request('stok') == 'habis' ? 'Habis' : 'Status Stok') }}',
                                    val: '{{ request('stok') }}'
                                }" @click.outside="open = false">

                                    <input type="hidden" name="stok" :value="val">

                                    <button type="button" @click="open = !open" class="{{ $btnClass }}">
                                        <span x-text="selected" class="truncate mr-2"></span>
                                        <svg class="w-4 h-4 text-slate-400 flex-shrink-0 transition-transform duration-200"
                                            :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>

                                    <div x-show="open" x-cloak 
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="{{ $dropdownClass }}">

                                        <div @click="selected = 'Status Stok'; val = ''; open = false"
                                            class="{{ $itemClass }}" :class="{ '{{ $activeItemClass }}': val === '' }">
                                            Semua Status
                                        </div>
                                        <div @click="selected = 'Tersedia'; val = 'tersedia'; open = false"
                                            class="{{ $itemClass }}" :class="{ '{{ $activeItemClass }}': val === 'tersedia' }">
                                            Tersedia
                                        </div>
                                        <div @click="selected = 'Habis'; val = 'habis'; open = false"
                                            class="{{ $itemClass }}" :class="{ '{{ $activeItemClass }}': val === 'habis' }">
                                            Habis
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ========== ACTIVE FILTER TAGS ========== -->
                        @if (request('kategori') || request('harga') || request('stok'))
                            <div class="flex flex-wrap items-center justify-center gap-2 pt-1 animate-fade-in-up">
                                <span class="text-[10px] font-medium text-slate-400 mr-1 uppercase tracking-wide">Filter:</span>

                                @php
                                    $tagClass = 'inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-white border border-gray-200 text-xs font-medium text-slate-600 shadow-sm';
                                    $closeBtnClass = 'text-slate-400 hover:text-green-600 transition-colors ml-0.5';
                                    $closeIcon = '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                                @endphp

                                @if (request('kategori'))
                                    @php
                                        $selKat = isset($kategoris) ? $kategoris->where('id', request('kategori'))->first() : null;
                                    @endphp
                                    <div class="{{ $tagClass }}">
                                        <span>{{ $selKat ? $selKat->nama_kategori : 'Kategori' }}</span>
                                        <button type="button" onclick="removeFilter('kategori')" class="{{ $closeBtnClass }}">{!! $closeIcon !!}</button>
                                    </div>
                                @endif

                                @if (request('harga'))
                                    <div class="{{ $tagClass }}">
                                        <span>{{ request('harga') == 'asc' ? 'Termurah' : 'Termahal' }}</span>
                                        <button type="button" onclick="removeFilter('harga')" class="{{ $closeBtnClass }}">{!! $closeIcon !!}</button>
                                    </div>
                                @endif

                                @if (request('stok'))
                                    <div class="{{ $tagClass }}">
                                        <span>{{ request('stok') == 'tersedia' ? 'Stok Ada' : 'Habis' }}</span>
                                        <button type="button" onclick="removeFilter('stok')" class="{{ $closeBtnClass }}">{!! $closeIcon !!}</button>
                                    </div>
                                @endif

                                <!-- Reset All Filters Link -->
                                <a href="{{ route('produk.index') }}" class="ml-1 text-[10px] font-bold text-slate-400 hover:text-green-600 transition-colors uppercase tracking-wide">
                                    Reset
                                </a>
                            </div>
                        @endif

                    </form>
                </div>
            </div>
        </section>

        <!-- ========== PRODUCTS SECTION ========== -->
        <section class="py-16 lg:py-24 relative bg-white border-t border-green-50 overflow-hidden">
            
            <!-- Background Decoration -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full md:w-[1000px] h-[300px] md:h-[500px] bg-green-50/40 rounded-full blur-[80px] md:blur-[120px] -mt-20 md:-mt-32"></div>
                <div class="absolute bottom-0 right-0 w-[300px] md:w-[600px] h-[200px] md:h-[400px] bg-green-50/30 rounded-full blur-[60px] md:blur-[100px] translate-y-1/3 translate-x-1/3"></div>

                <svg class="absolute top-0 right-0 w-[350px] md:w-[700px] h-[350px] md:h-[700px] opacity-25 translate-x-1/4 md:translate-x-1/3 -translate-y-1/4" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 Q 50 -20 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                    <path d="M0 100 Q 50 0 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                    <path d="M0 100 Q 50 20 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                </svg>

                <svg class="absolute bottom-0 left-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] opacity-20 -translate-x-1/3 translate-y-1/4 rotate-180" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 Q 50 0 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                    <path d="M0 100 Q 50 20 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                    <path d="M0 100 Q 50 40 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                </svg>
            </div>

            <!-- Products Container -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                
                <!-- Success Message Notification -->
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition
                        class="mb-8 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl flex items-center justify-between shadow-sm"
                        data-aos="fade-up">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-green-600 hover:text-green-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- ========== PRODUCTS GRID ========== -->
                @if (isset($daftarProduk) && !$daftarProduk->isEmpty())
                    
                    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6 lg:gap-8">
                        @foreach ($daftarProduk as $index => $item)
                            <!-- Single Product Card -->
                            <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                                class="group bg-white rounded-2xl overflow-hidden border border-slate-200 hover:border-green-500 transition-all duration-300 hover:-translate-y-2">

                                <!-- Product Image -->
                                <div class="relative aspect-square overflow-hidden bg-slate-50">
                                    @if ($item->foto_produk)
                                        <img src="{{ asset('storage/' . $item->foto_produk) }}"
                                            alt="{{ $item->nama_produk }}" loading="lazy"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <!-- Image Placeholder -->
                                        <div class="w-full h-full flex items-center justify-center">
                                            <div class="text-center">
                                                <svg class="w-16 h-16 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <p class="text-xs text-slate-400 font-medium">No Image</p>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Category Badge -->
                                    <div class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-green-600 px-2 sm:px-3 py-0.5 sm:py-1 rounded-lg text-[8px] sm:text-[10px] font-bold text-white shadow-md uppercase tracking-wide">
                                        {{ $item->kategoriProduk->nama_kategori ?? 'Umum' }}
                                    </div>
                                </div>

                                <!-- Product Details -->
                                <div class="p-3 sm:p-5 bg-white">
                                    <!-- Product Name -->
                                    <h3 class="text-sm sm:text-lg font-bold text-slate-900 mb-2 sm:mb-3 line-clamp-1 group-hover:text-green-600 transition-colors">
                                        {{ $item->nama_produk }}
                                    </h3>

                                    <!-- Stock Information -->
                                    <div class="flex items-center justify-between mb-2 sm:mb-4 bg-slate-50 rounded-lg px-2 sm:px-3 py-1 sm:py-2">
                                        <span class="text-[10px] sm:text-xs text-slate-600 font-medium">Stok</span>
                                        <span class="text-[10px] sm:text-sm font-bold {{ ($item->stok ?? 0) > 0 ? 'text-green-600' : 'text-red-500' }}">
                                            {{ $item->stok ?? 0 }} {{ $item->satuan ?? '' }}
                                        </span>
                                    </div>

                                    <!-- Price & Cart Button -->
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="min-w-0">
                                            <p class="text-[10px] sm:text-xs text-slate-500 font-medium mb-0.5 sm:mb-1">Harga</p>
                                            <p class="text-base sm:text-2xl font-bold text-slate-900 truncate">
                                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                                            </p>
                                            <p class="text-[10px] sm:text-xs text-slate-500 mt-0.5 truncate">/ {{ $item->satuan ?? 'kg' }}</p>
                                        </div>

                                        <!-- View Details Button -->
                                        <a href="{{ route('produk.show', $item->id) }}"
                                            class="flex-shrink-0 w-9 h-9 sm:w-12 sm:h-12 rounded-xl bg-green-600 hover:bg-green-700 flex items-center justify-center text-white transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-110">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- ========== PAGINATION ========== -->
                    <div class="mt-12" data-aos="fade-up">
                        {{ $daftarProduk->appends(request()->query())->links() }}
                    </div>

                @else
                    <!-- ========== EMPTY STATE ========== -->
                    <div class="text-center py-20 bg-white/50 backdrop-blur-sm rounded-3xl border-2 border-dashed border-green-200 mx-4 sm:mx-0" data-aos="fade-up">
                        <div class="w-20 h-20 lg:w-24 lg:h-24 mx-auto mb-6 bg-white rounded-full flex items-center justify-center shadow-md">
                            <svg class="w-10 h-10 lg:w-12 lg:h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg lg:text-xl font-bold text-slate-900 mb-2">Produk Tidak Ditemukan</h3>
                        <p class="text-slate-500 text-sm max-w-md mx-auto px-4">
                            Maaf, kami tidak dapat menemukan produk yang sesuai dengan pencarian Anda.
                        </p>
                        <a href="{{ route('produk.index') }}"
                            class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition-all shadow-lg hover:shadow-xl hover:scale-105 mt-6">
                            Reset Filter
                        </a>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <!-- ========== FOOTER SECTION ========== -->
    <x-footer />

    <!-- ========== BACK TO TOP BUTTON ========== -->
    <x-back-button />

    <!-- ========== EXTERNAL SCRIPTS ========== -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi AOS (Animate On Scroll)
        AOS.init({
            once: true,
            offset: 50,
            duration: 800,
        });

        // Logic untuk Reset Filter via Javascript
        function removeFilter(filterName) {
            const url = new URL(window.location.href);
            url.searchParams.delete(filterName);
            window.location.href = url.toString();
        }
    </script>
</body>

</html>