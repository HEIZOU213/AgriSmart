{{-- ================================================================
     NAVBAR TERPADU — Satu komponen untuk semua role.
     Gaya mengikuti konsumen: logo besar, avatar circular, dropdown w-72.
     Prop:
       - role      : 'konsumen' | 'admin' | 'petani'  (auto-detect jika null)
       - cartCount : integer, hanya dipakai role konsumen
     ================================================================ --}}
@props(['role' => null, 'cartCount' => 0, 'hasSidebar' => null])

@php
    // ── Deteksi role ────────────────────────────────────────────────
    $user = Auth::user();
    if (is_null($role)) {
        $role = $user?->role ?? 'user';
    }
    $isAdmin    = $role === 'admin';
    $isPetani   = in_array($role, ['pekebun', 'petani']);
    $isKonsumen = !$isAdmin && !$isPetani;
    if (is_null($hasSidebar)) {
        $hasSidebar = ($isAdmin || $isPetani) && !request()->routeIs('portal.index'); // punya sidebar → hamburger di kiri
    }

    // ── Href logo ───────────────────────────────────────────────────
    $logoHref = match(true) {
        $isAdmin  => route('admin.dashboard'),
        $isPetani => route('portal.index'),
        default   => '/',
    };

    // ── Label role (untuk badge tengah & dropdown) ───────────────────
    $roleLabel = match(true) {
        $isAdmin  => 'Administrator',
        $isPetani => 'Pekebun',
        default   => 'Konsumen',
    };

    // ── Foto profil (Google vs lokal) ────────────────────────────────
    $navbarPhotoUrl = null;
    $userInitials   = 'U';
    if ($user) {
        $userInitials = strtoupper(substr($user->name, 0, 1));
        if ($user->foto_profil) {
            if (!preg_match('#^https?://#i', $user->foto_profil)) {
                $navbarPhotoUrl = asset('storage/' . $user->foto_profil);
            } else {
                $clean          = preg_replace('/\?sz=\d+$/', '', $user->foto_profil);
                $navbarPhotoUrl = preg_replace('/=s\d+-c$/', '=s0-c', $clean);
            }
        }
    }
@endphp

{{-- Init Alpine store untuk sidebar (admin / pekebun durian) --}}
@if($hasSidebar)
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('sidebar', { open: false });
    });
</script>
@endif

{{-- ================================================================
     NAV UTAMA
     Gaya scroll-aware sama persis dengan konsumen.
     ================================================================ --}}
