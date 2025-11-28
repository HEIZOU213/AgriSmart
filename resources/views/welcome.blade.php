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
            /* green-50 */
        }

        ::-webkit-scrollbar-thumb {
            background: #16a34a;
            /* green-600 */
            border-radius: 5px;
            border: 2px solid #f0fdf4;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #15803d;
            /* green-700 */
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
    </style>
</head>

{{-- Background Body: Green-50 (Sangat muda) --}}

<body
    class="font-sans antialiased text-slate-700 bg-green-50 flex flex-col min-h-screen selection:bg-green-500 selection:text-white">

    {{-- NAVBAR --}}
    <x-navbar />

    {{-- MAIN CONTENT --}}
    <main class="flex-1">

        {{-- 1. HERO SECTION & STATS MERGED --}}
        <section class="relative bg-white overflow-hidden pt-24 pb-16 lg:pt-40 lg:pb-24">

            {{-- Background Pattern & Blobs --}}
            {{-- Pattern Halus --}}
            <div
                class="absolute inset-0 bg-[radial-gradient(#dcfce7_1px,transparent_1px)] [background-size:24px_24px] opacity-40 z-0">
            </div>

            {{-- PENTING: Pastikan section/div pembungkus (Parent) memiliki class 'relative overflow-hidden' --}}
            <div
                class="absolute top-0 right-0 -mr-12 -mt-12 w-48 h-48 sm:w-64 sm:h-64 md:-mr-20 md:-mt-20 md:w-96 md:h-96 rounded-full bg-green-100 opacity-60 blur-[50px] md:blur-[80px] pointer-events-none">
            </div>

            {{-- Blob Kiri Bawah (Responsive: Lebih kecil di Mobile) --}}
            <div
                class="absolute bottom-0 left-0 -ml-10 -mb-10 md:-ml-20 md:-mb-20 w-64 h-64 md:w-80 md:h-80 rounded-full bg-emerald-100 opacity-60 blur-[60px] md:blur-[80px]">
            </div>

            {{-- UPDATED WIDTH: max-w-7xl --}}
            <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                {{-- A. HERO CONTENT --}}
                <div class="grid lg:grid-cols-2 gap-12 items-center mb-20"> {{-- Added mb-20 for spacing with stats --}}

                    {{-- Left Content --}}
                    <div data-aos="fade-right" data-aos-duration="1000">
                        <div
                            class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 rounded-full border border-green-200 text-green-800 mb-8 shadow-sm">
                            <span class="flex h-2.5 w-2.5 rounded-full bg-green-600 animate-pulse"></span>
                            <span class="text-xs font-bold tracking-wide uppercase">Platform Pertanian No.1</span>
                        </div>

                        <h1
                            class="text-4xl sm:text-5xl lg:text-7xl font-extrabold text-slate-900 leading-tight mb-6 tracking-tight">
                            Pertanian Cerdas <br>
                            <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-600">Masa
                                Depan.</span>
                        </h1>

                        <p class="text-lg text-slate-600 mb-10 leading-relaxed max-w-xl font-medium">
                            Tingkatkan hasil panen dengan teknologi IoT, akses pasar langsung tanpa perantara, dan
                            edukasi dari para ahli. Semua dalam satu genggaman.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('produk.index') }}"
                                class="inline-flex justify-center items-center px-8 py-4 bg-green-600 text-white font-extrabold rounded-xl shadow-lg shadow-green-600/20 hover:bg-green-700 hover:scale-105 transition-all duration-300">
                                Mulai Sekarang
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                            <a href="#video"
                                class="inline-flex justify-center items-center px-8 py-4 border-2 border-slate-200 text-slate-700 font-bold rounded-xl hover:border-green-600 hover:text-green-600 hover:bg-green-50 transition-all duration-300">
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

                {{-- B. STATS BAR (INTEGRATED) --}}
                {{-- Border top halus untuk memisahkan tapi tetap menyatu --}}
                <div class="border-t border-green-100/60 pt-12" data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-0 divide-y md:divide-y-0 md:divide-x divide-green-100">

                        {{-- Item 1 --}}
                        <div class="text-center px-4 py-2 group">
                            <div
                                class="text-4xl md:text-5xl font-black text-green-700 mb-1 tracking-tight group-hover:scale-110 transition-transform duration-300">
                                99%
                            </div>
                            <div class="text-slate-800 font-bold text-lg leading-tight">Akurasi Data</div>
                            <p class="text-slate-500 text-sm font-medium mt-1">Validasi sensor presisi tinggi</p>
                        </div>

                        {{-- Item 2 --}}
                        <div class="text-center px-4 py-2 group">
                            <div
                                class="text-4xl md:text-5xl font-black text-green-700 mb-1 tracking-tight group-hover:scale-110 transition-transform duration-300">
                                500+
                            </div>
                            <div class="text-slate-800 font-bold text-lg leading-tight">Petani Terbantu</div>
                            <p class="text-slate-500 text-sm font-medium mt-1">Mitra aktif di seluruh Indonesia</p>
                        </div>

                        {{-- Item 3 --}}
                        <div class="text-center px-4 py-2 group">
                            <div
                                class="text-4xl md:text-5xl font-black text-green-700 mb-1 tracking-tight group-hover:scale-110 transition-transform duration-300">
                                24/7
                            </div>
                            <div class="text-slate-800 font-bold text-lg leading-tight">Realtime Monitor</div>
                            <p class="text-slate-500 text-sm font-medium mt-1">Akses data kapan saja</p>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        {{-- 3. LAYANAN SECTION (SOLID BACKGROUND & SIMPLE BUTTONS) --}}
        <section id="layanan" class="py-20 sm:py-24 lg:py-32 relative overflow-hidden bg-[#F0FDF4]">

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
                <div class="text-center mb-12 sm:mb-16 max-w-3xl mx-auto" data-aos="fade-up">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white text-green-800 text-xs sm:text-sm font-bold uppercase tracking-widest border border-green-200 mb-4 sm:mb-6 shadow-sm">
                        <span>Fitur Unggulan</span>
                    </div>

                    <h2
                        class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4 sm:mb-6">
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
                                class="text-2xl sm:text-2xl font-bold text-slate-900 mb-3 group-hover:text-green-700 transition-colors duration-300">
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
                                class="text-2xl sm:text-2xl font-bold text-slate-900 mb-3 group-hover:text-emerald-700 transition-colors duration-300">
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
                                class="text-2xl sm:text-2xl font-bold text-slate-900 mb-3 group-hover:text-teal-700 transition-colors duration-300">
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

        {{-- 4. EDUCATION SECTION (CLEAN & ATTRACTIVE) --}}
        <section id="edukasi-preview" class="py-24 relative bg-white border-t border-green-50 overflow-hidden">

            {{-- Background Decorations (Subtle & Modern) --}}
            <div class="absolute inset-0 pointer-events-none overflow-hidden">

                {{-- Soft Gradient Orb (Atas) - FIXED RESPONSIVE --}}
                {{-- Mobile: w-full, Desktop: w-[1000px] --}}
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-full md:w-[1000px] h-[300px] md:h-[500px] bg-green-50/40 rounded-full blur-[80px] md:blur-[120px] -mt-20 md:-mt-32">
                </div>

                {{-- Soft Gradient Orb (Bawah Kanan) - FIXED RESPONSIVE --}}
                <div
                    class="absolute bottom-0 right-0 w-[300px] md:w-[600px] h-[200px] md:h-[400px] bg-green-50/30 rounded-full blur-[60px] md:blur-[100px] translate-y-1/3 translate-x-1/3">
                </div>

                {{-- Spiral 1: Kanan Atas (Dominan) - FIXED RESPONSIVE --}}
                <svg class="absolute top-0 right-0 w-[350px] md:w-[700px] h-[350px] md:h-[700px] opacity-25 translate-x-1/4 md:translate-x-1/3 -translate-y-1/4"
                    viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 Q 50 -20 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                    <path d="M0 100 Q 50 0 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                    <path d="M0 100 Q 50 20 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                </svg>

                {{-- Spiral 2: Kiri Bawah (Penyeimbang) - FIXED RESPONSIVE --}}
                <svg class="absolute bottom-0 left-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] opacity-20 -translate-x-1/3 translate-y-1/4 rotate-180"
                    viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 Q 50 0 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                    <path d="M0 100 Q 50 20 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                    <path d="M0 100 Q 50 40 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                </svg>

                {{-- Spiral 3: Kecil (Kiri Atas) - FIXED RESPONSIVE --}}
                <svg class="absolute top-10 left-0 md:left-10 w-[150px] md:w-[300px] h-[150px] md:h-[300px] opacity-10 rotate-12 -translate-x-1/4 md:translate-x-0"
                    viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 Q 50 10 100 100" stroke="#dcfce7" stroke-width="0.8" fill="none" />
                    <path d="M0 100 Q 50 30 100 100" stroke="#dcfce7" stroke-width="0.8" fill="none" />
                </svg>
            </div>

            {{-- UPDATED WIDTH: max-w-7xl --}}
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">

                {{-- HEADER: Clean & Centered --}}
                <div class="text-center mb-20 max-w-3xl mx-auto" data-aos="fade-up">
                    <span
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-gradient-to-r from-green-50 to-emerald-50 text-green-700 text-xs font-bold uppercase tracking-widest border border-green-100 mb-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        Pusat Pengetahuan
                    </span>

                    <h2
                        class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6 bg-clip-text text-transparent bg-gradient-to-r from-slate-900 via-green-800 to-slate-900">
                        Belajar dari <span class="text-green-600 relative inline-block">
                            Ahlinya
                            <svg class="absolute -bottom-2 left-0 w-full h-3" viewBox="0 0 100 10"
                                preserveAspectRatio="none">
                                <path d="M0 8 Q 50 0, 100 8" stroke="#10b981" stroke-width="2" fill="none"
                                    opacity="0.3" />
                            </svg>
                        </span>
                    </h2>

                    <p class="text-lg md:text-xl text-slate-600 mb-10 max-w-2xl mx-auto leading-relaxed font-medium">
                        Perluas wawasan pertanian Anda dengan artikel pilihan, tips budidaya, dan inovasi teknologi
                        terbaru.
                    </p>
                </div>

                {{-- ARTICLES GRID --}}
                @if(isset($edukasi) && !$edukasi->isEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($edukasi as $index => $item)
                            <a href="{{ route('edukasi.show', $item->slug) }}"
                                class="group block {{ $index === 0 ? 'md:col-span-2 md:row-span-2' : '' }}" data-aos="zoom-in"
                                data-aos-delay="{{ $index * 100 }}">

                                {{-- Card Container: Clean Gradient Box --}}
                                <div
                                    class="relative h-full bg-gradient-to-br from-white via-white to-green-50 rounded-[2rem] overflow-hidden shadow-lg hover:shadow-2xl hover:shadow-green-900/10 transition-all duration-500 border border-green-100 hover:border-green-300 group-hover:-translate-y-2">

                                    {{-- Image Area --}}
                                    <div class="relative h-full min-h-[350px] {{ $index === 0 ? 'md:min-h-[550px]' : '' }}">
                                        @if($item->foto_sampul)
                                            <img src="{{ asset('storage/' . $item->foto_sampul) }}" alt="{{ $item->judul }}"
                                                class="absolute inset-0 w-full h-full object-cover opacity-95 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700">
                                        @else
                                            <div
                                                class="absolute inset-0 bg-gradient-to-br from-green-50 to-emerald-50 opacity-100 flex items-center justify-center">
                                                <svg class="w-20 h-20 text-green-200" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
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
                                        <div class="absolute inset-0 p-8 flex flex-col justify-end">
                                            <div
                                                class="space-y-4 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">

                                                {{-- Meta Info --}}
                                                <div class="flex items-center gap-3">
                                                    <span
                                                        class="px-3 py-1 bg-white/90 backdrop-blur-sm text-green-700 text-[10px] font-bold uppercase tracking-wider rounded-full shadow-sm">
                                                        Tips & Trik
                                                    </span>
                                                    <span class="text-green-50 text-xs font-semibold tracking-wide">
                                                        {{ $item->created_at->format('d M Y') }}
                                                    </span>
                                                </div>

                                                {{-- Title --}}
                                                <h3
                                                    class="text-2xl {{ $index === 0 ? 'lg:text-4xl' : '' }} font-bold text-white leading-tight drop-shadow-sm group-hover:text-green-100 transition-colors">
                                                    {{ $item->judul }}
                                                </h3>

                                                {{-- Excerpt (First Item Only) --}}
                                                @if($index === 0)
                                                    <p
                                                        class="text-green-50 text-base lg:text-lg leading-relaxed line-clamp-2 md:line-clamp-3 opacity-90 group-hover:opacity-100 transition-opacity duration-500 font-medium">
                                                        {{ Str::limit(strip_tags($item->isi_konten), 150) }}
                                                    </p>
                                                @endif

                                                {{-- Read More Link (No Underline) --}}
                                                <div
                                                    class="flex items-center gap-2 text-white font-bold text-sm pt-2 group/link">
                                                    <span class="group-hover:text-green-200 transition-colors">Baca
                                                        Selengkapnya</span>
                                                    <svg class="w-5 h-5 group-hover:translate-x-2 group-hover:text-green-200 transition-all"
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
                    <div class="text-center py-20 bg-green-50 rounded-[2rem] border-2 border-dashed border-green-200">
                        <p class="text-green-600 font-bold text-lg">Belum ada artikel edukasi.</p>
                    </div>
                @endif

                {{-- View All Button --}}
                <div class="mt-16 text-center">
                    <a href="{{ route('edukasi.index') }}"
                        class="inline-flex items-center justify-center px-8 py-4 bg-white border-2 border-slate-200 text-slate-700 font-bold rounded-full hover:border-green-600 hover:text-green-600 transition-all duration-300 hover:shadow-lg group">
                        Lihat Semua Artikel
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>

            </div>
        </section>

        {{-- 5. PRODUCTS SECTION (CLEAN GREEN THEME WITH WAVES) --}}
        <section class="py-24 relative overflow-hidden bg-emerald-50">

            {{-- Enhanced Background Decorations (New Wave & Blobs) --}}
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

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                {{-- Enhanced Header (CENTERED) --}}
                <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white text-green-700 text-[11px] font-bold uppercase tracking-widest border border-green-200 mb-5 shadow-sm hover:shadow-md transition-shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Pasar Segar
                    </span>
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-900 leading-tight mb-4">
                        Panen <span class="text-green-600 relative inline-block">
                            Terbaik
                            <svg class="absolute -bottom-1 left-0 w-full h-2" viewBox="0 0 100 10"
                                preserveAspectRatio="none">
                                <path d="M0 8 Q 50 0, 100 8" stroke="#10b981" stroke-width="2" fill="none"
                                    opacity="0.3" />
                            </svg>
                        </span>
                    </h2>
                    <p class="text-slate-600 text-base md:text-lg leading-relaxed">
                        Hasil pertanian berkualitas langsung dari petani lokal untuk kebutuhan dapur Anda sehari-hari.
                    </p>
                </div>

                @if(isset($produk) && !$produk->isEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                        @foreach($produk as $index => $item)
                            <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                                class="group bg-white rounded-3xl overflow-hidden shadow-lg shadow-green-900/5 border border-white hover:border-green-300 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-500 hover:-translate-y-3">

                                {{-- Enhanced Image Container --}}
                                <div class="relative aspect-square overflow-hidden bg-slate-50">
                                    @if($item->foto_produk)
                                        <img src="{{ asset('storage/' . $item->foto_produk) }}" alt="{{ $item->nama_produk }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
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

                                    {{-- Overlay Gradient on Hover --}}
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-green-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                    </div>

                                    {{-- Category Badge --}}
                                    <div
                                        class="absolute top-3 right-3 bg-white/95 backdrop-blur-md px-3 py-1.5 rounded-full text-[10px] font-bold text-green-700 shadow-sm border border-green-100 uppercase tracking-wider">
                                        {{ $item->kategori_produk ?? 'Umum' }}
                                    </div>
                                </div>

                                {{-- Content Area --}}
                                <div class="p-6">
                                    {{-- Product Name --}}
                                    <h3
                                        class="text-lg font-bold text-slate-900 mb-2 group-hover:text-green-600 transition-colors line-clamp-1">
                                        {{ $item->nama_produk }}
                                    </h3>

                                    {{-- Description --}}
                                    <p class="text-slate-500 text-sm mb-5 line-clamp-2 leading-relaxed h-10">
                                        {{ $item->deskripsi ?? 'Produk segar berkualitas tinggi dari petani lokal' }}
                                    </p>

                                    {{-- Price & Action Section --}}
                                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Harga</span>
                                            <span
                                                class="text-xl font-extrabold text-slate-900 group-hover:text-green-600 transition-colors">
                                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                                            </span>
                                            <span class="text-[10px] text-slate-400 font-medium mt-0.5">per
                                                {{ $item->satuan ?? 'kg' }}</span>
                                        </div>

                                        {{-- Action Button --}}
                                        <a href="{{ route('produk.show', $item->id) }}"
                                            class="relative w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center text-green-600 hover:bg-green-600 hover:text-white transition-all duration-300 shadow-sm hover:shadow-xl hover:shadow-green-500/30 group/btn hover:scale-110">
                                            <svg class="w-5 h-5 group-hover/btn:rotate-90 transition-transform duration-300"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </a>
                                    </div>

                                    {{-- Stock Indicator (Numeric) --}}
                                    <div class="mt-4 flex items-center justify-between bg-slate-50 rounded-lg px-3 py-2">
                                        <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Stok
                                            Tersedia</span>
                                        <div class="flex items-center gap-1.5">
                                            <span
                                                class="text-sm font-bold {{ ($item->stok ?? 0) > 0 ? 'text-green-700' : 'text-red-500' }}">
                                                {{ $item->stok ?? 0 }} {{ $item->satuan ?? '' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- CTA Button (Centered Below Grid) --}}
                    <div class="mt-16 text-center" data-aos="fade-up">
                        <a href="{{ route('produk.index') }}"
                            class="group inline-flex items-center gap-2 px-10 py-4 rounded-full bg-green-600 text-white font-bold hover:bg-green-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-green-600/30 hover:-translate-y-1">
                            <span>Lihat Semua Produk</span>
                            <div
                                class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-white/30 transition-colors">
                                <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>
                    </div>

                @else
                    {{-- Empty State --}}
                    <div
                        class="text-center py-20 bg-white/50 backdrop-blur-sm rounded-3xl border-2 border-dashed border-green-200">
                        <div
                            class="w-24 h-24 mx-auto mb-6 bg-white rounded-full flex items-center justify-center shadow-md">
                            <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Produk Belum Tersedia</h3>
                        <p class="text-slate-500 text-sm max-w-md mx-auto">Kami sedang mempersiapkan produk-produk
                            berkualitas untuk Anda. Nantikan segera!</p>
                    </div>
                @endif
            </div>
        </section>

        {{-- 6. TENTANG KAMI SECTION (CLEAN SPLIT LAYOUT) --}}
        <section id="tentang-kami" class="py-24 bg-white overflow-hidden">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
                <div class="grid lg:grid-cols-2 gap-16 items-center">

                    {{-- IMAGE SIDE (LEFT) --}}
                    <div class="relative" data-aos="fade-right">
                        {{-- Decorative Backdrops --}}
                        <div
                            class="absolute -top-4 -left-4 w-full h-full bg-green-100 rounded-[2.5rem] transform -rotate-2">
                        </div>
                        <div
                            class="absolute -bottom-4 -right-4 w-full h-full bg-slate-100 rounded-[2.5rem] transform rotate-2">
                        </div>

                        {{-- Main Image --}}
                        <div class="relative rounded-[2rem] overflow-hidden shadow-2xl border-4 border-white group">
                            <img src="images/hero1.png" alt="Tim AgriSmart"
                                class="w-full h-auto object-cover grayscale group-hover:grayscale-0 transition-all duration-700 scale-100 group-hover:scale-105">

                            {{-- Overlay Gradient --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-green-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </div>
                    </div>

                    {{-- CONTENT SIDE (RIGHT) --}}
                    <div data-aos="fade-left">
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-green-50 text-green-700 text-xs font-bold uppercase tracking-widest mb-4 border border-green-100">
                            Tentang Kami
                        </span>

                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 mb-6 leading-tight">
                            Membangun Masa Depan <span class="text-green-600 relative inline-block">
                                Pertanian
                                <svg class="absolute -bottom-2 left-0 w-full h-3" viewBox="0 0 100 10"
                                    preserveAspectRatio="none">
                                    <path d="M0 8 Q 50 0, 100 8" stroke="#10b981" stroke-width="2" fill="none"
                                        opacity="0.3" />
                                </svg>
                            </span>
                        </h2>

                        <p class="text-lg text-slate-600 leading-relaxed mb-8">
                            AgriSmart hadir untuk menjembatani kesenjangan teknologi bagi petani Indonesia. Kami percaya
                            bahwa dengan akses yang tepat terhadap teknologi IoT dan pasar digital, kesejahteraan petani
                            dapat meningkat pesat.
                        </p>

                        {{-- Feature List --}}
                        <ul class="space-y-4">
                            <li
                                class="flex items-start gap-4 p-4 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all duration-300 group">
                                <div
                                    class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-lg">Transparansi Harga</h4>
                                    <p class="text-sm text-slate-500 mt-1 leading-relaxed">Jaminan harga adil untuk
                                        petani dan konsumen dengan sistem yang terbuka.</p>
                                </div>
                            </li>

                            <li
                                class="flex items-start gap-4 p-4 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all duration-300 group">
                                <div
                                    class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-lg">Teknologi Berkelanjutan</h4>
                                    <p class="text-sm text-slate-500 mt-1 leading-relaxed">Solusi ramah lingkungan untuk
                                        jangka panjang demi masa depan yang lebih baik.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- 7. CONTACT FORM SECTION (FINAL CLEAN & BALANCED WITH MAP) --}}
        <section id="kontak" class="py-24 relative bg-green-50/50 overflow-hidden">

            {{-- Background Pattern & Spiral Decoration (Cleaned Opacity) --}}
            <div class="absolute inset-0 pointer-events-none">
                <div
                    class="absolute inset-0 opacity-[0.03] bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:20px_20px]">
                </div>
                <svg class="absolute -left-20 top-1/4 w-96 h-96 opacity-[0.02] animate-spin-slow" viewBox="0 0 100 100">
                    <path d="M50,50 m-40,0 a40,40 0 1,0 80,0 a40,40 0 1,0 -80,0" fill="none" stroke="currentColor"
                        stroke-width="2" />
                    <path d="M50,50 m-30,0 a30,30 0 1,0 60,0 a30,30 0 1,0 -60,0" fill="none" stroke="currentColor"
                        stroke-width="1.5" />
                </svg>
                <div class="absolute top-0 right-0 w-64 h-64 bg-green-200/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-emerald-200/20 rounded-full blur-3xl"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                {{-- 1. HEADER SECTION (UNCHANGED) --}}
                <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white text-green-700 text-xs font-bold uppercase tracking-widest mb-4 border border-green-100 shadow-sm">
                        Hubungi Kami
                    </span>
                    <h2
                        class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 mb-6 leading-tight tracking-tight">
                        Mari Berkolaborasi <br> Bersama
                        <span class="text-green-600 relative inline-block">
                            AgriSmart
                            <svg class="absolute -bottom-2 left-0 w-full h-3" viewBox="0 0 100 10"
                                preserveAspectRatio="none">
                                <path d="M0 8 Q 50 0, 100 8" stroke="#10b981" stroke-width="2" fill="none"
                                    opacity="0.3" />
                            </svg>
                        </span>
                    </h2>
                    <p class="text-slate-600 text-lg leading-relaxed font-medium">
                        Ayo bergabung bersama kami dan menjadi bagian dari Petani Masa Depan. Cukup dengan mengisi
                        formulir untuk memulai langkah besar Anda.
                    </p>
                </div>

                {{-- 2. CONTENT GRID (EQUAL HEIGHT CONFIGURATION) --}}
                {{-- items-stretch is crucial here to make both sides equal height --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-stretch">

                    {{-- BAGIAN KIRI: CARDS & MAP (FLEX GROW ENABLED) --}}
                    <div class="flex flex-col gap-6 h-full" data-aos="fade-right">

                        {{-- 1. Info Badge --}}
                        <div
                            class="flex items-center gap-4 bg-white p-5 rounded-[2rem] border border-green-100 shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div
                                class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center text-green-600 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-600">
                                    Respon cepat dari tim kami dalam <span class="text-green-700 font-bold">1x24
                                        Jam</span>.
                                </p>
                            </div>
                        </div>

                        {{-- 2. Contact Cards Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Email Card --}}
                            <a href="mailto:support@agrismart.id"
                                class="group bg-white rounded-[2rem] p-5 border border-green-100 shadow-sm hover:shadow-lg hover:shadow-green-100/50 hover:border-green-200 transition-all duration-300">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                                            Email</p>
                                        <p
                                            class="font-bold text-slate-900 group-hover:text-green-600 transition-colors truncate text-sm">
                                            support@agrismart.id
                                        </p>
                                    </div>
                                </div>
                            </a>

                            {{-- WhatsApp Card --}}
                            <a href="https://wa.me/6281234567890"
                                class="group bg-white rounded-[2rem] p-5 border border-green-100 shadow-sm hover:shadow-lg hover:shadow-green-100/50 hover:border-emerald-200 transition-all duration-300">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                                            WhatsApp</p>
                                        <p
                                            class="font-bold text-slate-900 group-hover:text-emerald-600 transition-colors truncate text-sm">
                                            +62 812 3456 7890
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- 3. Map Section (AUTO HEIGHT ADJUSTMENT) --}}
                        {{-- flex-1 & h-full ensures this fills the remaining space to match the form height --}}
                        <div
                            class="relative w-full flex-1 min-h-[300px] rounded-[2.5rem] overflow-hidden border border-white shadow-lg shadow-green-900/5 group z-0">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.331289647231!2d106.800032314769!3d-6.220000000000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f14d30079f01%3A0x2e74f2341ab481ee!2sGelora%20Bung%20Karno%20Sports%20Complex!5e0!3m2!1sen!2sid!4v1620000000000!5m2!1sen!2sid"
                                class="absolute inset-0 w-full h-full grayscale-[20%] hover:grayscale-0 transition-all duration-700 ease-in-out"
                                style="border:0;" allowfullscreen="" loading="lazy">
                            </iframe>
                            {{-- Hover Overlay --}}
                            <div
                                class="absolute inset-0 bg-green-900/0 group-hover:bg-green-900/5 transition-colors pointer-events-none">
                            </div>
                        </div>

                    </div>

                    {{-- BAGIAN KANAN: FORMULIR --}}
                    {{-- h-full ensures the container fills the grid cell --}}
                    <div class="h-full" data-aos="fade-left">
                        <div
                            class="bg-white rounded-[2.5rem] p-8 md:p-10 border border-green-50 shadow-xl shadow-green-900/5 relative z-10 h-full flex flex-col justify-center">

                            {{-- Form Header --}}
                            <div class="mb-8 pb-6 border-b border-slate-50 flex items-center justify-between">
                                <div>
                                    <h4 class="text-2xl font-extrabold text-slate-900">Isi Formulir</h4>
                                    <p class="text-sm text-slate-500 mt-1">Kami akan menghubungi Anda segera</p>
                                </div>
                                <div
                                    class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-green-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </div>
                            </div>

                            @if(session('success'))
                                <div
                                    class="mb-6 p-4 bg-emerald-50 text-emerald-800 rounded-2xl flex items-start gap-3 text-sm border border-emerald-100">
                                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="font-medium">{{ session('success') }}</span>
                                </div>
                            @endif

                            <form action="{{ route('kontak.store') }}" method="POST" class="space-y-5">
                                @csrf

                                {{-- Nama --}}
                                <div class="group">
                                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Nama Lengkap</label>
                                    <div class="relative">
                                        <input type="text" name="nama" required
                                            class="w-full pl-11 pr-4 py-4 rounded-2xl bg-slate-50 border border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium placeholder-slate-400 group-hover:bg-white group-hover:border-green-100"
                                            placeholder="Masukkan nama Anda">
                                        <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-green-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    {{-- WhatsApp --}}
                                    <div class="group">
                                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">No.
                                            WhatsApp</label>
                                        <div class="relative">
                                            <input type="text" name="no_hp" required
                                                class="w-full pl-11 pr-4 py-4 rounded-2xl bg-slate-50 border border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium placeholder-slate-400 group-hover:bg-white group-hover:border-green-100"
                                                placeholder="0812...">
                                            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-green-500 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="group">
                                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Email</label>
                                        <div class="relative">
                                            <input type="email" name="email" required
                                                class="w-full pl-11 pr-4 py-4 rounded-2xl bg-slate-50 border border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium placeholder-slate-400 group-hover:bg-white group-hover:border-green-100"
                                                placeholder="nama@email.com">
                                            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-green-500 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Pesan --}}
                                <div class="group">
                                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Pesan Anda</label>
                                    <div class="relative">
                                        <textarea name="pesan" rows="4" required
                                            class="w-full pl-11 pr-4 py-4 rounded-2xl bg-slate-50 border border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium resize-none placeholder-slate-400 group-hover:bg-white group-hover:border-green-100"
                                            placeholder="Tuliskan pertanyaan atau detail kebutuhan Anda..."></textarea>
                                        <svg class="w-5 h-5 text-slate-400 absolute left-4 top-5 group-focus-within:text-green-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>

                                {{-- Tombol --}}
                                <button type="submit"
                                    class="group w-full py-4 bg-green-600 text-white font-bold rounded-2xl hover:bg-green-700 shadow-lg shadow-green-600/20 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 flex items-center justify-center gap-2">
                                    <span>Kirim Pesan Sekarang</span>
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section> 
    </main>

    {{-- FOOTER --}}
    {{-- UPDATED: Green-900 (Deep Green) & Border Green-400 --}}
    <footer id="footer" class="bg-green-900 pt-20 pb-10 text-white border-t-[6px] border-green-400 relative font-sans">
        {{-- UPDATED WIDTH: max-w-7xl --}}
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-16 mb-16">

                {{-- Kolom 1: Brand & Social --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h4 class="text-3xl font-extrabold text-white tracking-tight">AgriTech</h4>
                    </div>
                    <p class="text-green-100 text-sm leading-relaxed font-medium">
                        Platform digital terintegrasi untuk pertanian cerdas. Solusi IoT untuk masa depan pangan
                        Indonesia
                        yang lebih baik.
                    </p>

                    {{-- Social Icons --}}
                    <div class="flex space-x-3 pt-2">
                        <a href="#"
                            class="w-10 h-10 bg-green-800 text-green-100 hover:bg-green-400 hover:text-white rounded-lg flex items-center justify-center transition-all duration-300 hover:-translate-y-1 shadow-md">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-green-800 text-green-100 hover:bg-green-400 hover:text-white rounded-lg flex items-center justify-center transition-all duration-300 hover:-translate-y-1 shadow-md">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-green-800 text-green-100 hover:bg-green-400 hover:text-white rounded-lg flex items-center justify-center transition-all duration-300 hover:-translate-y-1 shadow-md">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.906 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.906-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.38.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06h.045zM12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a3.997 3.997 0 110-7.994 3.997 3.997 0 010 7.994zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Kolom 2: Navigasi --}}
                <div class="lg:col-span-1">
                    <h5 class="font-bold text-lg mb-6 text-green-300">Menu</h5>
                    <ul class="space-y-4 text-green-100 font-medium">
                        <li><a href="#"
                                class="hover:text-white hover:translate-x-1 transition-all inline-block">Beranda</a>
                        </li>
                        <li><a href="#" class="hover:text-white hover:translate-x-1 transition-all inline-block">Tentang
                                Kami</a></li>
                        <li><a href="#"
                                class="hover:text-white hover:translate-x-1 transition-all inline-block">Fitur</a>
                        </li>
                        <li><a href="#"
                                class="hover:text-white hover:translate-x-1 transition-all inline-block">Produk</a></li>
                        <li><a href="#"
                                class="hover:text-white hover:translate-x-1 transition-all inline-block">Kontak</a></li>
                    </ul>
                </div>

                {{-- Kolom 3: Layanan --}}
                <div class="lg:col-span-1">
                    <h5 class="font-bold text-lg mb-6 text-green-300">Layanan</h5>
                    <ul class="space-y-4 text-green-100 font-medium">
                        <li><a href="#"
                                class="hover:text-white hover:translate-x-1 transition-all inline-block">Konsultasi
                                Tani</a></li>
                        <li><a href="#"
                                class="hover:text-white hover:translate-x-1 transition-all inline-block">Marketplace</a>
                        </li>
                        <li><a href="#" class="hover:text-white hover:translate-x-1 transition-all inline-block">IoT
                                Monitoring</a></li>
                        <li><a href="#" class="hover:text-white hover:translate-x-1 transition-all inline-block">Edukasi
                                &
                                Pelatihan</a></li>
                    </ul>
                </div>

                {{-- Kolom 4: Kontak Cepat --}}
                <div class="lg:col-span-1">
                    <h5 class="font-bold text-lg mb-6 text-green-300">Hubungi Kami</h5>
                    <ul class="space-y-6">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 mr-4 text-green-300 flex-shrink-0 mt-0.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <span
                                    class="block text-xs text-green-200 uppercase tracking-wider mb-0.5 font-bold">Email</span>
                                <a href="mailto:info@agritech.id"
                                    class="text-white hover:text-green-200 underline-offset-4 hover:underline transition-all font-semibold text-base">info@agritech.id</a>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 mr-4 text-green-300 flex-shrink-0 mt-0.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <div>
                                <span
                                    class="block text-xs text-green-200 uppercase tracking-wider mb-0.5 font-bold">Phone</span>
                                <a href="tel:+6281234567890"
                                    class="text-white hover:text-green-200 underline-offset-4 hover:underline transition-all font-semibold text-base">+62
                                    812 3456 7890</a>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 mr-4 text-green-300 flex-shrink-0 mt-0.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <span
                                    class="block text-xs text-green-200 uppercase tracking-wider mb-0.5 font-bold">Lokasi</span>
                                <span class="text-white font-medium leading-snug block">Jl. Pertanian Modern No. 88,<br>
                                    Jakarta Selatan, Indonesia</span>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>

            {{-- Copyright --}}
            <div class="border-t border-green-800/50 mt-12 pt-8 text-center relative z-10">
                <div class="flex flex-col md:flex-row items-center justify-center gap-4 text-green-200/80 text-sm">
                    <div>&copy; {{ date('Y') }} <span class="text-white font-extrabold">AgriTech</span>. All Rights
                        Reserved.
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- BACK TO TOP BUTTON --}}
    <button id="backToTop"
        class="fixed bottom-8 right-8 bg-green-600 hover:bg-green-700 text-white p-3 rounded-xl shadow-lg shadow-green-600/30 translate-y-20 opacity-0 transition-all duration-500 z-50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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