<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AgriSmart') }} - Edit Profil</title>

    {{-- FONTS --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Scripts & Styles via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 text-slate-800">

    {{-- ====================================================================== --}}
    {{-- ========================== BAGIAN NAVBAR ============================= --}}
    {{-- ====================================================================== --}}

    @php
        // LOGIKA MENU NAVIGASI TENGAH BERDASARKAN ROLE
        $navItems = [];

        if(Auth::user()->role === 'konsumen') {
            $navItems = [
                [
                    'name' => 'Pesanan Saya',
                    'href' => route('konsumen.pesanan.index'),
                    'active' => request()->routeIs('konsumen.pesanan.*'),
                    'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'
                ]
            ];
        } elseif(Auth::user()->role === 'admin') {
            $navItems = [
                [
                    'name' => 'Dashboard',
                    'href' => route('admin.dashboard'),
                    'active' => false,
                    'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'
                ]
            ];
        } elseif(Auth::user()->role === 'petani') {
            $navItems = [
                [
                    'name' => 'Dashboard',
                    'href' => route('petani.dashboard'),
                    'active' => false,
                    'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'
                ]
            ];
        }
    @endphp

    {{-- NAVBAR UNIFIED (SAMA UNTUK SEMUA ROLE) --}}
    <nav x-data="{ mobileOpen: false, scrolled: false, dropdownOpen: false }"
        @scroll.window.throttle.20ms="scrolled = window.scrollY > 20"
        :class="scrolled ? 'bg-white shadow-md border-b border-green-100' : 'bg-white border-b border-transparent'"
        class="fixed inset-x-0 top-0 z-50 w-full transition-all duration-500">

        {{-- Container Utama Navbar --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 transition-all duration-300">
            <div class="flex items-center justify-between h-16 lg:h-20">

                {{-- 1. LOGO SECTION (KIRI - SAMA UNTUK SEMUA) --}}
                <div class="flex-1 flex justify-start items-center py-2">
                    <a href="/" class="flex items-center gap-2 group relative shrink-0">
                        <img src="{{ asset('images/nav-logo.png') }}" alt="AgriSmart Logo"
                            class="h-12 sm:h-16 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                    </a>
                </div>

                {{-- 2. DESKTOP MENU (TENGAH - DINAMIS) --}}
                <div class="hidden lg:flex flex-none items-center justify-center gap-6">
                    @foreach($navItems as $item)
                        <a href="{{ $item['href'] }}"
                            class="relative px-3 py-2 rounded-lg font-semibold transition-all duration-300 group overflow-hidden 
                            {{ $item['active'] ? 'text-green-700' : 'text-slate-600 hover:text-green-700' }}">

                            <span class="relative flex items-center gap-2 text-sm lg:text-base whitespace-nowrap">
                                <svg class="w-4 h-4 {{ $item['active'] ? 'text-green-700' : 'opacity-70 group-hover:opacity-100' }} transition-opacity transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                                </svg>
                                {{ $item['name'] }}
                            </span>
                        </a>
                    @endforeach

                    {{-- MENU CHAT (KHUSUS KONSUMEN) --}}
                    @if(Auth::user()->role === 'konsumen')
                        <a href="{{ url('/chat') }}"
                            class="relative px-3 py-2 rounded-lg font-semibold transition-all duration-300 group overflow-hidden {{ request()->is('chat*') ? 'text-green-700' : 'text-slate-600 hover:text-green-700' }}">
                            <span class="relative flex items-center gap-2 text-sm lg:text-base whitespace-nowrap">
                                <svg class="w-4 h-4 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Pesan
                            </span>
                            <span id="badge-chat-desktop" class="hidden absolute top-0 right-0 -mt-0.5 -mr-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-600 text-[9px] font-bold text-white shadow-sm ring-1 ring-white">
                                0
                            </span>
                        </a>
                    @endif
                </div>

                {{-- 3. RIGHT SIDE (KANAN) --}}
                <div class="flex-1 flex justify-end items-center gap-2 sm:gap-4">

                    {{-- Ikon Keranjang (KHUSUS KONSUMEN) --}}
                    @if(Auth::user()->role === 'konsumen')
                        <a href="{{ route('cart.index') }}"
                            class="group relative p-2 text-slate-600 hover:text-green-700 transition-colors hidden sm:block mr-1">
                            <svg class="w-6 h-6 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span id="badge-cart-desktop" class="hidden absolute top-0 right-0 -mt-1 -mr-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-[10px] font-bold text-white shadow-md ring-2 ring-white transform transition-transform group-hover:scale-110">
                                0
                            </span>
                        </a>
                    @endif

                    {{-- USER DROPDOWN (SAMA STYLE, BEDA ISI LINK) --}}
                    <div class="hidden lg:block relative">
                        <button @click="dropdownOpen = !dropdownOpen"
                            class="relative flex items-center justify-center w-10 h-10 rounded-full text-white font-bold text-lg hover:shadow-lg hover:shadow-green-100 border-2 border-transparent hover:border-green-200 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 overflow-hidden">
                            <div class="h-10 w-10 rounded-full overflow-hidden {{ Auth::user()->foto_profil ? 'bg-transparent' : 'bg-green-600' }} flex items-center justify-center text-xl font-semibold border border-gray-300">
                                @if (Auth::user()->foto_profil)
                                    <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                                @else
                                    <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                @endif
                            </div>
                        </button>

                        {{-- Dropdown Content --}}
                        <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2" @click.away="dropdownOpen = false"
                            style="display: none;"
                            class="absolute right-0 mt-3 w-72 bg-white rounded-2xl shadow-xl border border-green-100 overflow-hidden z-50">

                            <div class="px-6 py-5 border-b border-green-50 bg-green-50/50">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full {{ Auth::user()->foto_profil ? 'bg-transparent' : 'bg-green-600' }} text-white flex items-center justify-center font-bold text-lg shadow-sm overflow-hidden border border-gray-300">
                                        @if(Auth::user()->foto_profil)
                                            <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="Profil" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <div class="overflow-hidden">
                                        <h4 class="font-bold text-slate-800 text-sm truncate">{{ Auth::user()->name }}</h4>
                                        <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                                        {{-- BAGIAN ROLE DIHAPUS SESUAI PERMINTAAN --}}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 space-y-1">
                                {{-- Link Profil (Semua Role) --}}
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all group">
                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profil Saya
                                </a>

                                {{-- Link Dashboard / Beranda (Tergantung Role) --}}
                                @if(Auth::user()->role === 'konsumen')
                                    <a href="/" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all group">
                                        <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        Beranda
                                    </a>
                                @elseif(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all group">
                                        <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                        </svg>
                                        Dashboard
                                    </a>
                                @elseif(Auth::user()->role === 'petani')
                                    <a href="{{ route('petani.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all group">
                                        <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                        </svg>
                                        Dashboard
                                    </a>
                                @endif

                                <div class="p-2 border-t border-green-50">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center gap-3 w-full px-4 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition-all group">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MOBILE TOGGLE BUTTON --}}
                    <button @click="mobileOpen = !mobileOpen"
                        class="lg:hidden p-2 text-slate-700 hover:text-green-700 transition-colors relative">
                        <span id="badge-hamburger" class="hidden absolute top-2 right-2 block h-2.5 w-2.5 rounded-full bg-red-600 ring-2 ring-white animate-pulse"></span>
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- MOBILE MENU --}}
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4" @click.away="mobileOpen = false"
            class="lg:hidden fixed inset-x-0 top-[64px] bg-white border-t border-green-100 shadow-xl z-40"
            style="display: none;">

            <div class="px-4 sm:px-6 py-6 space-y-2 max-h-[calc(100vh-5rem)] overflow-y-auto">

                {{-- Loop Menu Standar Mobile --}}
                @foreach($navItems as $item)
                    <a href="{{ $item['href'] }}" @click="mobileOpen = false"
                        class="flex items-center gap-4 py-3 px-4 text-base font-semibold {{ $item['active'] ? 'text-green-700 bg-green-50' : 'text-slate-700 hover:text-green-700 hover:bg-green-50' }} rounded-xl transition-all duration-300 group">
                        <svg class="w-5 h-5 {{ $item['active'] ? 'text-green-700' : 'text-slate-500 group-hover:text-green-700' }} transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                        </svg>
                        <span class="group-hover:translate-x-1 transition-transform">{{ $item['name'] }}</span>
                    </a>
                @endforeach

                @if(Auth::user()->role === 'konsumen')
                    <a href="{{ url('/chat') }}" @click="mobileOpen = false"
                        class="flex items-center justify-between gap-4 py-3 px-4 text-base font-semibold {{ request()->is('chat*') ? 'text-green-700 bg-green-50' : 'text-slate-700 hover:text-green-700 hover:bg-green-50' }} rounded-xl transition-all duration-300 group">
                        <div class="flex items-center gap-4">
                            <svg class="w-5 h-5 text-slate-500 group-hover:text-green-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <span class="group-hover:translate-x-1 transition-transform">Pesan / Chat</span>
                        </div>
                        <span id="badge-chat-mobile" class="hidden inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">0</span>
                    </a>

                    <a href="{{ route('cart.index') }}" @click="mobileOpen = false"
                        class="flex items-center justify-between gap-4 py-3 px-4 text-base font-semibold text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all duration-300 group">
                        <div class="flex items-center gap-4">
                            <svg class="w-5 h-5 text-slate-500 group-hover:text-green-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="group-hover:translate-x-1 transition-transform">Keranjang</span>
                        </div>
                        <span id="badge-cart-mobile" class="hidden inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">0</span>
                    </a>
                @endif

                <div class="pt-6 border-t border-green-100 space-y-3 mt-4">
                    <a href="{{ route('profile.edit') }}" @click="mobileOpen = false"
                        class="flex items-center gap-3 py-3 px-4 text-base font-semibold text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all group">
                        <svg class="w-5 h-5 text-slate-500 group-hover:text-green-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profil Saya
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" @click="mobileOpen = false"
                            class="flex items-center gap-3 w-full py-3 px-4 text-base font-semibold text-red-600 hover:text-red-700 hover:bg-red-50 rounded-xl transition-all group">
                            <svg class="w-5 h-5 text-red-500 group-hover:text-red-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>


    {{-- ====================================================================== --}}
    {{-- ======================== BAGIAN FORM EDIT PROFIL ===================== --}}
    {{-- ================= (SAMA UNTUK KONSUMEN, ADMIN, & PETANI) ============ --}}
    {{-- ====================================================================== --}}

    <main class="pt-24 pb-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Header Halaman --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Pengaturan Akun</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola informasi profil dan keamanan akun Anda.</p>
            </div>
            
            {{-- Tombol Kembali (Mobile Only / Optional jika sudah ada di navbar) --}}
            <div class="md:hidden">
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800">&larr;
                        Kembali ke Dashboard</a>
                @elseif(Auth::user()->role === 'petani')
                    <a href="{{ route('petani.dashboard') }}"
                        class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-800">&larr;
                        Kembali ke Dashboard</a>
                @endif
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session('status') === 'profile-updated')
            <div
                class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm flex items-center">
                <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="font-bold">Berhasil!</p>
                    <p class="text-sm">Informasi profil Anda telah diperbarui.</p>
                </div>
            </div>
        @endif
        @if (session('status') === 'password-updated')
            <div
                class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm flex items-center">
                <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="font-bold">Berhasil!</p>
                    <p class="text-sm">Kata sandi Anda telah diperbarui.</p>
                </div>
            </div>
        @endif

        {{-- 1. CARD FORMULIR EDIT PROFIL (Card Bagus) --}}
        <div
            class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 bg-gray-50 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Informasi Pribadi</h3>
                <p class="text-sm text-gray-500 mt-1">Perbarui foto profil dan detail kontak Anda.</p>
            </div>

            <div class="p-6 sm:p-8">
                <form method="post" action="{{ route('profile.update') }}" class="space-y-6"
                    enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    {{-- Foto Profil Section --}}
                    @php
                        $user = $user ?? Auth::user(); // Gunakan variabel $user dari view (jika ada) atau Auth::user()
                        $photoUrl = null;

                        if ($user->foto_profil) {
                            // Cek apakah itu path lokal atau URL eksternal (Socialite)
                            if (!preg_match('#^https?://#i', $user->foto_profil)) {
                                // Jika path lokal, gunakan asset('storage/')
                                $photoUrl = asset('storage/' . $user->foto_profil);
                            } else {
                                // Jika URL eksternal (Socialite)
                                $photoUrl = $user->foto_profil;
                            }
                        }

                        // Tentukan inisial untuk fallback
                        $initials = strtoupper(substr($user->name ?? $user->email, 0, 1));
                    @endphp

                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 pb-6 border-b border-gray-100">
                        <div class="shrink-0 relative group">

                            {{-- TAMPILKAN FOTO PROFIL --}}
                            @if($photoUrl)
                                <img class="h-24 w-24 object-cover rounded-full ring-4 ring-white shadow-lg transition"
                                    src="{{ $photoUrl }}" alt="Foto Profil {{ $user->name }}" />
                            @else
                                <div class="h-24 w-24 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white text-3xl font-bold ring-4 ring-white shadow-lg transition">
                                    {{ $initials }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 w-full">
                            <label class="block text-sm font-bold text-gray-700 mb-2" for="foto_profil">Unggah
                                Foto Baru</label>
                            <input type="file" id="foto_profil" name="foto_profil"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer transition" />
                            <p class="mt-2 text-xs text-gray-400">Format: JPG, PNG. Ukuran maks: 2MB.</p>
                            @error('foto_profil')
                                <span class="text-red-500 text-xs font-medium mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Grid Input Nama & Email --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama
                                Lengkap</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input id="name" name="name" type="text"
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>
                            @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <input id="email" name="email" type="email"
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>
                            @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Input Telepon --}}
                    <div>
                        <label for="no_telepon" class="block text-sm font-bold text-gray-700 mb-2">No. Telepon /
                            WhatsApp</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                            </div>
                            <input id="no_telepon" name="no_telepon" type="text"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                value="{{ old('no_telepon', $user->no_telepon) }}">
                        </div>
                    </div>

                    {{-- Input Alamat --}}
                    <div>
                        <label for="alamat" class="block text-sm font-bold text-gray-700 mb-2">Alamat
                            Lengkap</label>
                        <div class="relative">
                            <textarea id="alamat" name="alamat" rows="3"
                                class="w-full pl-4 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition resize-none"
                                placeholder="Masukkan alamat lengkap Anda...">{{ old('alamat', $user->alamat ?? '') }}</textarea>
                        </div>
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="flex justify-end pt-4">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- 2. CARD FORMULIR GANTI PASSWORD (Card Bagus) --}}
        <div
            class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 bg-gray-50 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Keamanan Akun</h3>
                <p class="text-sm text-gray-500 mt-1">Perbarui kata sandi Anda untuk menjaga keamanan akun.</p>
            </div>

            <div class="p-6 sm:p-8">
                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <label for="current_password"
                            class="block text-sm font-bold text-gray-700 mb-2">Password Saat Ini</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="current_password" name="current_password" type="password"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                autocomplete="current-password">
                        </div>
                        @error('current_password') <span
                            class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password
                                Baru</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input id="password" name="password" type="password"
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                    autocomplete="new-password">
                            </div>
                            @error('password') <span
                                class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password
                                Baru</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                    autocomplete="new-password">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-black focus:ring-4 focus:ring-gray-300 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>


    {{-- ====================================================================== --}}
    {{-- ============================ SCRIPTS ================================= --}}
    {{-- ====================================================================== --}}
    <script>
        // Script Realtime Notifikasi (Cek hanya jika user adalah KONSUMEN / ada elemen badge)
        function checkNotifications() {
            fetch('/api/cek-notifikasi')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    // Update Desktop Badges
                    updateBadge('badge-cart-desktop', data.keranjang);
                    updateBadge('badge-chat-desktop', data.chat); 

                    // Update Mobile Badges
                    updateBadge('badge-cart-mobile', data.keranjang);
                    updateBadge('badge-chat-mobile', data.chat);

                    // Update Hamburger Indicator (Red Dot)
                    const hamburgerBadge = document.getElementById('badge-hamburger');
                    if (hamburgerBadge) {
                        if (data.keranjang > 0 || data.chat > 0) {
                            hamburgerBadge.classList.remove('hidden');
                        } else {
                            hamburgerBadge.classList.add('hidden');
                        }
                    }
                })
                .catch(error => console.error('Error checking notifications:', error));
        }

        function updateBadge(id, count) {
            const el = document.getElementById(id);
            if (el) {
                if (count > 0) {
                    el.innerText = count;
                    el.classList.remove('hidden');
                } else {
                    el.classList.add('hidden');
                }
            }
        }

        // Jalankan cek notifikasi HANYA jika elemen badge ditemukan (artinya user adalah konsumen)
        if (document.getElementById('badge-cart-desktop')) {
            document.addEventListener('DOMContentLoaded', checkNotifications);
            setInterval(checkNotifications, 3000);
        }
    </script>

</body>

</html>