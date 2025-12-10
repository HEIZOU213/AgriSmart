<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO META TAGS --}}
    <meta name="description"
        content="Pusat Edukasi Pertanian AgriSmart. Pelajari teknik pertanian modern, tips budidaya, dan inovasi teknologi pertanian terkini.">
    <meta name="keywords" content="Edukasi Pertanian, Tips Budidaya, Teknologi Pertanian, AgriSmart, Petani Digital">
    <meta property="og:title" content="Edukasi - {{ config('app.name', 'AgriSmart') }}">
    <meta property="og:description" content="Tingkatkan pengetahuan bertani dengan panduan dari ahli.">
    <meta property="og:image" content="{{ asset('images/hero1.png') }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>Edukasi - {{ config('app.name', 'AgriSmart') }}</title>

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
            {{-- Background Spin Tengah --}}
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="w-[600px] h-[600px] lg:w-[800px] lg:h-[800px] opacity-5">
                    <div class="w-full h-full animate-[spin_30s_linear_infinite]">
                        <img src="images/nav-logo.png" alt="Background Decorative" class="w-full h-full object-contain">
                    </div>
                </div>
            </div>

            {{-- Konten Utama --}}
            <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
                <div class="text-center" data-aos="fade-up">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-slate-900 mb-6">
                        Edukasi
                        <span class="text-green-600">
                            Pertanian Modern
                        </span>
                    </h2>
                    <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                        Mengoptimalkan potensi pertanian dengan teknologi dan metode terkini
                    </p>
                </div>
            </div>
        </section>

        {{-- EDUCATION CONTENT SECTION --}}
        <section class="py-16 lg:py-24 relative bg-white overflow-hidden">

            {{-- Modern Background Decorations (Optional: bisa dihapus atau diubah ke warna netral) --}}
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                {{-- Clean Gradient Meshes --}}
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-gradient-to-br from-gray-50/20 via-gray-50/10 to-transparent rounded-full blur-3xl">
                </div>
                <div
                    class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-gradient-to-tl from-gray-50/15 to-transparent rounded-full blur-3xl translate-x-1/3 translate-y-1/3">
                </div>

                {{-- Floating Elements --}}
                <div class="absolute top-20 right-[10%] w-32 h-32 border border-gray-100/20 rounded-full"></div>
                <div class="absolute bottom-32 left-[8%] w-24 h-24 border border-gray-100/20 rounded-full"></div>

                {{-- Subtle Pattern --}}
                <div class="absolute inset-0 opacity-[0.015]"
                    style="background-image: radial-gradient(circle at 1px 1px, rgb(209 213 219) 1px, transparent 0); background-size: 40px 40px;">
                </div>
            </div>

            {{-- Main Content Container --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                @if(isset($daftarEdukasi) && !$daftarEdukasi->isEmpty())
                    {{-- Articles Grid --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                        @foreach($daftarEdukasi as $index => $item)
                            <article class="group" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                                <a href="{{ route('edukasi.show', $item->slug) }}" class="block h-full bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg 
                                                                                  transition-all duration-500 border border-green-100 hover:border-green-300 
                                                                                  hover:-translate-y-1">

                                    <div class="flex flex-col sm:flex-row h-full min-h-[280px]">

                                        {{-- Image Section --}}
                                        <div class="relative sm:w-2/5 h-48 sm:h-auto overflow-hidden bg-green-50">
                                            @if($item->foto_sampul)
                                                <img src="{{ asset('storage/' . $item->foto_sampul) }}" alt="{{ $item->judul }}"
                                                    class="w-full h-full object-cover transition-all duration-700 group-hover:scale-105">
                                            @else
                                                <div
                                                    class="w-full h-full bg-gradient-to-br from-green-50 to-emerald-50 flex items-center justify-center min-h-[250px]">
                                                    <svg class="w-16 h-16 text-green-200" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif

                                            {{-- Overlay Gradient --}}
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                            </div>

                                            {{-- Date Badge --}}
                                            <div class="absolute top-4 left-4">
                                                <div
                                                    class="flex items-center gap-1.5 px-3 py-1.5 bg-white rounded-full shadow-sm">
                                                    <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span class="text-xs font-medium text-green-600">
                                                        {{ $item->created_at->format('d M Y') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Content Section --}}
                                        <div class="flex-1 p-6 flex flex-col">

                                            {{-- Category Badge --}}
                                            <div class="mb-3">
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 
                                                                                                     text-green-600 text-xs font-medium uppercase tracking-wider rounded-lg border border-green-200">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                                                    </svg>
                                                    {{ $item->kategoriEdukasi->nama_kategori ?? 'Tips' }}
                                                </span>
                                            </div>

                                            {{-- Title --}}
                                            <h3
                                                class="text-xl font-bold text-slate-900 mb-3 line-clamp-2 
                                                                                               group-hover:text-green-600 transition-colors duration-300 leading-tight">
                                                {{ $item->judul }}
                                            </h3>

                                            {{-- Excerpt --}}
                                            <p class="text-slate-600 text-sm leading-relaxed mb-5 line-clamp-3 flex-grow">
                                                {{ Str::limit(strip_tags($item->isi_konten), 140) }}
                                            </p>

                                            {{-- Footer --}}
                                            <div
                                                class="flex items-center justify-between pt-4 border-t border-green-100 mt-auto">
                                                {{-- Author --}}
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-xs text-green-600 font-medium">Admin</span>
                                                </div>

                                                {{-- Read More --}}
                                                <div class="flex items-center gap-1 text-green-600 font-medium text-sm">
                                                    <span>Video/Baca Artikel</span>
                                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-16" data-aos="fade-up" data-aos-delay="200">
                        <div class="flex justify-center">
                            {{ $daftarEdukasi->links() }}
                        </div>
                    </div>

                @else
                    {{-- Empty State --}}
                    <div class="max-w-2xl mx-auto" data-aos="fade-up">
                        <div class="text-center py-20 px-6 bg-white rounded-3xl border border-green-200">

                            {{-- Icon --}}
                            <div class="relative inline-flex mb-6">
                                <div class="w-24 h-24 bg-green-50 rounded-2xl flex items-center justify-center">
                                    <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                            </div>

                            {{-- Text --}}
                            <h3 class="text-2xl font-bold text-slate-900 mb-3">Konten Segera Hadir!</h3>
                            <p class="text-slate-600 leading-relaxed max-w-md mx-auto mb-6">
                                Kami sedang menyiapkan artikel edukatif berkualitas tinggi untuk meningkatkan pengetahuan
                                pertanian Anda. Nantikan konten menarik dari kami segera!
                            </p>
                        </div>
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
    </script>
</body>

</html>