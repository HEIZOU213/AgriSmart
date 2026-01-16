<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AgriSmart Admin') }}</title>

    {{-- FONT --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- SCRIPT (CDN) --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    
    {{-- NAVIGASI ATAS (FIXED) --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 md:px-6 shadow-sm">
        
        {{-- BAGIAN KIRI: LOGO --}}
        <div class="flex items-center gap-2">
            <a href="/" class="flex items-center gap-2 group relative shrink-0">
                <img src="{{ asset('images/nav-logo.png') }}" alt="AgriSmart Logo"
                    class="h-12 lg:h-16 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
            </a>
        </div>

        {{-- BAGIAN KANAN: User Menu + Hamburger --}}
        <div class="flex items-center gap-3">
            
            {{-- User Menu (Desktop Only) --}}
            <div class="relative hidden md:block">
                <button id="adminUserBtn" class="flex items-center gap-2 focus:outline-none group">
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                    @if(Auth::user()->foto_profil)
                        <img class="h-9 w-9 rounded-full object-cover ring-2 ring-gray-200 group-hover:ring-indigo-500 transition" src="{{ asset('storage/' . Auth::user()->foto_profil) }}">
                    @else
                        <div class="h-9 w-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold ring-2 ring-gray-200 group-hover:ring-indigo-500 transition">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                {{-- Dropdown Content --}}
                <div id="adminUserDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                        Profil saya
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

            {{-- [FIX] Tombol Hamburger (Mobile) - Dipindah ke Kanan --}}
            {{-- [EDITED] Tombol Hamburger (Mobile) - Di Kanan - ICON TEBAL --}}
            <button id="mobileMenuBtn" class="md:hidden p-2 rounded-md text-gray-700 hover:bg-gray-100 focus:outline-none transition-colors">
                {{-- SVG Ikon Menu Tebal & Bulat --}}
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </nav>

    {{-- [FIX] MENU MOBILE (RIGHT SIDEBAR) --}}
    <div id="mobileMenuOverlay" class="hidden fixed inset-0 z-40 bg-black bg-opacity-50 md:hidden"></div>
    
    {{-- Perhatikan class: 'right-0' dan 'translate-x-full' (bukan -translate) --}}
    <div id="mobileSidebar" class="fixed top-0 right-0 w-72 h-full bg-white border-l border-gray-200 transform translate-x-full transition-transform duration-300 ease-in-out z-50 md:hidden overflow-y-auto">
        
        {{-- Header Sidebar Mobile --}}
        <div class="p-6 bg-indigo-50 border-b border-indigo-100 flex items-center justify-between">
             <div class="flex items-center gap-3">
                @if(Auth::user()->foto_profil)
                    <img class="h-10 w-10 rounded-full object-cover ring-2 ring-white" src="{{ asset('storage/' . Auth::user()->foto_profil) }}">
                @else
                    <div class="h-10 w-10 rounded-full bg-indigo-200 flex items-center justify-center text-indigo-700 font-bold ring-2 ring-white">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
                <div>
                    <div class="font-bold text-gray-900">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-indigo-600 font-medium">{{ Auth::user()->email }}</div>
                </div>
            </div>
            {{-- Tombol Tutup --}}
            <button id="closeMobileBtn" class="text-gray-500 hover:text-red-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="p-6">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Menu Admin</h3>
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.konten-edukasi.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.konten-edukasi.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    Konten Edukasi
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    Kelola Akun
                </a>

                <a href="{{ route('admin.products.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    Kelola produk
                </a>

                {{-- PERBAIKAN DI SINI: routeIs('admin.withdraw.*') --}}
                 <a href="{{ route('admin.withdraw.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.withdraw.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    Kelola penarikan
                </a>

                <a href="{{ route('admin.kontak.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.kontak.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    Inbox Pesan
                </a>
            </nav>

            <div class="my-6 border-t border-gray-100"></div>

            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Akun Saya</h3>
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

    {{-- WRAPPER KONTEN --}}
    <div class="pt-16 flex h-screen overflow-hidden">

        {{-- SIDEBAR KIRI DESKTOP (TETAP DI KIRI UNTUK LAPTOP) --}}
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:block overflow-y-auto flex-shrink-0">
            <div class="p-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Menu Utama</h3>
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.konten-edukasi.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.konten-edukasi.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Konten Edukasi
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Kelola Akun
                    </a>

                    <a href="{{ route('admin.products.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Kelola produk
                    </a>

                    {{-- PERBAIKAN DI SINI JUGA: routeIs('admin.withdraw.*') --}}
                    <a href="{{ route('admin.withdraw.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.withdraw.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Kelola penarikan
                    </a>

                    <a href="{{ route('admin.kontak.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.kontak.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Inbox Pesan
                    </a>
                </nav>
            </div>
        </aside>

        {{-- KONTEN UTAMA --}}
        <div class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-8">
            @if (isset($header))
                <header class="mb-6 md:mb-8">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">
                        {{ $header }}
                    </h2>
                </header>
            @endif

            {{ $slot }}
        </div>
    
    </div>

    {{-- SCRIPT JS MANUAL --}}
    <script>
        // 1. Mobile Sidebar Logic (Toggle dari Kanan)
        const mobileBtn = document.getElementById('mobileMenuBtn');
        const closeMobileBtn = document.getElementById('closeMobileBtn');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const mobileOverlay = document.getElementById('mobileMenuOverlay');

        function toggleMobileSidebar() {
            // Toggle translate-x-full (menyembunyikan ke kanan)
            mobileSidebar.classList.toggle('translate-x-full');
            mobileOverlay.classList.toggle('hidden');
        }

        if(mobileBtn) mobileBtn.addEventListener('click', toggleMobileSidebar);
        if(closeMobileBtn) closeMobileBtn.addEventListener('click', toggleMobileSidebar);
        if(mobileOverlay) mobileOverlay.addEventListener('click', toggleMobileSidebar);

        // 2. Desktop Dropdown Logic
        const userBtn = document.getElementById('adminUserBtn');
        const userDropdown = document.getElementById('adminUserDropdown');

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