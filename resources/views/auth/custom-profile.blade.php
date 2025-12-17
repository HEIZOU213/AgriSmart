<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AgriSmart') }} - Edit Profil</title>

    {{-- FONTS --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- SCRIPTS (Tailwind & Alpine) --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    {{-- Alpine.js Wajib untuk Navbar Konsumen --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 text-slate-800">

    {{-- ====================================================================== --}}
    {{-- ========================== BAGIAN NAVBAR ============================= --}}
    {{-- ====================================================================== --}}

    @if(Auth::user()->role === 'konsumen')

        {{-- >>>>>>>>>>>>>>>>>> NAVBAR KHUSUS KONSUMEN (Alpine.js) <<<<<<<<<<<<<<<<<< --}} {{-- NAVIGASI ATAS (STYLE KODE 1
            + LOGIKA KODE 2) --}} <nav x-data="{ mobileOpen: false, scrolled: false, dropdownOpen: false }"
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

                    {{-- Desktop Menu Konsumen --}}
                    <div class="hidden lg:flex flex-none items-center justify-center gap-6">
                        <a href="{{ Route::has('konsumen.pesanan.index') ? route('konsumen.pesanan.index') : '#' }}"
                            class="relative px-3 py-2 rounded-lg font-semibold text-slate-600 hover:text-green-700 transition-all duration-300 group">
                            Pesanan Saya
                            <span
                                class="absolute bottom-0 left-1/2 -translate-x-1/2 h-[2px] bg-green-600 transition-all duration-300 rounded-full w-0 group-hover:w-3/4"></span>
                        </a>
                        <a href="{{ url('/chat') }}"
                            class="relative px-3 py-2 rounded-lg font-semibold text-slate-600 hover:text-green-700 transition-all duration-300 group">
                            Pesan
                        </a>
                    </div>

                    {{-- Kanan Konsumen (Cart & User) --}}
                    <div class="flex-1 flex justify-end items-center gap-2 sm:gap-4">
                        <a href="{{ Route::has('cart.index') ? route('cart.index') : '#' }}"
                            class="group relative p-2 text-slate-600 hover:text-green-700 transition-colors hidden sm:block mr-1">
                            <svg class="w-6 h-6 transition-transform group-hover:scale-110" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            {{-- Badge Keranjang (Realtime via JS Bawah) --}}
                            <span id="badge-cart-desktop"
                                class="hidden absolute top-0 right-0 -mt-1 -mr-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-[10px] font-bold text-white shadow-md">0</span>
                        </a>

                        {{-- User Dropdown (Alpine.js) --}}
                        <div class="hidden lg:block relative" x-data="{ dropdownOpen: false }">
                            <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false"
                                class="relative flex items-center justify-center w-10 h-10 rounded-full {{ Auth::user()->foto_profil ? 'bg-transparent' : 'bg-green-700' }} text-white font-bold text-lg hover:shadow-lg hover:shadow-green-100 border-2 border-transparent hover:border-green-200 transition-all duration-300 focus:outline-none overflow-hidden">

                                @if(Auth::user()->foto_profil)
                                    <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="Profil"
                                        class="w-full h-full object-cover">
                                @else
                                    <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                @endif
                            </button>

                            {{-- Dropdown Menu --}}
                            <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-200"
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
                                    <a href="{{ route('profile.edit') }}"
                                        class="flex items-center gap-3 px-4 py-2 text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-lg transition-all">
                                        Profil Saya
                                    </a>
                                    <a href="{{ route('konsumen.pesanan.index') }}"
                                        class="flex items-center gap-3 px-4 py-2 text-sm font-medium text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-lg transition-all">
                                        Riwayat Pesanan
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center gap-3 w-full px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Mobile Toggle Button Konsumen --}}
                        <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 text-slate-700">
                            <span id="badge-hamburger"
                                class="hidden absolute top-2 right-2 block h-2.5 w-2.5 rounded-full bg-red-600 ring-2 ring-white animate-pulse"></span>
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Mobile Menu Konsumen --}}
            <div x-show="mobileOpen"
                class="lg:hidden fixed inset-x-0 top-[64px] bg-white border-t border-green-100 shadow-xl z-40 max-h-[80vh] overflow-y-auto"
                style="display: none;">
                <div class="px-6 py-6 space-y-2">
                    <a href="{{ Route::has('konsumen.pesanan.index') ? route('konsumen.pesanan.index') : '#' }}"
                        class="block py-3 px-4 font-semibold text-slate-700 hover:bg-green-50 rounded-xl">Pesanan Saya</a>
                    <a href="{{ url('/chat') }}"
                        class="block py-3 px-4 font-semibold text-slate-700 hover:bg-green-50 rounded-xl">Pesan/chat <span
                            id="badge-chat-mobile"
                            class="hidden bg-red-600 text-white text-xs px-2 py-1 rounded-full ml-2">0</span></a>
                    <a href="{{ Route::has('cart.index') ? route('cart.index') : '#' }}"
                        class="block py-3 px-4 font-semibold text-slate-700 hover:bg-green-50 rounded-xl">Keranjang <span
                            id="badge-cart-mobile"
                            class="hidden bg-red-600 text-white text-xs px-2 py-1 rounded-full ml-2">0</span></a>
                    <div class="border-t border-gray-100 my-2 pt-2">
                        <form method="POST" action="{{ route('logout') }}">@csrf<button
                                class="block w-full text-left py-3 px-4 font-medium text-red-600">Keluar</button></form>
                    </div>
                </div>
            </div>
            </nav>

    @else

            {{-- >>>>>>>>>>>>>>>>>> NAVBAR ADMIN / PETANI (ORIGINAL) <<<<<<<<<<<<<<<<<< --}} <nav
                class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 md:px-6 shadow-sm">
                <div class="flex items-center gap-2">
                    <a href="/" class="flex items-center gap-2 group relative shrink-0">
                        <img src="{{ asset('images/nav-logo.png') }}" alt="AgriSmart Logo"
                            class="h-36 lg:h-40 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                    </a>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <button id="adminUserBtn" class="flex items-center gap-2 focus:outline-none group">
                            <div class="text-right hidden md:block">
                                <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                            </div>
                            @if(Auth::user()->foto_profil)
                                <img class="h-9 w-9 rounded-full object-cover ring-2 ring-gray-200 group-hover:ring-indigo-500 transition"
                                    src="{{ asset('storage/' . Auth::user()->foto_profil) }}">
                            @else
                                <div
                                    class="h-9 w-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold ring-2 ring-gray-200 group-hover:ring-indigo-500 transition">
                                    {{ substr(Auth::user()->name, 0, 1) }}</div>
                            @endif
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div id="adminUserDropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50">
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600">Dashboard
                                    Admin</a>
                            @elseif(Auth::user()->role === 'petani')
                                <a href="{{ route('petani.dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-green-600">Dashboard
                                    Petani</a>
                            @endif
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
                </nav>

        @endif


            {{-- ====================================================================== --}}
            {{-- ======================== BAGIAN FORM EDIT PROFIL ===================== --}}
            {{-- ================= (SAMA UNTUK KONSUMEN, ADMIN, & PETANI) ============ --}}
            {{-- ====================================================================== --}}

            <main class="pt-24 pb-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

                {{-- Header Halaman --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Pengaturan Akun</h2>
                        <p class="text-sm text-gray-500 mt-1">Kelola informasi profil dan keamanan akun Anda.</p>
                    </div>
                    <div class="md:hidden">
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800">&larr;
                                Kembali ke Dashboard</a>
                        @elseif(Auth::user()->role === 'petani')
                            <a href="{{ route('petani.dashboard') }}"
                                class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-800">&larr;
                                Kembali ke Dashboard</a>
                        @endif
                    </div>
                </div>

                {{-- Flash Messages --}}
                @if (session('status') === 'profile-updated')
                    <div
                        class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-bold">Berhasil!</p>
                            <p class="text-sm">Informasi profil Anda telah diperbarui.</p>
                        </div>
                    </div>
                @endif
                @if (session('status') === 'password-updated')
                    <div
                        class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-bold">Berhasil!</p>
                            <p class="text-sm">Kata sandi Anda telah diperbarui.</p>
                        </div>
                    </div>
                @endif

                {{-- 1. CARD FORMULIR EDIT PROFIL (Card Bagus) --}}
                <div
                    class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900">Informasi Pribadi</h3>
                        <p class="text-sm text-gray-500 mt-1">Perbarui foto profil dan detail kontak Anda.</p>
                    </div>

                    <div class="p-6 sm:p-8">
                        <form method="post" action="{{ route('profile.update') }}" class="space-y-6"
                            enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            {{-- Foto Profil Section --}}
                            @php
                                $user = $user ?? Auth::user(); // Gunakan variabel $user dari view (jika ada) atau Auth::user()
                                $photoUrl = null;

                                if ($user->foto_profil) {
                                    // Cek apakah itu path lokal atau URL eksternal (Socialite)
                                    if (!preg_match('#^https?://#i', $user->foto_profil)) {
                                        // Jika path lokal, gunakan asset('storage/')
                                        $photoUrl = asset('storage/' . $user->foto_profil);
                                    } else {
                                        // Jika URL eksternal (Socialite)
                                        $photoUrl = $user->foto_profil;
                                    }
                                }

                                // Tentukan inisial untuk fallback
                                $initials = strtoupper(substr($user->name ?? $user->email, 0, 1));
                            @endphp

                            <div
                                class="flex flex-col sm:flex-row items-start sm:items-center gap-6 pb-6 border-b border-gray-100">
                                <div class="shrink-0 relative group">

                                    {{-- TAMPILKAN FOTO PROFIL (Menggunakan $photoUrl yang sudah dicek) --}}
                                    @if($photoUrl)
                                        {{-- Efek hover (group-hover:ring-green-100) dihilangkan di sini --}}
                                        <img class="h-24 w-24 object-cover rounded-full ring-4 ring-white shadow-lg transition"
                                            src="{{ $photoUrl }}" alt="Foto Profil {{ $user->name }}" />
                                    @else
                                        {{-- TAMPILKAN INISIAL (FALLBACK) --}}
                                        {{-- Efek hover (group-hover:ring-green-100) dihilangkan di sini --}}
                                        <div
                                            class="h-24 w-24 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white text-3xl font-bold ring-4 ring-white shadow-lg transition">
                                            {{ $initials }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 w-full">
                                    <label class="block text-sm font-bold text-gray-700 mb-2" for="foto_profil">Unggah
                                        Foto Baru</label>
                                    {{-- PENTING: NAME input harus "foto_profil" agar Controller menangkapnya --}}
                                    <input type="file" id="foto_profil" name="foto_profil"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer transition" />
                                    <p class="mt-2 text-xs text-gray-400">Format: JPG, PNG. Ukuran maks: 2MB.</p>

                                    {{-- Menggunakan komponen input-error atau span error --}}
                                    @error('foto_profil')
                                        <span class="text-red-500 text-xs font-medium mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Grid Input Nama & Email --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama
                                        Lengkap</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input id="name" name="name" type="text"
                                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                            value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                            </svg>
                                        </div>
                                        <input id="email" name="email" type="email"
                                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                            value="{{ old('email', $user->email) }}" required>
                                    </div>
                                    @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Input Telepon --}}
                            <div>
                                <label for="no_telepon" class="block text-sm font-bold text-gray-700 mb-2">No. Telepon /
                                    WhatsApp</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                        </svg>
                                    </div>
                                    <input id="no_telepon" name="no_telepon" type="text"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                        value="{{ old('no_telepon', $user->no_telepon) }}">
                                </div>
                            </div>

                            {{-- Input Alamat --}}
                            <div>
                                <label for="alamat" class="block text-sm font-bold text-gray-700 mb-2">Alamat
                                    Lengkap</label>
                                <div class="relative">
                                    <textarea id="alamat" name="alamat" rows="3"
                                        class="w-full pl-4 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition resize-none"
                                        placeholder="Masukkan alamat lengkap Anda...">{{ old('alamat', $user->alamat ?? '') }}</textarea>
                                </div>
                            </div>

                            {{-- Tombol Simpan --}}
                            <div class="flex justify-end pt-4">
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- 2. CARD FORMULIR GANTI PASSWORD (Card Bagus) --}}
                <div
                    class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900">Keamanan Akun</h3>
                        <p class="text-sm text-gray-500 mt-1">Perbarui kata sandi Anda untuk menjaga keamanan akun.</p>
                    </div>

                    <div class="p-6 sm:p-8">
                        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                            @csrf
                            @method('put')

                            <div>
                                <label for="current_password"
                                    class="block text-sm font-bold text-gray-700 mb-2">Password Saat Ini</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input id="current_password" name="current_password" type="password"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                        autocomplete="current-password">
                                </div>
                                @error('current_password') <span
                                class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password
                                        Baru</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input id="password" name="password" type="password"
                                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                            autocomplete="new-password">
                                    </div>
                                    @error('password') <span
                                    class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="password_confirmation"
                                        class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password
                                        Baru</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input id="password_confirmation" name="password_confirmation" type="password"
                                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                            autocomplete="new-password">
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-black focus:ring-4 focus:ring-gray-300 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>


            {{-- ====================================================================== --}}
            {{-- ============================ SCRIPTS ================================= --}}
            {{-- ====================================================================== --}}
            <script>
                // 1. Script untuk Dropdown Navbar Admin (Vanilla JS)
                const adminBtn = document.getElementById('adminUserBtn');
                const adminDropdown = document.getElementById('adminUserDropdown');
                if (adminBtn && adminDropdown) {
                    adminBtn.addEventListener('click', function (event) {
                        event.stopPropagation();
                        adminDropdown.classList.toggle('hidden');
                    });
                    document.addEventListener('click', function (event) {
                        if (!adminBtn.contains(event.target) && !adminDropdown.contains(event.target)) {
                            adminDropdown.classList.add('hidden');
                        }
                    });
                }

                // 2. Script Realtime Notifikasi (Untuk Konsumen)
                // Fungsi ini aman dibiarkan meski di halaman admin, karena hanya mencari elemen ID tertentu
                function checkNotifications() {
                    fetch('/api/cek-notifikasi')
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => {
                            // Update Badge Keranjang
                            updateBadge('badge-cart-desktop', data.keranjang);
                            updateBadge('badge-cart-mobile', data.keranjang);
                            // Update Badge Chat
                            updateBadge('badge-chat-mobile', data.chat);
                            // Update Hamburger Dot
                            const hamburgerBadge = document.getElementById('badge-hamburger');
                            if (hamburgerBadge) {
                                (data.keranjang > 0 || data.chat > 0) ? hamburgerBadge.classList.remove('hidden') : hamburgerBadge.classList.add('hidden');
                            }
                        })
                        .catch(error => { /* Silent fail */ });
                }

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

                // Jalankan cek notifikasi jika user adalah konsumen (cek elemen ada atau tidak)
                if (document.getElementById('badge-cart-desktop')) {
                    document.addEventListener('DOMContentLoaded', checkNotifications);
                    setInterval(checkNotifications, 3000);
                }
            </script>

</body>

</html>