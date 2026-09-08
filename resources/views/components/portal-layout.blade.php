@props(['portalName' => '', 'menuItems' => [], 'pageTitle' => '', 'title' => ''])

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?: $pageTitle }} - {{ config('app.name', 'AgriSmart') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #16a34a; border-radius: 3px; }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-green-50 text-slate-800" x-data="{ sidebarOpen: false }">

    {{-- Navbar --}}
    <x-app-navbar role="petani" />

    <div class="flex h-screen pt-16 lg:pt-20 overflow-hidden">

        {{-- ===================== SIDEBAR DESKTOP ===================== --}}
        <aside class="hidden lg:flex flex-col w-64 bg-white border-r border-slate-200 flex-shrink-0 overflow-y-auto">
            <div class="flex flex-col h-full p-3 pt-5">

                {{-- Portal Badge --}}
                <div class="mb-4 px-3">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Portal Aktif</span>
                    <p class="text-sm font-bold text-green-700 mt-0.5 capitalize">{{ $portalName }}</p>
                </div>

                {{-- Menus --}}
                <nav class="flex-1 space-y-1">
                    @foreach($menuItems as $item)
                        @php
                            // Match active state (support wildcard match like 'portal.pembibitan.bibit.*')
                            $isActive = request()->routeIs($item['match'] ?? $item['route']);
                        @endphp
                        <a href="{{ route($item['route']) }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 font-semibold {{ $isActive ? 'bg-green-50 text-green-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <span class="text-base leading-none">{!! $item['icon'] !!}</span>
                            <span class="text-sm">{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </nav>

                {{-- Back to Portal Selection --}}
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <a href="{{ route('portal.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm font-bold text-slate-500 hover:text-slate-700 hover:bg-slate-50 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Portal
                    </a>
                </div>
            </div>
        </aside>

        {{-- ===================== SIDEBAR MOBILE (Drawer) ===================== --}}
        <div x-show="$store.sidebar?.open || sidebarOpen" class="lg:hidden relative z-50" x-cloak>
            {{-- Backdrop --}}
            <div x-show="$store.sidebar?.open || sidebarOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="if ($store.sidebar) $store.sidebar.open = false; sidebarOpen = false"></div>

            {{-- Panel --}}
            <aside x-show="$store.sidebar?.open || sidebarOpen"
                   x-transition:enter="transition ease-out duration-300"
                   x-transition:enter-start="-translate-x-full"
                   x-transition:enter-end="translate-x-0"
                   x-transition:leave="transition ease-in duration-200"
                   x-transition:leave-start="translate-x-0"
                   x-transition:leave-end="-translate-x-full"
                   class="fixed inset-y-0 left-0 w-72 bg-white shadow-2xl flex flex-col z-50">

                <div class="flex items-center justify-between p-4 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-green-100 text-green-700 flex items-center justify-center font-bold text-xl">P</span>
                        <span class="font-bold text-slate-800">{{ $portalName }}</span>
                    </div>
                    <button @click="if ($store.sidebar) $store.sidebar.open = false; sidebarOpen = false" class="p-2 text-slate-400 hover:bg-slate-100 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="flex flex-col h-full overflow-y-auto p-4">
                    <nav class="flex-1 space-y-2">
                        @foreach($menuItems as $item)
                            @php $isActive = request()->routeIs($item['match'] ?? $item['route']); @endphp
                            <a href="{{ route($item['route']) }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-semibold {{ $isActive ? 'bg-green-50 text-green-700' : 'text-slate-600 hover:bg-slate-50' }}">
                                <span class="text-base">{!! $item['icon'] !!}</span>
                                <span class="text-sm">{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </nav>

                    <div class="mt-6 pt-6 border-t border-slate-100">
                        <a href="{{ route('portal.index') }}" class="flex items-center gap-2 px-4 py-3 text-sm font-bold text-slate-500 hover:bg-slate-50 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali ke Portal
                        </a>
                    </div>
                </div>
            </aside>
        </div>

        {{-- ===================== MAIN CONTENT ===================== --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Page Header --}}
            <header class="bg-white border-b border-green-100 px-4 lg:px-6 py-4 flex items-center justify-between gap-4 flex-shrink-0">
                <div class="flex-1">
                    <h1 class="text-lg font-bold text-slate-900">{{ $pageTitle }}</h1>
                    <p class="text-xs text-slate-400 mt-0.5">{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>

                @isset($headerActions)
                    <div class="flex items-center gap-2">{{ $headerActions }}</div>
                @endisset
            </header>

            {{-- Scrollable Content --}}
            <main class="flex-1 overflow-y-auto flex flex-col bg-green-50/50">
                <div class="p-4 lg:p-6 flex-1">
                    {{ $slot }}
                </div>
                {{-- Footer di bagian bawah kontainer utama --}}
                <div class="mt-auto">
                    <x-footer />
                </div>
            </main>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ once: true, duration: 500 });</script>
    @stack('scripts')

</body>
</html>
