{{-- 
  Ini adalah Layout Master untuk Halaman Publik (Tamu)
  Isinya: Navbar Publik, Konten (Slot), dan Footer
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'AgriSmart - Edukasi & Digital Marketing Pertanian' }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen">
            
            {{-- START: Navigasi Publik --}}
            <nav class="bg-white border-b border-gray-100 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        
                        {{-- Logo & Menu Kiri --}}
                        <div class="flex">
                            <div class="shrink-0 flex items-center">
                                <a href="{{ route('homepage') }}" class="font-bold text-xl text-green-600">
                                    AgriSmart
                                </a>
                            </div>
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <a href="{{ route('homepage') }}" 
                                   class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('homepage') ? 'border-indigo-500' : 'border-transparent hover:border-gray-300' }}">
                                    Home
                                </a>
                                <a href="{{ route('edukasi.index') }}" 
                                   class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('edukasi.*') ? 'border-indigo-500' : 'border-transparent hover:border-gray-300' }}">
                                    Edukasi
                                </a>
                                <a href="{{ route('produk.index') }}" 
                                   class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('produk.*') ? 'border-indigo-500' : 'border-transparent hover:border-gray-300' }}">
                                    Marketplace
                                </a>
                            </div>
                        </div>
                        
                        {{-- Menu Kanan (Login/Register atau Dashboard) --}}
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            @auth
                                {{-- Jika sudah login, tampilkan link Dashboard --}}
                                <a href="{{ url('/dashboard') }}" 
                                   class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">
                                   Dashboard
                                </a>
                            @else
                                {{-- Jika belum login, tampilkan Login & Register --}}
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-4 px-4 py-2 bg-gray-800 text-white rounded-md text-sm font-medium hover:bg-gray-700">Register</a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>
            {{-- END: Navigasi Publik --}}

            <main>
                {{-- Di sinilah konten (dari welcome.blade.php, dll) akan dimasukkan --}}
                {{ $slot }}
            </main>

            {{-- Footer --}}
            <footer class="bg-white border-t border-gray-200 mt-12">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center text-gray-500 text-sm">
                    &copy; {{ date('Y') }} AgriSmart. All rights reserved.
                </div>
            </footer>

        </div>
    </body>
</html>