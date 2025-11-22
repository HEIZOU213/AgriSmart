@php
    // [FIX] Definisi Variabel Global di Paling Atas
    $user = Auth::user();
    $is_logged_in = Auth::check();
    
    $is_admin = $is_logged_in && $user->role === 'admin';
    $is_petani = $is_logged_in && $user->role === 'petani';
    $is_konsumen = $is_logged_in && $user->role === 'konsumen';
@endphp

<nav x-data="{ open: false }" class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('homepage') }}" class="flex items-center gap-2 group">
                        <div class="bg-green-600 p-1.5 rounded-lg shadow-md shadow-green-600/20 group-hover:shadow-lg transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                        <span class="font-bold text-xl tracking-tight text-gray-900">Agri<span class="text-green-600">Smart</span></span>
                    </a>
                </div>

                <div class="hidden space-x-6 sm:-my-px sm:ml-10 sm:flex items-center">
                    
<x-nav-link :href="route('chat.index')" :active="request()->routeIs('chat.*')" class="text-sm font-semibold hover:text-green-600 transition-colors flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        {{ __('Pesan') }}
                    </x-nav-link>

                    {{-- 1. Marketplace & Edukasi --}}
                    @unless ($is_admin)
                        <x-nav-link :href="route('produk.index')" :active="request()->routeIs('produk.index')" class="text-sm font-semibold hover:text-green-600 transition-colors">
                            {{ __('Marketplace') }}
                        </x-nav-link>
                        
                        <x-nav-link :href="route('edukasi.index')" :active="request()->routeIs('edukasi.index')" class="text-sm font-semibold hover:text-green-600 transition-colors">
                            {{ __('Edukasi') }}
                        </x-nav-link>
                    @endunless

                    {{-- 2. Keranjang (Hanya untuk Konsumen) --}}
                    @if ($is_konsumen)
                        <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-500 hover:text-green-600 transition-colors rounded-full hover:bg-green-50 {{ request()->routeIs('cart.index') ? 'text-green-600 bg-green-50' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </a>
                    @endif
                    
                    {{-- 3. Link Dashboard --}}
                    @auth
                        @if($is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-xs font-bold text-white bg-indigo-600 rounded-full shadow-md hover:bg-indigo-700 transition-transform transform hover:-translate-y-0.5">
                                {{ __('Admin Panel') }}
                            </a>
                        @elseif($is_petani)
                            <a href="{{ route('petani.dashboard') }}" class="px-4 py-2 text-xs font-bold text-white bg-green-600 rounded-full shadow-md hover:bg-green-700 transition-transform transform hover:-translate-y-0.5">
                                {{ __('Petani Dashboard') }}
                            </a>
                        @elseif($is_konsumen)
                            <x-nav-link :href="route('konsumen.pesanan.index')" :active="request()->routeIs('konsumen.pesanan.*')" class="text-sm font-semibold hover:text-green-600 transition-colors">
                                {{ __('Riwayat Pesanan') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-3 pl-3 pr-4 py-2 border border-gray-200 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:text-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 shadow-sm">
                            <div class="flex items-center">
                                @if($is_logged_in && $user->foto_profil)
                                    <img class="h-8 w-8 rounded-full object-cover ring-2 ring-green-500" src="{{ asset('storage/' . $user->foto_profil) }}" alt="{{ $user->name }}">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold ring-2 ring-green-500">
                                        {{ $is_logged_in ? substr($user->name, 0, 1) : 'T' }}
                                    </div>
                                @endif
                                <span class="ml-2 hidden md:block">{{ $is_logged_in ? $user->name : 'Tamu' }}</span>
                            </div>
                            <svg class="fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if($is_logged_in)
                            @if(!$is_konsumen)
                                <x-dropdown-link :href="route('dashboard')" class="hover:bg-gray-50">
                                    {{ __('Dashboard') }}
                                </x-dropdown-link>
                            @endif

                            <x-dropdown-link :href="route('profile.edit')" class="hover:bg-gray-50">
                                {{ __('Profil Saya') }}
                            </x-dropdown-link>

                            @if($is_konsumen)
                                <x-dropdown-link :href="route('konsumen.pesanan.index')" class="hover:bg-gray-50">
                                    {{ __('Pesanan Saya') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" class="text-red-600 hover:bg-red-50"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Keluar') }}
                                </x-dropdown-link>
                            </form>
                        @else
                            <x-dropdown-link :href="route('login')">
                                {{ __('Masuk') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('register')">
                                {{ __('Daftar') }}
                            </x-dropdown-link>
                        @endif
                    </x-slot>
                </x-dropdown>
            </div>
            
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-green-600 hover:bg-green-50 focus:outline-none focus:bg-green-50 focus:text-green-600 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100 shadow-lg">
        <div class="pt-2 pb-3 space-y-1 px-2">
             {{-- Mobile Links --}}
             @unless ($is_admin)
                <x-responsive-nav-link :href="route('produk.index')" :active="request()->routeIs('produk.index')" class="rounded-md hover:bg-green-50 hover:text-green-700">
                    {{ __('Marketplace') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('edukasi.index')" :active="request()->routeIs('edukasi.index')" class="rounded-md hover:bg-green-50 hover:text-green-700">
                    {{ __('Edukasi') }}
                </x-responsive-nav-link>
            @endunless

            {{-- [FIX] Variabel $is_konsumen sekarang sudah didefinisikan di atas --}}
            @if ($is_konsumen)
                <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')" class="rounded-md hover:bg-green-50 hover:text-green-700">
                    {{ __('Keranjang') }}
                </x-responsive-nav-link>
            @endif

            @if($is_admin)
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-indigo-600 font-bold bg-indigo-50">
                    {{ __('Admin Panel') }}
                </x-responsive-nav-link>
            @elseif($is_petani)
                <x-responsive-nav-link :href="route('petani.dashboard')" :active="request()->routeIs('petani.dashboard')" class="text-green-600 font-bold bg-green-50">
                    {{ __('Petani Dashboard') }}
                </x-responsive-nav-link>
            @elseif($is_konsumen)
                <x-responsive-nav-link :href="route('konsumen.pesanan.index')" :active="request()->routeIs('konsumen.pesanan.*')" class="rounded-md hover:bg-green-50 hover:text-green-700">
                    {{ __('Riwayat Pesanan') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 bg-gray-50">
            <div class="px-4 flex items-center">
                <div class="shrink-0 mr-3">
                    @if($is_logged_in && $user->foto_profil)
                        <img class="h-10 w-10 rounded-full object-cover ring-2 ring-white" src="{{ asset('storage/' . $user->foto_profil) }}" alt="{{ $user->name }}">
                    @else
                        <div class="h-10 w-10 rounded-full bg-green-200 flex items-center justify-center text-green-700 font-bold ring-2 ring-white">
                            {{ $is_logged_in ? substr($user->name, 0, 1) : 'T' }}
                        </div>
                    @endif
                </div>
                <div>
                    <div class="font-bold text-base text-gray-800">{{ $is_logged_in ? $user->name : 'Tamu' }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ $is_logged_in ? $user->email : '' }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-2">
                @if($is_logged_in)
                    <x-responsive-nav-link :href="route('profile.edit')" class="rounded-md hover:bg-gray-200">
                        {{ __('Profil Saya') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" class="text-red-600 hover:bg-red-50 rounded-md"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Keluar') }}
                        </x-responsive-nav-link>
                    </form>
                @else
                     <x-responsive-nav-link :href="route('login')" class="rounded-md hover:bg-gray-200">
                        {{ __('Masuk') }}
                    </x-responsive-nav-link>
                @endif
            </div>
        </div>
    </div>
</nav>