<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Area Konsumen') }}</title>

    {{-- FONT --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- SCRIPT --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    
    {{-- 1. NAVIGASI ATAS --}}
    @include('layouts.navigation')

    {{-- WRAPPER UTAMA --}}
    <div class="pt-20 flex h-screen overflow-hidden">

        {{-- 2. SIDEBAR KIRI (FIXED) --}}
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:block overflow-y-auto flex-shrink-0">
            <div class="p-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Menu Konsumen</h3>
                
                <nav class="space-y-1">
                    {{-- Riwayat Pesanan --}}
                    <a href="{{ route('konsumen.pesanan.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('konsumen.pesanan.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('konsumen.pesanan.*') ? 'text-green-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Riwayat Pesanan
                    </a>

                    {{-- Chat / Pesan --}}
                    <a href="{{ route('chat.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('chat.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('chat.*') ? 'text-green-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        Pesan / Chat
                    </a>

                    {{-- Edit Profil --}}
                    <a href="{{ route('profile.edit') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('profile.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('profile.*') ? 'text-green-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profil Saya
                    </a>

                    <div class="my-4 border-t border-gray-100"></div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 px-2">Belanja</h3>

                    {{-- Ke Marketplace --}}
                    <a href="{{ route('produk.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Lanjut Belanja
                    </a>
                </nav>
            </div>
        </aside>

        {{-- 3. KONTEN UTAMA (SCROLLABLE) --}}
        <div class="flex-1 overflow-y-auto bg-gray-50 p-8">
            @if (isset($header))
                <header class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ $header }}
                    </h2>
                </header>
            @endif

            {{ $slot }}
        </div>
    
    </div>
</body>
</html>