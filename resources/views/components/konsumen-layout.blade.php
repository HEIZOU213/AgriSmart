<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AgriSmart') }} - Konsumen</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 text-slate-800">

    {{-- === NAVBAR START === --}}
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
                        class="h-12 lg:h-36 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                </a>
            </div>  

                {{-- 2. Desktop Menu --}}
                <div class="hidden lg:flex flex-none items-center justify-center gap-6">
                    @php
                        $navItems = [
                            
                            [
                                'name' => 'Pesanan Saya', 
                                'href' => route('konsumen.pesanan.index'), 
                                'active' => request()->routeIs('konsumen.pesanan.*'), 
                                'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'
                            ],
                            // --- TAMBAHAN FITUR CHAT DI SINI ---
                            [
                                'name' => 'pesan', 
                                'href' => url('/chat'), // Pastikan route ini sesuai dengan route chat Anda
                                'active' => request()->is('chat*'), 
                                'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z'
                            ],
                        ];
                    @endphp

                    @foreach ($navItems as $item)
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

                {{-- 3. Right Side (Auth / Cart) --}}
                <div class="flex-1 flex justify-end items-center gap-2 sm:gap-4">

                    {{-- Ikon Keranjang --}}
                    <a href="{{ route('cart.index') }}"
                        class="group relative p-2 text-slate-600 hover:text-green-700 transition-colors hidden sm:block mr-1">
                        <svg class="w-6 h-6 transition-transform group-hover:scale-110" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </a>

                    {{-- User Dropdown --}}
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
                                        <h4 class="font-bold text-slate-800 text-sm truncate">{{ Auth::user()->name }}
                                        </h4>
                                        <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 space-y-1">
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all">
                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profil Saya
                                </a>

                                <a href="{{ route('konsumen.pesanan.index') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all">
                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Pesanan Saya
                                </a>

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

                    {{-- Mobile Toggle Button --}}
                    <button @click="mobileOpen = !mobileOpen"
                        class="lg:hidden p-2 text-slate-700 hover:text-green-700 transition-colors">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
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
                @foreach ($navItems as $item)
                    <a href="{{ $item['href'] }}" @click="mobileOpen = false"
                        class="flex items-center gap-4 py-3 px-4 text-base font-semibold text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all duration-300 group">
                        <svg class="w-5 h-5 text-slate-500 group-hover:text-green-700 transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $item['icon'] }}" />
                        </svg>
                        <span class="group-hover:translate-x-1 transition-transform">{{ $item['name'] }}</span>
                    </a>
                @endforeach

                {{-- Link Keranjang Mobile --}}
                <a href="{{ route('cart.index') }}" @click="mobileOpen = false"
                    class="flex items-center gap-4 py-3 px-4 text-base font-semibold text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all duration-300 group">
                    <svg class="w-5 h-5 text-slate-500 group-hover:text-green-700 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="group-hover:translate-x-1 transition-transform">Keranjang</span>
                </a>

                <div class="pt-6 border-t border-green-100 space-y-3 mt-4">
                    <div class="flex items-center px-4 mb-4 gap-3">
                         <div class="w-10 h-10 rounded-full bg-green-700 text-white flex items-center justify-center font-bold text-lg">
                             {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                         </div>
                         <div>
                             <div class="font-bold text-gray-800">{{ Auth::user()->name }}</div>
                             <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                         </div>
                    </div>

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
                </div>
            </div>
        </div>
    </nav>
    {{-- === NAVBAR END === --}}


    {{-- === KONTEN UTAMA === --}}
    <main class="pt-24 min-h-screen">
        {{ $slot }}
    </main>

</body>
</html>