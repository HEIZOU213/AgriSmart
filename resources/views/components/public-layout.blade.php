<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AgriSmart') }}</title>

    {{-- FONT MODERN: Plus Jakarta Sans --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- TAILWIND & SCRIPTS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Navbar Kaca (Glassmorphism) */
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 50;
            transition: all 0.3s ease;
        }

        /* Padding agar konten tidak tertutup navbar */
        .main-content {
            padding-top: 80px; 
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50">
    
    {{-- NAVBAR PREMIUM --}}
    <nav class="glass-nav shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                {{-- 1. LOGO (KIRI) --}}
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('homepage') }}" class="flex items-center gap-2.5 group">
                        <div class="bg-gradient-to-br from-green-500 to-green-700 p-2 rounded-xl shadow-lg shadow-green-500/30 group-hover:scale-105 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-extrabold text-xl tracking-tight text-gray-900 leading-none">Agri<span class="text-green-600">Smart</span></span>
                            <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Pertanian Digital</span>
                        </div>
                    </a>
                </div>

                {{-- 2. MENU TENGAH (DESKTOP) --}}
                <div class="hidden md:flex items-center space-x-1 bg-gray-100/50 p-1 rounded-full border border-gray-200/50">
                    <a href="{{ route('homepage') }}" 
                       class="px-5 py-2 text-sm font-bold {{ request()->routeIs('homepage') ? 'bg-white text-green-700 shadow-sm' : 'text-gray-600 hover:text-green-600' }} rounded-full transition-all duration-300">
                       Beranda
                    </a>
                    <a href="{{ route('produk.index') }}" 
                       class="px-5 py-2 text-sm font-bold {{ request()->routeIs('produk.*') ? 'bg-white text-green-700 shadow-sm' : 'text-gray-600 hover:text-green-600' }} rounded-full transition-all duration-300">
                       Marketplace
                    </a>
                    <a href="{{ route('edukasi.index') }}" 
                       class="px-5 py-2 text-sm font-bold {{ request()->routeIs('edukasi.*') ? 'bg-white text-green-700 shadow-sm' : 'text-gray-600 hover:text-green-600' }} rounded-full transition-all duration-300">
                       Edukasi
                    </a>
                </div>

                {{-- 3. MENU KANAN (USER ACTIONS) --}}
                <div class="flex items-center gap-3">
                    @auth
                        {{-- LOGIKA ROLE --}}
                        @php
                            $user = Auth::user();
                            $is_konsumen = $user->role === 'konsumen';
                            $is_petani = $user->role === 'petani';
                            $is_admin = $user->role === 'admin';
                        @endphp

                        {{-- KERANJANG (Khusus Konsumen) --}}
                        @if($is_konsumen)
                            <a href="{{ route('cart.index') }}" class="relative p-2.5 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-full transition-all duration-300 group mr-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                {{-- Dot Indikator (Opsional: bisa dikasih logika if count > 0) --}}
                                <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full animate-pulse"></span>
                            </a>
                        @endif

                        {{-- USER DROPDOWN (Hover) --}}
                        <div class="relative group">
                            <button class="flex items-center gap-3 pl-1 pr-3 py-1 border border-gray-200 rounded-full hover:shadow-md hover:border-green-200 transition-all duration-300 bg-white">
                                {{-- Avatar --}}
                                @if($user->foto_profil)
                                    <img class="h-9 w-9 rounded-full object-cover ring-2 ring-green-500" src="{{ asset('storage/' . $user->foto_profil) }}" alt="{{ $user->nama }}">
                                @else
                                    <div class="h-9 w-9 rounded-full bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center text-white font-bold shadow-sm">
                                        {{ substr($user->nama, 0, 1) }}
                                    </div>
                                @endif
                                
                                <div class="hidden md:block text-left mr-1">
                                    <p class="text-xs font-bold text-gray-800 leading-tight">{{ Str::limit($user->nama, 10) }}</p>
                                    <p class="text-[10px] font-medium text-green-600 uppercase tracking-wide">{{ $user->role }}</p>
                                </div>

                                <svg class="w-4 h-4 text-gray-400 group-hover:text-green-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            {{-- Dropdown Menu --}}
                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right z-50 overflow-hidden">
                                <div class="px-4 py-3 border-b border-gray-50 bg-gray-50">
                                    <p class="text-xs text-gray-500">Login sebagai</p>
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ $user->email }}</p>
                                </div>

                                <div class="py-1">
                                    {{-- Link Dashboard / Riwayat --}}
                                    @if($is_konsumen)
                                        <a href="{{ route('konsumen.pesanan.index') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                            Riwayat Pesanan
                                        </a>
                                        <a href="{{ route('chat.index') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                            Chat / Pesan
                                        </a>
                                    @else
                                        <a href="{{ url('/dashboard') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                            Dashboard Utama
                                        </a>
                                    @endif

                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Edit Profil
                                    </a>
                                </div>

                                <div class="border-t border-gray-100 py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                            Log Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @else
                        {{-- BELUM LOGIN --}}
                        <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-bold text-gray-600 hover:text-green-600 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-6 py-2.5 text-sm font-bold text-white bg-green-600 rounded-full hover:bg-green-700 shadow-lg shadow-green-600/30 transition transform hover:-translate-y-0.5">
                            Daftar
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    {{-- KONTEN HALAMAN --}}
    <div class="main-content min-h-screen">
        {{ $slot }}
    </div>

</body>
</html>