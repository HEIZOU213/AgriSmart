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
    
    {{-- Pastikan Alpine.js dimuat (biasanya sudah include di app.js via Vite, jika belum tambahkan CDN ini) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-50 text-slate-800">

    {{-- NAVIGASI ATAS (STYLE KODE 1 + LOGIKA KODE 2) --}}
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

                {{-- 2. Desktop Menu (Gabungan Menu Umum & Konsumen) --}}
                <div class="hidden lg:flex flex-none items-center justify-center gap-6">
                    @php
                        $navItems = [
                            // Menu Khusus Konsumen dari Kode 2
                            ['name' => 'Pesanan Saya', 'href' => route('konsumen.pesanan.index'), 'active' => request()->routeIs('konsumen.pesanan.*')],
                        ];
                    @endphp

                    @foreach($navItems as $item)
                        <a href="{{ $item['href'] }}"
                            class="relative px-3 py-2 rounded-lg font-semibold transition-all duration-300 group overflow-hidden {{ $item['active'] ? 'text-green-700' : 'text-slate-600 hover:text-green-700' }}">
                            {{ $item['name'] }}
                            <span class="absolute bottom-0 left-1/2 -translate-x-1/2 h-[2px] bg-green-600 transition-all duration-300 rounded-full {{ $item['active'] ? 'w-3/4' : 'w-0 group-hover:w-3/4' }}"></span>
                        </a>
                    @endforeach

                    {{-- Link Chat Khusus --}}
                    <a href="{{ url('/chat') }}"
                        class="relative px-3 py-2 rounded-lg font-semibold transition-all duration-300 group {{ request()->is('chat*') ? 'text-green-700' : 'text-slate-600 hover:text-green-700' }}">
                        Pesan
                        {{-- ID Badge Chat Desktop (Untuk JS Realtime) --}}
                        <span id="badge-chat-desktop" class="hidden absolute top-0 right-0 -mt-1 -mr-1 bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">0</span>
                    </a>
                </div>

                {{-- 3. Right Side (Cart & Profile) --}}
                <div class="flex-1 flex justify-end items-center gap-2 sm:gap-4">

                    {{-- Ikon Keranjang (Desktop) --}}
                    <a href="{{ route('cart.index') }}"
                        class="group relative p-2 text-slate-600 hover:text-green-700 transition-colors hidden sm:block mr-1">
                        <svg class="w-6 h-6 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>

                        {{-- ID Badge Keranjang Desktop (Untuk JS Realtime) --}}
                        <span id="badge-cart-desktop" class="hidden absolute top-0 right-0 -mt-1 -mr-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-[10px] font-bold text-white shadow-md ring-2 ring-white transform transition-transform group-hover:scale-110">
                            0
                        </span>
                    </a>

                    {{-- User Dropdown (Alpine.js) --}}
                    <div class="hidden lg:block relative" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false"
                            class="relative flex items-center justify-center w-10 h-10 rounded-full {{ Auth::user()->foto_profil ? 'bg-transparent' : 'bg-green-700' }} text-white font-bold text-lg hover:shadow-lg hover:shadow-green-100 border-2 border-transparent hover:border-green-200 transition-all duration-300 focus:outline-none overflow-hidden">
                            
                            @if(Auth::user()->foto_profil)
                                <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="Profil" class="w-full h-full object-cover">
                            @else
                                <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            @endif
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="dropdownOpen" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-xl border border-green-100 overflow-hidden z-50"
                            style="display: none;">

                            <div class="px-6 py-4 border-b border-green-50 bg-green-50/50">
                                <h4 class="font-bold text-slate-800 text-sm truncate">{{ Auth::user()->name }}</h4>
                                <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <div class="p-2 space-y-1">
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2 text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-lg transition-all">
                                    Profil Saya
                                </a>
                                <a href="{{ route('konsumen.pesanan.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-lg transition-all">
                                    Riwayat Pesanan
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Mobile Toggle Button --}}
                    <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 text-slate-700 hover:text-green-700 transition-colors relative">
                        {{-- ID Badge Hamburger (Indikator titik merah jika ada notif) --}}
                        <span id="badge-hamburger" class="hidden absolute top-2 right-2 block h-2.5 w-2.5 rounded-full bg-red-600 ring-2 ring-white animate-pulse"></span>
                        
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu (Dropdown Style Alpine) --}}
        <div x-show="mobileOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4" 
            x-transition:enter-end="opacity-100 translate-y-0"
            @click.away="mobileOpen = false"
            class="lg:hidden fixed inset-x-0 top-[64px] bg-white border-t border-green-100 shadow-xl z-40 max-h-[80vh] overflow-y-auto"
            style="display: none;">

            <div class="px-6 py-6 space-y-2">
                @foreach($navItems as $item)
                    <a href="{{ $item['href'] }}" @click="mobileOpen = false"
                        class="block py-3 px-4 text-base font-semibold text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all">
                        {{ $item['name'] }}
                    </a>
                @endforeach

                {{-- Mobile Chat Link --}}
                <a href="{{ url('/chat') }}" @click="mobileOpen = false"
                    class="flex items-center justify-between py-3 px-4 text-base font-semibold text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all">
                    <span>Pesan / Chat</span>
                    <span id="badge-chat-mobile" class="hidden bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">0</span>
                </a>

                {{-- Mobile Cart Link --}}
                <a href="{{ route('cart.index') }}" @click="mobileOpen = false"
                    class="flex items-center justify-between py-3 px-4 text-base font-semibold text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all">
                    <span>Keranjang</span>
                    <span id="badge-cart-mobile" class="hidden bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">0</span>
                </a>

                <div class="border-t border-gray-100 my-2 pt-2">
                    <a href="{{ route('profile.edit') }}" class="block py-3 px-4 text-sm font-medium text-slate-600">Profil Saya</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left py-3 px-4 text-sm font-medium text-red-600">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- ================= KONTEN UTAMA ================= --}}
    <main class="pt-20 lg:pt-24 min-h-screen">
        {{ $slot }}
    </main>


    {{-- ================= SCRIPT JS REALTIME ================= --}}
    {{-- Kita hanya perlu mengambil logika Fetch API-nya saja, --}}
    {{-- karena Toggle Menu sudah ditangani oleh Alpine.js --}}
    <script>
        function checkNotifications() {
            fetch('/api/cek-notifikasi')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    // --- Update Badge Keranjang ---
                    updateBadge('badge-cart-desktop', data.keranjang);
                    updateBadge('badge-cart-mobile', data.keranjang);
                    
                    // --- Update Badge Chat ---
                    updateBadge('badge-chat-desktop', data.chat);
                    updateBadge('badge-chat-mobile', data.chat);

                    // --- Update Indikator Hamburger (Jika ada notif chat/keranjang) ---
                    const hamburgerBadge = document.getElementById('badge-hamburger');
                    if (hamburgerBadge) {
                        // Jika ada keranjang ATAU chat, nyalakan titik merah di menu mobile
                        if (data.keranjang > 0 || data.chat > 0) {
                            hamburgerBadge.classList.remove('hidden');
                        } else {
                            hamburgerBadge.classList.add('hidden');
                        }
                    }
                })
                .catch(error => console.error('Error checking notifications:', error)); // Silent error log
        }

        // Fungsi Helper untuk toggle class hidden
        function updateBadge(elementId, count) {
            const badge = document.getElementById(elementId);
            if (badge) {
                if (count > 0) {
                    badge.innerText = count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }
        }

        // Jalankan saat load & interval 3 detik
        document.addEventListener('DOMContentLoaded', checkNotifications);
        setInterval(checkNotifications, 3000);
    </script>

</body>
</html>