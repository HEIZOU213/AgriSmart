<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AgriSmart') }} — Admin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>body{font-family:'Figtree',sans-serif;} [x-cloak]{display:none!important}</style>
</head>
<body class="font-sans antialiased bg-green-50 text-slate-800">

{{-- Navbar terpadu (role admin) --}}
<x-app-navbar role="admin" />

{{-- ================================================================
     LAYOUT: Sidebar kiri (desktop) + Mobile sidebar (Alpine store)
     + Konten utama
     ================================================================ --}}
<div class="pt-16 lg:pt-20 flex h-screen overflow-hidden">

    {{-- ─── SIDEBAR DESKTOP (navigasi saja, tanpa profil/logout) ─── --}}
    <aside class="hidden lg:flex flex-col w-60 bg-white border-r border-slate-200 flex-shrink-0 overflow-y-auto">
        <div class="p-3 pt-5">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-3">Navigasi</p>

            @php
                $adminNav = [
                    ['label'=>'Dashboard',        'route'=>'admin.dashboard',           'match'=>'admin.dashboard',        'icon'=>'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
                    ['label'=>'Kelola Akun',      'route'=>'admin.users.index',         'match'=>'admin.users.*',          'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['label'=>'Kelola Produk',    'route'=>'admin.products.index',      'match'=>'admin.products.*',       'icon'=>'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                    ['label'=>'Kelola Penarikan', 'route'=>'admin.withdraw.index',      'match'=>'admin.withdraw.*',       'icon'=>'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                    ['label'=>'Konten Edukasi',   'route'=>'admin.konten-edukasi.index','match'=>'admin.konten-edukasi.*', 'icon'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                    ['label'=>'Inbox Pesan',      'route'=>'admin.kontak.index',        'match'=>'admin.kontak.*',         'icon'=>'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                ];
            @endphp

            <nav class="space-y-0.5">
                @foreach($adminNav as $nav)
                    @php $active = request()->routeIs($nav['match']); @endphp
                    <a href="{{ route($nav['route']) }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                              {{ $active ? 'bg-green-50 text-green-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="flex-shrink-0 {{ $active ? 'text-green-600' : 'text-slate-400' }}"
                             style="width:1.125rem;height:1.125rem"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $nav['icon'] }}"/>
                        </svg>
                        {{ $nav['label'] }}
                    </a>
                @endforeach
            </nav>
        </div>
    </aside>

    {{-- ─── MOBILE SIDEBAR (Alpine store, dipicu navbar hamburger) ─── --}}
    {{-- Overlay --}}
    <div x-data x-show="$store.sidebar?.open"
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-150"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         @click="$store.sidebar.open = false"
         class="lg:hidden fixed inset-0 top-16 bg-black/40 z-40"
         style="display:none">
    </div>

    {{-- Panel sidebar --}}
    <div x-data x-show="$store.sidebar?.open"
         x-transition:enter="transition ease-out duration-250"
         x-transition:enter-start="-translate-x-full opacity-0"
         x-transition:enter-end="translate-x-0 opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0 opacity-100"
         x-transition:leave-end="-translate-x-full opacity-0"
         class="lg:hidden fixed top-16 left-0 bottom-0 w-64 bg-white border-r border-green-100 shadow-xl z-50 overflow-y-auto"
         style="display:none">

        <div class="p-3 pt-4">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-3">Navigasi</p>
            <nav class="space-y-0.5">
                @foreach($adminNav as $nav)
                    @php $active = request()->routeIs($nav['match']); @endphp
                    <a href="{{ route($nav['route']) }}" @click="$store.sidebar.open = false"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                              {{ $active ? 'bg-green-50 text-green-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="flex-shrink-0 {{ $active ? 'text-green-600' : 'text-slate-400' }}"
                             style="width:1.125rem;height:1.125rem"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $nav['icon'] }}"/>
                        </svg>
                        {{ $nav['label'] }}
                    </a>
                @endforeach
            </nav>

            {{-- Akun — hanya di mobile (desktop ada di dropdown navbar) --}}
            <div class="mt-4 pt-4 border-t border-slate-100 space-y-0.5">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-3">Akun</p>
                <a href="{{ route('profile.edit') }}" @click="$store.sidebar.open = false"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
                          text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                    <svg class="flex-shrink-0 text-slate-400" style="width:1.125rem;height:1.125rem"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profil Saya
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" @click="$store.sidebar.open = false"
                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
                                   text-red-600 hover:bg-red-50 transition-colors">
                        <svg class="flex-shrink-0" style="width:1.125rem;height:1.125rem"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ─── KONTEN UTAMA ─── --}}
    <div class="flex-1 overflow-y-auto bg-green-50/50">
        <div class="p-5 md:p-8">
            @if(isset($header))
                <h1 class="text-xl md:text-2xl font-bold text-slate-800 mb-6">{{ $header }}</h1>
            @endif
            {{ $slot }}
        </div>
    </div>

</div>

</body>
</html>

