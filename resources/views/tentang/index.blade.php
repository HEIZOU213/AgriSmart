<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO META TAGS --}}
    <meta name="description"
        content="Tentang AgriSmart - Platform pertanian cerdas Indonesia. Pelajari visi, misi, dan tujuan kami dalam membangun ekosistem pertanian berkelanjutan.">
    <meta name="keywords"
        content="Tentang AgriSmart, Visi Misi Pertanian, Sejarah AgriSmart, Platform Pertanian Indonesia">
    <meta property="og:title" content="Tentang Kami - {{ config('app.name', 'AgriSmart') }}">
    <meta property="og:description"
        content="Mengenal lebih dekat AgriSmart dan komitmen kami untuk pertanian Indonesia.">
    <meta property="og:image" content="{{ asset('images/hero1.png') }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>Tentang Kami - {{ config('app.name', 'AgriSmart') }}</title>

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

        /* Timeline Styling */
        .timeline-item:before {
            content: '';
            position: absolute;
            left: -32px;
            top: 10px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #16a34a;
            border: 3px solid white;
            box-shadow: 0 0 0 4px #16a34a;
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
                        Tentang
                        <span class="text-green-600">
                            AgriSmart
                        </span>
                    </h2>
                    <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                        Mengenal lebih dekat tentang AgriSmart
                    </p>
                </div>
            </div>
        </section>

        {{-- TENTANG SECTION --}}
        <section class="py-16 lg:py-24 bg-white overflow-hidden">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">

                    {{-- IMAGE SIDE (LEFT) --}}
                    <div class="relative px-4 sm:px-0" data-aos="fade-right">
                        {{-- Decorative Backdrops --}}
                        <div
                            class="absolute -top-3 -left-3 sm:-top-4 sm:-left-4 w-full h-full bg-green-100 rounded-[2rem] sm:rounded-[2.5rem] transform -rotate-2">
                        </div>
                        <div
                            class="absolute -bottom-3 -right-3 sm:-bottom-4 sm:-right-4 w-full h-full bg-slate-100 rounded-[2rem] sm:rounded-[2.5rem] transform rotate-2">
                        </div>

                        {{-- Main Image --}}
                        <div
                            class="relative rounded-2xl sm:rounded-[2rem] overflow-hidden shadow-2xl border-4 border-white group">
                            <img src="images/hero1.png" alt="Tim AgriSmart"
                                class="w-full h-auto object-cover grayscale group-hover:grayscale-0 transition-all duration-700 scale-100 group-hover:scale-105">

                            {{-- Overlay Gradient --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-green-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </div>
                    </div>

                    {{-- CONTENT SIDE (RIGHT) --}}
                    <div data-aos="fade-left" class="px-4 sm:px-0">
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-green-50 text-green-700 text-xs font-bold uppercase tracking-widest mb-4 border border-green-100">
                            Mengapa AgriSmart?
                        </span>

                        <h2
                            class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-900 mb-4 lg:mb-6 leading-tight">
                            Membangun Masa Depan <span class="text-green-600 relative inline-block">
                                Pertanian
                                <svg class="absolute -bottom-1 lg:-bottom-2 left-0 w-full h-2 lg:h-3"
                                    viewBox="0 0 100 10" preserveAspectRatio="none">
                                    <path d="M0 8 Q 50 0, 100 8" stroke="#10b981" stroke-width="2" fill="none"
                                        opacity="0.3" />
                                </svg>
                            </span>
                        </h2>

                        <p class="text-base lg:text-lg text-slate-600 leading-relaxed mb-6 lg:mb-8">
                            AgriSmart hadir untuk menjembatani kesenjangan teknologi bagi petani Indonesia. Kami percaya
                            bahwa dengan akses yang tepat terhadap teknologi IoT dan pasar digital, kesejahteraan petani
                            dapat meningkat pesat. Platform kami dirancang untuk memberikan solusi terintegrasi dari
                            hulu hingga hilir.
                        </p>

                        {{-- Feature List --}}
                        <ul class="space-y-3 lg:space-y-4">
                            <li
                                class="flex items-start gap-3 lg:gap-4 p-4 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all duration-300 group">
                                <div
                                    class="w-10 h-10 lg:w-12 lg:h-12 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-base lg:text-lg">Transparansi Harga</h4>
                                    <p class="text-xs lg:text-sm text-slate-500 mt-1 leading-relaxed">Jaminan harga adil
                                        untuk petani dan konsumen dengan sistem yang terbuka dan terpercaya.</p>
                                </div>
                            </li>

                            <li
                                class="flex items-start gap-3 lg:gap-4 p-4 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all duration-300 group">
                                <div
                                    class="w-10 h-10 lg:w-12 lg:h-12 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M12 14c.5-1.5 1.5-2.5 2.5-2.5S16 12 16 13s-1 2-2 2-2-1-2-1z"
                                            transform="translate(-2 -1) scale(0.8)"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-base lg:text-lg">Teknologi Berkelanjutan
                                    </h4>
                                    <p class="text-xs lg:text-sm text-slate-500 mt-1 leading-relaxed">Solusi ramah
                                        lingkungan untuk jangka panjang demi masa depan pertanian yang lebih baik dan
                                        berkelanjutan.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- VISI MISI SECTION --}}
        {{-- SECTION 1: VISI & MISI --}}
        <section class="py-20 lg:py-28 relative bg-white overflow-hidden">

            {{-- 1. BACKGROUND DECORATION (CLEAN - NO SPIRAL) --}}
            {{-- Hanya menyisakan blob warna halus agar "style welcome" tetap terasa tapi bersih --}}
            <div class="absolute top-0 right-0 w-72 sm:w-96 h-72 sm:h-96 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"
                aria-hidden="true"></div>
            <div class="absolute bottom-0 left-0 w-72 sm:w-96 h-72 sm:h-96 bg-emerald-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"
                aria-hidden="true"></div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">

                {{-- 2. HEADER SECTION (JUDUL STYLE WELCOME) --}}
                <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">

                    {{-- Main Title --}}
                    <h2 class="text-3xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Visi & Misi <span class="text-green-600">AgriSmart</span>
                    </h2>
                </div>

                {{-- 3. CONTENT (CARDS GRID - TETAP ADA) --}}
                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12">

                    {{-- VISI Card --}}
                    <div data-aos="fade-right" data-aos-delay="100" class="h-full">
                        <div
                            class="h-full bg-white rounded-[2rem] p-10 border border-green-100 shadow-sm hover:shadow-xl hover:border-green-300 transition-all duration-300 flex flex-col hover:-translate-y-1">

                            <div class="flex items-center gap-5 mb-8">
                                <div
                                    class="flex-shrink-0 w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center border border-green-100 text-green-600">
                                    {{-- Icon: Chart --}}
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <h3 class="text-3xl font-bold text-slate-900">Visi</h3>
                            </div>

                            <p class="text-lg text-slate-600 leading-relaxed font-medium flex-grow">
                                Menjadi platform pertanian digital terdepan di Indonesia yang mendorong transformasi
                                pertanian tradisional menuju <span class="text-green-600 font-bold">pertanian 4.0
                                    berkelanjutan</span>, meningkatkan kesejahteraan petani,
                                dan menjamin ketahanan pangan nasional.
                            </p>
                        </div>
                    </div>

                    {{-- MISI Card --}}
                    <div data-aos="fade-left" data-aos-delay="200" class="h-full">
                        <div
                            class="h-full bg-white rounded-[2rem] p-10 border border-green-100 shadow-sm hover:shadow-xl hover:border-green-300 transition-all duration-300 flex flex-col hover:-translate-y-1">

                            <div class="flex items-center gap-5 mb-8">
                                <div
                                    class="flex-shrink-0 w-14 h-14 bg-emerald-50 rounded-xl flex items-center justify-center border border-emerald-100 text-emerald-600">
                                    {{-- Icon: Rocket --}}
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 4.493 0 004.306-1.757M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-3xl font-bold text-slate-900">Misi</h3>
                            </div>

                            <ul class="space-y-5">
                                <li class="flex items-start gap-4">
                                    <span
                                        class="flex-shrink-0 w-6 h-6 rounded-full bg-green-100 text-green-600 text-xs font-bold flex items-center justify-center mt-0.5">1</span>
                                    <p class="text-slate-600">Mengintegrasikan teknologi IoT dan data analytics untuk
                                        optimalisasi produksi pertanian.</p>
                                </li>
                                <li class="flex items-start gap-4">
                                    <span
                                        class="flex-shrink-0 w-6 h-6 rounded-full bg-green-100 text-green-600 text-xs font-bold flex items-center justify-center mt-0.5">2</span>
                                    <p class="text-slate-600">Membangun ekosistem marketplace yang adil dan transparan
                                        bagi petani dan konsumen.</p>
                                </li>
                                <li class="flex items-start gap-4">
                                    <span
                                        class="flex-shrink-0 w-6 h-6 rounded-full bg-green-100 text-green-600 text-xs font-bold flex items-center justify-center mt-0.5">3</span>
                                    <p class="text-slate-600">Menyediakan akses edukasi dan pelatihan berkelanjutan
                                        untuk peningkatan kapasitas petani.</p>
                                </li>
                                <li class="flex items-start gap-4">
                                    <span
                                        class="flex-shrink-0 w-6 h-6 rounded-full bg-green-100 text-green-600 text-xs font-bold flex items-center justify-center mt-0.5">4</span>
                                    <p class="text-slate-600">Mendorong praktik pertanian berkelanjutan dan ramah
                                        lingkungan.</p>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- SECTION 2: NILAI UTAMA --}}
        <section class="py-20 lg:py-28 relative bg-white overflow-hidden">

            {{-- 1. BACKGROUND DECORATION (CLEAN - NO SPIRAL) --}}
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-72 sm:w-96 h-72 sm:h-96 bg-teal-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"
                aria-hidden="true"></div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">

                {{-- 2. HEADER SECTION (JUDUL SAJA) --}}
                <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">

                    <h2 class="text-3xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Nilai Utama <span class="text-green-600">AgriSmart</span>
                    </h2>
                </div>

                {{-- 3. CONTENT (CARDS GRID 4 KOLOM) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">

                    {{-- Card 1: Berkelanjutan --}}
                    <div data-aos="fade-up" data-aos-delay="0" class="h-full">
                        <div
                            class="h-full bg-white rounded-[2rem] p-8 border border-green-100 shadow-sm hover:shadow-xl hover:border-green-300 transition-all duration-300 flex flex-col items-center text-center hover:-translate-y-1">

                            <div
                                class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center border border-green-100 text-green-600 mb-6">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>

                            <h3 class="text-xl font-bold text-slate-900 mb-3">Berkelanjutan</h3>
                            <p class="text-slate-600 leading-relaxed font-medium text-sm">
                                Menjaga keseimbangan ekosistem alam demi masa depan pertanian yang lestari.
                            </p>
                        </div>
                    </div>

                    {{-- Card 2: Integritas --}}
                    <div data-aos="fade-up" data-aos-delay="100" class="h-full">
                        <div
                            class="h-full bg-white rounded-[2rem] p-8 border border-green-100 shadow-sm hover:shadow-xl hover:border-green-300 transition-all duration-300 flex flex-col items-center text-center hover:-translate-y-1">

                            <div
                                class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center border border-green-100 text-green-600 mb-6">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>

                            <h3 class="text-xl font-bold text-slate-900 mb-3">Integritas</h3>
                            <p class="text-slate-600 leading-relaxed font-medium text-sm">
                                Mengutamakan kejujuran, transparansi, dan kepercayaan dalam setiap kemitraan.
                            </p>
                        </div>
                    </div>

                    {{-- Card 3: Inovasi --}}
                    <div data-aos="fade-up" data-aos-delay="200" class="h-full">
                        <div
                            class="h-full bg-white rounded-[2rem] p-8 border border-green-100 shadow-sm hover:shadow-xl hover:border-green-300 transition-all duration-300 flex flex-col items-center text-center hover:-translate-y-1">

                            <div
                                class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center border border-green-100 text-green-600 mb-6">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                    </path>
                                </svg>
                            </div>

                            <h3 class="text-xl font-bold text-slate-900 mb-3">Inovasi</h3>
                            <p class="text-slate-600 leading-relaxed font-medium text-sm">
                                Terus beradaptasi dan menciptakan solusi teknologi terbaru untuk petani modern.
                            </p>
                        </div>
                    </div>

                    {{-- Card 4: Empati --}}
                    <div data-aos="fade-up" data-aos-delay="300" class="h-full">
                        <div
                            class="h-full bg-white rounded-[2rem] p-8 border border-green-100 shadow-sm hover:shadow-xl hover:border-green-300 transition-all duration-300 flex flex-col items-center text-center hover:-translate-y-1">

                            <div
                                class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center border border-green-100 text-green-600 mb-6">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </div>

                            <h3 class="text-xl font-bold text-slate-900 mb-3">Empati</h3>
                            <p class="text-slate-600 leading-relaxed font-medium text-sm">
                                Mendengar dan memahami kebutuhan petani adalah inti dari setiap langkah kami.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    {{-- FOOTER (sama seperti di index.blade.php) --}}
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
                        @foreach(['Beranda' => '/', 'Tentang Kami' => 'tentang.index', 'Layanan' => '#layanan', 'Produk' => route('produk.index'), 'Kontak' => '#kontak'] as $label => $link)
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