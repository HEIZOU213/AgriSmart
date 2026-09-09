<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <!-- ============================= META & SEO ============================= -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="Platform Perkebunan Durian Cerdas Masa Depan. Dapatkan durian premium dengan teknologi IoT dan akses kebun langsung.">
    <meta name="keywords" content="Durian, Perkebunan Durian, IoT, AgriSmart, Pekebun Durian, Marketplace Durian">
    <meta property="og:title" content="{{ config('app.name', 'AgriSmart') }} - Perkebunan Durian Cerdas">
    <meta property="og:description" content="Solusi IoT perkebunan durian terintegrasi dari hulu ke hilir.">
    <meta property="og:image" content="{{ asset('images/hero1.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon & Title -->
    <x-favicon />
    <title>{{ config('app.name', 'AgriSmart') }}</title>

    <!-- ============================= FONTS & LIBRARIES ============================= -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"></noscript>

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

        /* ===================== ANIMASI FLOAT ===================== */
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-delayed {
            animation: float-delayed 7s ease-in-out infinite 1s;
        }

        @keyframes float-delayed {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        @keyframes float {
            0%   { transform: translateY(0px); }
            50%  { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        /* ===================== LINE CLAMP ===================== */
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

        /* ===================== LOGO FLOAT AROUND ===================== */
        @keyframes float-around {
            0%   { transform: translate(0vw, -10vh) rotate(0deg); }
            25%  { transform: translate(60vw, 20vh) rotate(15deg) scale(1.1); }
            50%  { transform: translate(40vw, 70vh) rotate(-10deg) scale(0.9); }
            75%  { transform: translate(-10vw, 50vh) rotate(20deg) scale(1.05); }
            100% { transform: translate(0vw, -10vh) rotate(0deg); }
        }
        .animate-float-around {
            animation: float-around 40s ease-in-out infinite;
        }

        /* ===================== SPIN SLOW ===================== */
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 20s linear infinite;
        }

        /* ===================== IMAGE OPTIMASI ===================== */
        img { max-width: 100%; height: auto; }
        .aspect-square img { object-fit: cover; width: 100%; height: 100%; }

        /* ===================== HERO: PURE WHITE BG ===================== */
        .hero-white-bg {
            background-color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        /* ===================== HERO: SPOTLIGHT CARD ===================== */
        .spotlight-card {
            position: relative;
            border-radius: 1.5rem;
            overflow: hidden;
            isolation: isolate;
        }
        .spotlight-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(600px circle at var(--mouse-x, 50%) var(--mouse-y, 50%),
                rgba(134,239,172,0.18) 0%,
                transparent 60%);
            opacity: 0;
            transition: opacity 0.4s ease;
            pointer-events: none;
            z-index: 1;
            border-radius: inherit;
        }
        .spotlight-card:hover::before {
            opacity: 1;
        }

        /* ===================== HERO: TYPEWRITER ===================== */
        .typewriter-cursor {
            display: inline-block;
            width: 3px;
            height: 1em;
            background: #16a34a;
            margin-left: 4px;
            vertical-align: middle;
            animation: blink-cursor 0.75s step-end infinite;
        }
        @keyframes blink-cursor {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0; }
        }

        /* ===================== HERO: SHIMMER BADGE ===================== */
        .shimmer-badge {
            position: relative;
            overflow: hidden;
        }
        .shimmer-badge::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.7), transparent);
            animation: badge-shimmer 3s ease-in-out infinite 1s;
        }
        @keyframes badge-shimmer {
            0%   { left: -100%; }
            100% { left: 200%; }
        }

        /* ===================== HERO: STICKER PEEL BADGE ===================== */
        .sticker-peel {
            position: relative;
            transform-origin: top left;
            transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1);
        }
        .sticker-peel:hover {
            transform: rotate(-3deg) scale(1.08);
        }
        .sticker-peel::after {
            content: '';
            position: absolute;
            bottom: -4px; right: -4px;
            width: 14px; height: 14px;
            background: linear-gradient(135deg, #bbf7d0 50%, rgba(0,0,0,0.08) 50%);
            clip-path: polygon(100% 0, 0 100%, 100% 100%);
            border-radius: 0 0 4px 0;
        }

        /* ===================== HERO: ENTRANCE ANIMATIONS ===================== */
        @keyframes hero-fade-up {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes hero-fade-right {
            from { opacity: 0; transform: translateX(-40px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes hero-fade-left {
            from { opacity: 0; transform: translateX(40px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes hero-scale-in {
            from { opacity: 0; transform: scale(0.85); }
            to   { opacity: 1; transform: scale(1); }
        }
        .hero-anim-badge   { animation: hero-fade-up    0.6s cubic-bezier(0.34,1.56,0.64,1) 0.2s both; }
        .hero-anim-title   { animation: hero-fade-right 0.8s cubic-bezier(0.22,1,0.36,1)    0.4s both; }
        .hero-anim-desc    { animation: hero-fade-up    0.7s ease-out                        0.65s both; }
        .hero-anim-btns    { animation: hero-fade-up    0.7s ease-out                        0.85s both; }
        .hero-anim-stats   { animation: hero-fade-up    0.7s ease-out                        1.05s both; }
        .hero-anim-img     { animation: hero-fade-left  0.9s cubic-bezier(0.22,1,0.36,1)    0.5s both; }
        .hero-anim-floater { animation: hero-scale-in   0.6s cubic-bezier(0.34,1.56,0.64,1) var(--delay,0.8s) both; }

        /* ===================== HERO: 3D TILT CARD ===================== */
        .tilt-card {
            transform-style: preserve-3d;
            transform: perspective(900px) rotateX(0deg) rotateY(0deg);
            transition: transform 0.08s linear, box-shadow 0.3s ease;
            border-radius: 1.5rem;
            will-change: transform;
        }
        .tilt-card:hover {
            box-shadow: 0 30px 80px rgba(22,163,74,0.15);
        }
        .tilt-card .tilt-shine {
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: radial-gradient(circle at var(--tx,50%) var(--ty,50%),
                rgba(255,255,255,0.18) 0%,
                transparent 65%);
            pointer-events: none;
            z-index: 10;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .tilt-card:hover .tilt-shine { opacity: 1; }


        /* ===================== HERO: MORPH SVG ORB ===================== */
        .hero-morph-orb {
            position: absolute;
            pointer-events: none;
            animation: orb-drift var(--dur, 12s) ease-in-out infinite var(--del, 0s);
            opacity: var(--op, 0.4);
        }
        @keyframes orb-drift {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33%       { transform: translate(var(--tx1,20px), var(--ty1,-30px)) scale(1.1); }
            66%       { transform: translate(var(--tx2,-15px), var(--ty2,20px)) scale(0.95); }
        }

        /* ===================== HERO: LOOP MARQUEE (LOGO) ===================== */
        .marquee-logo-track {
            display: flex;
            align-items: center;
            width: max-content;
            animation: marquee-loop 18s linear infinite;
        }
        .marquee-logo-track:hover { animation-play-state: paused; }
        @keyframes marquee-loop {
            from { transform: translateX(-50%); }
            to   { transform: translateX(0); }
        }
        .marquee-logo-item {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            padding: 0 40px;
            opacity: 0.55;
            transition: opacity 0.3s ease, transform 0.3s ease;
            filter: grayscale(1);
        }
        .marquee-logo-item:hover {
            opacity: 1;
            filter: grayscale(0);
            transform: scale(1.08);
        }



        /* ===================== HERO: IMAGE RING ===================== */
        @keyframes ring-rotate {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }
    </style>
</head>

<body
    class="font-sans antialiased text-slate-700 bg-green-50 flex flex-col min-h-screen selection:bg-green-500 selection:text-white">

    <!-- Preloader Website -->
    <x-preloader />

    <!-- ============================= BACKGROUND LOGO ANIMATION ============================= -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0 opacity-10">
        <img src="{{ asset('images/nav-logo.png') }}" alt="Background Logo" width="300" height="300"
            class="absolute top-0 left-0 w-64 h-auto md:w-96 animate-float-around object-contain">
    </div>

    <!-- ============================= NAVBAR KOMPONEN ============================= -->
    <div class="relative z-50">
        <x-navbar />
    </div>

    <main class="flex-1">

        <!-- ============================= SECTION: HERO ============================= -->
        <section id="hero" class="hero-white-bg overflow-hidden min-h-[93vh] flex flex-col justify-center pt-24 pb-4 lg:pt-28 lg:pb-6">

            <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                <!-- Grid: Konten vs Gambar -->
                <div class="grid lg:grid-cols-2 gap-10 lg:gap-12 items-center mb-0">

                    <!-- ===================== KOLOM KIRI: KONTEN TEKS ===================== -->
                    <div class="text-center lg:text-left order-1">

                        <!-- Judul Utama dengan Typewriter -->
                        <h1 class="hero-anim-title text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight mb-4 lg:mb-6 tracking-tight">
                            Perkebunan Durian <br class="hidden sm:block">
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 via-emerald-500 to-teal-500">
                                <span id="hero-typewriter">Cerdas Terintegrasi</span><span class="typewriter-cursor"></span>
                            </span>
                        </h1>

                        <!-- Deskripsi -->
                        <p class="hero-anim-desc text-base sm:text-lg text-slate-600 mb-8 lg:mb-10 leading-relaxed max-w-xl font-medium mx-auto lg:mx-0">
                            Platform <strong class="text-green-700">Perkebunan Cerdas Masa Depan</strong> — pantau kebun via sensor <strong class="text-green-700">IoT</strong>, jual durian premium langsung ke pembeli, dan tingkatkan ilmu budidaya dari para ahli agronomi.
                        </p>

                        <!-- Container Tombol Aksi -->
                        <div class="hero-anim-btns flex flex-col sm:flex-row gap-3 lg:gap-4 justify-center lg:justify-start w-full sm:w-auto mb-8 lg:mb-10">
                            <!-- Tombol Utama: Mulai Sekarang -->
                            <a href="#fitur-unggulan"
                                class="group/btn relative inline-flex justify-center items-center px-6 lg:px-8 py-3 lg:py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-extrabold rounded-xl shadow-lg shadow-green-500/30 hover:shadow-green-500/50 hover:scale-105 transition-all duration-300 text-sm lg:text-base w-full sm:w-auto overflow-hidden">
                                <span class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-green-500 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></span>
                                <span class="relative z-10">
                                    Mulai Sekarang
                                </span>
                            </a>

                            <!-- Tombol Sekunder: Tonton Video -->
                            <a href="#edukasi-preview"
                                class="group/btn2 inline-flex justify-center items-center gap-2 px-6 lg:px-8 py-3 lg:py-4 border-2 border-green-500 text-green-700 font-bold rounded-xl hover:bg-green-600 hover:text-white hover:border-green-600 hover:scale-105 transition-all duration-300 text-sm lg:text-base w-full sm:w-auto">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                                <span>Tonton Video</span>
                            </a>
                        </div>

                        <!-- Mini Stats Row (Data Real dari Database) -->
                        <div class="hero-anim-stats flex flex-wrap gap-4 justify-center lg:justify-start">
                            <div class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                                <span class="text-2xl font-extrabold text-green-600">{{ $heroStats['jumlah_petani'] }}</span> Mitra Kebun
                            </div>
                            <span class="text-slate-300">|</span>
                            <div class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                                <span class="text-2xl font-extrabold text-green-600">{{ $heroStats['jumlah_produk'] }}</span> Varian Durian
                            </div>
                            <span class="text-slate-300">|</span>
                            <div class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                                <span class="text-2xl font-extrabold text-green-600">{{ $heroStats['pesanan_selesai'] }}</span> Durian Terkirim
                            </div>
                        </div>
                    </div>

                    <!-- ===================== KOLOM KANAN: GAMBAR HERO ===================== -->
                    <div class="relative block order-2 mt-8 lg:mt-0 hero-anim-img">

                        <!-- Morph Orbs (floating blobs di belakang gambar) -->
                        <div class="hero-morph-orb w-72 h-72 rounded-full bg-green-200/50 -top-10 -right-10"
                            style="--dur:10s;--del:0s;--op:0.35;--tx1:25px;--ty1:-20px;--tx2:-15px;--ty2:25px;"></div>
                        <div class="hero-morph-orb w-56 h-56 rounded-full bg-emerald-200/40 bottom-0 -left-8"
                            style="--dur:13s;--del:-4s;--op:0.28;--tx1:-20px;--ty1:15px;--tx2:18px;--ty2:-25px;"></div>

                        <!-- Spotlight + 3D Tilt Card Wrapper -->
                        <div id="hero-spotlight" class="spotlight-card relative w-full max-w-sm sm:max-w-md lg:max-w-lg mx-auto">

                            <!-- 3D Tilt Container -->
                            <div id="hero-tilt" class="tilt-card cursor-pointer">

                                <!-- Shine overlay -->
                                <div class="tilt-shine"></div>

                                <!-- Gambar Utama -->
                                <div class="animate-float">
                                    <div class="relative w-full h-full [mask-image:radial-gradient(ellipse_at_center,black_65%,transparent_100%)] [-webkit-mask-image:radial-gradient(ellipse_at_center,black_65%,transparent_100%)]">
                                        <img src="{{ asset('images/hero4.png') }}" alt="Dashboard Perkebunan Durian" width="500" height="500"
                                            class="w-full h-auto object-cover">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================= HERO JS ANIMATIONS ============================= -->
        <script>
        (function() {
            // ---- TYPEWRITER ----
            const words = ['Cerdas Terintegrasi', 'Cerdas Masa Depan'];
            let wi = 0, ci = 0, deleting = false;
            const el = document.getElementById('hero-typewriter');
            function type() {
                if (!el) return;
                const word = words[wi];
                if (!deleting) {
                    el.textContent = word.substring(0, ci + 1);
                    ci++;
                    if (ci === word.length) { deleting = true; setTimeout(type, 2000); return; }
                    setTimeout(type, 90);
                } else {
                    el.textContent = word.substring(0, ci - 1);
                    ci--;
                    if (ci === 0) { deleting = false; wi = (wi + 1) % words.length; setTimeout(type, 400); return; }
                    setTimeout(type, 50);
                }
            }
            setTimeout(type, 800);

            // ---- SPOTLIGHT CARD ----
            const card = document.getElementById('hero-spotlight');
            if (card) {
                card.addEventListener('mousemove', function(e) {
                    const rect = card.getBoundingClientRect();
                    const x = ((e.clientX - rect.left) / rect.width * 100).toFixed(1) + '%';
                    const y = ((e.clientY - rect.top) / rect.height * 100).toFixed(1) + '%';
                    card.style.setProperty('--mouse-x', x);
                    card.style.setProperty('--mouse-y', y);
                });
            }

            // ---- 3D TILT (react-parallax-tilt style) ----
            const tilt = document.getElementById('hero-tilt');
            if (tilt) {
                const MAX_TILT = 12; // derajat
                tilt.addEventListener('mousemove', function(e) {
                    const rect = tilt.getBoundingClientRect();
                    const cx   = rect.left + rect.width  / 2;
                    const cy   = rect.top  + rect.height / 2;
                    const dx   = (e.clientX - cx) / (rect.width  / 2); // -1 to 1
                    const dy   = (e.clientY - cy) / (rect.height / 2); // -1 to 1
                    const rotX = (-dy * MAX_TILT).toFixed(2);
                    const rotY = ( dx * MAX_TILT).toFixed(2);
                    // Shine position
                    const tx = ((e.clientX - rect.left) / rect.width  * 100).toFixed(1);
                    const ty = ((e.clientY - rect.top)  / rect.height * 100).toFixed(1);
                    tilt.style.transform = `perspective(900px) rotateX(${rotX}deg) rotateY(${rotY}deg) scale3d(1.03,1.03,1.03)`;
                    tilt.style.setProperty('--tx', tx + '%');
                    tilt.style.setProperty('--ty', ty + '%');
                });
                tilt.addEventListener('mouseleave', function() {
                    tilt.style.transform = 'perspective(900px) rotateX(0deg) rotateY(0deg) scale3d(1,1,1)';
                });
            }
        })();
        </script>

        <!-- ===================== LOOP MARQUEE LOGO (FULL WIDTH) ===================== -->
        <div class="relative w-full overflow-hidden bg-white border-y border-slate-100 shadow-sm py-5">
            <!-- Fade edges kiri & kanan -->
            <div class="absolute left-0 top-0 h-full w-16 md:w-32 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
            <div class="absolute right-0 top-0 h-full w-16 md:w-32 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>

            <div class="marquee-logo-track">
                {{-- Set 1: logo AgriSmart diulang beberapa kali untuk kepadatan strip --}}
                @for($i = 0; $i < 12; $i++)
                <div class="marquee-logo-item">
                    <img src="{{ asset('images/nav-logo.png') }}" alt="AgriSmart" class="h-8 w-auto object-contain">
                </div>
                @endfor
                {{-- Set 2: duplikat identik agar loop mulus (seamless) --}}
                @for($i = 0; $i < 12; $i++)
                <div class="marquee-logo-item">
                    <img src="{{ asset('images/nav-logo.png') }}" alt="AgriSmart" class="h-8 w-auto object-contain">
                </div>
                @endfor
            </div>
        </div>

        <!-- ============================= SECTION: FITUR UNGGULAN ============================= -->
        <section id="fitur-unggulan" class="py-16 sm:py-20 lg:py-32 overflow-hidden bg-[#F0FDF4] scroll-mt-16">
            <span id="layanan" class="scroll-mt-24"></span>


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
                            <a href="{{ route('layanan.index') }}"
                                class="inline-block px-6 py-2.5 bg-green-600 text-white font-bold text-sm sm:text-base rounded-full shadow-md hover:bg-green-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">Lihat
                                Dashboard</a>
                        </div>
                    </div>

                    <!-- Kartu 2: Marketplace Durian -->
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
                                Marketplace Durian</h3>
                            <!-- Deskripsi Fitur -->
                            <p class="text-slate-600 leading-relaxed mb-6 text-sm sm:text-base">
                                Jual beli durian kualitas premium langsung dari pekebun lokal dengan harga transparan dan
                                adil.
                            </p>
                            <!-- Tombol Aksi -->
                            <a href="{{ route('produk.index') }}"
                                class="inline-block px-6 py-2.5 bg-green-600 text-white font-bold text-sm sm:text-base rounded-full shadow-md hover:bg-green-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">Mulai
                                Belanja</a>
                        </div>
                    </div>

                    <!-- Kartu 3: Edukasi Durian -->
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
                                Edukasi Durian</h3>
                            <!-- Deskripsi Fitur -->
                            <p class="text-slate-600 leading-relaxed mb-6 text-sm sm:text-base">
                                Tingkatkan wawasan budidaya durian melalui artikel, video tutorial, dan modul lengkap dari ahli
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

        <!-- ============================= SECTION: PRODUK TERBARU ============================= -->
        <section class="py-12 md:py-16 lg:py-24 bg-white border-t border-green-50 overflow-hidden">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <!-- Header Section -->
                <div class="text-center max-w-3xl mx-auto mb-10 md:mb-12 lg:mb-16" data-aos="fade-up">
                    <!-- Badge panen durian -->
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1.5 md:px-4 md:py-2 rounded-full bg-emerald-50 text-green-700 text-[10px] md:text-[11px] font-bold uppercase tracking-widest border border-green-100 mb-3 md:mb-5 shadow-sm hover:shadow-md transition-shadow">
                        panen durian
                    </span>
                    <!-- Judul Section -->
                    <h2
                        class="text-2xl md:text-3xl lg:text-5xl font-extrabold text-slate-900 leading-tight mb-3 lg:mb-4">
                        Panen Durian <span class="text-green-600 relative inline-block">
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
                        Durian premium matang pohon langsung dari kebun lokal untuk kepuasan Anda.
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
                                            loading="lazy" width="400" height="400"
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
                                        <a href="{{ route('produk.show', $item->id) }}" aria-label="Lihat Detail Produk {{ $item->nama_produk }}"
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
        <section id="edukasi-preview" class="py-16 lg:py-24 overflow-hidden bg-[#F0FDF4]">


            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">
                <!-- Header Section -->
                <div class="text-center mb-12 lg:mb-20 max-w-3xl mx-auto" data-aos="fade-up">
                    <!-- Badge Pusat Pengetahuan -->
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 lg:px-5 lg:py-2.5 rounded-full bg-white text-green-700 text-xs font-bold uppercase tracking-widest border border-green-200 mb-4 lg:mb-6 shadow-sm hover:shadow-md transition-shadow duration-300">
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
                        Perluas wawasan budidaya durian Anda dengan artikel pilihan, tips perawatan, dan inovasi perkebunan
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
                                                loading="lazy" width="600" height="400"
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
                @else
                    <!-- State Kosong: Tidak Ada Artikel -->
                    <div class="text-center py-12 lg:py-20 bg-white/50 backdrop-blur-sm rounded-3xl border-2 border-dashed border-green-200 mx-4 sm:mx-0">
                        <div class="w-20 h-20 lg:w-24 lg:h-24 mx-auto mb-6 bg-white rounded-full flex items-center justify-center shadow-md">
                            <svg class="w-10 h-10 lg:w-12 lg:h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg lg:text-xl font-bold text-slate-900 mb-2">Konten Segera Hadir!</h3>
                        <p class="text-slate-500 text-sm max-w-md mx-auto px-4">Kami sedang menyiapkan artikel edukatif berkualitas tinggi untuk meningkatkan pengetahuan budidaya durian Anda. Nantikan konten menarik dari kami segera!</p>
                    </div>
                @endif
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
                            <img src="{{ asset('images/hero2.png') }}" alt="Tim AgriSmart" loading="lazy" width="500" height="400"
                                class="w-full h-auto object-cover hover:scale-105 transition-transform duration-700">
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
                                Perkebunan
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
                            AgriSmart hadir untuk menjembatani kesenjangan teknologi bagi pekebun durian Indonesia. Kami percaya
                            bahwa dengan akses yang tepat terhadap teknologi IoT dan pasar digital, kesejahteraan pekebun
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
                                        untuk pekebun dan konsumen dengan sistem yang terbuka.</p>
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
        <section id="kontak" class="py-16 lg:py-24 bg-[#F0FDF4] overflow-hidden">
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
                        Ayo bergabung bersama kami dan menjadi bagian dari Pekebun Durian Masa Depan. Cukup dengan mengisi
                        formulir untuk memulai langkah besar Anda.
                    </p>
                </div>

                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12">
                    <!-- Kolom Kiri: Info & Gambar -->
                    <div class="space-y-6" data-aos="fade-right">
                        <!-- Gambar Lokasi -->
                        <div class="relative w-full h-[350px] lg:h-[450px] overflow-hidden group">
                            <img src="{{ asset('images/hero3.png') }}" alt="Lokasi Kami" loading="lazy" width="500" height="400"
                                class="w-full h-auto object-cover hover:scale-105 transition-transform duration-700">
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