<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AgriSmart') }}</title>

    {{-- FONT MODERN: Plus Jakarta Sans --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- TAILWIND & SCRIPTS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Animasi Fade In */
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.5s ease-out forwards;
        }

        /* Scrollbar Kustom */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #10B981;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #059669;
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen">

    {{-- NAVBAR TELAH DIHAPUS SEPENUHNYA --}}
    {{-- Tidak ada elemen <nav> sama sekali di sini --}}

        {{-- KONTEN HALAMAN (tanpa padding top karena tidak ada navbar fixed) --}}
        <main class="flex-1">
            {{ $slot }}
        </main>

        {{-- FOOTER (tetap dipertahankan agar layout konsisten) --}}
        <footer class="bg-gray-900 text-white py-12 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h4 class="text-xl font-black text-white mb-4">Agri<span class="text-green-500">Smart</span>
                        </h4>
                        <p class="text-gray-400 text-sm leading-relaxed">Platform digital terdepan untuk memajukan
                            pertanian Indonesia melalui teknologi dan edukasi.</p>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-white mb-4">Tautan</h4>
                        <ul class="space-y-2 text-gray-400 text-sm">
                            <li><a href="{{ route('produk.index') }}"
                                    class="hover:text-green-400 transition">Marketplace</a></li>
                            <li><a href="{{ route('edukasi.index') }}"
                                    class="hover:text-green-400 transition">Edukasi</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-white mb-4">Kontak</h4>
                        <ul class="space-y-2 text-gray-400 text-sm">
                            <li>support@agrismart.id</li>
                            <li>Jakarta, Indonesia</li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-500 text-xs">
                    © {{ date('Y') }} AgriSmart Indonesia. All rights reserved.
                </div>
            </div>
        </footer>

</body>

</html>