<nav x-data="{ mobileOpen: false, scrolled: false, dropdownOpen: false }"
     @scroll.window.throttle.20ms="scrolled = window.scrollY > 20"
     :class="scrolled ? 'bg-white shadow-md border-b border-green-100' : 'bg-white border-b border-transparent'"
     class="fixed inset-x-0 top-0 z-50 w-full transition-all duration-500">

    <div class="{{ $isKonsumen ? 'max-w-7xl mx-auto' : '' }} px-4 sm:px-6 lg:px-8 transition-all duration-300">
        <div class="flex items-center justify-between h-16 lg:h-20">

            {{-- ════════════════ KIRI: Logo (+ Hamburger untuk sidebar) ════════════════ --}}
            <div class="flex-1 flex justify-start items-center gap-3 py-2">

                @if($hasSidebar)
                {{-- Hamburger di KIRI karena sidebar slide dari kiri --}}
                <button @click="$store.sidebar.open = !$store.sidebar.open"
                        class="lg:hidden relative p-2 text-slate-600 hover:text-green-700 transition-colors">
                    {{-- Badge notif --}}
                    <span id="badge-hamburger"
                          class="hidden absolute top-2 right-2 h-2.5 w-2.5 rounded-full bg-red-600 ring-2 ring-white"></span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                @endif

                {{-- Logo --}}
                <a href="{{ $logoHref }}" class="flex items-center gap-2 group shrink-0">
                    <img src="{{ asset('images/nav-logo.png') }}" alt="AgriSmart Logo"
                         class="h-10 sm:h-14 lg:h-16 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                </a>

                {{-- Label Panel — hanya admin/petani, di samping logo --}}
                @if($hasSidebar)
                <div class="hidden lg:flex items-center gap-2.5 ml-1">
                    <span class="block w-0.5 h-7 rounded-full bg-gradient-to-b from-green-400 to-green-600"></span>
                    <div class="flex flex-col leading-none gap-0.5">
                        <span class="text-[10px] font-semibold text-green-600 uppercase tracking-[0.18em]">Panel</span>
                        <span class="text-lg font-bold text-slate-800 leading-none">{{ $isAdmin ? 'Admin' : 'Pekebun' }}</span>
                    </div>
                </div>
                @endif

            </div>

            {{-- ════════════════ TENGAH: Menu konsumen saja ════════════════ --}}
            @if($isKonsumen)
            <div class="hidden lg:flex flex-none items-center justify-center gap-6">
                {{-- ── Nav links Konsumen ── --}}
                <a href="{{ route('konsumen.pesanan.index') }}"
                   class="relative px-3 py-2 rounded-lg font-semibold transition-all duration-300 group overflow-hidden
                          {{ request()->routeIs('konsumen.pesanan.*') ? 'text-green-700' : 'text-slate-600 hover:text-green-700' }}">
                    <span class="relative flex items-center gap-2 text-sm lg:text-base whitespace-nowrap">
                        <svg class="w-4 h-4 {{ request()->routeIs('konsumen.pesanan.*') ? 'text-green-700' : 'opacity-70 group-hover:opacity-100' }} transition-opacity"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Pesanan Saya
                    </span>
                </a>

                <a href="{{ url('/chat') }}"
                   class="relative px-3 py-2 rounded-lg font-semibold transition-all duration-300 group
                          {{ request()->is('chat*') ? 'text-green-700' : 'text-slate-600 hover:text-green-700' }}">
                    <span class="relative flex items-center gap-2 text-sm lg:text-base whitespace-nowrap">
                        <svg class="w-4 h-4 opacity-70 group-hover:opacity-100 transition-opacity"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Pesan
                    </span>
                    {{-- Badge chat desktop --}}
                    <span id="badge-chat-desktop"
                          class="hidden absolute top-0 right-0 -mt-0.5 -mr-1 flex h-4 w-4 items-center justify-center
                                 rounded-full bg-red-600 text-[9px] font-bold text-white shadow-sm ring-1 ring-white">0</span>
                </a>
            </div>
            @endif

            {{-- ════════════════ KANAN: Keranjang + Avatar ════════════════ --}}
            <div class="flex-1 flex justify-end items-center gap-1.5 sm:gap-4">

                {{-- Keranjang — hanya konsumen --}}
                @if($isKonsumen)
                <a href="{{ route('cart.index') }}"
                   class="group relative p-1.5 sm:p-2 text-slate-600 hover:text-green-700 transition-colors flex items-center">
                    <svg class="w-6 h-6 transition-transform group-hover:scale-110"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    @if(isset($cartCount) && $cartCount > 0)
                    <span id="badge-cart-desktop"
                          class="absolute top-0 right-0 -mt-0.5 -mr-0.5 sm:-mt-1 sm:-mr-1 flex h-4 w-4 sm:h-5 sm:w-5 items-center justify-center rounded-full
                                 bg-red-600 text-[9px] sm:text-[10px] font-bold text-white shadow-md ring-2 ring-white
                                 transform transition-transform group-hover:scale-110">
                        {{ $cartCount }}
                    </span>
                    @endif
                </a>
                @endif

                @auth
                {{-- ── Avatar Dropdown (Mobile & Desktop Responsive) ── --}}
                <div class="relative" x-data="{ dropdownOpen: false }">

                    {{-- Tombol avatar circular (bebas garis biru di semua browser) --}}
                    <button type="button" @click="dropdownOpen = !dropdownOpen"
                            class="flex-shrink-0 w-9 h-9 sm:w-10 sm:h-10 rounded-full overflow-hidden
                                   border-2 border-slate-200 hover:border-green-500
                                   outline-none focus:outline-none focus:ring-0
                                   transition-all duration-300 hover:shadow-md hover:shadow-green-100/50 active:scale-95
                                   {{ $navbarPhotoUrl ? '' : 'bg-green-600 flex items-center justify-center' }}"
                            style="outline: none !important; -webkit-tap-highlight-color: transparent !important;">
                        @if($navbarPhotoUrl)
                            <img src="{{ $navbarPhotoUrl }}" alt="Foto Profil"
                                 class="w-full h-full object-cover block pointer-events-none">
                        @else
                            <span class="text-white font-bold text-sm sm:text-base leading-none select-none">{{ $userInitials }}</span>
                        @endif
                    </button>

                    {{-- Dropdown — responsive pada mobile (max-w-[calc(100vw-1.5rem)]) --}}
                    <div x-show="dropdownOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                         @click.away="dropdownOpen = false"
                         style="display:none"
                         class="absolute right-0 mt-3 w-72 max-w-[calc(100vw-1.5rem)] bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden z-50 dropdown-menu-responsive">

                        {{-- Header dropdown — foto + nama + email + badge role --}}
                        <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-green-50 bg-green-50/50">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0 w-11 h-11 rounded-full overflow-hidden shadow-sm
                                            {{ $navbarPhotoUrl ? '' : 'bg-green-600 flex items-center justify-center' }}">
                                    @if($navbarPhotoUrl)
                                        <img src="{{ $navbarPhotoUrl }}" alt="Profil"
                                             class="w-full h-full object-cover block">
                                    @else
                                        <span class="text-white font-bold text-base leading-none">{{ $userInitials }}</span>
                                    @endif
                                </div>
                                <div class="overflow-hidden">
                                    <h4 class="font-bold text-slate-800 text-sm truncate">{{ $user->name }}</h4>
                                    <p class="text-xs text-slate-500 truncate">{{ $user->email }}</p>
                                    <span class="inline-block mt-0.5 text-[10px] font-semibold text-green-700
                                                 bg-green-100 px-2 py-0.5 rounded-full">
                                        {{ $roleLabel }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Menu dropdown — disesuaikan per role --}}
                        <div class="p-2 space-y-1">

                            <a href="{{ route('profile.edit') }}"
                               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium
                                      text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all group">
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profil Saya
                            </a>

                            {{-- Link kontekstual — hanya konsumen --}}
                            @if($isKonsumen)
                                @if(request()->routeIs('konsumen.pesanan.*') || request()->is('chat*'))
                                <a href="/"
                                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium
                                          text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all group">
                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Beranda
                                </a>
                                @else
                                <a href="{{ route('konsumen.pesanan.index') }}"
                                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium
                                          text-slate-700 hover:text-green-700 hover:bg-green-50 transition-all group">
                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-green-600"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    Pesanan Saya
                                </a>
                                @endif
                            @endif

                            <div class="p-2 border-t border-green-50">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="flex items-center gap-3 w-full px-4 py-2.5 rounded-xl text-sm font-medium
                                                   text-red-600 hover:bg-red-50 transition-all group">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol hamburger mobile — konsumen: di KANAN (buka menu dropdown) --}}
                @if($isKonsumen)
                <button @click="mobileOpen = !mobileOpen"
                        class="lg:hidden p-1.5 sm:p-2 text-slate-700 hover:text-green-700 transition-colors relative">
                    <span id="badge-hamburger"
                          class="hidden absolute top-2 right-2 h-2.5 w-2.5 rounded-full bg-red-600 ring-2 ring-white"></span>
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileOpen" x-cloak stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                @endif
                @endauth
            </div>
        </div>
    </div>

    {{-- ════════════════ MOBILE MENU — hanya konsumen ════════════════
         Admin/petani pakai sidebar terpisah di layout masing-masing.
         ════════════════════════════════════════════════════════════ --}}
    @if($isKonsumen)
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         @click.away="mobileOpen = false"
         class="lg:hidden fixed inset-x-0 top-[64px] bg-white border-t border-green-100 shadow-xl z-40"
         style="display: none;">

        <div class="px-4 sm:px-6 py-6 space-y-2 max-h-[calc(100vh-5rem)] overflow-y-auto">

            <a href="{{ route('konsumen.pesanan.index') }}" @click="mobileOpen = false"
               class="flex items-center gap-4 py-3 px-4 text-base font-semibold rounded-xl transition-all
                      {{ request()->routeIs('konsumen.pesanan.*') ? 'text-green-700 bg-green-50' : 'text-slate-700 hover:text-green-700 hover:bg-green-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Pesanan Saya
            </a>

            <a href="{{ url('/chat') }}" @click="mobileOpen = false"
               class="flex items-center justify-between gap-4 py-3 px-4 text-base font-semibold rounded-xl transition-all
                      {{ request()->is('chat*') ? 'text-green-700 bg-green-50' : 'text-slate-700 hover:text-green-700 hover:bg-green-50' }}">
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Pesan / Chat
                </div>
                <span id="badge-chat-mobile"
                      class="hidden text-xs font-bold text-white bg-red-600 px-2 py-0.5 rounded-full">0</span>
            </a>

            <a href="{{ route('cart.index') }}" @click="mobileOpen = false"
               class="flex items-center justify-between gap-4 py-3 px-4 text-base font-semibold
                      text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all">
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Keranjang
                </div>
                @if(isset($cartCount) && $cartCount > 0)
                <span id="badge-cart-mobile"
                      class="text-xs font-bold text-white bg-red-600 px-2 py-0.5 rounded-full">{{ $cartCount }}</span>
                @endif
            </a>

            @auth
            <div class="pt-6 border-t border-green-100 space-y-2 mt-2">
                <a href="{{ route('profile.edit') }}" @click="mobileOpen = false"
                   class="flex items-center gap-3 py-3 px-4 text-base font-semibold
                          text-slate-700 hover:text-green-700 hover:bg-green-50 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profil Saya
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" @click="mobileOpen = false"
                            class="flex items-center gap-3 w-full py-3 px-4 text-base font-semibold
                                   text-red-600 hover:bg-red-50 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </div>
    @endif

</nav>


