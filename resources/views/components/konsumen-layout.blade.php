<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AgriSmart') }} - Konsumen</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="font-sans antialiased bg-gray-50 text-slate-800">

    {{-- Navbar terpadu (role konsumen) --}}
    <x-app-navbar role="konsumen" :cart-count="$cartCount ?? 0" />

    {{-- MAIN CONTENT --}}
    <main class="pt-20 lg:pt-24 min-h-screen">
        {{ $slot }}
    </main>

    {{-- Realtime: update badge keranjang & chat --}}
    <script>
        function checkNotifications() {
            fetch('/api/cek-notifikasi')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    updateBadge('badge-cart-desktop', data.keranjang);
                    updateBadge('badge-chat-desktop', data.chat);
                    updateBadge('badge-cart-mobile', data.keranjang);
                    updateBadge('badge-chat-mobile', data.chat);

                    const hamburgerBadge = document.getElementById('badge-hamburger');
                    if (hamburgerBadge) {
                        hamburgerBadge.classList.toggle('hidden', !(data.keranjang > 0 || data.chat > 0));
                    }
                })
                .catch(error => console.error('Error checking notifications:', error));
        }

        function updateBadge(id, count) {
            const el = document.getElementById(id);
            if (el) {
                if (count > 0) { el.innerText = count; el.classList.remove('hidden'); }
                else { el.classList.add('hidden'); }
            }
        }

        document.addEventListener('DOMContentLoaded', checkNotifications);
        setInterval(checkNotifications, 3000);
    </script>

</body>
</html>

