<nav id="main-navbar" class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                
                {{-- Logo --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('homepage') }}" class="flex items-center gap-2">
                        <div class="bg-green-600 p-1.5 rounded-lg shadow-md shadow-green-600/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                        <span class="font-bold text-xl tracking-tight text-gray-900">Agri<span class="text-green-600">Smart</span></span>
                    </a>
                </div>

                {{-- Menu Desktop --}}
                <div class="hidden space-x-6 sm:-my-px sm:ml-10 sm:flex items-center">
                    @php
                        $user = Auth::user();
                        $is_logged_in = Auth::check();
                        $is_admin = $is_logged_in && $user->role === 'admin';
                        $is_petani = $is_logged_in && $user->role === 'petani';
                        $is_konsumen = $is_logged_in && $user->role === 'konsumen';
                    @endphp

                    @unless ($is_admin)
                        <a href="{{ route('produk.index') }}" class="text-sm font-semibold text-gray-500 hover:text-green-600 transition-colors {{ request()->routeIs('produk.index') ? 'text-green-600' : '' }}">Marketplace</a>
                        <a href="{{ route('edukasi.index') }}" class="text-sm font-semibold text-gray-500 hover:text-green-600 transition-colors {{ request()->routeIs('edukasi.index') ? 'text-green-600' : '' }}">Edukasi</a>
                    @endunless

                    @if ($is_konsumen)
                        <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-500 hover:text-green-600 transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        </a>
                    @endif

                    @if(!$is_admin)
                        <a href="{{ route('chat.index') }}" class="flex items-center gap-1 text-sm font-semibold text-gray-500 hover:text-green-600 transition-colors {{ request()->routeIs('chat.*') ? 'text-green-600' : '' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                            Pesan
                        </a>
                    @endif
                    
                    @auth
                        @if($is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-xs font-bold text-white bg-indigo-600 rounded-full hover:bg-indigo-700 transition">Admin Panel</a>
                        @elseif($is_petani)
                            <a href="{{ route('petani.dashboard') }}" class="px-4 py-2 text-xs font-bold text-white bg-green-600 rounded-full hover:bg-green-700 transition">Petani Dashboard</a>
                        @elseif($is_konsumen)
                            <a href="{{ route('konsumen.pesanan.index') }}" class="text-sm font-semibold text-gray-500 hover:text-green-600 transition-colors {{ request()->routeIs('konsumen.pesanan.*') ? 'text-green-600' : '' }}">Riwayat Pesanan</a>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- User Menu Dropdown (Desktop) --}}
            <div class="hidden sm:flex sm:items-center sm:ml-6 relative">
                <button id="navUserBtn" class="flex items-center gap-3 pl-1 pr-3 py-1 border border-gray-200 rounded-full hover:shadow-md bg-white transition">
                    @if($is_logged_in && $user->foto_profil)
                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . $user->foto_profil) }}" alt="{{ $user->name }}">
                    @else
                        <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold">{{ $is_logged_in ? substr($user->name, 0, 1) : 'T' }}</div>
                    @endif
                    <span class="ml-2 text-sm font-medium text-gray-700">{{ $is_logged_in ? $user->name : 'Tamu' }}</span>
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                {{-- Dropdown Content --}}
                <div id="navUserDropdown" class="hidden absolute right-0 top-12 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-1 z-50">
                    @if($is_logged_in)
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profil Saya</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Masuk</a>
                        <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Daftar</a>
                    @endif
                </div>
            </div>

            {{-- Hamburger Mobile --}}
            <div class="-mr-2 flex items-center sm:hidden">
                <button id="mobileMenuBtn" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobileMenu" class="hidden sm:hidden bg-white border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1 px-4">
            @unless ($is_admin)
                <a href="{{ route('produk.index') }}" class="block py-2 text-base font-medium text-gray-600 hover:text-green-600">Marketplace</a>
                <a href="{{ route('edukasi.index') }}" class="block py-2 text-base font-medium text-gray-600 hover:text-green-600">Edukasi</a>
            @endunless
            
            @if($is_logged_in)
                <a href="{{ route('profile.edit') }}" class="block py-2 text-base font-medium text-gray-600 hover:text-green-600">Profil Saya</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left py-2 text-base font-medium text-red-600">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block py-2 text-base font-medium text-gray-600">Masuk</a>
            @endif
        </div>
    </div>
</nav>

{{-- SCRIPT JS MANUAL (PENTING) --}}
<script>
    // Desktop Dropdown
    const userBtn = document.getElementById('navUserBtn');
    const userDropdown = document.getElementById('navUserDropdown');

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

    // Mobile Menu
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    if(mobileBtn && mobileMenu) {
        mobileBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }
</script>