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
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    
    {{-- 1. NAVIGASI ATAS --}}
    @include('layouts.navigation')

    {{-- WRAPPER UTAMA (TANPA SIDEBAR) --}}
    {{-- pt-24 agar konten turun ke bawah navbar fixed --}}
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header Halaman (Opsional) --}}
            @if (isset($header))
                <header class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ $header }}
                    </h2>
                </header>
            @endif

            {{-- Slot Konten --}}
            {{ $slot }}
        </div>
    </div>

</body>
</html>