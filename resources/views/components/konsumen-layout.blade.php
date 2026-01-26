<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AgriSmart') }} - Konsumen</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    {{-- Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js (Wajib ada untuk navbar ini) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-50 text-slate-800">

    {{-- ================================================
    NAVBAR COMPONENT
    =================================================== --}}
    @php
        $navItems = [
            [
                'name' => 'Pesanan Saya',
                'href' => route('konsumen.pesanan.index'),
                'active' => request()->routeIs('konsumen.pesanan.*'),
                'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'
            ],
        ];
    @endphp

    <nav x-data="{ mobileOpen: false, scrolled: false, dropdownOpen: false }"
        @scroll.window.throttle.20ms="scrolled = window.scrollY > 20"
        :class="scrolled ? 'bg-white shadow-md border-b border-green-100' : 'bg-white border-b border-transparent'"
        class="fixed inset-x-0 top-0 z-50 w-full transition-all duration-500">

        {{-- Container Utama Navbar --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 transition-all duration-300">
            <div class="flex items-center justify-between h-16 lg:h-20">

                {{-- 1. LOGO SECTION (KIRI) --}}
                <div class="flex-1 flex justify-start items-center py-2">
                    <a href="/" class="flex items-center gap-2 group relative shrink-0">
                        <img src="{{ asset('images/nav-logo.png') }}" alt="AgriSmart Logo"
                            class="h-12 sm:h-16 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                    </a>
                </div>

                {{-- 2. DESKTOP MENU (TENGAH) --}}
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

                    {{-- MENU CHAT --}}
                    <a href="{{ url('/chat') }}"
                        class="relative px-3 py-2 rounded-lg font-semibold transition-all duration-300 group overflow-hidden {{ request()->is('chat*') ? 'text-green-700' : 'text-slate-600 hover:text-green-700' }}">
                        <span class="relative flex items-center gap-2 text-sm lg:text-base whitespace-nowrap">
                            <svg class="w-4 h-4 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            Pesan
                        </span>
                        {{-- Badge Chat Desktop --}}
                        <span id="badge-chat-desktop" class="hidden absolute top-0 right-0 -mt-0.5 -mr-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-600 text-[9px] font-bold text-white shadow-sm ring-1 ring-white">
                            0
                        </span>
                    </a>
                </div>

                {{-- 3. RIGHT SIDE (KANAN) --}}
                <div class="flex-1 flex justify-end items-center gap-2 sm:gap-4">

                    {{-- Ikon Keranjang (Desktop) --}}
                    <a href="{{ route('cart.index') }}"
                        class="group relative p-2 text-slate-600 hover:text-green-700 transition-colors hidden sm:block mr-1">

                        <svg class="w-6 h-6 transition-transform group-hover:scale-110" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>

                        {{-- Badge Keranjang Desktop --}}
                        <span id="badge-cart-desktop"
                            class="hidden absolute top-0 right-0 -mt-1 -mr-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-[10px] font-bold text-white shadow-md ring-2 ring-white transform transition-transform group-hover:scale-110">
                            0
                        </span>
                    </a>

                    {{-- AREA USER (Auth Only) --}}
                    @auth
                        {{-- User Dropdown (Desktop Only) --}}
                        <div class="hidden lg:block relative">

                            {{-- Tombol Profil --}}
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

                                {{-- Header Dropdown --}}
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
                                        </div>
                                    </div>
                                </div>

                                {{-- Menu Dropdown --}}
                                <div class="p-2 space-y-1">
                                    {{-- Link Profil --}}
                                    <a href="{{ route('profile.edit') }}"
                                        class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all group">
                                        <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profil Saya
                                    </a>

                                    {{-- LOGIKA BARU: Jika di halaman Pesanan/Chat -> Tampilkan Beranda. Jika tidak -> Tampilkan Pesanan Saya --}}
                                    @if(request()->routeIs('konsumen.pesanan.*') || request()->is('chat*'))
                                        <a href="/"
                                            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all group">
                                            <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                            Beranda
                                        </a>
                                    @else
                                        <a href="{{ route('konsumen.pesanan.index') }}"
                                            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all group">
                                            <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            Pesanan Saya
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
                    @endauth

                    {{-- MOBILE TOGGLE BUTTON --}}
                    <button @click="mobileOpen = !mobileOpen"
                        class="lg:hidden p-2 text-slate-700 hover:text-green-700 transition-colors relative">

                        {{-- Badge Hamburger --}}
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

                {{-- Mobile Chat Link --}}
                <a href="{{ url('/chat') }}" @click="mobileOpen = false"
                    class="flex items-center justify-between gap-4 py-3 px-4 text-base font-semibold {{ request()->is('chat*') ? 'text-green-700 bg-green-50' : 'text-slate-700 hover:text-green-700 hover:bg-green-50' }} rounded-xl transition-all duration-300 group">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5 text-slate-500 group-hover:text-green-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span class="group-hover:translate-x-1 transition-transform">Pesan / Chat</span>
                    </div>
                    {{-- Badge Chat Mobile --}}
                    <span id="badge-chat-mobile" class="hidden inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                        0
                    </span>
                </a>

                {{-- Link Keranjang (Mobile) --}}
                <a href="{{ route('cart.index') }}" @click="mobileOpen = false"
                    class="flex items-center justify-between gap-4 py-3 px-4 text-base font-semibold text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all duration-300 group">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5 text-slate-500 group-hover:text-green-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="group-hover:translate-x-1 transition-transform">Keranjang</span>
                    </div>
                    {{-- Badge Keranjang Mobile --}}
                    <span id="badge-cart-mobile" class="hidden inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                        0
                    </span>
                </a>

                {{-- Area User Mobile --}}
                <div class="pt-6 border-t border-green-100 space-y-3 mt-4">
                    @auth
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
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="pt-20 lg:pt-24 min-h-screen">
        {{ $slot }}
    </main>

    {{-- LOGIKA JS REALTIME --}}
    <script>
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

        document.addEventListener('DOMContentLoaded', checkNotifications);
        setInterval(checkNotifications, 3000);
    </script>
</body>
</html>