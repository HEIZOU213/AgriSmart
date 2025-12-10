<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO META TAGS --}}
    <meta name="description"
        content="Platform Pertanian Cerdas Masa Depan. Tingkatkan hasil panen dengan teknologi IoT dan akses pasar langsung.">
    <meta name="keywords" content="Pertanian, IoT, AgriSmart, Petani Digital, Marketplace Tani">
    <meta property="og:title" content="{{ config('app.name', 'AgriSmart') }} - Pertanian Cerdas">
    <meta property="og:description" content="Solusi IoT pertanian terintegrasi dari hulu ke hilir.">
    <meta property="og:image" content="{{ asset('images/hero1.png') }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <title>{{ config('app.name', 'AgriSmart') }}</title>

    {{-- FONT MODERN: Plus Jakarta Sans --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- LIBRARY ANIMASI AOS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- TAILWIND & SCRIPTS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
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

        /* Slow Spin */
        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin-slow {
            animation: spin-slow 20s linear infinite;
        }
    </style>
</head>

<body
    class="font-sans antialiased text-slate-700 bg-green-50 flex flex-col min-h-screen selection:bg-green-500 selection:text-white">

    {{-- NAVBAR --}}
    <x-navbar />

    {{-- MAIN CONTENT --}}
    <main class="flex-1">

        {{-- 1. HERO SECTION & STATS MERGED --}}
        <section class="relative bg-white overflow-hidden pt-24 pb-16 lg:pt-40 lg:pb-24">

            {{-- Background Pattern & Blobs --}}
            <div
                class="absolute inset-0 bg-[radial-gradient(#dcfce7_1px,transparent_1px)] [background-size:24px_24px] opacity-40 z-0">
            </div>

            <div
                class="absolute top-0 right-0 -mr-12 -mt-12 w-48 h-48 sm:w-64 sm:h-64 md:-mr-20 md:-mt-20 md:w-96 md:h-96 rounded-full bg-green-100 opacity-60 blur-[50px] md:blur-[80px] pointer-events-none">
            </div>

            <div
                class="absolute bottom-0 left-0 -ml-10 -mb-10 md:-ml-20 md:-mb-20 w-64 h-64 md:w-80 md:h-80 rounded-full bg-emerald-100 opacity-60 blur-[60px] md:blur-[80px]">
            </div>

            {{-- UPDATED WIDTH: max-w-7xl --}}
            <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                {{-- A. HERO CONTENT --}}
                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center mb-16 lg:mb-20">

                    {{-- Left Content --}}
                    <div data-aos="fade-right" data-aos-duration="1000" class="px-2 sm:px-0">
                        <div
                            class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 rounded-full border border-green-200 text-green-800 mb-6 lg:mb-8 shadow-sm">
                            <span class="flex h-2.5 w-2.5 rounded-full bg-green-600 animate-pulse"></span>
                            <span class="text-xs font-bold tracking-wide uppercase">Platform Pertanian No.1</span>
                        </div>

                        <h1
                            class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-extrabold text-slate-900 leading-tight mb-4 lg:mb-6 tracking-tight">
                            Pertanian Cerdas <br>
                            <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-600">Masa
                                Depan.</span>
                        </h1>

                        <p
                            class="text-base sm:text-lg text-slate-600 mb-8 lg:mb-10 leading-relaxed max-w-xl font-medium">
                            Tingkatkan hasil panen dengan teknologi IoT, akses pasar langsung tanpa perantara, dan
                            edukasi dari para ahli. Semua dalam satu genggaman.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-3 lg:gap-4">
                            <a href="{{ route('produk.index') }}"
                                class="inline-flex justify-center items-center px-6 lg:px-8 py-3 lg:py-4 bg-green-600 text-white font-extrabold rounded-xl shadow-lg shadow-green-600/20 hover:bg-green-700 hover:scale-105 transition-all duration-300 text-sm lg:text-base">
                                Mulai Sekarang
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                            <a href="#video"
                                class="inline-flex justify-center items-center px-6 lg:px-8 py-3 lg:py-4 border-2 border-green-600 text-green-600 font-bold rounded-xl hover:bg-green-50 transition-all duration-300 text-sm lg:text-base">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Tonton Video
                            </a>
                        </div>
                    </div>

                    {{-- Right Image --}}
                    <div class="relative hidden lg:block" data-aos="fade-left" data-aos-duration="1200">
                        <div class="relative w-full max-w-lg mx-auto animate-float">
                            <div
                                class="absolute top-10 -right-10 w-full h-full bg-green-200 rounded-[2.5rem] opacity-60 rotate-6 mix-blend-multiply">
                            </div>
                            <div
                                class="absolute -bottom-5 -left-5 w-full h-full bg-emerald-200 rounded-[2.5rem] opacity-60 -rotate-3 mix-blend-multiply">
                            </div>
                            <div
                                class="relative rounded-[2rem] overflow-hidden shadow-2xl border-[6px] border-white ring-1 ring-slate-100">
                                <img src="images/hero1.png" alt="Dashboard Pertanian"
                                    class="w-full h-auto object-cover transform hover:scale-105 transition-transform duration-700">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        {{-- 3. LAYANAN SECTION --}}
        <section id="layanan" class="py-16 sm:py-20 lg:py-32 relative overflow-hidden bg-[#F0FDF4]">

            {{-- Spiral Background Pattern --}}
            <div class="absolute inset-0 opacity-20 pointer-events-none">
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 800"
                    preserveAspectRatio="xMidYMid slice">
                    <path d="M 720 400 Q 800 300, 900 350 T 1050 450 T 1150 600 T 1200 800" stroke="#10b981"
                        stroke-width="3" fill="none" opacity="0.3" />
                    <path d="M 300 200 Q 400 150, 500 200 T 650 300 T 750 450 T 800 650" stroke="#10b981"
                        stroke-width="2.5" fill="none" opacity="0.2" />
                    <path d="M 100 500 Q 150 480, 180 510 T 220 580 T 240 660" stroke="#10b981" stroke-width="2"
                        fill="none" opacity="0.15" />
                    <path d="M 1200 150 Q 1250 120, 1300 160 T 1350 240 T 1380 340" stroke="#14b8a6" stroke-width="2"
                        fill="none" opacity="0.15" />
                    <path d="M 0 400 Q 360 300, 720 400 T 1440 400" stroke="#059669" stroke-width="1.5" fill="none"
                        opacity="0.1" />
                    <path d="M 0 600 Q 360 550, 720 600 T 1440 600" stroke="#10b981" stroke-width="1.5" fill="none"
                        opacity="0.1" />
                </svg>
            </div>

            {{-- Decorative Blobs --}}
            <div class="absolute top-0 right-0 w-72 sm:w-96 h-72 sm:h-96 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"
                aria-hidden="true"></div>
            <div class="absolute bottom-0 left-0 w-72 sm:w-96 h-72 sm:h-96 bg-emerald-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"
                aria-hidden="true"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-72 sm:w-96 h-72 sm:h-96 bg-teal-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"
                aria-hidden="true"></div>

            {{-- UPDATED WIDTH: max-w-7xl --}}
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">

                {{-- Header --}}
                <div class="text-center mb-12 lg:mb-16 max-w-3xl mx-auto" data-aos="fade-up">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white text-green-800 text-xs sm:text-sm font-bold uppercase tracking-widest border border-green-200 mb-4 sm:mb-6 shadow-sm">
                        <span>Fitur Unggulan</span>
                    </div>

                    <h2
                        class="text-2xl sm:text-3xl md:text-4xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4 sm:mb-6">
                        Ekosistem <span class="text-green-600">AgriSmart</span>
                    </h2>

                    <p class="text-base sm:text-lg lg:text-xl text-slate-600 font-medium leading-relaxed">
                        Teknologi terintegrasi dari hulu ke hilir untuk hasil maksimal.
                    </p>
                </div>

                {{-- Cards Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">

                    {{-- Card 1: IoT --}}
                    <div data-aos="fade-up" data-aos-delay="100"
                        class="group relative bg-white rounded-3xl p-6 sm:p-8 shadow-lg border border-green-100 hover:border-green-500 hover:shadow-xl hover:shadow-green-500/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden">
                        <div class="relative z-10">
                            <div
                                class="w-16 h-16 sm:w-18 sm:h-18 bg-green-50 rounded-2xl flex items-center justify-center mb-6 text-green-600 group-hover:scale-110 group-hover:bg-green-600 group-hover:text-white transition-all duration-500">
                                <svg class="w-8 h-8 sm:w-9 sm:h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full mb-4 border border-green-200">Real-time</span>
                            <h3
                                class="text-xl sm:text-2xl font-bold text-slate-900 mb-3 group-hover:text-green-700 transition-colors duration-300">
                                Monitoring IoT</h3>
                            <p class="text-slate-600 leading-relaxed mb-6 text-sm sm:text-base">Pantau kelembaban, suhu,
                                dan nutrisi tanah secara realtime melalui dashboard pintar berbasis AI.</p>

                            {{-- Simple Button: No Border/Line --}}
                            <a href="#"
                                class="inline-flex items-center gap-2 text-green-600 font-bold text-sm sm:text-base hover:text-green-800 transition-colors duration-300 group/link">
                                <span>Lihat Dashboard</span>
                                <svg class="w-5 h-5 group-hover/link:translate-x-1 transition-transform duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Card 2: Produk --}}
                    <div data-aos="fade-up" data-aos-delay="200"
                        class="group relative bg-white rounded-3xl p-6 sm:p-8 shadow-lg border border-green-100 hover:border-emerald-500 hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden">
                        <div class="relative z-10">
                            <div
                                class="w-16 h-16 sm:w-18 sm:h-18 bg-emerald-50 rounded-2xl flex items-center justify-center mb-6 text-emerald-600 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500">
                                <svg class="w-8 h-8 sm:w-9 sm:h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="inline-block px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full mb-4 border border-emerald-200">Direct
                                Trade</span>
                            <h3
                                class="text-xl sm:text-2xl font-bold text-slate-900 mb-3 group-hover:text-emerald-700 transition-colors duration-300">
                                Marketplace Tani</h3>
                            <p class="text-slate-600 leading-relaxed mb-6 text-sm sm:text-base">Jual beli hasil panen
                                berkualitas langsung dari petani lokal dengan harga transparan dan adil.</p>

                            {{-- Simple Button: No Border/Line --}}
                            <a href="{{ route('produk.index') }}"
                                class="inline-flex items-center gap-2 text-emerald-600 font-bold text-sm sm:text-base hover:text-emerald-800 transition-colors duration-300 group/link">
                                <span>Mulai Belanja</span>
                                <svg class="w-5 h-5 group-hover/link:translate-x-1 transition-transform duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Card 3: Edukasi --}}
                    <div data-aos="fade-up" data-aos-delay="300"
                        class="group relative bg-white rounded-3xl p-6 sm:p-8 shadow-lg border border-green-100 hover:border-teal-500 hover:shadow-xl hover:shadow-teal-500/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden md:col-span-2 lg:col-span-1">
                        <div class="relative z-10">
                            <div
                                class="w-16 h-16 sm:w-18 sm:h-18 bg-teal-50 rounded-2xl flex items-center justify-center mb-6 text-teal-600 group-hover:scale-110 group-hover:bg-teal-600 group-hover:text-white transition-all duration-500">
                                <svg class="w-8 h-8 sm:w-9 sm:h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="inline-block px-3 py-1 bg-teal-100 text-teal-700 text-xs font-bold rounded-full mb-4 border border-teal-200">Expert
                                Tips</span>
                            <h3
                                class="text-xl sm:text-2xl font-bold text-slate-900 mb-3 group-hover:text-teal-700 transition-colors duration-300">
                                Edukasi Tani</h3>
                            <p class="text-slate-600 leading-relaxed mb-6 text-sm sm:text-base">Tingkatkan wawasan
                                bertani melalui artikel, video tutorial, dan modul lengkap dari ahli agronomi.</p>

                            {{-- Simple Button: No Border/Line --}}
                            <a href="{{ route('edukasi.index') }}"
                                class="inline-flex items-center gap-2 text-teal-600 font-bold text-sm sm:text-base hover:text-teal-800 transition-colors duration-300 group/link">
                                <span>Baca Artikel</span>
                                <svg class="w-5 h-5 group-hover/link:translate-x-1 transition-transform duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- 4. PRODUCTS SECTION --}}
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

                {{-- Spiral 3: Kecil --}}
                <svg class="absolute top-10 left-0 md:left-10 w-[150px] md:w-[300px] h-[150px] md:h-[300px] opacity-10 rotate-12 -translate-x-1/4 md:translate-x-0"
                    viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 Q 50 10 100 100" stroke="#dcfce7" stroke-width="0.8" fill="none" />
                    <path d="M0 100 Q 50 30 100 100" stroke="#dcfce7" stroke-width="0.8" fill="none" />
                </svg>
            </div>

            {{-- PRODUCT CONTENT (Inner Content) --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                {{-- Header --}}
                <div class="text-center max-w-3xl mx-auto mb-12 lg:mb-16" data-aos="fade-up">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-50 text-green-700 text-[11px] font-bold uppercase tracking-widest border border-green-100 mb-4 lg:mb-5 shadow-sm hover:shadow-md transition-shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Pasar Segar
                    </span>
                    <h2
                        class="text-2xl md:text-3xl lg:text-5xl font-extrabold text-slate-900 leading-tight mb-3 lg:mb-4">
                        Panen <span class="text-green-600 relative inline-block">
                            Terbaik
                            <svg class="absolute -bottom-1 left-0 w-full h-2" viewBox="0 0 100 10"
                                preserveAspectRatio="none">
                                <path d="M0 8 Q 50 0, 100 8" stroke="#10b981" stroke-width="2" fill="none"
                                    opacity="0.3" />
                            </svg>
                        </span>
                    </h2>
                    <p class="text-slate-600 text-sm md:text-base lg:text-lg leading-relaxed px-4 sm:px-0">
                        Hasil pertanian berkualitas langsung dari petani lokal untuk kebutuhan dapur Anda sehari-hari.
                    </p>
                </div>

                @if(isset($produk) && !$produk->isEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 lg:gap-8">
                        @foreach($produk as $index => $item)
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

                    {{-- CTA Button --}}
                    <div class="mt-12 lg:mt-16 text-center" data-aos="fade-up">
                        <a href="{{ route('produk.index') }}"
                            class="group inline-flex items-center gap-2 px-8 lg:px-10 py-3 lg:py-4 rounded-full bg-green-600 text-white font-bold hover:bg-green-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1 text-sm lg:text-base">
                            <span>Lihat Semua Produk</span>
                            <svg class="w-4 h-4 lg:w-5 lg:h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>

                @else
                    {{-- Empty State --}}
                    <div
                        class="text-center py-12 lg:py-20 bg-white/50 backdrop-blur-sm rounded-3xl border-2 border-dashed border-green-200 mx-4 sm:mx-0">
                        <div
                            class="w-20 h-20 lg:w-24 lg:h-24 mx-auto mb-6 bg-white rounded-full flex items-center justify-center shadow-md">
                            <svg class="w-10 h-10 lg:w-12 lg:h-12 text-green-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg lg:text-xl font-bold text-slate-900 mb-2">Produk Belum Tersedia</h3>
                        <p class="text-slate-500 text-sm max-w-md mx-auto px-4">Kami sedang mempersiapkan produk-produk
                            berkualitas untuk Anda. Nantikan segera!</p>
                    </div>
                @endif
            </div>
        </section>

        {{-- 5. EDUCATION SECTION --}}
        <section id="edukasi-preview" class="py-16 lg:py-24 relative overflow-hidden bg-[#F0FDF4]">

            {{-- Enhanced Background Decorations --}}
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                {{-- SVG Wave Pattern --}}
                <div class="absolute inset-0 opacity-20 pointer-events-none">
                    <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 800"
                        preserveAspectRatio="xMidYMid slice">
                        <path d="M 720 400 Q 800 300, 900 350 T 1050 450 T 1150 600 T 1200 800" stroke="#10b981"
                            stroke-width="3" fill="none" opacity="0.3" />
                        <path d="M 300 200 Q 400 150, 500 200 T 650 300 T 750 450 T 800 650" stroke="#10b981"
                            stroke-width="2.5" fill="none" opacity="0.2" />
                        <path d="M 100 500 Q 150 480, 180 510 T 220 580 T 240 660" stroke="#10b981" stroke-width="2"
                            fill="none" opacity="0.15" />
                        <path d="M 1200 150 Q 1250 120, 1300 160 T 1350 240 T 1380 340" stroke="#14b8a6"
                            stroke-width="2" fill="none" opacity="0.15" />
                        <path d="M 0 400 Q 360 300, 720 400 T 1440 400" stroke="#059669" stroke-width="1.5" fill="none"
                            opacity="0.1" />
                        <path d="M 0 600 Q 360 550, 720 600 T 1440 600" stroke="#10b981" stroke-width="1.5" fill="none"
                            opacity="0.1" />
                    </svg>
                </div>

                {{-- Decorative Blobs --}}
                <div class="absolute top-0 right-0 w-72 sm:w-96 h-72 sm:h-96 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"
                    aria-hidden="true"></div>
                <div class="absolute bottom-0 left-0 w-72 sm:w-96 h-72 sm:h-96 bg-emerald-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"
                    aria-hidden="true"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-72 sm:w-96 h-72 sm:h-96 bg-teal-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"
                    aria-hidden="true"></div>
            </div>

            {{-- EDUCATION CONTENT (Inner Content) --}}
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">

                {{-- Header --}}
                <div class="text-center mb-12 lg:mb-20 max-w-3xl mx-auto" data-aos="fade-up">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 lg:px-5 lg:py-2.5 rounded-full bg-white text-green-700 text-xs font-bold uppercase tracking-widest border border-green-200 mb-4 lg:mb-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        Pusat Pengetahuan
                    </span>

                    <h2
                        class="text-2xl sm:text-3xl md:text-4xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4 lg:mb-6">
                        Belajar dari <span class="text-green-600 relative inline-block">
                            Ahlinya
                            <svg class="absolute -bottom-1 lg:-bottom-2 left-0 w-full h-2 lg:h-3" viewBox="0 0 100 10"
                                preserveAspectRatio="none">
                                <path d="M0 8 Q 50 0, 100 8" stroke="#10b981" stroke-width="2" fill="none"
                                    opacity="0.3" />
                            </svg>
                        </span>
                    </h2>

                    <p
                        class="text-base md:text-lg lg:text-xl text-slate-600 mb-8 lg:mb-10 max-w-2xl mx-auto leading-relaxed font-medium px-4 sm:px-0">
                        Perluas wawasan pertanian Anda dengan artikel pilihan, tips budidaya, dan inovasi teknologi
                        terbaru.
                    </p>
                </div>

                {{-- Articles Grid --}}
                @if(isset($edukasi) && !$edukasi->isEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                        @foreach($edukasi as $index => $item)
                            <a href="{{ route('edukasi.show', $item->slug) }}"
                                class="group block {{ $index === 0 ? 'md:col-span-2 md:row-span-2' : '' }}" data-aos="zoom-in"
                                data-aos-delay="{{ $index * 100 }}">

                                {{-- Card Container --}}
                                <div
                                    class="relative h-full bg-gradient-to-br from-white via-white to-green-50 rounded-2xl lg:rounded-[2rem] overflow-hidden shadow-lg hover:shadow-2xl hover:shadow-green-900/10 transition-all duration-500 border border-green-100 hover:border-green-300 group-hover:-translate-y-2">

                                    {{-- Image Area --}}
                                    <div
                                        class="relative h-full min-h-[250px] sm:min-h-[300px] {{ $index === 0 ? 'md:min-h-[400px] lg:min-h-[550px]' : 'lg:min-h-[350px]' }}">
                                        @if($item->foto_sampul)
                                            <img src="{{ asset('storage/' . $item->foto_sampul) }}" alt="{{ $item->judul }}"
                                                class="absolute inset-0 w-full h-full object-cover opacity-95 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700">
                                        @else
                                            <div
                                                class="absolute inset-0 bg-gradient-to-br from-green-50 to-emerald-50 opacity-100 flex items-center justify-center">
                                                <svg class="w-16 h-16 lg:w-20 lg:h-20 text-green-200" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif

                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-green-950/90 via-green-900/30 to-transparent">
                                        </div>

                                        {{-- Content Overlay --}}
                                        <div class="absolute inset-0 p-5 lg:p-8 flex flex-col justify-end">
                                            <div
                                                class="space-y-3 lg:space-y-4 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">

                                                {{-- Meta Info --}}
                                                <div class="flex items-center gap-3">
                                                    <span
                                                        class="px-2 py-1 lg:px-3 lg:py-1 bg-white/90 backdrop-blur-sm text-green-700 text-[10px] font-bold uppercase tracking-wider rounded-full shadow-sm">
                                                        {{ $item->kategoriEdukasi->nama_kategori ?? 'Tips' }}
                                                    </span>
                                                    <span class="text-green-50 text-xs font-semibold tracking-wide">
                                                        {{ $item->created_at->format('d M Y') }}
                                                    </span>
                                                </div>

                                                {{-- Title --}}
                                                <h3
                                                    class="text-xl {{ $index === 0 ? 'lg:text-3xl xl:text-4xl' : 'lg:text-2xl' }} font-bold text-white leading-tight drop-shadow-sm group-hover:text-green-100 transition-colors">
                                                    {{ $item->judul }}
                                                </h3>

                                                {{-- Excerpt (First Item Only) --}}
                                                @if($index === 0)
                                                    <p
                                                        class="text-green-50 text-sm lg:text-base xl:text-lg leading-relaxed line-clamp-2 md:line-clamp-3 opacity-90 group-hover:opacity-100 transition-opacity duration-500 font-medium">
                                                        {{ Str::limit(strip_tags($item->isi_konten), 150) }}
                                                    </p>
                                                @endif

                                                {{-- Read More Link --}}
                                                <div
                                                    class="flex items-center gap-2 text-white font-bold text-sm pt-2 group/link">
                                                    <span class="group-hover:text-green-200 transition-colors">Baca
                                                        Selengkapnya</span>
                                                    <svg class="w-4 h-4 lg:w-5 lg:h-5 group-hover:translate-x-2 group-hover:text-green-200 transition-all"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
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

                {{-- View All Button --}}
                <div class="mt-12 lg:mt-16 text-center">
                    <a href="{{ route('edukasi.index') }}"
                        class="inline-flex items-center justify-center px-6 lg:px-8 py-3 lg:py-4 bg-white border-2 border-green-600 text-green-600 font-bold rounded-full hover:bg-green-50 transition-all duration-300 hover:shadow-lg group text-sm lg:text-base">
                        Lihat Semua Artikel
                        <svg class="w-4 h-4 lg:w-5 lg:h-5 ml-2 group-hover:translate-x-1 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        {{-- 6. TENTANG KAMI SECTION --}}
        <section id="tentang-kami" class="py-16 lg:py-24 bg-white overflow-hidden">
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
                            Tentang Kami
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
                            dapat meningkat pesat.
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
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-base lg:text-lg">Transparansi Harga</h4>
                                    <p class="text-xs lg:text-sm text-slate-500 mt-1 leading-relaxed">Jaminan harga adil
                                        untuk
                                        petani dan konsumen dengan sistem yang terbuka.</p>
                                </div>
                            </li>

                            <li
                                class="flex items-start gap-3 lg:gap-4 p-4 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all duration-300 group">
                                <div
                                    class="w-10 h-10 lg:w-12 lg:h-12 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-base lg:text-lg">Teknologi Berkelanjutan
                                    </h4>
                                    <p class="text-xs lg:text-sm text-slate-500 mt-1 leading-relaxed">Solusi ramah
                                        lingkungan untuk
                                        jangka panjang demi masa depan yang lebih baik.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- 7. CONTACT FORM SECTION --}}
        <section id="kontak" class="py-16 lg:py-24 relative bg-[#F0FDF4] overflow-hidden">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                {{-- 1. HEADER SECTION --}}
                <div class="text-center max-w-3xl mx-auto mb-12 lg:mb-16" data-aos="fade-up">
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white text-green-700 text-xs font-bold uppercase tracking-widest mb-3 lg:mb-4 border border-green-100 shadow-sm">
                        Hubungi Kami
                    </span>
                    <h2
                        class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-900 mb-4 lg:mb-6 leading-tight tracking-tight">
                        Mari Berkolaborasi <br> Bersama
                        <span class="text-green-600 relative inline-block">
                            AgriSmart
                            <svg class="absolute -bottom-1 lg:-bottom-2 left-0 w-full h-2 lg:h-3" viewBox="0 0 100 10"
                                preserveAspectRatio="none">
                                <path d="M0 8 Q 50 0, 100 8" stroke="#10b981" stroke-width="2" fill="none"
                                    opacity="0.3" />
                            </svg>
                        </span>
                    </h2>
                    <p class="text-slate-600 text-base lg:text-lg leading-relaxed font-medium px-4 sm:px-0">
                        Ayo bergabung bersama kami dan menjadi bagian dari Petani Masa Depan. Cukup dengan mengisi
                        formulir untuk memulai langkah besar Anda.
                    </p>
                </div>

                {{-- CONTENT GRID --}}
                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12">

                    {{-- LEFT SECTION: INFO & MAP --}}
                    <div class="space-y-6" data-aos="fade-right">

                        {{-- 1. Image Section --}}
                        <div class="relative w-full h-[350px] lg:h-[450px] overflow-hidden group">
                            <img src="images/hero3.png" alt="Lokasi Kami"
                                class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 ease-in-out">
                        </div>

                        {{-- Response Time Badge --}}
                        <div
                            class="flex items-center gap-4 bg-white p-5 rounded-3xl border border-green-100 transition-all duration-300">
                            <div
                                class="w-11 h-11 bg-green-50 rounded-full flex items-center justify-center text-green-600 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-slate-700">
                                Respon cepat dalam <span class="text-green-600 font-bold">1x24 Jam</span>
                            </p>
                        </div>

                        {{-- Contact Cards --}}
                        <div class="grid sm:grid-cols-2 gap-4">
                            {{-- Email Card --}}
                            <a href="mailto:support@agrismart.id"
                                class="group bg-white rounded-3xl p-5 border border-green-100 hover:border-green-300 hover:-translate-y-1 transition-all duration-300">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-all duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                            Email</p>
                                        <p
                                            class="font-bold text-slate-900 group-hover:text-green-600 transition-colors truncate">
                                            support@agrismart.id
                                        </p>
                                    </div>
                                </div>
                            </a>

                            {{-- WhatsApp Card --}}
                            <a href="https://wa.me/6281234567890" target="_blank"
                                class="group bg-white rounded-3xl p-5 border border-green-100 hover:border-green-300 hover:-translate-y-1 transition-all duration-300">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-all duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                            WhatsApp</p>
                                        <p
                                            class="font-bold text-slate-900 group-hover:text-green-600 transition-colors truncate">
                                            +62 812 3456 7890
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    {{-- RIGHT SECTION: CONTACT FORM --}}
                    {{-- Tambahkan 'h-full' disini agar wrapper mengikuti tinggi grid --}}
                    <div data-aos="fade-left" class="h-full">
                        {{-- Tambahkan 'h-full flex flex-col justify-center' agar card putih meregang penuh --}}
                        <div
                            class="bg-white rounded-3xl p-8 lg:p-10 border border-green-50 shadow-xl h-full flex flex-col justify-center">

                            {{-- Form Header --}}
                            <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-100">
                                <div>
                                    <h4 class="text-2xl font-bold text-slate-900 mb-1">Hubungi Kami</h4>
                                    <p class="text-sm text-slate-500">Kami siap membantu Anda</p>
                                </div>
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-green-50 to-green-100 rounded-2xl flex items-center justify-center text-green-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </div>
                            </div>

                            {{-- Success Message --}}
                            @if(session('success'))
                                <div
                                    class="mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-2xl flex items-start gap-3 border border-emerald-200">
                                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium text-sm">{{ session('success') }}</span>
                                </div>
                            @endif

                            {{-- Form --}}
                            {{-- Tambahkan 'flex-1' jika ingin form mengisi ruang kosong vertical secara merata --}}
                            <form action="{{ route('kontak.store') }}" method="POST" class="space-y-5">
                                @csrf

                                {{-- Full Name --}}
                                <div class="group">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                                    <div class="relative">
                                        <input type="text" name="nama" required
                                            class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium placeholder:text-slate-400"
                                            placeholder="Masukkan nama Anda">
                                        <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 gap-5">
                                    {{-- WhatsApp Number --}}
                                    <div class="group">
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">No.
                                            WhatsApp</label>
                                        <div class="relative">
                                            <input type="tel" name="no_hp" required
                                                class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium placeholder:text-slate-400"
                                                placeholder="0812...">
                                            <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="group">
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                                        <div class="relative">
                                            <input type="email" name="email" required
                                                class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium placeholder:text-slate-400"
                                                placeholder="nama@email.com">
                                            <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Message --}}
                                <div class="group">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pesan Anda</label>
                                    <div class="relative">
                                        <textarea name="pesan" rows="4" required
                                            class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium resize-none placeholder:text-slate-400"
                                            placeholder="Tuliskan pertanyaan atau kebutuhan Anda..."></textarea>
                                        <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-4 group-focus-within:text-green-600 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                        </svg>
                                    </div>
                                </div>

                                {{-- Submit Button --}}
                                <button type="submit"
                                    class="group w-full py-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-2xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 flex items-center justify-center gap-2">
                                    <span>Kirim Pesan Sekarang</span>
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <footer id="footer" class="bg-white border-t border-slate-100 pt-16 pb-8 font-sans relative overflow-hidden">

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
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4.001-1.793-4.001-4.001s1.792-4.001 4.001-4.001c2.21 0 4.001 1.793 4.001 4.001s-1.791 4.001-4.001 4.001zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
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
                {{-- Menggantikan slot "Unduh Aplikasi" agar data kontak tetap ada tapi dengan style baru --}}
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