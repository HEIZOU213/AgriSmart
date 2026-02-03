{{-- ================================================
NAVBAR COMPONENT
Komponen navigasi utama dengan logika tampilan.
Logika database sudah dipindah ke AppServiceProvider.
Hanya menangani logika tampilan (Menu & Foto Profil).
=================================================== --}}

@php
    // ================================================
    // 1. DEFINISI MENU NAVIGASI
    // Mendefinisikan semua item menu dengan nama, URL, status aktif, dan ikon SVG
    // ================================================
    $navItems = [
        ['name' => 'Beranda', 'href' => '/', 'active' => request()->is('/'), 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['name' => 'Layanan', 'href' => route('layanan.index'), 'active' => request()->routeIs('layanan.index') || request()->routeIs('layanan.show'), 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
        ['name' => 'Produk', 'href' => route('produk.index'), 'active' => request()->routeIs('produk.index') || request()->routeIs('produk.show'), 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
        ['name' => 'Edukasi', 'href' => route('edukasi.index'), 'active' => request()->routeIs('edukasi.index') || request()->routeIs('edukasi.show'), 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
        ['name' => 'Tentang', 'href' => route('tentang.index'), 'active' => request()->routeIs('tentang.index'), 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['name' => 'Kontak', 'href' => route('kontak.show'), 'active' => request()->routeIs('kontak.show'), 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
    ];

    // ================================================
    // 2. PERSIAPAN DATA USER
    // Mengelola data user untuk tampilan foto profil dan inisial
    // ================================================
    $user = Auth::user();
    $userInitials = '';
    $userPhotoUrl = null;

    if ($user) {
        // Ambil inisial dari nama atau email
        $userInitials = strtoupper(substr($user->name ?? $user->email, 0, 1));

        // Logika Foto Profil (Local vs URL Eksternal)
        if ($user->foto_profil) {
            if (!preg_match('#^https?://#i', $user->foto_profil)) {
                // Foto Lokal: ambil dari storage
                $userPhotoUrl = asset('storage/' . $user->foto_profil);
            } else {
                // Foto URL (misal: Google), bersihkan parameter size untuk resolusi tinggi
                $cleanUrl = preg_replace('/\?sz=\d+$/', '', $user->foto_profil);
                $userPhotoUrl = preg_replace('/=s\d+-c$/', '=s0-c', $cleanUrl);
            }
        }
    }
@endphp

{{-- ================================================
NAVBAR CONTAINER
Menggunakan Alpine.js untuk state mobile menu dan scroll effect
=================================================== --}}
<nav x-data="{ mobileOpen: false, scrolled: false }" @scroll.window.throttle.20ms="scrolled = window.scrollY > 20"
    :class="scrolled ? 'bg-white shadow-md border-b border-green-100' : 'bg-white border-b border-transparent'"
    class="fixed inset-x-0 top-0 z-50 w-full transition-all duration-500">

    {{-- Container Utama Navbar --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 transition-all duration-300">
        <div class="flex items-center justify-between h-16 lg:h-20">

            {{-- ================================================
            1. LOGO SECTION (KIRI)
            ================================================ --}}
            <div class="flex-1 flex justify-start items-center py-2">
                <a href="/" class="flex items-center gap-2 group relative shrink-0">
                    <img src="{{ asset('images/nav-logo.png') }}" alt="AgriSmart Logo"
                        class="h-12 sm:h-16 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                </a>
            </div>

            {{-- ================================================
            2. DESKTOP MENU (TENGAH)
            Hanya tampil di layar besar (lg:)
            ================================================ --}}
            <div class="hidden lg:flex flex-none items-center justify-center gap-6">
                @foreach($navItems as $item)
                    <a href="{{ $item['href'] }}"
                        class="relative px-3 py-2 rounded-lg font-semibold transition-all duration-300 group overflow-hidden 
                                               {{ $item['active'] ? 'text-green-700' : 'text-slate-600 hover:text-green-700' }}">

                        <span class="relative flex items-center gap-2 text-sm lg:text-base whitespace-nowrap">
                            {{-- Ikon Menu --}}
                            <svg class="w-4 h-4 {{ $item['active'] ? 'text-green-700' : 'opacity-70 group-hover:opacity-100' }} transition-opacity transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $item['icon'] }}" />
                            </svg>
                            {{ $item['name'] }}
                        </span>
                    </a>
                @endforeach
            </div>

            {{-- ================================================
            3. RIGHT SIDE (KANAN)
            Berisi keranjang, profil user, dan tombol mobile menu
            ================================================ --}}
            <div class="flex-1 flex justify-end items-center gap-2 sm:gap-4">

                {{-- Ikon Keranjang (Desktop) --}}
                <a href="{{ Auth::check() ? route('cart.index') : route('login') }}"
                    class="group relative p-2 text-slate-600 hover:text-green-700 transition-colors hidden sm:block mr-1">

                    <svg class="w-6 h-6 transition-transform group-hover:scale-110" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>

                    {{-- Badge jumlah item di keranjang --}}
                    @if(isset($cartCount) && $cartCount > 0)
                        <span
                            class="absolute top-0 right-0 -mt-1 -mr-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-[10px] font-bold text-white shadow-md ring-2 ring-white transform transition-transform group-hover:scale-110">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                {{-- ================================================
                AREA USER (Jika sudah login)
                ================================================ --}}
                @auth
                    {{-- User Dropdown (Desktop Only) --}}
                    <div class="hidden lg:block relative" x-data="{ dropdownOpen: false }">

                        {{-- Tombol Profil Utama --}}
                        <button @click="dropdownOpen = !dropdownOpen"
                            class="relative flex items-center justify-center w-10 h-10 rounded-full text-white font-bold text-lg hover:shadow-lg hover:shadow-green-100 border-2 border-transparent hover:border-green-200 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 overflow-hidden">

                            {{-- Foto Profil atau Inisial --}}
                            <div
                                class="h-10 w-10 rounded-full overflow-hidden {{ $userPhotoUrl ? 'bg-transparent' : 'bg-green-600' }} flex items-center justify-center text-xl font-semibold border border-gray-300">
                                @if ($userPhotoUrl)
                                    <img src="{{ $userPhotoUrl }}" alt="Foto Profil {{ $user->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <span>{{ $userInitials }}</span>
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

                            {{-- Header Dropdown (Info User) --}}
                            <div class="px-6 py-5 border-b border-green-50 bg-green-50/50">
                                <div class="flex items-center gap-3">
                                    {{-- Foto di dalam Dropdown --}}
                                    <div
                                        class="w-10 h-10 rounded-full {{ $userPhotoUrl ? 'bg-transparent' : 'bg-green-600' }} text-white flex items-center justify-center font-bold text-lg shadow-sm overflow-hidden border border-gray-300">
                                        @if($userPhotoUrl)
                                            <img src="{{ $userPhotoUrl }}" alt="Foto Profil {{ $user->name }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <span class="text-white">{{ $userInitials }}</span>
                                        @endif
                                    </div>
                                    <div class="overflow-hidden">
                                        <h4 class="font-bold text-slate-800 text-sm truncate">{{ $user->name }}</h4>
                                        <p class="text-xs text-slate-500 truncate">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Menu Dropdown --}}
                            <div class="p-2 space-y-1">
                                {{-- Dashboard berdasarkan role --}}
                                @if($user->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all group">
                                        <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                        </svg>
                                        Admin Panel
                                    </a>
                                @elseif($user->role === 'petani')
                                    <a href="{{ route('petani.dashboard') }}"
                                        class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all group">
                                        <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        Dashboard
                                    </a>
                                @endif

                                {{-- Menu Profil --}}
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all group">
                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profil Saya
                                </a>

                                {{-- Menu Pesanan untuk konsumen --}}
                                @if($user->role === 'konsumen')
                                    <a href="{{ route('konsumen.pesanan.index') }}"
                                        class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all group">
                                        <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        Pesanan Saya
                                    </a>
                                @endif

                                {{-- Logout Section --}}
                                <div class="p-2 border-t border-green-50">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center gap-3 w-full px-4 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition-all group">
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
                    {{-- ================================================
                    TOMBOL GUEST (Belum login - Desktop/Tablet)
                    ================================================ --}}
                    <div class="hidden md:flex items-center gap-3">
                        <a href="{{ route('login') }}"
                            class="group relative px-5 py-2.5 text-sm lg:text-base font-bold text-white bg-gradient-to-r from-green-600 to-green-700 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-green-200 hover:-translate-y-0.5 whitespace-nowrap overflow-hidden">
                            <div
                                class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                            </div>
                            <span class="relative z-10 flex items-center gap-2">Masuk</span>
                        </a>
                    </div>
                @endauth

                {{-- ================================================
                MOBILE TOGGLE BUTTON
                Tombol hamburger untuk membuka menu mobile
                ================================================ --}}
                <button @click="mobileOpen = !mobileOpen"
                    class="lg:hidden p-2 text-slate-700 hover:text-green-700 transition-colors">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileOpen" x-cloak stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- ================================================
    MOBILE MENU
    Menu yang muncul di perangkat mobile
    ================================================ --}}
    <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4" @click.away="mobileOpen = false"
        class="lg:hidden fixed inset-x-0 top-[64px] bg-white border-t border-green-100 shadow-xl z-40"
        style="display: none;">

        <div class="px-4 sm:px-6 py-6 space-y-2 max-h-[calc(100vh-5rem)] overflow-y-auto">
            {{-- Menu Navigasi Mobile --}}
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

            {{-- Link Keranjang (Mobile View) --}}
            <a href="{{ Auth::check() ? route('cart.index') : route('login') }}" @click="mobileOpen = false"
                class="flex items-center justify-between gap-4 py-3 px-4 text-base font-semibold text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all duration-300 group">
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5 text-slate-500 group-hover:text-green-700 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="group-hover:translate-x-1 transition-transform">Keranjang</span>
                </div>

                {{-- Badge jumlah item di keranjang (Mobile) --}}
                @if(isset($cartCount) && $cartCount > 0)
                    <span
                        class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>

            {{-- ================================================
            AREA USER (Mobile)
            ================================================ --}}
            <div class="pt-6 border-t border-green-100 space-y-3 mt-4">
                @auth
                    {{-- Menu Auth (Mobile) --}}
                    @if($user->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" @click="mobileOpen = false"
                            class="flex items-center gap-3 py-3 px-4 text-base font-semibold text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all group">
                            <svg class="w-5 h-5 text-slate-500 group-hover:text-green-700 transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Admin Panel
                        </a>
                    @elseif($user->role === 'petani')
                        <a href="{{ route('petani.dashboard') }}" @click="mobileOpen = false"
                            class="flex items-center gap-3 py-3 px-4 text-base font-semibold text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all group">
                            <svg class="w-5 h-5 text-slate-500 group-hover:text-green-700 transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                    @endif

                    {{-- Menu Profil Mobile --}}
                    <a href="{{ route('profile.edit') }}" @click="mobileOpen = false"
                        class="flex items-center gap-3 py-3 px-4 text-base font-semibold text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all group">
                        <svg class="w-5 h-5 text-slate-500 group-hover:text-green-700 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profil Saya
                    </a>

                    {{-- Menu Pesanan untuk konsumen (Mobile) --}}
                    @if($user->role === 'konsumen')
                        <a href="{{ route('konsumen.pesanan.index') }}" @click="mobileOpen = false"
                            class="flex items-center gap-3 py-3 px-4 text-base font-semibold text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all group">
                            <svg class="w-5 h-5 text-slate-500 group-hover:text-green-700 transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Pesanan Saya
                        </a>
                    @endif

                    {{-- Logout Form Mobile --}}
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" @click="mobileOpen = false"
                            class="flex items-center gap-3 w-full py-3 px-4 text-base font-semibold text-red-600 hover:text-red-700 hover:bg-red-50 rounded-xl transition-all group">
                            <svg class="w-5 h-5 text-red-500 group-hover:text-red-700 transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                @else
                    {{-- ================================================
                    TOMBOL GUEST (Mobile - Belum login)
                    ================================================ --}}
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('login') }}" @click="mobileOpen = false"
                            class="flex items-center justify-center gap-2 py-3 text-base font-bold text-white bg-gradient-to-r from-green-600 to-green-700 rounded-xl hover:shadow-lg hover:shadow-green-100 transition-all">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" @click="mobileOpen = false"
                            class="flex items-center justify-center gap-2 py-3 text-base font-bold text-green-700 border border-green-200 bg-white rounded-xl hover:bg-green-50 hover:border-green-300 transition-all shadow-sm">
                            Daftar
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>