<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AgriSmart') }}</title>

    {{-- FONT MODERN: Plus Jakarta Sans --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- TAILWIND & SCRIPTS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Fallback Script jika Vite belum disetup (Opsional) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Alpine JS (Diperlukan untuk Navbar ini) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        [x-cloak] { display: none !important; }

        /* Animasi Fade In */
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fade-in 0.5s ease-out forwards;
        }

        /* Scrollbar Kustom */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #10B981; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #059669; }
    </style>
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen">

    {{-- ====================================================================== --}}
    {{--  1. NAVBAR (Sesuai Permintaan)                                         --}}
    {{-- ====================================================================== --}}
    <nav x-data="{ mobileOpen: false, scrolled: false, dropdownOpen: false }"
        @scroll.window="scrolled = window.scrollY > 20"
        :class="scrolled ? 'bg-white shadow-md border-b border-green-100' : 'bg-white border-b border-transparent'"
        class="fixed inset-x-0 top-0 z-50 w-full transition-all duration-500">

        {{-- Container Responsif --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 transition-all duration-300">
            <div class="flex items-center justify-between h-16 lg:h-20">

                {{-- 1. Logo Section --}}
                <div class="flex-1 flex justify-start items-center">
                    <a href="/" class="flex items-center gap-2 group relative shrink-0">
                        <img src="{{ asset('images/nav-logo.png') }}" alt="AgriSmart Logo"
                            class="h-36 lg:h-36 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                    </a>
                </div>

                {{-- 2. Desktop Menu --}}
                <div class="hidden lg:flex flex-none items-center justify-center gap-6">
                    @php
                        $navItems = [
                            ['name' => 'Beranda', 'href' => '/', 'active' => request()->is('/'), 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                            ['name' => 'Layanan', 'href' => '#layanan', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                            ['name' => 'Produk', 'href' => route('produk.index'), 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                            ['name' => 'Edukasi', 'href' => route('edukasi.index'), 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                            ['name' => 'Tentang', 'href' => '#tentang-kami', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                            ['name' => 'Kontak', 'href' => '#kontak', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                        ];
                    @endphp

                    @foreach($navItems as $item)
                        <a href="{{ $item['href'] }}"
                            class="relative px-3 py-2 rounded-lg font-semibold transition-all duration-300 group overflow-hidden {{ $item['active'] ?? false ? 'text-green-700' : 'text-slate-600 hover:text-green-700' }}">

                            <span class="relative flex items-center gap-2 text-sm lg:text-base whitespace-nowrap">
                                <svg class="w-4 h-4 opacity-70 group-hover:opacity-100 transition-opacity" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $item['icon'] }}" />
                                </svg>
                                {{ $item['name'] }}
                            </span>

                            {{-- Indikator Garis Bawah --}}
                            <span
                                class="absolute bottom-0 left-1/2 -translate-x-1/2 h-[2px] bg-green-600 transition-all duration-300 rounded-full {{ $item['active'] ?? false ? 'w-3/4' : 'w-0 group-hover:w-3/4' }}"></span>
                        </a>
                    @endforeach
                </div>

                {{-- 3. Right Side (Auth / Guest Buttons) --}}
                <div class="flex-1 flex justify-end items-center gap-2 sm:gap-4">

                    {{-- Ikon Keranjang (Desktop) --}}
                    <a href="{{ Auth::check() ? route('cart.index') : route('login') }}"
                        class="group relative p-2 text-slate-600 hover:text-green-700 transition-colors hidden sm:block mr-1">
                        <svg class="w-6 h-6 transition-transform group-hover:scale-110" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </a>

                    @auth
                        {{-- User Dropdown (Desktop Only) --}}
                        <div class="hidden lg:block relative" x-data="{ dropdownOpen: false }">

                            <button @click="dropdownOpen = !dropdownOpen"
                                class="relative flex items-center justify-center w-10 h-10 rounded-full bg-green-700 text-white font-bold text-lg hover:bg-green-800 hover:shadow-lg hover:shadow-green-100 border-2 border-transparent hover:border-green-200 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </button>

                            <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-2" @click.away="dropdownOpen = false"
                                class="absolute right-0 mt-3 w-72 bg-white rounded-2xl shadow-xl border border-green-100 overflow-hidden z-50"
                                style="display: none;">

                                <div class="px-6 py-5 border-b border-green-50 bg-green-50/50">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-green-700 text-white flex items-center justify-center font-bold text-lg shadow-sm">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                        <div class="overflow-hidden">
                                            <h4 class="font-bold text-slate-800 text-sm truncate">{{ Auth::user()->name }}</h4>
                                            <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-2 space-y-1">
                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all">
                                            <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                            </svg>
                                            Admin Panel
                                        </a>
                                    @elseif(Auth::user()->role === 'petani')
                                        <a href="{{ route('petani.dashboard') }}"
                                            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all">
                                            <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                            Dashboard Petani
                                        </a>
                                    @endif

                                    <a href="{{ route('profile.edit') }}"
                                        class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all">
                                        <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profil Saya
                                    </a>

                                    @if(Auth::user()->role === 'konsumen')
                                        <a href="{{ route('konsumen.pesanan.index') }}"
                                            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all">
                                            <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            Pesanan Saya
                                        </a>
                                    @endif

                                    <div class="p-2 border-t border-green-50">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="flex items-center gap-3 w-full px-4 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                Keluar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Guest Buttons --}}
                        <div class="hidden md:flex items-center gap-3">
                            <a href="{{ route('login') }}"
                                class="group relative px-5 py-2.5 text-sm lg:text-base font-bold text-green-700 bg-white border border-green-200 rounded-xl transition-all duration-300 hover:border-green-500 hover:shadow-lg hover:shadow-green-50 hover:-translate-y-0.5 whitespace-nowrap overflow-hidden">
                                <span class="relative z-10 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-600 transition-transform duration-300 group-hover:-translate-x-0.5"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    Masuk
                                </span>
                            </a>
                            <a href="{{ route('register') }}"
                                class="group relative px-5 py-2.5 text-sm lg:text-base font-bold text-white bg-gradient-to-r from-green-600 to-green-700 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-green-200 hover:-translate-y-0.5 whitespace-nowrap overflow-hidden">
                                <div
                                    class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                </div>
                                <span class="relative z-10 flex items-center gap-2">
                                    Daftar
                                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                    @endauth

                    {{-- Mobile Toggle Button --}}
                    <button @click="mobileOpen = !mobileOpen"
                        class="lg:hidden p-2 text-slate-700 hover:text-green-700 transition-colors">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            @click.away="mobileOpen = false"
            class="lg:hidden fixed inset-x-0 top-[64px] lg:top-[80px] bg-white border-t border-green-100 shadow-xl z-40"
            style="display: none;">

            <div class="container mx-auto px-6 py-6 space-y-2 max-h-[calc(100vh-5rem)] overflow-y-auto">
                @foreach($navItems as $item)
                    <a href="{{ $item['href'] }}" @click="mobileOpen = false"
                        class="flex items-center gap-4 py-3 px-4 text-base font-semibold text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all duration-300 group">
                        <svg class="w-5 h-5 text-slate-500 group-hover:text-green-700 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                        </svg>
                        <span class="group-hover:translate-x-1 transition-transform">{{ $item['name'] }}</span>
                    </a>
                @endforeach

                {{-- Link Keranjang (Mobile View) --}}
                <a href="{{ Auth::check() ? route('cart.index') : route('login') }}" @click="mobileOpen = false"
                    class="flex items-center gap-4 py-3 px-4 text-base font-semibold text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all duration-300 group">
                    <svg class="w-5 h-5 text-slate-500 group-hover:text-green-700 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="group-hover:translate-x-1 transition-transform">Keranjang</span>
                </a>

                <div class="pt-6 border-t border-green-100 space-y-3 mt-4">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" @click="mobileOpen = false"
                                class="flex items-center gap-3 py-3 px-4 text-base font-semibold text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Admin Panel
                            </a>
                        @elseif(Auth::user()->role === 'petani')
                            <a href="{{ route('petani.dashboard') }}" @click="mobileOpen = false"
                                class="flex items-center gap-3 py-3 px-4 text-base font-semibold text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard Petani
                            </a>
                        @endif

                        <a href="{{ route('profile.edit') }}" @click="mobileOpen = false"
                            class="flex items-center gap-3 py-3 px-4 text-base font-semibold text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profil Saya
                        </a>

                        @if(Auth::user()->role === 'konsumen')
                            <a href="{{ route('konsumen.pesanan.index') }}" @click="mobileOpen = false"
                                class="flex items-center gap-3 py-3 px-4 text-base font-semibold text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                Pesanan Saya
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" @click="mobileOpen = false"
                                class="flex items-center gap-3 w-full py-3 px-4 text-base font-semibold text-red-600 hover:text-red-700 hover:bg-red-50 rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Keluar
                            </button>
                        </form>
                    @else
                        <div class="grid grid-cols-2 gap-3 mt-4">
                            <a href="{{ route('login') }}" @click="mobileOpen = false"
                                class="flex items-center justify-center gap-2 py-3 text-base font-bold text-green-700 border border-green-200 bg-white rounded-xl hover:bg-green-50 hover:border-green-300 transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" @click="mobileOpen = false"
                                class="flex items-center justify-center gap-2 py-3 text-base font-bold text-white bg-gradient-to-r from-green-600 to-green-700 rounded-xl hover:shadow-lg hover:shadow-green-100 transition-all">
                                Daftar
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    {{-- AKHIR NAVBAR --}}

    {{-- 
        KONTEN HALAMAN 
        Ditambahkan padding-top (pt-20 lg:pt-24) agar konten tidak 
        tertutup oleh Navbar yang posisinya FIXED 
    --}}
    <main class="flex-1 pt-20 lg:pt-24">
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <footer class="bg-gray-900 text-white py-12 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h4 class="text-xl font-black text-white mb-4">Agri<span class="text-green-500">Smart</span>
                    </h4>
                    <p class="text-gray-400 text-sm leading-relaxed">Platform digital terdepan untuk memajukan
                        pertanian Indonesia melalui teknologi dan edukasi.</p>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">Tautan</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('produk.index') }}"
                                class="hover:text-green-400 transition">Marketplace</a></li>
                        <li><a href="{{ route('edukasi.index') }}"
                                class="hover:text-green-400 transition">Edukasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li>support@agrismart.id</li>
                        <li>Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-500 text-xs">
                © {{ date('Y') }} AgriSmart Indonesia. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>