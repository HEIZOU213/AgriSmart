<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO META TAGS --}}
    <meta name="description"
        content="Marketplace Pertanian AgriSmart. Temukan hasil panen segar langsung dari petani dengan harga terbaik.">
    <meta name="keywords" content="Marketplace Tani, Jual Sayur, AgriSmart, Petani Digital, Panen Segar">
    <meta property="og:title" content="Marketplace - {{ config('app.name', 'AgriSmart') }}">
    <meta property="og:description" content="Belanja hasil tani segar langsung dari sumbernya.">
    <meta property="og:image" content="{{ asset('images/hero1.png') }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>Marketplace - {{ config('app.name', 'AgriSmart') }}</title>

    {{-- FONT MODERN: Plus Jakarta Sans --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- LIBRARY ANIMASI AOS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- TAILWIND & SCRIPTS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Scrollbar Green Theme */
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

        /* Custom Animation Utilities */
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

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

        /* Blob Animation */
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</head>

<body
    class="font-sans antialiased text-slate-700 bg-green-50 flex flex-col min-h-screen selection:bg-green-500 selection:text-white">

    {{-- NAVBAR --}}
    <x-navbar />

    {{-- MAIN CONTENT --}}
    <main class="flex-1">

        {{-- HERO SECTION --}}
        <section class="relative overflow-hidden pt-20 pb-12 lg:pt-28 lg:pb-16 bg-slate-50">

            {{-- Minimalist Spiral Background --}}
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none overflow-hidden">
                <img src="images/nav-logo.png" alt="Decorative Background"
                    class="w-[700px] h-[700px] object-contain opacity-10 animate-[spin_30s_linear_infinite]">
            </div>

            <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">

                {{-- Header Compact --}}
                <div class="text-center max-w-2xl mx-auto mb-8 lg:mb-10" data-aos="fade-up">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 tracking-tight">
                        Temukan <span
                            class="text-transparent bg-clip-text bg-gradient-to-br from-green-600 to-emerald-600">Panen
                            Terbaik</span>
                    </h1>
                </div>

                {{-- SEARCH & FILTER MINIMALIST --}}
                <div class="max-w-4xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                    <form action="{{ route('produk.index') }}" method="GET" class="space-y-6">

                        <div class="relative w-full max-w-2xl mx-auto group">
                            {{-- Input Field --}}
                            <input type="search" name="q" value="{{ request('q') }}"
                                placeholder="Cari produk pertanian..."
                                class="w-full pl-5 pr-12 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl shadow-sm focus:ring-4 focus:ring-green-500/10 focus:border-green-500 outline-none transition-all duration-300 text-sm font-medium placeholder:text-slate-400 hover:shadow-md">

                            {{-- Submit Button (Smaller & Boxy) --}}
                            <button type="submit"
                                class="absolute right-1.5 top-1/2 -translate-y-1/2 w-9 h-9 bg-green-600 text-white rounded-lg hover:bg-green-700 hover:scale-105 active:scale-95 transition-all duration-300 flex items-center justify-center shadow-sm">
                                {{-- Logo Search (Ukuran disesuaikan) --}}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>

                        {{-- 2. Filters (Grid System) --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            @php
                                // Styling variabel untuk Dropdown yang konsisten dan rapi
                                $selectWrapper = "relative";
                                $selectClass = "w-full appearance-none bg-white border border-slate-200 text-slate-600 text-sm font-medium py-3 pl-5 pr-10 rounded-xl focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500/10 hover:border-green-400 transition-colors shadow-sm cursor-pointer";
                                $iconWrapper = "absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400";
                            @endphp

                            {{-- Filter: Kategori --}}
                            <div class="{{ $selectWrapper }}">
                                <select name="kategori" class="{{ $selectClass }}" onchange="this.form.submit()">
                                    <option value="">Semua Kategori</option>
                                    @if(isset($kategoris))
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama_kategori }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="{{ $iconWrapper }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>

                            {{-- Filter: Harga --}}
                            <div class="{{ $selectWrapper }}">
                                <select name="harga" class="{{ $selectClass }}" onchange="this.form.submit()">
                                    <option value="">Urutkan Harga</option>
                                    <option value="asc" {{ request('harga') == 'asc' ? 'selected' : '' }}>Termurah
                                    </option>
                                    <option value="desc" {{ request('harga') == 'desc' ? 'selected' : '' }}>Termahal
                                    </option>
                                </select>
                                <div class="{{ $iconWrapper }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>

                            {{-- Filter: Stok --}}
                            <div class="{{ $selectWrapper }}">
                                <select name="stok" class="{{ $selectClass }}" onchange="this.form.submit()">
                                    <option value="">Status Stok</option>
                                    <option value="tersedia" {{ request('stok') == 'tersedia' ? 'selected' : '' }}>
                                        Tersedia</option>
                                    <option value="habis" {{ request('stok') == 'habis' ? 'selected' : '' }}>Habis
                                    </option>
                                </select>
                                <div class="{{ $iconWrapper }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- 3. Active Filters (Pill Style) --}}
                        @if(request()->hasAny(['q', 'kategori', 'harga', 'stok']))
                            <div class="flex flex-wrap items-center justify-center gap-2 pt-2 animate-fade-in-up">
                                <span
                                    class="text-xs font-semibold text-slate-400 uppercase tracking-wider mr-1">Filter:</span>

                                @php
                                    $tagClass = "group inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-50 border border-green-200 text-xs font-medium text-green-700 transition-all hover:bg-green-100 hover:border-green-300";
                                    $closeIcon = '<svg class="w-3.5 h-3.5 text-green-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                                @endphp

                                @if(request('q'))
                                    <div class="{{ $tagClass }}">
                                        <span>"{{ request('q') }}"</span>
                                        <button type="button" onclick="removeFilter('q')">{!! $closeIcon !!}</button>
                                    </div>
                                @endif

                                @if(request('kategori'))
                                    @php $selKat = isset($kategoris) ? $kategoris->where('id', request('kategori'))->first() : null; @endphp
                                    <div class="{{ $tagClass }}">
                                        <span>{{ $selKat ? $selKat->nama_kategori : 'Kategori' }}</span>
                                        <button type="button" onclick="removeFilter('kategori')">{!! $closeIcon !!}</button>
                                    </div>
                                @endif

                                @if(request('harga'))
                                    <div class="{{ $tagClass }}">
                                        <span>{{ request('harga') == 'asc' ? 'Termurah' : 'Termahal' }}</span>
                                        <button type="button" onclick="removeFilter('harga')">{!! $closeIcon !!}</button>
                                    </div>
                                @endif

                                @if(request('stok'))
                                    <div class="{{ $tagClass }}">
                                        <span>{{ request('stok') == 'tersedia' ? 'Stok Ada' : 'Habis' }}</span>
                                        <button type="button" onclick="removeFilter('stok')">{!! $closeIcon !!}</button>
                                    </div>
                                @endif

                                <a href="{{ route('produk.index') }}"
                                    class="ml-2 text-xs font-medium text-slate-400 hover:text-green-600 transition-colors">
                                    Hapus Semua
                                </a>
                            </div>
                        @endif

                    </form>
                </div>
            </div>
        </section>

        {{-- PRODUCT GRID SECTION --}}
        <section class="py-16 lg:py-24 relative bg-white border-t border-green-50 overflow-hidden">

            {{-- Background Decorations --}}
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                {{-- Soft Gradient Orb (Atas) --}}
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-full md:w-[1000px] h-[300px] md:h-[500px] bg-green-50/40 rounded-full blur-[80px] md:blur-[120px] -mt-20 md:-mt-32">
                </div>

                {{-- Soft Gradient Orb (Bawah Kanan) --}}
                <div
                    class="absolute bottom-0 right-0 w-[300px] md:w-[600px] h-[200px] md:h-[400px] bg-green-50/30 rounded-full blur-[60px] md:blur-[100px] translate-y-1/3 translate-x-1/3">
                </div>

                {{-- Spiral 1: Kanan Atas --}}
                <svg class="absolute top-0 right-0 w-[350px] md:w-[700px] h-[350px] md:h-[700px] opacity-25 translate-x-1/4 md:translate-x-1/3 -translate-y-1/4"
                    viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 Q 50 -20 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                    <path d="M0 100 Q 50 0 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                    <path d="M0 100 Q 50 20 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                </svg>

                {{-- Spiral 2: Kiri Bawah --}}
                <svg class="absolute bottom-0 left-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] opacity-20 -translate-x-1/3 translate-y-1/4 rotate-180"
                    viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 Q 50 0 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                    <path d="M0 100 Q 50 20 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                    <path d="M0 100 Q 50 40 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                </svg>
            </div>

            {{-- PRODUCT CONTENT --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                {{-- Flash Message --}}
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition
                        class="mb-8 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl flex items-center justify-between shadow-sm"
                        data-aos="fade-up">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-green-600 hover:text-green-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                @endif

                {{-- PRODUCT GRID (BOX PRODUK TIDAK DIUBAH) --}}
                @if(isset($daftarProduk) && !$daftarProduk->isEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8">
                        @foreach($daftarProduk as $index => $item)
                            <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                                class="group bg-white rounded-2xl overflow-hidden border border-slate-200 hover:border-green-500 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">

                                {{-- Image Container --}}
                                <div class="relative aspect-square overflow-hidden bg-slate-50">
                                    @if($item->foto_produk)
                                        <img src="{{ asset('storage/' . $item->foto_produk) }}" alt="{{ $item->nama_produk }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <div class="text-center">
                                                <svg class="w-16 h-16 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                <p class="text-xs text-slate-400 font-medium">No Image</p>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Category Badge --}}
                                    <div
                                        class="absolute top-3 right-3 bg-green-600 px-3 py-1 rounded-lg text-[10px] font-bold text-white shadow-md uppercase tracking-wide">
                                        {{ $item->kategoriProduk->nama_kategori ?? 'Umum' }}
                                    </div>
                                </div>

                                {{-- Content Area --}}
                                <div class="p-5 bg-white">
                                    {{-- Product Name --}}
                                    <h3
                                        class="text-lg font-bold text-slate-900 mb-3 line-clamp-1 group-hover:text-green-600 transition-colors">
                                        {{ $item->nama_produk }}
                                    </h3>

                                    {{-- Seller Info --}}
                                    <div class="space-y-2 mb-4 pb-4 border-b border-slate-100">
                                        <div class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-slate-400 flex-shrink-0 mt-0.5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                            <p class="text-xs font-medium text-slate-700 truncate">
                                                {{ $item->user->name ?? 'Penjual' }}
                                            </p>
                                        </div>
                                        <div class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-slate-400 flex-shrink-0 mt-0.5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <p class="text-xs text-slate-500 truncate">
                                                {{ $item->user->alamat ?? 'Alamat tidak tersedia' }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Stock Info --}}
                                    <div class="flex items-center justify-between mb-4 bg-slate-50 rounded-lg px-3 py-2">
                                        <span class="text-xs text-slate-600 font-medium">Stok Tersedia</span>
                                        <span
                                            class="text-sm font-bold {{ ($item->stok ?? 0) > 0 ? 'text-green-600' : 'text-red-500' }}">
                                            {{ $item->stok ?? 0 }} {{ $item->satuan ?? '' }}
                                        </span>
                                    </div>

                                    {{-- Price & Action Section --}}
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-xs text-slate-500 font-medium mb-1">Harga</p>
                                            <p class="text-2xl font-bold text-slate-900">
                                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                                            </p>
                                            <p class="text-xs text-slate-500 mt-0.5">per {{ $item->satuan ?? 'kg' }}</p>
                                        </div>

                                        {{-- Action Button --}}
                                        <a href="{{ route('produk.show', $item->id) }}"
                                            class="flex-shrink-0 w-12 h-12 rounded-xl bg-green-600 hover:bg-green-700 flex items-center justify-center text-white transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-110">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-12" data-aos="fade-up">
                        {{ $daftarProduk->appends(request()->query())->links() }}
                    </div>

                @else
                    {{-- EMPTY STATE --}}
                    <div class="text-center py-20 bg-white/50 backdrop-blur-sm rounded-3xl border-2 border-dashed border-green-200 mx-4 sm:mx-0"
                        data-aos="fade-up">
                        <div
                            class="w-20 h-20 lg:w-24 lg:h-24 mx-auto mb-6 bg-white rounded-full flex items-center justify-center shadow-md">
                            <svg class="w-10 h-10 lg:w-12 lg:h-12 text-green-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
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

    {{-- FOOTER (diambil dari welcome.blade.php) --}}
    <footer id="footer" class="bg-white border-t border-slate-100 pt-16 pb-8 font-sans relative overflow-hidden">

        {{-- DEKORASI BACKGROUND --}}
        <div
            class="absolute top-0 left-0 -translate-x-1/3 -translate-y-1/3 w-[500px] h-[500px] opacity-40 pointer-events-none">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#DCFCE7"
                    d="M47.5,-57.2C59.6,-46.3,66.4,-28.9,65.6,-12.9C64.8,3.1,56.3,17.7,46.2,29.9C36.1,42.1,24.3,51.9,10.6,56.7C-3.1,61.5,-18.8,61.3,-31.2,54.1C-43.7,46.9,-53,32.7,-57.3,17.6C-61.6,2.5,-60.9,-13.5,-53.4,-26.8C-45.9,-40.1,-31.6,-50.7,-17.1,-54.2C-2.6,-57.7,12,-54.1,25.4,-50.4L47.5,-57.2Z"
                    transform="translate(100 100)" />
            </svg>
        </div>
        <div
            class="absolute top-0 right-0 translate-x-1/4 -translate-y-1/4 w-[600px] h-[600px] opacity-30 pointer-events-none">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#F0FDF4"
                    d="M41.4,-70.3C52.6,-62.7,60.2,-49.6,67.3,-36.1C74.3,-22.6,80.8,-8.7,78.9,4.2C77,17.1,66.7,29,56.5,38.9C46.3,48.8,36.2,56.7,24.8,62.2C13.4,67.7,0.7,70.8,-11.2,69.5C-23.1,68.2,-34.2,62.5,-44.7,54.6C-55.2,46.7,-65.1,36.6,-70.6,24.2C-76.1,11.8,-77.2,-2.9,-71.9,-15.2C-66.6,-27.5,-54.9,-37.4,-43,-44.8C-31.1,-52.2,-19,-57.1,-6.3,-58.5C6.4,-59.9,20,-77.9,41.4,-70.3Z"
                    transform="translate(100 100)" />
            </svg>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-12 mb-16 items-start">

                {{-- 1. Brand Column (Lebar: 5 Kolom) --}}
                <div class="lg:col-span-5">
                    <a href="/" class="inline-block mb-6">
                        <img src="{{ asset('images/logo2.png') }}" alt="AgriSmart Logo"
                            class="h-16 lg:h-20 w-auto object-contain">
                    </a>
                    <p class="text-slate-500 leading-relaxed mb-8 pr-0 lg:pr-12">
                        Platform digital terintegrasi untuk pertanian cerdas. Solusi IoT inovatif untuk masa depan
                        pangan Indonesia yang berkelanjutan.
                    </p>
                    <div class="flex items-center gap-3">
                        @foreach(['facebook', 'instagram', 'twitter'] as $social)
                            <a href="#"
                                class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-500 border border-slate-100 transition-all duration-300 hover:bg-green-600 hover:text-white hover:scale-110 hover:shadow-lg group">
                                <span class="sr-only">{{ ucfirst($social) }}</span>
                                {{-- Menggunakan SVG spesifik dari kode lama Anda --}}
                                @if($social == 'facebook')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                @elseif($social == 'instagram')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0, -3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4.001-1.793-4.001-4.001s1.792-4.001 4.001-4.001c2.21 0 4.001 1.793 4.001 4.001s-1.791 4.001-4.001 4.001zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                                @else
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                    </svg>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- 2. Menu Utama Column (Lebar: 2 Kolom) --}}
                <div class="lg:col-span-2">
                    <h5 class="font-bold text-slate-900 mb-6">Menu Utama</h5>
                    <ul class="space-y-4">
                        @foreach(['Beranda' => '/', 'Tentang Kami' => '#tentang-kami', 'Layanan' => '#layanan', 'Produk' => route('produk.index'), 'Kontak' => '#kontak'] as $label => $link)
                            <li>
                                <a href="{{ $link }}"
                                    class="text-slate-500 text-sm font-medium hover:text-green-600 transition-all duration-200 block hover:translate-x-1">
                                    {{ $label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- 3. Layanan Column (Lebar: 2 Kolom) --}}
                <div class="lg:col-span-2">
                    <h5 class="font-bold text-slate-900 mb-6">Layanan</h5>
                    <ul class="space-y-4">
                        @foreach(['Konsultasi Tani' => '#', 'Marketplace Panen' => '#', 'Monitoring IoT' => '#', 'Edukasi & Pelatihan' => route('edukasi.index')] as $label => $link)
                            <li>
                                <a href="{{ $link }}"
                                    class="text-slate-500 text-sm font-medium hover:text-green-600 transition-all duration-200 block hover:translate-x-1">
                                    {{ $label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- 4. Hubungi Kami Column (Lebar: 3 Kolom) --}}
                <div class="lg:col-span-3">
                    <h5 class="font-bold text-slate-900 mb-6">Hubungi Kami</h5>
                    <div class="space-y-5">
                        {{-- Address --}}
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-600 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p class="text-sm text-slate-500 leading-snug">
                                Jl. Pertanian Modern No. 88,<br>Jakarta Selatan, Indonesia
                            </p>
                        </div>

                        {{-- Email --}}
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <a href="mailto:info@agrismart.id"
                                class="text-sm text-slate-500 hover:text-green-600 transition-colors">
                                info@agrismart.id
                            </a>
                        </div>

                        {{-- Phone --}}
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <a href="tel:+6281234567890"
                                class="text-sm text-slate-500 hover:text-green-600 transition-colors">
                                +62 812 3456 7890
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Copyright & Legal --}}
            <div class="border-t border-slate-100 pt-8 flex flex-col justify-center items-center gap-4">
                <p class="text-sm text-slate-500 text-center">
                    &copy; {{ date('Y') }} <span class="text-green-600 font-bold">AgriSmart</span>. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

    {{-- BACK TO TOP BUTTON --}}
    <button id="backToTop"
        class="fixed bottom-6 right-4 sm:bottom-8 sm:right-8 bg-green-600 hover:bg-green-700 text-white p-2.5 sm:p-3 rounded-xl shadow-lg shadow-green-600/30 translate-y-20 opacity-0 transition-all duration-500 z-50">
        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18">
            </path>
        </svg>
    </button>

    {{-- SCRIPT INITIALIZATION --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Init AOS
        AOS.init({
            once: true,
            offset: 50,
            duration: 800,
        });

        // Back to Top Logic
        const backToTopBtn = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopBtn.classList.remove('translate-y-20', 'opacity-0');
            } else {
                backToTopBtn.classList.add('translate-y-20', 'opacity-0');
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Function to remove individual filters
        function removeFilter(filterName) {
            const url = new URL(window.location.href);
            url.searchParams.delete(filterName);
            window.location.href = url.toString();
        }
    </script>
</body>

</html>