<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AgriSmart Petani') }}</title>

    {{-- FONT --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- SCRIPT (CDN Tailwind) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    
    {{-- 1. NAVIGASI ATAS (Memuat Foto Profil dari layouts/navigation.blade.php) --}}
    @include('layouts.navigation')

    {{-- WRAPPER UTAMA (pt-20 agar tidak tertutup navbar) --}}
    <div class="pt-20">

        {{-- 2. HEADER HALAMAN --}}
        @if (isset($header))
            <header class="bg-white shadow relative z-10">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        {{-- 3. KONTEN UTAMA + SIDEBAR --}}
        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="flex flex-col md:flex-row gap-6">
                                
                                {{-- SIDEBAR MENU PETANI --}}
                                <div class="w-full md:w-1/4 md:pr-6 md:border-r border-gray-200">
                                    <h3 class="text-lg font-bold text-gray-800 mb-4 px-2">Menu Petani</h3>
                                    
                                    <ul class="space-y-1">
                                        {{-- Dashboard --}}
                                        <li>
                                            <a href="{{ route('petani.dashboard') }}" 
                                               class="block px-3 py-2 rounded-md transition-colors {{ request()->routeIs('petani.dashboard') ? 'bg-green-50 text-green-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                                Dashboard
                                            </a>
                                        </li>

                                        {{-- Kelola Produk --}}
                                        <li>
                                            <a href="{{ route('petani.produk.index') }}" 
                                               class="block px-3 py-2 rounded-md transition-colors {{ request()->routeIs('petani.produk.*') ? 'bg-green-50 text-green-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                                Kelola Produk Saya
                                            </a>
                                        </li>

                                        {{-- Pesanan Masuk --}}
                                        <li>
                                            <a href="{{ route('petani.pesanan.index') }}" 
                                               class="block px-3 py-2 rounded-md transition-colors {{ request()->routeIs('petani.pesanan.*') ? 'bg-green-50 text-green-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                                Pesanan Masuk
                                            </a>
                                        </li>
                                        
                                        {{-- Chat / Pesan --}}
                                        <li>
                                            <a href="{{ route('chat.index') }}" 
                                               class="block px-3 py-2 rounded-md transition-colors {{ request()->routeIs('chat.*') ? 'bg-green-50 text-green-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                                Chat / Pesan
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                
                                {{-- ISI KONTEN KANAN --}}
                                <div class="w-full md:w-3/4 md:pl-6">
                                    {{ $slot }}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    
    </div> {{-- End Wrapper --}}

</body>
</html>