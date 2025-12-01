{{-- resources/views/components/navbar.blade.php --}}
<nav x-data="{ mobileOpen: false, scrolled: false, dropdownOpen: false }"
    @scroll.window="scrolled = window.scrollY > 20"
    :class="scrolled ? 'bg-white shadow-md border-b border-gray-100' : 'bg-white border-b border-transparent'"
    class="fixed inset-x-0 top-0 z-50 transition-all duration-500">

    {{-- Container Responsif --}}
    {{-- MODIFIKASI: Padding diperbesar (lg:px-12 xl:px-32) agar konten lebih rapat ke tengah --}}
    <div class="container mx-auto px-4 sm:px-8 lg:px-12 xl:px-32 transition-all duration-300">
        <div class="flex items-center justify-between h-16 lg:h-20">

            {{-- 1. Logo Section (Kiri) --}}
            <a href="/" class="flex items-center gap-2 group relative shrink-0">
                <img src="{{ asset('images/nav-logo.png') }}" alt="AgriSmart Logo"
                    class="h-36 lg:h-40 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
            </a>

            {{-- 2. Desktop Menu (Tengah) --}}
            <div class="hidden lg:flex items-center gap-1 xl:gap-2">
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
                        class="relative px-3 lg:px-2 xl:px-4 py-2.5 rounded-lg font-semibold transition-all duration-300 group overflow-hidden {{ $item['active'] ?? false ? 'text-emerald-700' : 'text-gray-600 hover:text-emerald-700' }}">

                        <span class="relative flex items-center gap-1.5 text-sm xl:text-base whitespace-nowrap">
                            <svg class="w-4 h-4 opacity-70 group-hover:opacity-100 transition-opacity" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $item['icon'] }}" />
                            </svg>
                            {{ $item['name'] }}
                        </span>

                        {{-- Indikator Garis Bawah --}}
                        <span
                            class="absolute bottom-0 left-1/2 -translate-x-1/2 h-[2px] bg-emerald-600 transition-all duration-300 rounded-full {{ $item['active'] ?? false ? 'w-3/4' : 'w-0 group-hover:w-3/4' }}"></span>
                    </a>
                @endforeach
            </div>

            {{-- 3. Right Side (Auth / Guest Buttons) (Kanan) --}}
            <div class="flex items-center gap-2 sm:gap-4 shrink-0">

                @auth
                    {{-- User Dropdown --}}
                    <div class="relative" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen"
                            class="flex items-center gap-2 xl:gap-3 px-2 sm:px-4 py-2 rounded-xl hover:bg-emerald-50 transition-all duration-300 group">

                            <div class="relative shrink-0">
                                <div
                                    class="relative w-9 h-9 xl:w-10 xl:h-10 bg-emerald-700 text-white rounded-full flex items-center justify-center font-bold transition-all duration-300 text-sm xl:text-base">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            </div>

                            <span
                                class="hidden xl:block font-semibold text-gray-700 group-hover:text-emerald-700 transition-colors max-w-[100px] truncate">
                                {{ Auth::user()->name }}
                            </span>

                            <svg class="w-4 h-4 xl:w-5 xl:h-5 text-gray-500 group-hover:text-emerald-700 transition-transform duration-300"
                                :class="dropdownOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- Dropdown Menu Content --}}
                        <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0" @click.away="dropdownOpen = false"
                            class="absolute right-0 mt-3 w-72 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden"
                            style="display: none;">

                            <div class="px-6 py-5 bg-gray-50 border-b border-gray-100">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-12 bg-emerald-700 text-white rounded-full flex items-center justify-center font-bold text-lg shrink-0">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                                        <p class="text-sm text-gray-600 truncate">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="py-2">
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="flex items-center gap-3 px-6 py-3.5 hover:bg-emerald-50 text-gray-700 font-medium transition-colors group">
                                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                        <span class="group-hover:translate-x-1 transition-transform">Admin Panel</span>
                                    </a>
                                @elseif(Auth::user()->role === 'petani')
                                    <a href="{{ route('petani.dashboard') }}"
                                        class="flex items-center gap-3 px-6 py-3.5 hover:bg-emerald-50 text-gray-700 font-medium transition-colors group">
                                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        <span class="group-hover:translate-x-1 transition-transform">Dashboard Petani</span>
                                    </a>
                                @endif

                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-3 px-6 py-3.5 hover:bg-emerald-50 text-gray-700 font-medium transition-colors group">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="group-hover:translate-x-1 transition-transform">Profil Saya</span>
                                </a>

                                @if(Auth::user()->role === 'konsumen')
                                    <a href="{{ route('konsumen.pesanan.index') }}"
                                        class="flex items-center gap-3 px-6 py-3.5 hover:bg-emerald-50 text-gray-700 font-medium transition-colors group">
                                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        <span class="group-hover:translate-x-1 transition-transform">Pesanan Saya</span>
                                    </a>
                                @endif

                                <hr class="my-2 border-gray-100">

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-3 w-full px-6 py-3.5 text-red-600 hover:bg-red-50 font-medium transition-colors group">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span class="group-hover:translate-x-1 transition-transform">Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Guest Buttons (Masuk & Daftar) --}}
                    <div class="hidden md:flex items-center gap-3">
                        {{-- Button Masuk --}}
                        <a href="{{ route('login') }}"
                            class="group relative px-5 py-2.5 text-sm lg:text-base font-bold text-emerald-700 bg-white border border-emerald-200 rounded-xl transition-all duration-300 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-50 hover:-translate-y-0.5 whitespace-nowrap overflow-hidden">
                            <span class="relative z-10 flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-600 transition-transform duration-300 group-hover:-translate-x-0.5"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                Masuk
                            </span>
                        </a>

                        {{-- Button Daftar --}}
                        <a href="{{ route('register') }}"
                            class="group relative px-5 py-2.5 text-sm lg:text-base font-bold text-white bg-gradient-to-r from-emerald-600 to-emerald-800 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-emerald-200 hover:-translate-y-0.5 whitespace-nowrap overflow-hidden">
                            {{-- Shine Effect --}}
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
                    class="lg:hidden p-2 text-gray-700 hover:text-emerald-700 transition-colors">
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
        class="lg:hidden fixed inset-x-0 top-[64px] lg:top-[80px] bg-white border-t border-gray-100 shadow-xl z-40"
        style="display: none;">

        <div class="container mx-auto px-6 py-6 space-y-2 max-h-[calc(100vh-5rem)] overflow-y-auto">
            @foreach($navItems as $item)
                <a href="{{ $item['href'] }}" @click="mobileOpen = false"
                    class="flex items-center gap-4 py-3 px-4 text-base font-semibold text-gray-700 hover:text-emerald-700 hover:bg-emerald-50 rounded-xl transition-all duration-300 group">
                    <svg class="w-5 h-5 text-gray-500 group-hover:text-emerald-700 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                    </svg>
                    <span class="group-hover:translate-x-1 transition-transform">{{ $item['name'] }}</span>
                </a>
            @endforeach

            <div class="pt-6 border-t border-gray-100 space-y-3 mt-4">
                @auth
                    <div class="px-4 py-3 bg-gray-50 rounded-xl mb-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-emerald-700 text-white rounded-full flex items-center justify-center font-bold shrink-0">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="overflow-hidden">
                                <p class="font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-600 truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('profile.edit') }}" @click="mobileOpen = false"
                        class="flex items-center gap-3 py-3 px-4 text-base font-semibold text-gray-700 hover:text-emerald-700 hover:bg-emerald-50 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profil Saya
                    </a>

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
                    {{-- Mobile Guest Buttons --}}
                    <div class="grid grid-cols-2 gap-3 mt-4">
                        <a href="{{ route('login') }}" @click="mobileOpen = false"
                            class="flex items-center justify-center gap-2 py-3 text-base font-bold text-emerald-700 border border-emerald-200 bg-white rounded-xl hover:bg-emerald-50 hover:border-emerald-300 transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" @click="mobileOpen = false"
                            class="flex items-center justify-center gap-2 py-3 text-base font-bold text-white bg-gradient-to-r from-emerald-600 to-emerald-800 rounded-xl hover:shadow-lg hover:shadow-emerald-100 transition-all">
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