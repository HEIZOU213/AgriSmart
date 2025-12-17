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
    class="font-sans antialiased text-slate-700 bg-green-50 flex flex-col min-h-screen selection:bg-green-500 selection:text-white overflow-x-hidden">

    {{-- NAVBAR --}}
    <x-navbar />

    {{-- MAIN CONTENT --}}
    <main class="flex-1 w-full">

        {{-- HERO SECTION --}}
        <section class="relative overflow-hidden pt-24 pb-12 sm:pt-28 lg:pt-32 lg:pb-20 bg-slate-50">
            {{-- Background Spin Tengah --}}
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="w-[300px] h-[300px] sm:w-[500px] sm:h-[500px] lg:w-[800px] lg:h-[800px] opacity-5">
                    <div class="w-full h-full animate-[spin_30s_linear_infinite]">
                        <img src="images/nav-logo.png" alt="Background Decorative" class="w-full h-full object-contain">
                    </div>
                </div>
            </div>

            {{-- Konten Utama --}}
            <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
                <div class="text-center" data-aos="fade-up">
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

        {{-- CONTACT CONTENT SECTION --}}
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

                {{-- Subtle Pattern --}}
                <div class="absolute inset-0 opacity-[0.015]"
                    style="background-image: radial-gradient(circle at 1px 1px, rgb(167 243 208) 1px, transparent 0); background-size: 40px 40px;">
                </div>
            </div>

            {{-- Main Content Container --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                {{-- CONTENT GRID --}}
                <div class="grid lg:grid-cols-2 gap-10 lg:gap-16">

                    {{-- LEFT SECTION: INFO & DETAILS --}}
                    <div class="space-y-8 order-2 lg:order-1" data-aos="fade-right">

                        {{-- Header Section --}}
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

                        {{-- Contact Info Cards --}}
                        <div class="space-y-6">
                            {{-- Contact Channels --}}
                            <div class="grid sm:grid-cols-2 gap-4">
                                {{-- Email Card --}}
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

                                {{-- WhatsApp Card --}}
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

                        {{-- Maps Section --}}
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

                                    {{-- Overlay dengan informasi --}}
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

                            {{-- Maps Note --}}
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

                    {{-- RIGHT SECTION: CONTACT FORM --}}
                    <div data-aos="fade-left" class="h-full order-1 lg:order-2">
                        <div class="bg-white rounded-3xl p-6 sm:p-8 lg:p-10 border border-green-50 shadow-xl h-full">

                            {{-- Form Header --}}
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
                            <form action="{{ route('kontak.store') }}" method="POST" class="space-y-4 sm:space-y-5">
                                @csrf

                                {{-- Full Name --}}
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

                                <div class="grid md:grid-cols-2 gap-4 sm:gap-5">
                                    {{-- WhatsApp Number --}}
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

                                    {{-- Email --}}
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

                                {{-- Message --}}
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

                                {{-- Submit Button --}}
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

                {{-- FAQ Section --}}
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

                    <div class="grid md:grid-cols-2 gap-4 sm:gap-6 max-w-4xl mx-auto">
                        {{-- FAQ Items --}}
                        {{-- Item 1 --}}
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

                        {{-- Item 2 --}}
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

                        {{-- Item 3 --}}
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

                        {{-- Item 4 --}}
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
    <footer id="footer"
        class="bg-white border-t border-slate-100 pt-12 sm:pt-16 pb-8 font-sans relative overflow-hidden">

        {{-- DEKORASI BACKGROUND --}}
        <div
            class="absolute top-0 left-0 -translate-x-1/3 -translate-y-1/3 w-[300px] sm:w-[500px] h-[300px] sm:h-[500px] opacity-40 pointer-events-none">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#DCFCE7"
                    d="M47.5,-57.2C59.6,-46.3,66.4,-28.9,65.6,-12.9C64.8,3.1,56.3,17.7,46.2,29.9C36.1,42.1,24.3,51.9,10.6,56.7C-3.1,61.5,-18.8,61.3,-31.2,54.1C-43.7,46.9,-53,32.7,-57.3,17.6C-61.6,2.5,-60.9,-13.5,-53.4,-26.8C-45.9,-40.1,-31.6,-50.7,-17.1,-54.2C-2.6,-57.7,12,-54.1,25.4,-50.4L47.5,-57.2Z"
                    transform="translate(100 100)" />
            </svg>
        </div>
        <div
            class="absolute top-0 right-0 translate-x-1/4 -translate-y-1/4 w-[400px] sm:w-[600px] h-[400px] sm:h-[600px] opacity-30 pointer-events-none">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#F0FDF4"
                    d="M41.4,-70.3C52.6,-62.7,60.2,-49.6,67.3,-36.1C74.3,-22.6,80.8,-8.7,78.9,4.2C77,17.1,66.7,29,56.5,38.9C46.3,48.8,36.2,56.7,24.8,62.2C13.4,67.7,0.7,70.8,-11.2,69.5C-23.1,68.2,-34.2,62.5,-44.7,54.6C-55.2,46.7,-65.1,36.6,-70.6,24.2C-76.1,11.8,-77.2,-2.9,-71.9,-15.2C-66.6,-27.5,-54.9,-37.4,-43,-44.8C-31.1,-52.2,-19,-57.1,-6.3,-58.5C6.4,-59.9,20,-77.9,41.4,-70.3Z"
                    transform="translate(100 100)" />
            </svg>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-12 mb-12 sm:mb-16 items-start">

                {{-- 1. Brand Column (Lebar: 5 Kolom) --}}
                <div class="lg:col-span-5">
                    <a href="/" class="inline-block mb-6">
                        <img src="{{ asset('images/logo2.png') }}" alt="AgriSmart Logo"
                            class="h-14 sm:h-16 lg:h-20 w-auto object-contain">
                    </a>
                    <p class="text-slate-500 leading-relaxed mb-8 pr-0 lg:pr-12 text-sm sm:text-base">
                        Platform digital terintegrasi untuk pertanian cerdas. Solusi IoT inovatif untuk masa depan
                        pangan Indonesia yang berkelanjutan.
                    </p>
                    <div class="flex items-center gap-3">
                        @foreach(['facebook', 'instagram', 'twitter'] as $social)
                            <a href="#"
                                class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-500 border border-slate-100 transition-all duration-300 hover:bg-green-600 hover:text-white hover:scale-110 hover:shadow-lg group">
                                <span class="sr-only">{{ ucfirst($social) }}</span>
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
                    <h5 class="font-bold text-slate-900 mb-4 sm:mb-6">Menu Utama</h5>
                    <ul class="space-y-3 sm:space-y-4">
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
                    <h5 class="font-bold text-slate-900 mb-4 sm:mb-6">Layanan</h5>
                    <ul class="space-y-3 sm:space-y-4">
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
                    <h5 class="font-bold text-slate-900 mb-4 sm:mb-6">Hubungi Kami</h5>
                    <div class="space-y-4 sm:space-y-5">
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
                <p class="text-xs sm:text-sm text-slate-500 text-center">
                    © {{ date('Y') }} <span class="text-green-600 font-bold">AgriSmart</span>. All Rights Reserved.
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