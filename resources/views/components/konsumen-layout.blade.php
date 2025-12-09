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

    {{-- Scripts (Tetap menggunakan Vite sesuai settingan awal Anda) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 text-slate-800">

   {{-- NAVIGASI ATAS (FIXED) --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 md:px-6 shadow-sm">
        
        {{-- BAGIAN KIRI: LOGO --}}
        <div class="flex items-center gap-2">
            <a href="/" class="flex items-center gap-2 group relative shrink-0">
                <img src="{{ asset('images/nav-logo.png') }}" alt="AgriSmart Logo"
                    class="h-36 lg:h-40 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
            </a>
        </div>

        {{-- 2. BAGIAN TENGAH/KANAN: MENU DESKTOP & USER --}}
        <div class="flex items-center gap-4">
            
            {{-- Menu Navigasi Desktop (Hidden di Mobile) --}}
            <div class="hidden md:flex items-center gap-1 mr-2">
                <a href="{{ route('konsumen.pesanan.index') }}" 
                   class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('konsumen.pesanan.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                   Pesanan Saya
                </a>
                
                {{-- Link Chat --}}
                <a href="{{ url('/chat') }}" 
                   class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('chat*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                   Pesan
                </a>
            </div>

            {{-- Ikon Keranjang (Selalu Muncul) --}}
            <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-500 hover:text-green-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </a>

            {{-- User Menu (Desktop Only) --}}
            <div class="relative hidden md:block">
                <button id="userMenuBtn" class="flex items-center gap-2 focus:outline-none group">
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">Konsumen</p>
                    </div>
                    @if(Auth::user()->foto_profil)
                        <img class="h-9 w-9 rounded-full object-cover ring-2 ring-gray-200 group-hover:ring-green-500 transition" src="{{ asset('storage/' . Auth::user()->foto_profil) }}">
                    @else
                        <div class="h-9 w-9 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold ring-2 ring-gray-200 group-hover:ring-green-500 transition">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                {{-- Dropdown Content --}}
                <div id="userMenuDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-green-600">
                        Profil Saya
                    </a>
                    <a href="{{ route('konsumen.pesanan.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-green-600">
                        Riwayat Pesanan
                    </a>
                    <div class="border-t border-gray-100 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>

            {{-- [EDITED] Tombol Hamburger (Mobile Only) - ICON TEBAL --}}
            <button id="mobileMenuBtn" class="md:hidden p-2 rounded-md text-gray-700 hover:bg-gray-100 focus:outline-none transition-colors">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </nav>


    {{-- ================= MENU MOBILE (DRAWER KANAN) ================= --}}
    <div id="mobileMenuOverlay" class="hidden fixed inset-0 z-40 bg-black bg-opacity-50 md:hidden"></div>
    
    <div id="mobileSidebar" class="fixed top-0 right-0 w-72 h-full bg-white border-l border-gray-200 transform translate-x-full transition-transform duration-300 ease-in-out z-50 md:hidden overflow-y-auto">
        
        {{-- Header Sidebar Mobile --}}
        <div class="p-6 bg-green-50 border-b border-green-100 flex items-center justify-between">
             <div class="flex items-center gap-3">
                @if(Auth::user()->foto_profil)
                    <img class="h-10 w-10 rounded-full object-cover ring-2 ring-white" src="{{ asset('storage/' . Auth::user()->foto_profil) }}">
                @else
                    <div class="h-10 w-10 rounded-full bg-green-200 flex items-center justify-center text-green-700 font-bold ring-2 ring-white">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
                <div>
                    <div class="font-bold text-gray-900">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-green-600 font-medium">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <button id="closeMobileBtn" class="text-gray-500 hover:text-red-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        {{-- Isi Menu Mobile --}}
        <div class="p-6">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Menu Konsumen</h3>
            <nav class="space-y-1">
                <a href="{{ route('konsumen.pesanan.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('konsumen.pesanan.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Pesanan Saya
                </a>
                
                <a href="{{ url('/chat') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->is('chat*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                     <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    Pesan (Chat)
                </a>

                <a href="{{ route('cart.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('cart.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Keranjang
                </a>
            </nav>

            <div class="my-6 border-t border-gray-100"></div>

            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Akun</h3>
            <nav class="space-y-1">
                <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition-colors">
                    Profil Saya
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-3 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                        Keluar
                    </button>
                </form>
            </nav>
        </div>
    </div>


    {{-- ================= KONTEN UTAMA ================= --}}
    <main class="pt-20 min-h-screen">
        {{ $slot }}
    </main>


    {{-- ================= SCRIPT JS (Sama seperti Admin Layout) ================= --}}
    <script>
        // 1. Mobile Sidebar Logic
        const mobileBtn = document.getElementById('mobileMenuBtn');
        const closeMobileBtn = document.getElementById('closeMobileBtn');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const mobileOverlay = document.getElementById('mobileMenuOverlay');

        function toggleMobileSidebar() {
            mobileSidebar.classList.toggle('translate-x-full');
            mobileOverlay.classList.toggle('hidden');
        }

        if(mobileBtn) mobileBtn.addEventListener('click', toggleMobileSidebar);
        if(closeMobileBtn) closeMobileBtn.addEventListener('click', toggleMobileSidebar);
        if(mobileOverlay) mobileOverlay.addEventListener('click', toggleMobileSidebar);

        // 2. Desktop Dropdown Logic
        const userBtn = document.getElementById('userMenuBtn');
        const userDropdown = document.getElementById('userMenuDropdown');

        if(userBtn && userDropdown) {
            userBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdown.classList.toggle('hidden');
            });
            document.addEventListener('click', (e) => {
                if (!userBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.add('hidden');
                }
            });
        }
    </script>

</body>
</html>