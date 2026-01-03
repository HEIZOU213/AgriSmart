<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO META TAGS --}}
    <meta name="description"
        content="Hubungi AgriSmart untuk konsultasi, dukungan, dan kolaborasi pertanian cerdas. Kami siap membantu Anda.">
    <meta name="keywords" content="Kontak AgriSmart, Hubungi Kami, Support Pertanian, Konsultasi Tani">
    <meta property="og:title" content="Kontak - {{ config('app.name', 'AgriSmart') }}">
    <meta property="og:description" content="Hubungi tim AgriSmart untuk solusi pertanian terbaik.">
    <meta property="og:image" content="{{ asset('images/hero1.png') }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>Kontak - {{ config('app.name', 'AgriSmart') }}</title>

    {{-- FONT: Plus Jakarta Sans --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- LIBRARY ANIMASI AOS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- TAILWIND & SCRIPTS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- CUSTOM STYLES --}}
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
    class="font-sans antialiased text-slate-700 bg-green-50 flex flex-col min-h-screen selection:bg-green-500 selection:text-white overflow-x-hidden">

    {{-- NAVBAR --}}
    <x-navbar />

    {{-- MAIN CONTENT --}}
    <main class="flex-1 w-full">

        {{-- ================================================
        HERO SECTION
        ================================================ --}}
        <section class="relative overflow-hidden pt-24 pb-12 sm:pt-28 lg:pt-32 lg:pb-20 bg-slate-50">
            {{-- Background Spin Tengah --}}
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="w-[300px] h-[300px] sm:w-[500px] sm:h-[500px] lg:w-[800px] lg:h-[800px] opacity-5">
                    <div class="w-full h-full animate-[spin_30s_linear_infinite]">
                        <img src="images/nav-logo.png" alt="Background Decorative" class="w-full h-full object-contain">
                    </div>
                </div>
            </div>

            {{-- Konten Utama Hero --}}
            <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
                <div class="text-center" data-aos="fade-up">
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-green-100/50 text-green-700 text-[10px] sm:text-xs font-bold tracking-wider uppercase mb-3 border border-green-200/50 shadow-sm">
                        Kontak Kami
                    </span>
                    <h2
                        class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-slate-900 mb-4 sm:mb-6 leading-tight">
                        Hubungi
                        <span class="text-green-600">
                            Kami
                        </span>
                    </h2>
                    <p class="text-base sm:text-lg text-slate-600 max-w-xl sm:max-w-2xl mx-auto px-2">
                        Kami siap membantu Anda dalam perjalanan pertanian cerdas. Hubungi tim AgriSmart untuk solusi
                        terbaik.
                    </p>
                </div>
            </div>
        </section>

        {{-- ================================================
        CONTENT SECTION (Kontak & Form)
        ================================================ --}}
        <section class="py-12 sm:py-16 lg:py-24 relative bg-white overflow-hidden">

            {{-- Modern Background Decorations --}}
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                {{-- Clean Gradient Meshes --}}
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-[300px] sm:w-[800px] h-[400px] bg-gradient-to-br from-green-50/20 via-green-50/10 to-transparent rounded-full blur-3xl">
                </div>
                <div
                    class="absolute bottom-0 right-0 w-[300px] sm:w-[600px] h-[300px] sm:h-[600px] bg-gradient-to-tl from-green-50/15 to-transparent rounded-full blur-3xl translate-x-1/3 translate-y-1/3">
                </div>

                {{-- Floating Elements --}}
                <div
                    class="absolute top-20 right-[5%] lg:right-[10%] w-20 sm:w-32 h-20 sm:h-32 border border-green-100/20 rounded-full hidden sm:block">
                </div>
                <div
                    class="absolute bottom-32 left-[5%] lg:left-[8%] w-16 sm:w-24 h-16 sm:h-24 border border-green-100/20 rounded-full hidden sm:block">
                </div>

                {{-- Subtle Pattern Background --}}
                <div class="absolute inset-0 opacity-[0.015]"
                    style="background-image: radial-gradient(circle at 1px 1px, rgb(167 243 208) 1px, transparent 0); background-size: 40px 40px;">
                </div>
            </div>

            {{-- Main Content Container --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                {{-- GRID UTAMA: Info & Form --}}
                <div class="grid lg:grid-cols-2 gap-10 lg:gap-16">

                    {{-- KOLOM KIRI: Informasi Kontak & Peta --}}
                    <div class="space-y-8 order-2 lg:order-1" data-aos="fade-right">

                        {{-- Header Section Kiri --}}
                        <div class="text-center lg:text-left">
                            <span
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-50 text-green-700 text-xs font-bold uppercase tracking-widest mb-4 border border-green-100">
                                Informasi Kontak
                            </span>
                            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 mb-4 leading-tight">
                                Mari Berbicara Tentang
                                <span class="text-green-600 block sm:inline">Pertanian Masa Depan</span>
                            </h2>
                            <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
                                Tim AgriSmart siap mendukung Anda dalam setiap langkah menuju pertanian modern yang
                                lebih efisien dan berkelanjutan.
                            </p>
                        </div>

                        {{-- Card Kontak (Email & WhatsApp) --}}
                        <div class="space-y-6">
                            <div class="grid sm:grid-cols-2 gap-4">
                                {{-- Card Email --}}
                                <a href="mailto:support@agrismart.id"
                                    class="group bg-white rounded-2xl p-4 sm:p-5 border border-green-100 hover:border-green-300 hover:-translate-y-1 transition-all duration-300 shadow-sm hover:shadow-md flex sm:block items-center sm:items-start gap-4 sm:gap-0">
                                    <div class="flex items-center gap-3 mb-0 sm:mb-3">
                                        <div
                                            class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-all duration-300 flex-shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="block sm:hidden">
                                            <p class="text-xs font-medium text-slate-500">Email</p>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1 sm:mt-2">
                                        <p class="hidden sm:block text-xs font-medium text-slate-500 mb-1">Email</p>
                                        <p
                                            class="font-semibold text-sm sm:text-base text-slate-900 group-hover:text-green-600 transition-colors truncate">
                                            support@agrismart.id
                                        </p>
                                    </div>
                                </a>

                                {{-- Card WhatsApp --}}
                                <a href="https://wa.me/6281234567890" target="_blank"
                                    class="group bg-white rounded-2xl p-4 sm:p-5 border border-green-100 hover:border-green-300 hover:-translate-y-1 transition-all duration-300 shadow-sm hover:shadow-md flex sm:block items-center sm:items-start gap-4 sm:gap-0">
                                    <div class="flex items-center gap-3 mb-0 sm:mb-3">
                                        <div
                                            class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-all duration-300 flex-shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </div>
                                        <div class="block sm:hidden">
                                            <p class="text-xs font-medium text-slate-500">WhatsApp</p>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1 sm:mt-2">
                                        <p class="hidden sm:block text-xs font-medium text-slate-500 mb-1">WhatsApp</p>
                                        <p
                                            class="font-semibold text-sm sm:text-base text-slate-900 group-hover:text-green-600 transition-colors truncate">
                                            +62 812 3456 7890
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>

                        {{-- Section Peta Lokasi --}}
                        <div class="mt-8">
                            <h4 class="font-bold text-slate-900 mb-4 text-center lg:text-left">Lokasi Kami</h4>
                            <div
                                class="rounded-2xl overflow-hidden border border-green-100 hover:border-green-300 transition-all duration-300 shadow-sm hover:shadow-md">
                                <div class="h-56 sm:h-64 relative">
                                    {{-- Google Maps iframe --}}
                                    <iframe
                                        src="https://maps.google.com/maps?q=Politeknik%20Negeri%20Bengkalis&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade" class="absolute inset-0">
                                    </iframe>

                                    {{-- Overlay informasi alamat --}}
                                    <div
                                        class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                                        <div class="flex items-center gap-2 text-white">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="text-xs sm:text-sm font-medium leading-tight">Sungai Alam,
                                                Bengkalis, Riau 28714</span>
                                        </div>
                                    </div>

                                    {{-- Marker Pin --}}
                                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                        <div
                                            class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center animate-pulse">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Catatan Peta --}}
                            <p
                                class="text-xs text-slate-500 mt-3 flex items-center justify-center lg:justify-start gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Klik pada peta untuk melihat rute
                            </p>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: Formulir Kontak --}}
                    <div data-aos="fade-left" class="h-full order-1 lg:order-2">
                        <div class="bg-white rounded-3xl p-6 sm:p-8 lg:p-10 border border-green-50 shadow-xl h-full">

                            {{-- Header Form --}}
                            <div
                                class="flex items-center justify-between mb-6 sm:mb-8 pb-4 sm:pb-6 border-b border-slate-100">
                                <div>
                                    <h4 class="text-xl sm:text-2xl font-bold text-slate-900 mb-1">Kirim Pesan</h4>
                                    <p class="text-sm text-slate-500">Isi formulir untuk menghubungi kami</p>
                                </div>
                                <div
                                    class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-green-50 to-green-100 rounded-2xl flex items-center justify-center text-green-600">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </div>
                            </div>

                            {{-- Pesan Sukses (jika ada) --}}
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

                            {{-- Formulir Input --}}
                            <form action="{{ route('kontak.store') }}" method="POST" class="space-y-4 sm:space-y-5">
                                @csrf

                                {{-- Field Nama Lengkap --}}
                                <div class="group">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                                    <div class="relative">
                                        <input type="text" name="nama" required
                                            class="w-full pl-11 pr-4 py-3 sm:py-3.5 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium placeholder:text-slate-400 text-sm sm:text-base"
                                            placeholder="Masukkan nama Anda">
                                        <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </div>

                                {{-- Grid WhatsApp & Email --}}
                                <div class="grid md:grid-cols-2 gap-4 sm:gap-5">
                                    {{-- Field WhatsApp --}}
                                    <div class="group">
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">No.
                                            WhatsApp</label>
                                        <div class="relative">
                                            <input type="tel" name="no_hp" required
                                                class="w-full pl-11 pr-4 py-3 sm:py-3.5 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium placeholder:text-slate-400 text-sm sm:text-base"
                                                placeholder="0812...">
                                            <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </div>
                                    </div>

                                    {{-- Field Email --}}
                                    <div class="group">
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                                        <div class="relative">
                                            <input type="email" name="email" required
                                                class="w-full pl-11 pr-4 py-3 sm:py-3.5 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium placeholder:text-slate-400 text-sm sm:text-base"
                                                placeholder="nama@email.com">
                                            <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Field Pesan --}}
                                <div class="group">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pesan Anda</label>
                                    <div class="relative">
                                        <textarea name="pesan" rows="4" required
                                            class="w-full pl-11 pr-4 py-3 sm:py-3.5 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium resize-none placeholder:text-slate-400 text-sm sm:text-base"
                                            placeholder="Tuliskan pertanyaan atau kebutuhan Anda..."></textarea>
                                        <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-4 group-focus-within:text-green-600 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                        </svg>
                                    </div>
                                </div>

                                {{-- Tombol Submit --}}
                                <button type="submit"
                                    class="group w-full py-3.5 sm:py-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-2xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 flex items-center justify-center gap-2 text-sm sm:text-base">
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

                {{-- ================================================
                SECTION FAQ
                ================================================ --}}
                <div class="mt-16 sm:mt-20 pt-12 sm:pt-16 border-t border-green-100" data-aos="fade-up">
                    <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-12 px-4">
                        <span
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-50 text-green-700 text-xs font-bold uppercase tracking-widest mb-4 border border-green-100">
                            Pertanyaan Umum
                        </span>
                        <h3 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">
                            Yang Sering Ditanyakan
                        </h3>
                        <p class="text-slate-600 text-sm sm:text-base">
                            Temukan jawaban untuk pertanyaan yang paling sering diajukan.
                        </p>
                    </div>

                    {{-- Grid Item FAQ --}}
                    <div class="grid md:grid-cols-2 gap-4 sm:gap-6 max-w-4xl mx-auto">
                        {{-- FAQ Item 1 --}}
                        <div
                            class="bg-white rounded-2xl p-5 sm:p-6 border border-green-100 hover:border-green-300 transition-all duration-300">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center text-green-600 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 mb-2 text-sm sm:text-base">Berapa lama waktu
                                        respon?</h4>
                                    <p class="text-slate-600 text-xs sm:text-sm">Kami berusaha merespon dalam 1x24 jam
                                        untuk email
                                        dan WhatsApp. Untuk konsultasi mendesak, silakan hubungi nomor WhatsApp.</p>
                                </div>
                            </div>
                        </div>

                        {{-- FAQ Item 2 --}}
                        <div
                            class="bg-white rounded-2xl p-5 sm:p-6 border border-green-100 hover:border-green-300 transition-all duration-300">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center text-green-600 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 mb-2 text-sm sm:text-base">Apakah tersedia
                                        konsultasi langsung?</h4>
                                    <p class="text-slate-600 text-xs sm:text-sm">Ya, kami menyediakan konsultasi
                                        langsung melalui
                                        WhatsApp dan email. Untuk pertemuan offline, silakan hubungi kami untuk janji
                                        temu.</p>
                                </div>
                            </div>
                        </div>

                        {{-- FAQ Item 3 --}}
                        <div
                            class="bg-white rounded-2xl p-5 sm:p-6 border border-green-100 hover:border-green-300 transition-all duration-300">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center text-green-600 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 mb-2 text-sm sm:text-base">Bagaimana cara
                                        menjadi mitra?</h4>
                                    <p class="text-slate-600 text-xs sm:text-sm">Silakan kirim email ke
                                        partnership@agrismart.id
                                        dengan proposal kerjasama atau hubungi kami melalui formulir di atas.</p>
                                </div>
                            </div>
                        </div>

                        {{-- FAQ Item 4 --}}
                        <div
                            class="bg-white rounded-2xl p-5 sm:p-6 border border-green-100 hover:border-green-300 transition-all duration-300">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center text-green-600 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 mb-2 text-sm sm:text-base">Apakah ada biaya
                                        konsultasi?</h4>
                                    <p class="text-slate-600 text-xs sm:text-sm">Konsultasi awal gratis untuk semua
                                        klien. Untuk
                                        konsultasi mendalam dan teknis, mungkin ada biaya tergantung kompleksitas.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>

    {{-- FOOTER --}}
    <x-footer />

    {{-- TOMBOL BACK TO TOP --}}
    <x-back-button />

    {{-- SCRIPT INITIALIZATION --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi AOS
        AOS.init({
            once: true,
            offset: 50,
            duration: 800,
        });
    </script>
</body>

</html>