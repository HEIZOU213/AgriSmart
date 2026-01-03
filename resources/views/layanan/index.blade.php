<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO META TAGS --}}
    <meta name="description"
        content="AgriSmart IoT Services - Pantau kebun Anda secara real-time dengan teknologi pertanian cerdas.">
    <title>Layanan IoT - {{ config('app.name', 'AgriSmart') }}</title>

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
            width: 8px;
        }

        @media (min-width: 640px) {
            ::-webkit-scrollbar {
                width: 10px;
            }
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
                <div class="w-[280px] h-[280px] sm:w-[500px] sm:h-[500px] lg:w-[800px] lg:h-[800px] opacity-5">
                    <div class="w-full h-full animate-[spin_30s_linear_infinite]">
                        <img src="{{ asset('images/nav-logo.png') }}" alt="Background"
                            class="w-full h-full object-contain">
                    </div>
                </div>
            </div>

            {{-- Konten Utama Hero --}}
            <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
                <div class="text-center" data-aos="fade-up">
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-green-100/50 text-green-700 text-[10px] sm:text-xs font-bold tracking-wider uppercase mb-3 border border-green-200/50 shadow-sm">
                        Smart Farming System
                    </span>
                    <h2
                        class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-slate-900 mb-4 sm:mb-6 leading-tight break-words">
                        Pantau Kebun
                        <span class="text-green-600 inline-block">Real-time</span>
                    </h2>
                    <p class="text-base sm:text-lg text-slate-600 max-w-xl sm:max-w-2xl mx-auto px-2 leading-relaxed">
                        Integrasikan teknologi sensor tanah dan cuaca untuk hasil panen yang lebih optimal dan efisien.
                    </p>
                </div>
            </div>
        </section>

        {{-- ================================================
        CONTENT SECTION (Form & Grid Device)
        ================================================ --}}
        <section class="py-8 sm:py-16 lg:py-24 relative bg-white overflow-hidden">

            {{-- Background Decorations --}}
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-[300px] sm:w-[800px] h-[400px] bg-gradient-to-br from-green-50/20 via-green-50/10 to-transparent rounded-full blur-3xl">
                </div>
                <div
                    class="absolute bottom-0 right-0 w-[200px] sm:w-[600px] h-[300px] sm:h-[600px] bg-gradient-to-tl from-green-50/15 to-transparent rounded-full blur-3xl translate-x-1/3 translate-y-1/3">
                </div>
                <div class="absolute inset-0 opacity-[0.015]"
                    style="background-image: radial-gradient(circle at 1px 1px, rgb(167 243 208) 1px, transparent 0); background-size: 40px 40px;">
                </div>
            </div>

            {{-- Main Content Container --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                {{-- PESAN SUKSES / ERROR --}}
                @if(session('success') || session('error'))
                    <div class="max-w-4xl mx-auto mb-6 sm:mb-8" data-aos="fade-down">
                        <div
                            class="p-4 rounded-2xl flex items-start sm:items-center gap-3 border shadow-sm {{ session('success') ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5 sm:mt-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ session('success') ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' }}" />
                            </svg>
                            <span
                                class="font-medium text-sm leading-tight">{{ session('success') ?? session('error') }}</span>
                        </div>
                    </div>
                @endif

                {{-- ================================================
                LOGIC TAMPILAN BERDASARKAN ROLE
                ================================================ --}}
                @if(Auth::check())
                    {{-- $userRole sudah dikirim dari Controller --}}

                    {{-- === TAMPILAN PETANI / ADMIN === --}}
                    @if(in_array($userRole, ['petani', 'admin']))

                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

                            {{-- === KOLOM KIRI: FORM INPUT DEVICE === --}}
                            <div class="lg:col-span-4 lg:sticky lg:top-28 w-full">
                                <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-100 shadow-xl">

                                    {{-- Form Header --}}
                                    <div class="mb-5 sm:mb-6">
                                        <h3 class="font-bold text-lg text-slate-900">Tambah Alat Baru</h3>
                                        <p class="text-sm text-slate-500">Masukkan identitas sensor IoT Anda.</p>
                                    </div>

                                    {{-- Form Claim Device --}}
                                    <form action="{{ route('layanan.claim') }}" method="POST" class="space-y-4">
                                        @csrf

                                        {{-- Input: Serial Number --}}
                                        <div>
                                            <label
                                                class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1 block pl-1">
                                                Serial Number
                                            </label>
                                            <input type="text" name="serial_number" required placeholder="Contoh: SN-AGRI-01"
                                                class="w-full px-4 py-3 rounded-xl bg-slate-50/50 border border-slate-200 text-slate-800 font-semibold text-base sm:text-sm placeholder:font-normal placeholder:text-slate-400
                                                hover:bg-white hover:border-green-200
                                                focus:outline-none focus:ring-0 focus:shadow-none focus:border-slate-200
                                                focus:hover:bg-white focus:hover:border-green-200 transition-colors">
                                        </div>

                                        {{-- Input: PIN Code --}}
                                        <div>
                                            <label
                                                class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1 block pl-1">
                                                PIN Code
                                            </label>
                                            <input type="password" name="pin_code" required placeholder="• • • • • •" class="w-full px-4 py-3 rounded-xl bg-slate-50/50 border border-slate-200 text-slate-800 font-semibold text-base sm:text-sm placeholder:font-normal placeholder:text-slate-400
                                                hover:bg-white hover:border-green-200
                                                focus:outline-none focus:ring-0 focus:shadow-none focus:border-slate-200
                                                focus:hover:bg-white focus:hover:border-green-200 transition-colors">
                                        </div>

                                        {{-- Input: Nama Kebun --}}
                                        <div>
                                            <label
                                                class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1 block pl-1">
                                                Nama Kebun
                                            </label>
                                            <input type="text" name="name" required placeholder="Misal: Kebun Hidroponik" class="w-full px-4 py-3 rounded-xl bg-slate-50/50 border border-slate-200 text-slate-800 font-semibold text-base sm:text-sm placeholder:font-normal placeholder:text-slate-400
                                                hover:bg-white hover:border-green-200
                                                focus:outline-none focus:ring-0 focus:shadow-none focus:border-slate-200
                                                focus:hover:bg-white focus:hover:border-green-200 transition-colors">
                                        </div>

                                        {{-- Submit Button --}}
                                        <button type="submit"
                                            class="w-full mt-2 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-green-600/20 active:scale-95 flex items-center justify-center gap-2 text-sm sm:text-base">
                                            <span>Hubungkan</span>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- === KOLOM KANAN: LIST PERANGKAT TERHUBUNG === --}}
                            <div class="lg:col-span-8 w-full">
                                <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden">

                                    {{-- Header List Device --}}
                                    <div
                                        class="px-5 sm:px-6 py-4 sm:py-5 flex items-center justify-between mb-2 border-b border-slate-50">
                                        <h3 class="font-bold text-slate-900 text-base sm:text-lg">Perangkat Saya</h3>
                                        <span
                                            class="bg-green-100/50 text-green-700 px-3 py-1 rounded-full text-[10px] sm:text-xs font-bold border border-green-100 whitespace-nowrap">
                                            {{ isset($myDevices) ? count($myDevices) : 0 }} Unit
                                        </span>
                                    </div>

                                    {{-- Body List Device --}}
                                    <div class="p-4 sm:p-6 space-y-3 pt-2">
                                        @if(isset($myDevices) && count($myDevices) > 0)
                                            {{-- Loop setiap device --}}
                                            @foreach ($myDevices as $dev)
                                                <a href="{{ route('layanan.show', $dev->serial_number) }}" class="group flex items-center gap-3 sm:gap-4 p-3 sm:p-4 rounded-2xl bg-slate-50/50 border border-slate-100 transition-all duration-200
                                                                    hover:bg-white hover:border-green-200
                                                                    focus:outline-none focus:ring-0 focus:shadow-none focus:border-slate-100
                                                                    focus:hover:border-green-200 focus:hover:bg-white">

                                                    {{-- Icon Status Device --}}
                                                    <div
                                                        class="w-10 h-10 sm:w-12 sm:h-12 bg-white rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-green-500 group-hover:text-white transition-all duration-300 flex-shrink-0 shadow-sm">
                                                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                                        </svg>
                                                    </div>

                                                    {{-- Info Device --}}
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center gap-2">
                                                            <h4
                                                                class="font-bold text-slate-900 text-sm sm:text-base truncate group-hover:text-green-700 transition-colors">
                                                                {{ $dev->name }}
                                                            </h4>
                                                        </div>
                                                        <p class="text-[11px] sm:text-xs text-slate-400 font-mono mt-0.5 truncate">SN:
                                                            {{ $dev->serial_number }}
                                                        </p>
                                                    </div>

                                                    {{-- Arrow Navigasi ke Detail --}}
                                                    <div
                                                        class="text-slate-300 group-hover:text-green-600 group-hover:translate-x-1 transition-all flex-shrink-0">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M9 5l7 7-7 7" />
                                                        </svg>
                                                    </div>
                                                </a>
                                            @endforeach
                                        @else
                                            {{-- Empty State: Tidak ada device --}}
                                            <div
                                                class="py-8 flex flex-col items-center justify-center text-center px-4 border-2 border-dashed border-slate-100 rounded-2xl bg-slate-50/30">
                                                <div
                                                    class="w-14 h-14 sm:w-16 sm:h-16 bg-white rounded-full flex items-center justify-center mb-3 text-slate-300 shadow-sm">
                                                    <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2 2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                    </svg>
                                                </div>
                                                <h4 class="text-slate-900 font-bold text-sm">Belum Ada Perangkat</h4>
                                                <p class="text-slate-500 text-xs mt-1 max-w-xs leading-relaxed">Data monitoring akan
                                                    muncul di sini setelah Anda menghubungkan perangkat.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- === TAMPILAN KONSUMEN (RESTRICTED ACCESS) === --}}
                    @elseif($userRole == 'konsumen')
                        <div class="max-w-lg mx-auto px-4" data-aos="zoom-in">
                            <div class="p-6 sm:p-8 text-center">

                                {{-- Icon Akses Terbatas --}}
                                <div
                                    class="w-14 h-14 sm:w-16 sm:h-16 bg-green-50 rounded-2xl flex items-center justify-center mx-auto mb-5 sm:mb-6 text-green-600 shadow-sm">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>

                                {{-- Content Pesan Restriksi --}}
                                <h3 class="text-xl sm:text-2xl font-bold text-slate-900 mb-2">Akses Terbatas</h3>
                                <p class="text-slate-500 text-sm mb-8 px-2 leading-relaxed">
                                    Fitur Smart Farming ini dikhususkan untuk akun Petani.
                                </p>

                            </div>
                        </div>

                        {{-- === TAMPILAN ROLE LAIN (FALLBACK) === --}}
                    @else
                        <div class="max-w-lg mx-auto text-center bg-yellow-50 rounded-2xl p-6 border border-yellow-100 mx-4">
                            <h3 class="font-bold text-yellow-800 text-sm">Role Belum Dikonfigurasi: {{ $userRole ?? 'NULL' }}
                            </h3>
                        </div>
                    @endif

                    {{-- === TAMPILAN GUEST (BELUM LOGIN) === --}}
                @else
                    <div class="max-w-md mx-auto px-4" data-aos="zoom-in">
                        <div class="bg-white rounded-3xl p-6 sm:p-8 text-center border border-slate-100 shadow-xl">
                            <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2">Login Diperlukan</h3>
                            <p class="text-slate-500 text-sm mb-6">Masuk ke akun Petani Anda untuk mengakses dashboard.</p>

                            {{-- Tombol Login --}}
                            <a href="{{ route('login') }}"
                                class="block w-full py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-green-600/20 text-sm">
                                Masuk Sekarang
                            </a>
                        </div>
                    </div>
                @endif
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
        AOS.init({ once: true, offset: 50, duration: 800 });
    </script>
</body>

</html>