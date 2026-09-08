{{--
    PORTAL SELECTION LAYOUT
    Dipakai hanya di /portal — tanpa sidebar.
    Hanya ada navbar + content area.
--}}
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Portal' }} — {{ config('app.name', 'AgriSmart') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-green-50 text-slate-800 min-h-screen">

    {{-- Navbar tanpa sidebar --}}
    <x-app-navbar role="petani" />

    {{-- Main Content --}}
    <main class="pt-16 lg:pt-20 min-h-screen flex flex-col">
        <div class="flex-1">
            {{ $slot }}
        </div>
        <x-footer />
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ once: true, duration: 600 });</script>
    @stack('scripts')
</body>
</html>
