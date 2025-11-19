<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'AgriSmart') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900">
        <div class="min-h-screen bg-gray-100">
            
            {{-- Navigasi Publik --}}
            <nav class="bg-white shadow-sm border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        
                        {{-- Logo --}}
                        <div class="flex">
                            <div class="shrink-0 flex items-center">
                                <a href="{{ route('homepage') }}">
                                    <span class="font-bold text-lg text-green-600">AgriSmart</span>
                                </a>
                            </div>
                        </div>

                        {{-- Menu Navigasi Kanan --}}
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            @if (Route::has('login'))
                                <div class="space-x-4 flex items-center">
                                    @auth
                                        {{-- [LOGIKA BARU] Tautan Berdasarkan Role --}}
                                        @if(Auth::user()->role === 'konsumen')
                                            {{-- Jika Konsumen: Tampilkan Link ke Riwayat Pesanan --}}
                                            <a href="{{ route('konsumen.pesanan.index') }}" class="text-sm font-medium text-gray-700 hover:text-green-600 transition">
                                                Riwayat Pesanan
                                            </a>
                                            <span class="text-gray-300">|</span>
                                            {{-- Tambahkan tombol Logout kecil --}}
                                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">
                                                    Log Out
                                                </button>
                                            </form>
                                        @else
                                            {{-- Jika Admin/Petani: Tampilkan Link ke Dashboard --}}
                                            <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">
                                                Dashboard
                                            </a>
                                        @endif
                                    @else
                                        {{-- Jika Belum Login --}}
                                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">Log in</a>

                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="ml-4 px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700 transition">Register</a>
                                        @endif
                                    @endauth
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </nav>

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>