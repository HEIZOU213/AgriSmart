@php
    $user = Auth::user();
    $is_logged_in = Auth::check();
    
    $is_admin = $is_logged_in && $user->role === 'admin';
    $is_petani = $is_logged_in && $user->role === 'petani';
    $is_konsumen = $is_logged_in && $user->role === 'konsumen';
@endphp

<nav id="main-navbar" class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                
                {{-- Logo --}}
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

                {{-- Menu Desktop (Tengah) --}}
                <div class="hidden space-x-6 sm:-my-px sm:ml-10 sm:flex items-center">
                    {{-- Semua user (kecuali Admin/Petani yang sedang kerja) bisa lihat menu belanja --}}
                    @if(!$is_admin && !$is_petani)
                        <a href="{{ route('produk.index') }}" class="text-sm font-semibold text-gray-500 hover:text-green-600 transition-colors {{ request()->routeIs('produk.index') ? 'text-green-600' : '' }}">Marketplace</a>
                        <a href="{{ route('edukasi.index') }}" class="text-sm font-semibold text-gray-500 hover:text-green-600 transition-colors {{ request()->routeIs('edukasi.index') ? 'text-green-600' : '' }}">Edukasi</a>
                    @endif

                    {{-- Jika Admin/Petani login, tampilkan tombol ke Dashboard mereka --}}
                    @auth
                        @if($is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-xs font-bold text-white bg-indigo-600 rounded-full hover:bg-indigo-700 transition shadow-md transform hover:-translate-y-0.5">Admin Panel</a>
                        @elseif($is_petani)
                            <a href="{{ route('petani.dashboard') }}" class="px-4 py-2 text-xs font-bold text-white bg-green-600 rounded-full hover:bg-green-700 transition shadow-md transform hover:-translate-y-0.5">Petani Dashboard</a>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Bagian Kanan: Keranjang & Profil --}}
            <div class="hidden sm:flex sm:items-center sm:ml-6 gap-4">
                
                {{-- Keranjang (Hanya untuk Konsumen/Tamu) --}}
                @if(!$is_admin && !$is_petani)
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-500 hover:text-green-600 transition-colors rounded-full hover:bg-green-50 group" title="Keranjang Belanja">
                        <svg class="h-6 w-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        {{-- Opsional: Badge jumlah item bisa ditambah di sini --}}
                    </a>
                @endif

                @auth
                    {{-- User Dropdown --}}
                    <div class="relative" x-data="{ dropdownOpen: false }">
                        <button id="navUserBtn" class="flex items-center gap-3 pl-1 pr-3 py-1 border border-gray-200 rounded-full hover:shadow-md bg-white transition focus:outline-none group">
                            @if($user->foto_profil)
                                <img class="h-9 w-9 rounded-full object-cover ring-2 ring-green-100 group-hover:ring-green-200 transition" src="{{ asset('storage/' . $user->foto_profil) }}" alt="{{ $user->name }}">
                            @else
                                <div class="h-9 w-9 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold ring-2 ring-green-50 transition">{{ substr($user->name, 0, 1) }}</div>
                            @endif
                            
                            <div class="text-left hidden lg:block">
                                <p class="text-xs font-bold text-gray-800">{{ $user->name }}</p>
                                <p class="text-[10px] font-bold text-green-600 uppercase tracking-wide">{{ $user->role }}</p>
                            </div>
                            
                            <svg id="arrowIcon" class="h-4 w-4 text-gray-400 group-hover:text-green-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        {{-- Dropdown Content --}}
                        <div id="navUserDropdown" class="hidden absolute right-0 top-14 w-60 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 origin-top-right">
                            
                            {{-- Info Akun --}}
                            <div class="px-5 py-3 border-b border-gray-50 mb-1 bg-gray-50/50">
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Akun Terdaftar</p>
                                <p class="text-sm font-bold text-gray-900 truncate" title="{{ $user->email }}">{{ $user->email }}</p>
                            </div>

                            {{-- [FITUR UTAMA KONSUMEN DIPINDAH KE SINI] --}}
                            @if($is_konsumen)
                                <a href="{{ route('konsumen.pesanan.index') }}" class="flex items-center gap-3 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 transition group">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    Riwayat Pesanan
                                </a>
                                <a href="{{ route('chat.index') }}" class="flex items-center gap-3 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 transition group">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                    Chat / Pesan
                                </a>
                            @endif

                            {{-- Menu Profil Umum --}}
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 transition group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profil Saya
                            </a>

                            <div class="border-t border-gray-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 w-full text-left px-5 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 rounded-b-xl transition group">
                                    <svg class="w-5 h-5 text-red-500 group-hover:text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-green-600 px-3 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 bg-green-600 text-white text-sm font-bold rounded-full hover:bg-green-700 shadow-md transition transform hover:-translate-y-0.5">Daftar</a>
                    </div>
                @endauth
            </div>

            {{-- Tombol Hamburger (Mobile) --}}
            <div class="-mr-2 flex items-center sm:hidden">
                <button id="mobileMenuBtn" class="p-2 rounded-lg text-gray-500 hover:text-green-600 hover:bg-green-50 transition focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu (Dropdown) --}}
    <div id="mobileMenu" class="hidden sm:hidden bg-white border-t border-gray-200 absolute w-full left-0 top-16 z-40 shadow-xl max-h-[80vh] overflow-y-auto">
        <div class="p-4 space-y-1">
            
            @if(!$is_admin && !$is_petani)
                <a href="{{ route('produk.index') }}" class="block px-4 py-3 text-base font-medium text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg">Marketplace</a>
                <a href="{{ route('edukasi.index') }}" class="block px-4 py-3 text-base font-medium text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg">Edukasi</a>
            @endif

            @auth
                <div class="border-t border-gray-100 pt-4 mt-2">
                    <div class="flex items-center px-4 mb-4 gap-3">
                         @if($user->foto_profil)
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $user->foto_profil) }}">
                        @else
                            <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold">{{ substr($user->name, 0, 1) }}</div>
                        @endif
                        <div>
                            <div class="font-bold text-gray-800">{{ $user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                        </div>
                    </div>

                    @if($is_konsumen)
                        <a href="{{ route('konsumen.pesanan.index') }}" class="block px-4 py-3 font-bold text-green-700 bg-green-50 rounded-lg mb-1">📦 Riwayat Pesanan</a>
                        <a href="{{ route('chat.index') }}" class="block px-4 py-3 font-bold text-green-700 bg-green-50 rounded-lg mb-1">💬 Chat / Pesan</a>
                    @endif

                    @if($is_admin)
                         <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 font-bold text-white bg-indigo-600 rounded-lg mb-1">Admin Panel</a>
                    @elseif($is_petani)
                         <a href="{{ route('petani.dashboard') }}" class="block px-4 py-3 font-bold text-white bg-green-600 rounded-lg mb-1">Dashboard Petani</a>
                    @endif
                    
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg">Profil Saya</a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-3 text-red-600 font-bold hover:bg-red-50 rounded-lg">Keluar</button>
                    </form>
                </div>
            @else
                <div class="border-t border-gray-100 pt-4 mt-2 grid grid-cols-2 gap-3">
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2.5 border-2 border-gray-200 text-gray-700 font-bold rounded-xl">Masuk</a>
                    <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2.5 bg-green-600 text-white font-bold rounded-xl shadow-lg">Daftar</a>
                </div>
            @endauth
        </div>
    </div>
</nav>

{{-- SCRIPT JS MANUAL --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Toggle Dropdown Desktop
        const userBtn = document.getElementById('navUserBtn');
        const userDropdown = document.getElementById('navUserDropdown');
        const arrowIcon = document.getElementById('arrowIcon');

        if(userBtn && userDropdown) {
            userBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdown.classList.toggle('hidden');
                if(arrowIcon) arrowIcon.classList.toggle('rotate-180');
            });
            document.addEventListener('click', (e) => {
                if (!userBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.add('hidden');
                    if(arrowIcon) arrowIcon.classList.remove('rotate-180');
                }
            });
        }

        // 2. Toggle Mobile Menu
        const mobileBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        if(mobileBtn && mobileMenu) {
            mobileBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    });
</script>