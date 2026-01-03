<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <!-- ============================= META & SEO ============================= -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="Platform Pertanian Cerdas Masa Depan. Tingkatkan hasil panen dengan teknologi IoT dan akses pasar langsung.">
    <meta name="keywords" content="Pertanian, IoT, AgriSmart, Petani Digital, Marketplace Tani">
    <meta property="og:title" content="{{ config('app.name', 'AgriSmart') }} - Pertanian Cerdas">
    <meta property="og:description" content="Solusi IoT pertanian terintegrasi dari hulu ke hilir.">
    <meta property="og:image" content="{{ asset('images/hero1.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon & Title -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>{{ config('app.name', 'AgriSmart') }}</title>

    <!-- ============================= FONTS & LIBRARIES ============================= -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- ============================= CUSTOM STYLES ============================= -->
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Scrollbar Kustom */
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

        /* Animasi Floating */
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

        /* Line Clamp Utilities */
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

        /* Animasi Blob */
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

        /* Animasi Spin Lambat */
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

        /* Optimasi Gambar */
        img {
            max-width: 100%;
            height: auto;
        }

        .aspect-square img {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body
    class="font-sans antialiased text-slate-700 bg-green-50 flex flex-col min-h-screen selection:bg-green-500 selection:text-white">

    <!-- ============================= NAVBAR KOMPONEN ============================= -->
    <x-navbar />

    <main class="flex-1">

        <!-- ============================= SECTION: HERO ============================= -->
        <section class="relative bg-white overflow-hidden pt-24 pb-12 lg:pt-40 lg:pb-24">
            <!-- Background Elements -->
            <div
                class="absolute inset-0 bg-[radial-gradient(#dcfce7_1px,transparent_1px)] [background-size:24px_24px] opacity-40 z-0">
            </div>
            <div
                class="absolute top-0 right-0 -mr-12 -mt-12 w-48 h-48 sm:w-64 sm:h-64 md:-mr-20 md:-mt-20 md:w-96 md:h-96 rounded-full bg-green-100 opacity-60 blur-[50px] md:blur-[80px] pointer-events-none">
            </div>
            <div
                class="absolute bottom-0 left-0 -ml-10 -mb-10 md:-ml-20 md:-mb-20 w-64 h-64 md:w-80 md:h-80 rounded-full bg-emerald-100 opacity-60 blur-[60px] md:blur-[80px]">
            </div>

            <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
                <!-- Grid: Konten vs Gambar -->
                <div class="grid lg:grid-cols-2 gap-10 lg:gap-12 items-center mb-12 lg:mb-20">
                    <!-- Kolom Kiri: Konten Teks -->
                    <div data-aos="fade-right" data-aos-duration="1000" class="text-center lg:text-left order-1">
                        <!-- Badge Platform -->
                        <div
                            class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 rounded-full border border-green-200 text-green-800 mb-6 lg:mb-8 shadow-sm mx-auto lg:mx-0">
                            <span class="flex h-2.5 w-2.5 rounded-full bg-green-600 animate-pulse"></span>
                            <span class="text-xs font-bold tracking-wide uppercase">Platform Pertanian No.1</span>
                        </div>

                        <!-- Judul Utama -->
                        <h1
                            class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-extrabold text-slate-900 leading-tight mb-4 lg:mb-6 tracking-tight">
                            Pertanian Cerdas <br class="hidden sm:block">
                            <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-600">Masa
                                Depan.</span>
                        </h1>

                        <!-- Deskripsi -->
                        <p
                            class="text-base sm:text-lg text-slate-600 mb-8 lg:mb-10 leading-relaxed max-w-xl font-medium mx-auto lg:mx-0">
                            Tingkatkan hasil panen dengan teknologi IoT, akses pasar langsung tanpa perantara, dan
                            edukasi dari para ahli. Semua dalam satu genggaman.
                        </p>

                        <!-- Container Tombol Aksi -->
                        <div
                            class="flex flex-col sm:flex-row gap-3 lg:gap-4 justify-center lg:justify-start w-full sm:w-auto">
                            <!-- Tombol Utama: Mulai Sekarang -->
                            <a href="{{ route('produk.index') }}"
                                class="inline-flex justify-center items-center px-6 lg:px-8 py-3 lg:py-4 bg-green-600 text-white font-extrabold rounded-xl shadow-lg shadow-green-600/20 hover:bg-green-700 hover:scale-105 transition-all duration-300 text-sm lg:text-base w-full sm:w-auto">
                                Mulai Sekarang
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>

                            <!-- Tombol Sekunder: Tonton Video -->
                            <a href="#edukasi-preview"
                                class="inline-flex justify-center items-center px-6 lg:px-8 py-3 lg:py-4 border-2 border-green-600 text-green-600 font-bold rounded-xl hover:bg-green-50 transition-all duration-300 text-sm lg:text-base w-full sm:w-auto">
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

                    <!-- Kolom Kanan: Gambar Hero -->
                    <div class="relative block order-2 mt-8 lg:mt-0" data-aos="fade-left" data-aos-duration="1200">
                        <div class="relative w-full max-w-sm sm:max-w-md lg:max-w-lg mx-auto animate-float">
                            <!-- Efek Latar Belakang Gambar -->
                            <div
                                class="absolute top-10 -right-4 sm:-right-10 w-full h-full bg-green-200 rounded-[2.5rem] opacity-60 rotate-6 mix-blend-multiply">
                            </div>
                            <div
                                class="absolute -bottom-5 -left-4 sm:-left-5 w-full h-full bg-emerald-200 rounded-[2.5rem] opacity-60 -rotate-3 mix-blend-multiply">
                            </div>

                            <!-- Container Gambar Utama -->
                            <div
                                class="relative rounded-[2rem] overflow-hidden shadow-2xl border-[6px] border-white ring-1 ring-slate-100">
                                <img src="{{ asset('images/hero1.png') }}" alt="Dashboard Pertanian"
                                    class="w-full h-auto object-cover transform hover:scale-105 transition-transform duration-700">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================= SECTION: LAYANAN ============================= -->
        <section id="layanan" class="py-16 sm:py-20 lg:py-32 relative overflow-hidden bg-[#F0FDF4]">
            <!-- Background SVG -->
            <div class="absolute inset-0 opacity-20 pointer-events-none">
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 800"
                    preserveAspectRatio="xMidYMid slice">
                    <path d="M 720 400 Q 800 300, 900 350 T 1050 450 T 1150 600 T 1200 800" stroke="#10b981"
                        stroke-width="3" fill="none" opacity="0.3" />
                    <path d="M 300 200 Q 400 150, 500 200 T 650 300 T 750 450 T 800 650" stroke="#10b981"
                        stroke-width="2.5" fill="none" opacity="0.2" />
                    <path d="M 100 500 Q 150 480, 180 510 T 220 580 T 240 660" stroke="#10b981" stroke-width="2"
                        fill="none" opacity="0.15" />
                    <path d="M 0 400 Q 360 300, 720 400 T 1440 400" stroke="#059669" stroke-width="1.5" fill="none"
                        opacity="0.1" />
                    <path d="M 0 600 Q 360 550, 720 600 T 1440 600" stroke="#10b981" stroke-width="1.5" fill="none"
                        opacity="0.1" />
                </svg>
            </div>

            <!-- Animated Blobs -->
            <div class="absolute top-0 right-0 w-72 sm:w-96 h-72 sm:h-96 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"
                aria-hidden="true"></div>
            <div class="absolute bottom-0 left-0 w-72 sm:w-96 h-72 sm:h-96 bg-emerald-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"
                aria-hidden="true"></div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">
                <!-- Header Section -->
                <div class="text-center mb-12 lg:mb-16 max-w-3xl mx-auto" data-aos="fade-up">
                    <!-- Badge Fitur Unggulan -->
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white text-green-800 text-xs sm:text-sm font-bold uppercase tracking-widest border border-green-200 mb-4 sm:mb-6 shadow-sm">
                        <span>Fitur Unggulan</span>
                    </div>
                    <!-- Judul Section -->
                    <h2
                        class="text-2xl sm:text-3xl md:text-4xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4 sm:mb-6">
                        Ekosistem <span class="text-green-600">AgriSmart</span>
                    </h2>
                    <!-- Deskripsi Section -->
                    <p class="text-base sm:text-lg lg:text-xl text-slate-600 font-medium leading-relaxed">
                        Teknologi terintegrasi dari hulu ke hilir untuk hasil maksimal.
                    </p>
                </div>

                <!-- Grid Kartu Fitur -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    <!-- Kartu 1: Monitoring IoT -->
                    <div data-aos="fade-up" data-aos-delay="100"
                        class="group relative bg-white rounded-3xl p-6 sm:p-8 shadow-lg border border-green-100 hover:border-green-500 hover:shadow-xl hover:shadow-green-500/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden">
                        <div class="relative z-10 text-center">
                            <!-- Ikon Fitur -->
                            <div
                                class="w-16 h-16 sm:w-18 sm:h-18 bg-green-50 rounded-2xl flex items-center justify-center mb-5 text-green-600 group-hover:scale-110 group-hover:bg-green-600 group-hover:text-white transition-all duration-500 mx-auto">
                                <svg class="w-8 h-8 sm:w-9 sm:h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z">
                                    </path>
                                </svg>
                            </div>
                            <!-- Badge Real-time -->
                            <span
                                class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full mb-3 border border-green-200">Real-time</span>
                            <!-- Judul Fitur -->
                            <h3
                                class="text-xl sm:text-2xl font-bold text-slate-900 mb-2 group-hover:text-green-700 transition-colors duration-300">
                                Monitoring IoT</h3>
                            <!-- Deskripsi Fitur -->
                            <p class="text-slate-600 leading-relaxed mb-6 text-sm sm:text-base">
                                Pantau kelembaban, suhu, dan nutrisi tanah secara realtime melalui dashboard pintar
                                berbasis AI.
                            </p>
                            <!-- Tombol Aksi -->
                            <a href="#"
                                class="inline-block px-6 py-2.5 bg-green-600 text-white font-bold text-sm sm:text-base rounded-full shadow-md hover:bg-green-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">Lihat
                                Dashboard</a>
                        </div>
                    </div>

                    <!-- Kartu 2: Marketplace Tani -->
                    <div data-aos="fade-up" data-aos-delay="200"
                        class="group relative bg-white rounded-3xl p-6 sm:p-8 shadow-lg border border-green-100 hover:border-green-500 hover:shadow-xl hover:shadow-green-500/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden">
                        <div class="relative z-10 text-center">
                            <!-- Ikon Fitur -->
                            <div
                                class="w-16 h-16 sm:w-18 sm:h-18 bg-green-50 rounded-2xl flex items-center justify-center mb-5 text-green-600 group-hover:scale-110 group-hover:bg-green-600 group-hover:text-white transition-all duration-500 mx-auto">
                                <svg class="w-8 h-8 sm:w-9 sm:h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <!-- Badge Direct Trade -->
                            <span
                                class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full mb-3 border border-green-200">Direct
                                Trade</span>
                            <!-- Judul Fitur -->
                            <h3
                                class="text-xl sm:text-2xl font-bold text-slate-900 mb-2 group-hover:text-green-700 transition-colors duration-300">
                                Marketplace Tani</h3>
                            <!-- Deskripsi Fitur -->
                            <p class="text-slate-600 leading-relaxed mb-6 text-sm sm:text-base">
                                Jual beli hasil panen berkualitas langsung dari petani lokal dengan harga transparan dan
                                adil.
                            </p>
                            <!-- Tombol Aksi -->
                            <a href="{{ route('produk.index') }}"
                                class="inline-block px-6 py-2.5 bg-green-600 text-white font-bold text-sm sm:text-base rounded-full shadow-md hover:bg-green-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">Mulai
                                Belanja</a>
                        </div>
                    </div>

                    <!-- Kartu 3: Edukasi Tani -->
                    <div data-aos="fade-up" data-aos-delay="300"
                        class="group relative bg-white rounded-3xl p-6 sm:p-8 shadow-lg border border-green-100 hover:border-green-500 hover:shadow-xl hover:shadow-green-500/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden md:col-span-2 lg:col-span-1">
                        <div class="relative z-10 text-center">
                            <!-- Ikon Fitur -->
                            <div
                                class="w-16 h-16 sm:w-18 sm:h-18 bg-green-50 rounded-2xl flex items-center justify-center mb-5 text-green-600 group-hover:scale-110 group-hover:bg-green-600 group-hover:text-white transition-all duration-500 mx-auto">
                                <svg class="w-8 h-8 sm:w-9 sm:h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                            <!-- Badge Expert Tips -->
                            <span
                                class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full mb-3 border border-green-200">Expert
                                Tips</span>
                            <!-- Judul Fitur -->
                            <h3
                                class="text-xl sm:text-2xl font-bold text-slate-900 mb-2 group-hover:text-green-700 transition-colors duration-300">
                                Edukasi Tani</h3>
                            <!-- Deskripsi Fitur -->
                            <p class="text-slate-600 leading-relaxed mb-6 text-sm sm:text-base">
                                Tingkatkan wawasan bertani melalui artikel, video tutorial, dan modul lengkap dari ahli
                                agronomi.
                            </p>
                            <!-- Tombol Aksi -->
                            <a href="{{ route('edukasi.index') }}"
                                class="inline-block px-6 py-2.5 bg-green-600 text-white font-bold text-sm sm:text-base rounded-full shadow-md hover:bg-green-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">Baca
                                Artikel</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================= SECTION: PRODUK ============================= -->
        <section class="py-12 md:py-16 lg:py-24 relative bg-white border-t border-green-50 overflow-hidden">
            <!-- Background Effects -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-full md:w-[1000px] h-[300px] md:h-[500px] bg-green-50/40 rounded-full blur-[80px] md:blur-[120px] -mt-20 md:-mt-32">
                </div>
                <div
                    class="absolute bottom-0 right-0 w-[300px] md:w-[600px] h-[200px] md:h-[400px] bg-green-50/30 rounded-full blur-[60px] md:blur-[100px] translate-y-1/3 translate-x-1/3">
                </div>

                <!-- SVG Decorations -->
                <svg class="absolute top-0 right-0 w-[350px] md:w-[700px] h-[350px] md:h-[700px] opacity-25 translate-x-1/4 md:translate-x-1/3 -translate-y-1/4"
                    viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 Q 50 -20 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                    <path d="M0 100 Q 50 0 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                    <path d="M0 100 Q 50 20 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                </svg>
                <svg class="absolute bottom-0 left-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] opacity-20 -translate-x-1/3 translate-y-1/4 rotate-180"
                    viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 Q 50 0 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                    <path d="M0 100 Q 50 20 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                    <path d="M0 100 Q 50 40 100 100" stroke="#dcfce7" stroke-width="0.5" fill="none" />
                </svg>
                <svg class="absolute top-10 left-0 md:left-10 w-[150px] md:w-[300px] h-[150px] md:h-[300px] opacity-10 rotate-12 -translate-x-1/4 md:translate-x-0"
                    viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 Q 50 10 100 100" stroke="#dcfce7" stroke-width="0.8" fill="none" />
                    <path d="M0 100 Q 50 30 100 100" stroke="#dcfce7" stroke-width="0.8" fill="none" />
                </svg>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <!-- Header Section -->
                <div class="text-center max-w-3xl mx-auto mb-10 md:mb-12 lg:mb-16" data-aos="fade-up">
                    <!-- Badge Pasar Segar -->
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1.5 md:px-4 md:py-2 rounded-full bg-emerald-50 text-green-700 text-[10px] md:text-[11px] font-bold uppercase tracking-widest border border-green-100 mb-3 md:mb-5 shadow-sm hover:shadow-md transition-shadow">
                        <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Pasar Segar
                    </span>
                    <!-- Judul Section -->
                    <h2
                        class="text-2xl md:text-3xl lg:text-5xl font-extrabold text-slate-900 leading-tight mb-3 lg:mb-4">
                        Panen <span class="text-green-600 relative inline-block">
                            Terbaik
                            <svg class="absolute -bottom-1 left-0 w-full h-1.5 md:h-2" viewBox="0 0 100 10"
                                preserveAspectRatio="none">
                                <path d="M0 8 Q 50 0, 100 8" stroke="#10b981" stroke-width="2" fill="none"
                                    opacity="0.3" />
                            </svg>
                        </span>
                    </h2>
                    <!-- Deskripsi Section -->
                    <p class="text-slate-600 text-sm md:text-base lg:text-lg leading-relaxed px-2 md:px-0">
                        Hasil pertanian berkualitas langsung dari petani lokal untuk kebutuhan dapur Anda sehari-hari.
                    </p>
                </div>

                <!-- Grid Produk -->
                @if(isset($produk) && !$produk->isEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                        @foreach($produk as $index => $item)
                            <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                                class="group bg-white rounded-2xl overflow-hidden border border-slate-200 hover:border-green-500 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 h-full flex flex-col">
                                <!-- Gambar Produk -->
                                <div class="relative aspect-square overflow-hidden bg-slate-50 flex-shrink-0">
                                    @if($item->foto_produk)
                                        <img src="{{ asset('storage/' . $item->foto_produk) }}" alt="{{ $item->nama_produk }}"
                                            loading="lazy"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <!-- Placeholder jika tidak ada gambar -->
                                        <div class="w-full h-full flex items-center justify-center">
                                            <div class="text-center">
                                                <svg class="w-12 h-12 md:w-16 md:h-16 mx-auto text-slate-300 mb-2" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                <p class="text-xs text-slate-400 font-medium">No Image</p>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Badge Kategori -->
                                    <div
                                        class="absolute top-3 right-3 bg-green-600 px-2.5 py-1 rounded-lg text-[10px] font-bold text-white shadow-md uppercase tracking-wide">
                                        {{ $item->kategoriProduk->nama_kategori ?? 'Umum' }}
                                    </div>
                                </div>

                                <!-- Detail Produk -->
                                <div class="p-4 md:p-5 bg-white flex flex-col flex-grow">
                                    <!-- Nama Produk -->
                                    <h3
                                        class="text-base md:text-lg font-bold text-slate-900 mb-3 line-clamp-1 group-hover:text-green-600 transition-colors">
                                        {{ $item->nama_produk }}
                                    </h3>

                                    <!-- Info Stok -->
                                    <div
                                        class="flex items-center justify-between mb-4 bg-slate-50 rounded-lg px-3 py-2 mt-auto">
                                        <span class="text-xs text-slate-600 font-medium">Stok Tersedia</span>
                                        <span
                                            class="text-sm font-bold {{ ($item->stok ?? 0) > 0 ? 'text-green-600' : 'text-red-500' }}">
                                            {{ $item->stok ?? 0 }} {{ $item->satuan ?? '' }}
                                        </span>
                                    </div>

                                    <!-- Harga & Tombol Aksi -->
                                    <div class="flex items-center justify-between pt-2">
                                        <!-- Harga -->
                                        <div>
                                            <p class="text-xs text-slate-500 font-medium mb-1">Harga</p>
                                            <p class="text-xl md:text-2xl font-bold text-slate-900">
                                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                                            </p>
                                            <p class="text-[10px] md:text-xs text-slate-500 mt-0.5">per
                                                {{ $item->satuan ?? 'kg' }}
                                            </p>
                                        </div>

                                        <!-- Tombol Detail Produk -->
                                        <a href="{{ route('produk.show', $item->id) }}"
                                            class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 rounded-xl bg-green-600 hover:bg-green-700 flex items-center justify-center text-white transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 active:scale-95">
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

                    <!-- Tombol Lihat Semua Produk -->
                    <div class="mt-10 lg:mt-16 text-center" data-aos="fade-up">
                        <a href="{{ route('produk.index') }}"
                            class="group inline-flex items-center gap-2 px-6 py-3 lg:px-10 lg:py-4 rounded-full bg-green-600 text-white font-bold hover:bg-green-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1 text-sm lg:text-base">
                            <span>Lihat Semua Produk</span>
                            <svg class="w-4 h-4 lg:w-5 lg:h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>

                @else
                    <!-- State Kosong: Tidak Ada Produk -->
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

        <!-- ============================= SECTION: EDUKASI ============================= -->
        <section id="edukasi-preview" class="py-16 lg:py-24 relative overflow-hidden bg-[#F0FDF4]">
            <!-- Background Effects -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
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

                <!-- Animated Blobs -->
                <div class="absolute top-0 right-0 w-72 sm:w-96 h-72 sm:h-96 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"
                    aria-hidden="true"></div>
                <div class="absolute bottom-0 left-0 w-72 sm:w-96 h-72 sm:h-96 bg-emerald-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"
                    aria-hidden="true"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-72 sm:w-96 h-72 sm:h-96 bg-teal-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"
                    aria-hidden="true"></div>
            </div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">
                <!-- Header Section -->
                <div class="text-center mb-12 lg:mb-20 max-w-3xl mx-auto" data-aos="fade-up">
                    <!-- Badge Pusat Pengetahuan -->
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 lg:px-5 lg:py-2.5 rounded-full bg-white text-green-700 text-xs font-bold uppercase tracking-widest border border-green-200 mb-4 lg:mb-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        Pusat Pengetahuan
                    </span>

                    <!-- Judul Section -->
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

                    <!-- Deskripsi Section -->
                    <p
                        class="text-base md:text-lg lg:text-xl text-slate-600 mb-8 lg:mb-10 max-w-2xl mx-auto leading-relaxed font-medium px-4 sm:px-0">
                        Perluas wawasan pertanian Anda dengan artikel pilihan, tips budidaya, dan inovasi teknologi
                        terbaru.
                    </p>
                </div>

                <!-- Grid Artikel Edukasi -->
                @if(isset($edukasi) && !$edukasi->isEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                        @foreach($edukasi as $index => $item)
                            <a href="{{ route('edukasi.show', $item->slug) }}"
                                class="group block {{ $index === 0 ? 'md:col-span-2 md:row-span-2' : '' }}" data-aos="zoom-in"
                                data-aos-delay="{{ $index * 100 }}">
                                <div
                                    class="relative h-full bg-gradient-to-br from-white via-white to-green-50 rounded-2xl lg:rounded-[2rem] overflow-hidden shadow-lg hover:shadow-2xl hover:shadow-green-900/10 transition-all duration-500 border border-green-100 hover:border-green-300 group-hover:-translate-y-2">
                                    <div
                                        class="relative h-full min-h-[250px] sm:min-h-[300px] {{ $index === 0 ? 'md:min-h-[400px] lg:min-h-[550px]' : 'lg:min-h-[350px]' }}">
                                        @if($item->foto_sampul)
                                            <!-- Gambar Artikel -->
                                            <img src="{{ asset('storage/' . $item->foto_sampul) }}" alt="{{ $item->judul }}"
                                                loading="lazy"
                                                class="absolute inset-0 w-full h-full object-cover opacity-95 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700">
                                        @else
                                            <!-- Placeholder jika tidak ada gambar -->
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

                                        <!-- Gradient Overlay -->
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-green-950/90 via-green-900/30 to-transparent">
                                        </div>

                                        <!-- Konten Overlay -->
                                        <div class="absolute inset-0 p-5 lg:p-8 flex flex-col justify-end">
                                            <div
                                                class="space-y-3 lg:space-y-4 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                                                <!-- Kategori & Tanggal -->
                                                <div class="flex items-center gap-3">
                                                    <span
                                                        class="px-2 py-1 lg:px-3 lg:py-1 bg-white/90 backdrop-blur-sm text-green-700 text-[10px] font-bold uppercase tracking-wider rounded-full shadow-sm">
                                                        {{ $item->kategoriEdukasi->nama_kategori ?? 'Tips' }}
                                                    </span>
                                                    <span
                                                        class="text-green-50 text-xs font-semibold tracking-wide">{{ $item->created_at->format('d M Y') }}</span>
                                                </div>

                                                <!-- Judul Artikel -->
                                                <h3
                                                    class="text-xl {{ $index === 0 ? 'lg:text-3xl xl:text-4xl' : 'lg:text-2xl' }} font-bold text-white leading-tight drop-shadow-sm group-hover:text-green-100 transition-colors">
                                                    {{ $item->judul }}
                                                </h3>

                                                <!-- Excerpt (hanya untuk item pertama) -->
                                                @if($index === 0)
                                                    <p
                                                        class="text-green-50 text-sm lg:text-base xl:text-lg leading-relaxed line-clamp-2 md:line-clamp-3 opacity-90 group-hover:opacity-100 transition-opacity duration-500 font-medium">
                                                        {{ Str::limit(strip_tags($item->isi_konten), 150) }}
                                                    </p>
                                                @endif

                                                <!-- Link Baca Selengkapnya -->
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
                    <!-- State Kosong: Tidak Ada Artikel -->
                    <div class="max-w-2xl mx-auto" data-aos="fade-up">
                        <div class="text-center py-20 px-6 bg-white rounded-3xl border border-green-200">
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

                            <h3 class="text-2xl font-bold text-slate-900 mb-3">Konten Segera Hadir!</h3>
                            <p class="text-slate-600 leading-relaxed max-w-md mx-auto mb-6">
                                Kami sedang menyiapkan artikel edukatif berkualitas tinggi untuk meningkatkan pengetahuan
                                pertanian Anda. Nantikan konten menarik dari kami segera!
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Tombol Lihat Semua Artikel -->
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

        <!-- ============================= SECTION: TENTANG KAMI ============================= -->
        <section id="tentang-kami" class="py-12 md:py-16 lg:py-24 bg-white overflow-hidden">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 md:gap-12 lg:gap-16 items-center">
                    <!-- Kolom Gambar -->
                    <div class="relative w-full max-w-md mx-auto lg:max-w-none px-4 sm:px-8 lg:px-0"
                        data-aos="fade-right">
                        <!-- Efek Latar Belakang Gambar -->
                        <div
                            class="absolute -top-3 -left-2 sm:-top-4 sm:-left-4 w-full h-full bg-green-100 rounded-[2rem] sm:rounded-[2.5rem] transform -rotate-2">
                        </div>
                        <div
                            class="absolute -bottom-3 -right-2 sm:-bottom-4 sm:-right-4 w-full h-full bg-slate-100 rounded-[2rem] sm:rounded-[2.5rem] transform rotate-2">
                        </div>

                        <!-- Container Gambar Utama -->
                        <div
                            class="relative rounded-2xl sm:rounded-[2rem] overflow-hidden shadow-2xl border-4 border-white group">
                            <img src="{{ asset('images/hero2.png') }}" alt="Tim AgriSmart"
                                class="w-full h-auto object-cover grayscale group-hover:grayscale-0 transition-all duration-700 scale-100 group-hover:scale-105">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-green-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Konten -->
                    <div data-aos="fade-left" class="px-2 sm:px-0 text-center lg:text-left">
                        <!-- Badge Tentang Kami -->
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-green-50 text-green-700 text-[10px] sm:text-xs font-bold uppercase tracking-widest mb-3 sm:mb-4 border border-green-100">
                            Tentang Kami
                        </span>

                        <!-- Judul Section -->
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

                        <!-- Deskripsi Section -->
                        <p
                            class="text-sm sm:text-base lg:text-lg text-slate-600 leading-relaxed mb-6 lg:mb-8 max-w-2xl mx-auto lg:mx-0">
                            AgriSmart hadir untuk menjembatani kesenjangan teknologi bagi petani Indonesia. Kami percaya
                            bahwa dengan akses yang tepat terhadap teknologi IoT dan pasar digital, kesejahteraan petani
                            dapat meningkat pesat.
                        </p>

                        <!-- Daftar Fitur -->
                        <ul class="space-y-3 lg:space-y-4 max-w-xl mx-auto lg:mx-0">
                            <!-- Fitur 1: Transparansi Harga -->
                            <li
                                class="flex items-start gap-3 lg:gap-4 p-3 sm:p-4 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all duration-300 group text-left">
                                <div
                                    class="w-10 h-10 lg:w-12 lg:h-12 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm sm:text-base lg:text-lg">Transparansi
                                        Harga</h4>
                                    <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">Jaminan harga adil
                                        untuk petani dan konsumen dengan sistem yang terbuka.</p>
                                </div>
                            </li>

                            <!-- Fitur 2: Teknologi Berkelanjutan -->
                            <li
                                class="flex items-start gap-3 lg:gap-4 p-3 sm:p-4 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all duration-300 group text-left">
                                <div
                                    class="w-10 h-10 lg:w-12 lg:h-12 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm sm:text-base lg:text-lg">Teknologi
                                        Berkelanjutan</h4>
                                    <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">Solusi ramah
                                        lingkungan untuk jangka panjang demi masa depan yang lebih baik.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================= SECTION: KONTAK ============================= -->
        <section id="kontak" class="py-16 lg:py-24 relative bg-[#F0FDF4] overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <!-- Header Section -->
                <div class="text-center max-w-3xl mx-auto mb-12 lg:mb-16" data-aos="fade-up">
                    <!-- Badge Hubungi Kami -->
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white text-green-700 text-xs font-bold uppercase tracking-widest mb-3 lg:mb-4 border border-green-100 shadow-sm">
                        Hubungi Kami
                    </span>
                    <!-- Judul Section -->
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
                    <!-- Deskripsi Section -->
                    <p class="text-slate-600 text-base lg:text-lg leading-relaxed font-medium px-4 sm:px-0">
                        Ayo bergabung bersama kami dan menjadi bagian dari Petani Masa Depan. Cukup dengan mengisi
                        formulir untuk memulai langkah besar Anda.
                    </p>
                </div>

                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12">
                    <!-- Kolom Kiri: Info & Gambar -->
                    <div class="space-y-6" data-aos="fade-right">
                        <!-- Gambar Lokasi -->
                        <div class="relative w-full h-[350px] lg:h-[450px] overflow-hidden group">
                            <img src="{{ asset('images/hero3.png') }}" alt="Lokasi Kami"
                                class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 ease-in-out">
                        </div>

                        <!-- Info Waktu Respon -->
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

                        <!-- Metode Kontak -->
                        <div class="grid sm:grid-cols-2 gap-4">
                            <!-- Email -->
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
                                            support@agrismart.id</p>
                                    </div>
                                </div>
                            </a>

                            <!-- WhatsApp -->
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
                                            +62 812 3456 7890</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Formulir Kontak -->
                    <div data-aos="fade-left" class="h-full">
                        <div
                            class="bg-white rounded-3xl p-8 lg:p-10 border border-green-50 shadow-xl h-full flex flex-col justify-center">
                            <!-- Header Form -->
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

                            <!-- Pesan Sukses -->
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

                            <!-- Formulir Kontak -->
                            <form action="{{ route('kontak.store') }}" method="POST" class="space-y-5">
                                @csrf

                                <!-- Field: Nama Lengkap -->
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

                                <!-- Grid: Telepon & Email -->
                                <div class="grid md:grid-cols-2 gap-5">
                                    <!-- Field: Nomor WhatsApp -->
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

                                    <!-- Field: Email -->
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

                                <!-- Field: Pesan -->
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

                                <!-- Tombol Kirim -->
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

    <!-- ============================= FOOTER ============================= -->
    <x-footer />

    <!-- ============================= TOMBOL BACK TO TOP ============================= -->
    <x-back-button />

    <!-- ============================= SCRIPTS ============================= -->
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