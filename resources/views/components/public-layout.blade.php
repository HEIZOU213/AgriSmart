<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AgriSmart') }}</title>

    {{-- FONT MODERN: Plus Jakarta Sans --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- TAILWIND & SCRIPTS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Animasi Fade In */
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fade-in 0.5s ease-out forwards; }

        /* Scrollbar Kustom */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #10B981; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #059669; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen">
    
    {{-- NAVBAR PREMIUM (Sama seperti Homepage) --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-200/50 shadow-sm transition-all duration-300" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                {{-- 1. LOGO --}}
                <div class="flex-shrink-0">
                    <a href="{{ route('homepage') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-green-600 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-green-500/30 transition-all duration-300">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <div class="hidden sm:block">
                            <div class="text-xl font-black text-gray-900 tracking-tight">Agri<span class="text-green-600">Smart</span></div>
                            <div class="text-[10px] text-gray-500 font-semibold uppercase tracking-wider -mt-1">Platform Pertanian Digital</div>
                        </div>
                    </a>
                </div>
                
                {{-- 2. MENU TENGAH (DESKTOP) --}}
                <div class="hidden lg:flex items-center gap-1 bg-gray-100/50 p-1.5 rounded-full border border-gray-200/50">
                    <a href="{{ route('homepage') }}" class="px-5 py-2 text-sm font-bold rounded-full transition-all {{ request()->routeIs('homepage') ? 'bg-white text-green-700 shadow-sm' : 'text-gray-600 hover:text-green-700 hover:bg-gray-200/50' }}">
                        Beranda
                    </a>
                    <a href="{{ route('produk.index') }}" class="px-5 py-2 text-sm font-bold rounded-full transition-all {{ request()->routeIs('produk.*') ? 'bg-white text-green-700 shadow-sm' : 'text-gray-600 hover:text-green-700 hover:bg-gray-200/50' }}">
                        Produk
                    </a>
                    <a href="{{ route('edukasi.index') }}" class="px-5 py-2 text-sm font-bold rounded-full transition-all {{ request()->routeIs('edukasi.*') ? 'bg-white text-green-700 shadow-sm' : 'text-gray-600 hover:text-green-700 hover:bg-gray-200/50' }}">
                        Edukasi
                    </a>
                </div>
                
                {{-- 3. MENU KANAN (AUTH & CART) --}}
                <div class="flex items-center gap-3">
                    
                    {{-- Keranjang (Muncul untuk Konsumen / Tamu) --}}
                    @if(!Auth::check() || (Auth::check() && Auth::user()->role === 'konsumen'))
                        <a href="{{ route('cart.index') }}" class="relative p-2.5 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-full transition-all group">
                            <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            {{-- Indikator Merah (Opsional: Logic jika ada isi) --}}
                            {{-- <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full animate-pulse"></span> --}}
                        </a>
                    @endif

                    @auth
                        {{-- USER DROPDOWN --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 pl-1 pr-3 py-1 border border-gray-200 rounded-full hover:shadow-md hover:border-green-200 transition-all duration-300 bg-white group">
                                @if(Auth::user()->foto_profil)
                                    <img class="w-9 h-9 rounded-full object-cover ring-2 ring-green-500 group-hover:ring-green-600 transition-all" src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="{{ Auth::user()->name }}">
                                @else
                                    <div class="w-9 h-9 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-sm ring-2 ring-green-500">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                                
                                <div class="hidden md:block text-left mr-1">
                                    <div class="text-xs font-bold text-gray-800 leading-tight">{{ Str::limit(Auth::user()->name, 10) }}</div>
                                    <div class="text-[10px] font-bold text-green-600 uppercase tracking-wide">{{ Auth::user()->role }}</div>
                                </div>
                                
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-green-600 transition" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            {{-- Dropdown Content --}}
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                 class="absolute right-0 mt-2 w-60 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 origin-top-right"
                                 style="display: none;">
                                
                                <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/50">
                                    <p class="text-xs text-gray-500 font-medium">Akun Terdaftar</p>
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->email }}</p>
                                </div>

                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                        Admin Panel
                                    </a>
                                @elseif(Auth::user()->role === 'petani')
                                    <a href="{{ route('petani.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                        Dashboard Petani
                                    </a>
                                @elseif(Auth::user()->role === 'konsumen')
                                    <a href="{{ route('konsumen.pesanan.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        Pesanan Saya
                                    </a>
                                    <a href="{{ route('chat.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                        Chat
                                    </a>
                                @endif

                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Profil Saya
                                </a>

                                <div class="border-t border-gray-100 my-1"></div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors rounded-b-xl">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        {{-- Tombol Login / Register --}}
                        <a href="{{ route('login') }}" class="hidden md:inline-flex items-center gap-2 px-6 py-2.5 text-gray-700 font-bold rounded-xl border-2 border-gray-200 hover:border-green-600 hover:text-green-600 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            Masuk
                        </a>
                        
                        <a href="{{ route('register') }}" class="hidden md:inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl hover:shadow-lg hover:shadow-green-500/30 transition-all transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            Daftar
                        </a>
                    @endauth

                    {{-- Mobile Menu Button --}}
                    <button class="lg:hidden p-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors" @click="open = !open">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu (Dropdown) --}}
        <div class="lg:hidden bg-white border-t border-gray-100" x-show="open" style="display: none;">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('homepage') }}" class="block px-4 py-3 text-gray-700 hover:text-green-600 hover:bg-green-50 font-bold rounded-xl transition-all">Beranda</a>
                <a href="{{ route('produk.index') }}" class="block px-4 py-3 text-gray-700 hover:text-green-600 hover:bg-green-50 font-bold rounded-xl transition-all">Produk</a>
                <a href="{{ route('edukasi.index') }}" class="block px-4 py-3 text-gray-700 hover:text-green-600 hover:bg-green-50 font-bold rounded-xl transition-all">Edukasi</a>
                
                <div class="border-t border-gray-100 my-2 pt-2">
                    @auth
                         <div class="flex items-center px-4 py-2 mb-2">
                            @if(Auth::user()->foto_profil)
                                <img class="w-8 h-8 rounded-full object-cover mr-3" src="{{ asset('storage/' . Auth::user()->foto_profil) }}">
                            @else
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold mr-3">{{ substr(Auth::user()->name, 0, 1) }}</div>
                            @endif
                            <span class="font-bold text-gray-800">{{ Auth::user()->name }}</span>
                         </div>

                         @if(Auth::user()->role === 'konsumen')
                            <a href="{{ route('konsumen.pesanan.index') }}" class="block px-4 py-3 text-gray-600 hover:text-green-600 font-medium rounded-xl">📦 Pesanan Saya</a>
                         @elseif(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 text-indigo-600 font-bold rounded-xl bg-indigo-50">Admin Panel</a>
                         @endif

                         <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-4 py-3 text-red-600 font-bold hover:bg-red-50 rounded-xl">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block px-4 py-3 text-gray-700 font-bold border border-gray-200 rounded-xl text-center mb-2">Masuk</a>
                        <a href="{{ route('register') }}" class="block px-4 py-3 bg-green-600 text-white font-bold rounded-xl text-center shadow-lg">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- KONTEN HALAMAN (Diberi padding top agar tidak tertutup navbar fixed) --}}
    <main class="pt-20">
        {{ $slot }}
    </main>

    {{-- FOOTER (Opsional, agar konsisten di semua halaman) --}}
    <footer class="bg-gray-900 text-white py-12 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h4 class="text-xl font-black text-white mb-4">Agri<span class="text-green-500">Smart</span></h4>
                    <p class="text-gray-400 text-sm leading-relaxed">Platform digital terdepan untuk memajukan pertanian Indonesia melalui teknologi dan edukasi.</p>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">Tautan</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('produk.index') }}" class="hover:text-green-400 transition">Marketplace</a></li>
                        <li><a href="{{ route('edukasi.index') }}" class="hover:text-green-400 transition">Edukasi</a></li>
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
                &copy; {{ date('Y') }} AgriSmart Indonesia. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>