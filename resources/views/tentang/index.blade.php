<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <!-- ========== META TAGS DAN ENCODING ========== -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ========== SEO META TAGS ========== -->
    <meta name="description"
        content="Tentang AgriSmart - Platform pertanian cerdas Indonesia. Pelajari visi, misi, dan tujuan kami dalam membangun ekosistem pertanian berkelanjutan.">
    <meta name="keywords"
        content="Tentang AgriSmart, Visi Misi Pertanian, Sejarah AgriSmart, Platform Pertanian Indonesia">
    <meta property="og:title" content="Tentang Kami - {{ config('app.name', 'AgriSmart') }}">
    <meta property="og:description"
        content="Mengenal lebih dekat AgriSmart dan komitmen kami untuk pertanian Indonesia.">
    <meta property="og:image" content="{{ asset('images/hero1.png') }}">

    <!-- ========== FAVICON DAN TITLE ========== -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>Tentang Kami - {{ config('app.name', 'AgriSmart') }}</title>

    <!-- ========== FONT MODERN: Plus Jakarta Sans ========== -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- ========== LIBRARY ANIMASI AOS ========== -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- ========== TAILWIND & SCRIPTS ========== -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- ========== CUSTOM STYLES ========== -->
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Utility class untuk AlpineJS */
        [x-cloak] {
            display: none !important;
        }

        /* ========== SCROLLBAR GREEN THEME ========== */
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

        /* ========== CUSTOM ANIMATION UTILITIES ========== */
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

        /* ========== TEXT TRUNCATION UTILITIES ========== */
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

        /* ========== BLOB ANIMATION ========== */
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

    <!-- ========== NAVBAR COMPONENT ========== -->
    <x-navbar />

    <!-- ========== MAIN CONTENT ========== -->
    <main class="flex-1">

        <!-- ========== HERO SECTION ========== -->
        <section class="relative overflow-hidden pt-20 pb-12 lg:pt-28 lg:pb-16 bg-slate-50">
            <!-- Background Spin Animation -->
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="w-[300px] h-[300px] sm:w-[600px] sm:h-[600px] lg:w-[800px] lg:h-[800px] opacity-5">
                    <div class="w-full h-full animate-[spin_30s_linear_infinite]">
                        <img src="images/nav-logo.png" alt="Background Decorative" class="w-full h-full object-contain">
                    </div>
                </div>
            </div>

            <!-- Hero Content -->
            <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
                <div class="text-center" data-aos="fade-up">
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-green-100/50 text-green-700 text-[10px] sm:text-xs font-bold tracking-wider uppercase mb-3 border border-green-200/50 shadow-sm">
                        Tentang Kami
                    </span>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-slate-900 mb-4 sm:mb-6">
                        Tentang
                        <span class="text-green-600">
                            AgriSmart
                        </span>
                    </h2>
                    <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto px-2">
                        Mengenal lebih dekat tentang AgriSmart
                    </p>
                </div>
            </div>
        </section>

        <!-- ========== TENTANG KAMI SECTION ========== -->
        <section class="py-12 sm:py-16 lg:py-24 bg-white overflow-hidden">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
                <!-- Grid Layout: Image dan Konten -->
                <div class="grid lg:grid-cols-2 gap-8 sm:gap-12 lg:gap-16 items-center">

                    <!-- ========== IMAGE SIDE (KIRI) ========== -->
                    <div class="relative px-2 sm:px-0" data-aos="fade-right">
                        <!-- Decorative Backdrops -->
                        <div
                            class="absolute -top-3 -left-3 sm:-top-4 sm:-left-4 w-full h-full bg-green-100 rounded-[1.5rem] sm:rounded-[2.5rem] transform -rotate-2">
                        </div>
                        <div
                            class="absolute -bottom-3 -right-3 sm:-bottom-4 sm:-right-4 w-full h-full bg-slate-100 rounded-[1.5rem] sm:rounded-[2.5rem] transform rotate-2">
                        </div>

                        <!-- Main Image -->
                        <div
                            class="relative rounded-2xl sm:rounded-[2rem] overflow-hidden shadow-2xl border-4 border-white group">
                            <img src="images/hero1.png" alt="Tim AgriSmart"
                                class="w-full h-auto object-cover grayscale group-hover:grayscale-0 transition-all duration-700 scale-100 group-hover:scale-105">

                            <!-- Overlay Gradient Effect -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-green-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </div>
                    </div>

                    <!-- ========== CONTENT SIDE (KANAN) ========== -->
                    <div data-aos="fade-left" class="px-2 sm:px-0">
                        <!-- Section Badge -->
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-green-50 text-green-700 text-[10px] sm:text-xs font-bold uppercase tracking-widest mb-3 sm:mb-4 border border-green-100">
                            Mengapa AgriSmart?
                        </span>

                        <!-- Main Title -->
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

                        <!-- Description -->
                        <p class="text-sm sm:text-base lg:text-lg text-slate-600 leading-relaxed mb-6 lg:mb-8">
                            AgriSmart hadir untuk menjembatani kesenjangan teknologi bagi petani Indonesia. Kami percaya
                            bahwa dengan akses yang tepat terhadap teknologi IoT dan pasar digital, kesejahteraan petani
                            dapat meningkat pesat. Platform kami dirancang untuk memberikan solusi terintegrasi dari
                            hulu hingga hilir.
                        </p>

                        <!-- ========== FEATURE LIST ========== -->
                        <ul class="space-y-3 lg:space-y-4">
                            <!-- Fitur 1: Transparansi Harga -->
                            <li
                                class="flex items-start gap-3 lg:gap-4 p-3 sm:p-4 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all duration-300 group">
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
                                    <h4 class="font-bold text-slate-900 text-sm sm:text-base lg:text-lg">Transparansi
                                        Harga</h4>
                                    <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">Jaminan harga adil
                                        untuk petani dan konsumen dengan sistem yang terbuka dan terpercaya.</p>
                                </div>
                            </li>

                            <!-- Fitur 2: Teknologi Berkelanjutan -->
                            <li
                                class="flex items-start gap-3 lg:gap-4 p-3 sm:p-4 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all duration-300 group">
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
                                    <h4 class="font-bold text-slate-900 text-sm sm:text-base lg:text-lg">Teknologi
                                        Berkelanjutan
                                    </h4>
                                    <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">Solusi ramah
                                        lingkungan untuk jangka panjang demi masa depan pertanian yang lebih baik dan
                                        berkelanjutan.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========== VISI MISI SECTION ========== -->
        <section class="py-16 lg:py-28 relative bg-white overflow-hidden">

            <!-- ========== BACKGROUND DECORATION ========== -->
            <div class="absolute top-0 right-0 w-48 sm:w-72 lg:w-96 h-48 sm:h-72 lg:h-96 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"
                aria-hidden="true"></div>
            <div class="absolute bottom-0 left-0 w-48 sm:w-72 lg:w-96 h-48 sm:h-72 lg:h-96 bg-emerald-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"
                aria-hidden="true"></div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">

                <!-- ========== SECTION HEADER ========== -->
                <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-16" data-aos="fade-up">
                    <h2
                        class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Visi & Misi <span class="text-green-600">AgriSmart</span>
                    </h2>
                </div>

                <!-- ========== VISI & MISI CONTENT ========== -->
                <div class="grid lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-12">

                    <!-- ========== VISI CARD ========== -->
                    <div data-aos="fade-right" data-aos-delay="100" class="h-full">
                        <div
                            class="h-full bg-white rounded-3xl sm:rounded-[2rem] p-6 sm:p-8 lg:p-10 border border-green-100 shadow-sm hover:shadow-xl hover:border-green-300 transition-all duration-300 flex flex-col hover:-translate-y-1">

                            <!-- Card Header -->
                            <div class="flex items-center gap-4 sm:gap-5 mb-6 sm:mb-8">
                                <div
                                    class="flex-shrink-0 w-12 h-12 sm:w-14 sm:h-14 bg-green-50 rounded-xl flex items-center justify-center border border-green-100 text-green-600">
                                    <!-- Icon: Chart -->
                                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl sm:text-3xl font-bold text-slate-900">Visi</h3>
                            </div>

                            <!-- Visi Content -->
                            <p class="text-base sm:text-lg text-slate-600 leading-relaxed font-medium flex-grow">
                                Menjadi platform pertanian digital terdepan di Indonesia yang mendorong transformasi
                                pertanian tradisional menuju <span class="text-green-600 font-bold">pertanian 4.0
                                    berkelanjutan</span>, meningkatkan kesejahteraan petani,
                                dan menjamin ketahanan pangan nasional.
                            </p>
                        </div>
                    </div>

                    <!-- ========== MISI CARD ========== -->
                    <div data-aos="fade-left" data-aos-delay="200" class="h-full">
                        <div
                            class="h-full bg-white rounded-3xl sm:rounded-[2rem] p-6 sm:p-8 lg:p-10 border border-green-100 shadow-sm hover:shadow-xl hover:border-green-300 transition-all duration-300 flex flex-col hover:-translate-y-1">

                            <!-- Card Header -->
                            <div class="flex items-center gap-4 sm:gap-5 mb-6 sm:mb-8">
                                <div
                                    class="flex-shrink-0 w-12 h-12 sm:w-14 sm:h-14 bg-emerald-50 rounded-xl flex items-center justify-center border border-emerald-100 text-emerald-600">
                                    <!-- Icon: Rocket -->
                                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.757M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl sm:text-3xl font-bold text-slate-900">Misi</h3>
                            </div>

                            <!-- Misi List -->
                            <ul class="space-y-4 sm:space-y-5">
                                <li class="flex items-start gap-3 sm:gap-4">
                                    <span
                                        class="flex-shrink-0 w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-green-100 text-green-600 text-[10px] sm:text-xs font-bold flex items-center justify-center mt-0.5">1</span>
                                    <p class="text-sm sm:text-base text-slate-600">Mengintegrasikan teknologi IoT dan
                                        data analytics untuk
                                        optimalisasi produksi pertanian.</p>
                                </li>
                                <li class="flex items-start gap-3 sm:gap-4">
                                    <span
                                        class="flex-shrink-0 w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-green-100 text-green-600 text-[10px] sm:text-xs font-bold flex items-center justify-center mt-0.5">2</span>
                                    <p class="text-sm sm:text-base text-slate-600">Membangun ekosistem marketplace yang
                                        adil dan transparan
                                        bagi petani dan konsumen.</p>
                                </li>
                                <li class="flex items-start gap-3 sm:gap-4">
                                    <span
                                        class="flex-shrink-0 w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-green-100 text-green-600 text-[10px] sm:text-xs font-bold flex items-center justify-center mt-0.5">3</span>
                                    <p class="text-sm sm:text-base text-slate-600">Menyediakan akses edukasi dan
                                        pelatihan berkelanjutan
                                        untuk peningkatan kapasitas petani.</p>
                                </li>
                                <li class="flex items-start gap-3 sm:gap-4">
                                    <span
                                        class="flex-shrink-0 w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-green-100 text-green-600 text-[10px] sm:text-xs font-bold flex items-center justify-center mt-0.5">4</span>
                                    <p class="text-sm sm:text-base text-slate-600">Mendorong praktik pertanian
                                        berkelanjutan dan ramah
                                        lingkungan.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========== NILAI UTAMA SECTION ========== -->
        <section class="py-16 lg:py-28 relative bg-white overflow-hidden">

            <!-- Background Decoration -->
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-48 sm:w-72 lg:w-96 h-48 sm:h-72 lg:h-96 bg-teal-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"
                aria-hidden="true"></div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">

                <!-- ========== SECTION HEADER ========== -->
                <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-16" data-aos="fade-up">
                    <h2
                        class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Nilai Utama <span class="text-green-600">AgriSmart</span>
                    </h2>
                </div>

                <!-- ========== NILAI UTAMA GRID ========== -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">

                    <!-- Card 1: Berkelanjutan -->
                    <div data-aos="fade-up" data-aos-delay="0" class="h-full">
                        <div
                            class="h-full bg-white rounded-3xl sm:rounded-[2rem] p-6 sm:p-8 border border-green-100 shadow-sm hover:shadow-xl hover:border-green-300 transition-all duration-300 flex flex-col items-center text-center hover:-translate-y-1">

                            <!-- Icon -->
                            <div
                                class="w-12 h-12 sm:w-14 sm:h-14 bg-green-50 rounded-xl flex items-center justify-center border border-green-100 text-green-600 mb-4 sm:mb-6">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>

                            <!-- Title & Description -->
                            <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2 sm:mb-3">Berkelanjutan</h3>
                            <p class="text-slate-600 leading-relaxed font-medium text-xs sm:text-sm">
                                Menjaga keseimbangan ekosistem alam demi masa depan pertanian yang lestari.
                            </p>
                        </div>
                    </div>

                    <!-- Card 2: Integritas -->
                    <div data-aos="fade-up" data-aos-delay="100" class="h-full">
                        <div
                            class="h-full bg-white rounded-3xl sm:rounded-[2rem] p-6 sm:p-8 border border-green-100 shadow-sm hover:shadow-xl hover:border-green-300 transition-all duration-300 flex flex-col items-center text-center hover:-translate-y-1">

                            <!-- Icon -->
                            <div
                                class="w-12 h-12 sm:w-14 sm:h-14 bg-green-50 rounded-xl flex items-center justify-center border border-green-100 text-green-600 mb-4 sm:mb-6">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>

                            <!-- Title & Description -->
                            <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2 sm:mb-3">Integritas</h3>
                            <p class="text-slate-600 leading-relaxed font-medium text-xs sm:text-sm">
                                Mengutamakan kejujuran, transparansi, dan kepercayaan dalam setiap kemitraan.
                            </p>
                        </div>
                    </div>

                    <!-- Card 3: Inovasi -->
                    <div data-aos="fade-up" data-aos-delay="200" class="h-full">
                        <div
                            class="h-full bg-white rounded-3xl sm:rounded-[2rem] p-6 sm:p-8 border border-green-100 shadow-sm hover:shadow-xl hover:border-green-300 transition-all duration-300 flex flex-col items-center text-center hover:-translate-y-1">

                            <!-- Icon -->
                            <div
                                class="w-12 h-12 sm:w-14 sm:h-14 bg-green-50 rounded-xl flex items-center justify-center border border-green-100 text-green-600 mb-4 sm:mb-6">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                    </path>
                                </svg>
                            </div>

                            <!-- Title & Description -->
                            <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2 sm:mb-3">Inovasi</h3>
                            <p class="text-slate-600 leading-relaxed font-medium text-xs sm:text-sm">
                                Terus beradaptasi dan menciptakan solusi teknologi terbaru untuk petani modern.
                            </p>
                        </div>
                    </div>

                    <!-- Card 4: Empati -->
                    <div data-aos="fade-up" data-aos-delay="300" class="h-full">
                        <div
                            class="h-full bg-white rounded-3xl sm:rounded-[2rem] p-6 sm:p-8 border border-green-100 shadow-sm hover:shadow-xl hover:border-green-300 transition-all duration-300 flex flex-col items-center text-center hover:-translate-y-1">

                            <!-- Icon -->
                            <div
                                class="w-12 h-12 sm:w-14 sm:h-14 bg-green-50 rounded-xl flex items-center justify-center border border-green-100 text-green-600 mb-4 sm:mb-6">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </div>

                            <!-- Title & Description -->
                            <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2 sm:mb-3">Empati</h3>
                            <p class="text-slate-600 leading-relaxed font-medium text-xs sm:text-sm">
                                Mendengar dan memahami kebutuhan petani adalah inti dari setiap langkah kami.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- ========== FOOTER SECTION ========== -->
    <x-footer />

    <!-- ========== BACK TO TOP BUTTON ========== -->
    <x-back-button />

    <!-- ========== SCRIPT INITIALIZATION ========== -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi AOS (Animate On Scroll)
        AOS.init({
            once: true,
            offset: 50,
            duration: 800,
        });
    </script>
</body>

</html>