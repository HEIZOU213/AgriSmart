<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AgriSmart Petani') }}</title>

    {{-- FONT --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- SCRIPT --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
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
                    class="h-36 lg:h-40 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
            </a>
        </div>

        {{-- BAGIAN KANAN: User Menu + Hamburger --}}
        <div class="flex items-center gap-3">
            
            {{-- User Menu (Desktop Only) --}}
            <div class="relative hidden md:block">
                <button id="petaniUserBtn" class="flex items-center gap-2 focus:outline-none group">
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
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
                <div id="petaniUserDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-green-600">
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

            {{-- Tombol Hamburger (Mobile) - Di Kanan --}}
            <div class="relative">
                <button id="mobileMenuBtn" class="md:hidden p-2 rounded-md text-gray-700 hover:bg-gray-100 focus:outline-none transition-colors relative">
                    
                    {{-- [REALTIME] Indikator Merah di Hamburger --}}
                    {{-- Default hidden, akan dimunculkan oleh JS jika ada notif --}}
                    <span id="badge-hamburger" class="absolute top-2 right-2 block h-2.5 w-2.5 rounded-full bg-red-600 ring-2 ring-white animate-pulse hidden"></span>
                    
                    {{-- SVG Ikon Menu --}}
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    {{-- ======================= MOBILE SIDEBAR (RIGHT SLIDE) ======================= --}}
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
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Menu Petani</h3>
            <nav class="space-y-1">
                {{-- Dashboard --}}
                <a href="{{ route('petani.dashboard') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('petani.dashboard') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>

                {{-- Kelola Produk --}}
                <a href="{{ route('petani.produk.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('petani.produk.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Kelola Produk
                </a>

                {{-- Pesanan Masuk (Mobile) --}}
                <a href="{{ route('petani.pesanan.index') }}" class="flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('petani.pesanan.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Pesanan Masuk
                    </div>
                    {{-- [REALTIME] Badge Pesanan Mobile --}}
                    <span id="badge-pesanan-mobile" class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm hidden">0</span>
                </a>

                {{-- [BARU] MENU DOMPET SAYA (MOBILE) --}}
                <a href="{{ route('petani.dompet.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dompet.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                    Dompet Saya
                </a>

                {{-- Pesan / Chat (Mobile) --}}
                <a href="{{ route('chat.index') }}" class="flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('chat.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        Pesan
                    </div>
                    {{-- [REALTIME] Badge Chat Mobile --}}
                    <span id="badge-chat-mobile" class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm hidden">0</span>
                </a>
                
                <div class="mt-4 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Akses Cepat</div>
                <a href="{{ route('produk.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors hover:bg-gray-50 hover:text-gray-900 text-gray-600">
                    Marketplace
                </a>
                <a href="{{ route('edukasi.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors hover:bg-gray-50 hover:text-gray-900 text-gray-600">
                    Konten Edukasi
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

    {{-- ======================= WRAPPER KONTEN ======================= --}}
    <div class="pt-16 flex h-screen overflow-hidden">

        {{-- SIDEBAR KIRI DESKTOP --}}
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:block overflow-y-auto flex-shrink-0">
            <div class="p-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Menu Petani</h3>
                <nav class="space-y-1">
                    {{-- Dashboard --}}
                    <a href="{{ route('petani.dashboard') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('petani.dashboard') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Dashboard
                    </a>

                    {{-- Kelola Produk --}}
                    <a href="{{ route('petani.produk.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('petani.produk.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Kelola Produk
                    </a>

                    {{-- Pesanan Masuk (Desktop) --}}
                    <a href="{{ route('petani.pesanan.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('petani.pesanan.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Pesanan Masuk
                        </div>
                        {{-- [REALTIME] Badge Pesanan Desktop --}}
                        <span id="badge-pesanan-desktop" class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full ml-auto shadow-sm hidden">0</span>
                    </a>

                    {{-- [BARU] MENU DOMPET SAYA (DESKTOP) --}}
                    <a href="{{ route('petani.dompet.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dompet.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                        Dompet Saya
                    </a>

                    {{-- Pesan / Chat (Desktop) --}}
                    <a href="{{ route('chat.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('chat.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            Pesan
                        </div>
                        {{-- [REALTIME] Badge Chat Desktop --}}
                        <span id="badge-chat-desktop" class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full ml-auto shadow-sm hidden">0</span>
                    </a>

                    <div class="my-4 border-t border-gray-100"></div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 px-2">Akses Cepat</h3>

                    {{-- Marketplace --}}
                    <a href="{{ route('produk.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('produk.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        Marketplace
                    </a>

                    {{-- Konten Edukasi --}}
                    <a href="{{ route('edukasi.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('edukasi.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Konten Edukasi
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

    {{-- SCRIPT JAVASCRIPT & AJAX POLLING --}}
    <script>
        // 1. Sidebar Logic (Mobile)
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
        const userBtn = document.getElementById('petaniUserBtn');
        const userDropdown = document.getElementById('petaniUserDropdown');

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

        // ==========================================
        // 3. LOGIKA REALTIME NOTIFIKASI (AJAX POLLING)
        // ==========================================
        
        // Fungsi untuk mengambil data dari server
        function checkNotifications() {
            fetch('/api/cek-notifikasi')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    // Update Badge Pesanan (Desktop & Mobile)
                    updateBadge('badge-pesanan-desktop', data.pesanan);
                    updateBadge('badge-pesanan-mobile', data.pesanan);
                    
                    // Update Badge Chat (Desktop & Mobile)
                    updateBadge('badge-chat-desktop', data.chat);
                    updateBadge('badge-chat-mobile', data.chat);

                    // Update Indikator Hamburger (Mobile)
                    const hamburgerBadge = document.getElementById('badge-hamburger');
                    if (hamburgerBadge) {
                        if (data.pesanan > 0 || data.chat > 0) {
                            hamburgerBadge.classList.remove('hidden');
                        } else {
                            hamburgerBadge.classList.add('hidden');
                        }
                    }
                })
                .catch(error => console.error('Error checking notifications:', error));
        }

        // Fungsi Helper untuk Update UI Badge
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

        // Jalankan saat halaman pertama kali dimuat
        document.addEventListener('DOMContentLoaded', checkNotifications);

        // Jalankan berulang setiap 3 detik (3000 ms)
        setInterval(checkNotifications, 3000);
    </script>

</body>
</html>