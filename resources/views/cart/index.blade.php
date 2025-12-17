<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description"
        content="Keranjang Belanja AgriSmart - Lihat dan kelola produk dalam keranjang belanja Anda.">
    <meta name="keywords" content="Keranjang Belanja, AgriSmart, Marketplace Tani, Belanja Online">
    <meta property="og:title" content="{{ config('app.name', 'AgriSmart') }} - Keranjang Belanja">
    <meta property="og:description" content="Kelola produk dalam keranjang belanja Anda.">
    <meta property="og:image" content="{{ asset('images/logo2.png') }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>Keranjang Belanja - {{ config('app.name', 'AgriSmart') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f0fdf4;
        }

        ::-webkit-scrollbar-thumb {
            background: #16a34a;
            border-radius: 5px;
            border: 2px solid #f0fdf4;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #15803d;
        }

        /* Custom Animation Utilities */
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Blob Animation */
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</head>

<body
    class="font-sans antialiased text-slate-700 bg-green-50 flex flex-col min-h-screen selection:bg-green-500 selection:text-white">

    <x-navbar />

    <main class="flex-1">

        {{-- HERO SECTION --}}
        <section class="relative overflow-hidden pt-20 pb-12 lg:pt-28 lg:pb-16 bg-slate-50">
            {{-- Background Spin Tengah --}}
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="w-[600px] h-[600px] lg:w-[800px] lg:h-[800px] opacity-5">
                    <div class="w-full h-full animate-[spin_30s_linear_infinite]">
                        <img src="images/nav-logo.png" alt="Background Decorative" class="w-full h-full object-contain">
                    </div>
                </div>
            </div>

            {{-- Konten Utama --}}
            <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
                <div class="text-center" data-aos="fade-up">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-slate-900 mb-6">
                        Keranjang
                        <span class="text-green-600">
                            Belanja Anda
                        </span>
                    </h2>
                    <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                        Kelola dan periksa produk dalam keranjang belanja Anda sebelum melanjutkan ke pembayaran
                    </p>
                </div>
            </div>
        </section>

        {{-- CART CONTENT SECTION --}}
        <section class="py-16 lg:py-24 relative bg-white overflow-hidden">

            {{-- Modern Background Decorations --}}
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                {{-- Clean Gradient Meshes --}}
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-gradient-to-br from-gray-50/20 via-gray-50/10 to-transparent rounded-full blur-3xl">
                </div>
                <div
                    class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-gradient-to-tl from-gray-50/15 to-transparent rounded-full blur-3xl translate-x-1/3 translate-y-1/3">
                </div>

                {{-- Floating Elements --}}
                <div class="absolute top-20 right-[10%] w-32 h-32 border border-gray-100/20 rounded-full"></div>
                <div class="absolute bottom-32 left-[8%] w-24 h-24 border border-gray-100/20 rounded-full"></div>

                {{-- Subtle Pattern --}}
                <div class="absolute inset-0 opacity-[0.015]"
                    style="background-image: radial-gradient(circle at 1px 1px, rgb(209 213 219) 1px, transparent 0); background-size: 40px 40px;">
                </div>
            </div>

            {{-- Main Content Container --}}
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 relative z-10">
                @if (session('success'))
                    <div
                        class="mb-6 px-4 py-3 bg-green-50 text-green-700 text-sm rounded-lg border border-green-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div
                        class="mb-6 px-4 py-3 bg-red-50 text-red-700 text-sm rounded-lg border border-red-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden" data-aos="fade-up"
                    data-aos-delay="100">
                    @if(count($cart) > 0)
                        <form action="{{ route('checkout.index') }}" method="GET" id="checkoutForm">
                            {{-- Jika checkout menggunakan POST, ganti method="POST" dan tambahkan @csrf --}}

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-100">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-4 text-left w-10">
                                                <input type="checkbox" id="checkAll"
                                                    class="rounded border-gray-300 text-green-600 focus:ring-green-500 w-5 h-5 cursor-pointer">
                                            </th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Produk</th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Harga</th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Jumlah</th>
                                            <th
                                                class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Subtotal</th>
                                            <th
                                                class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($cart as $id => $detail)
                                            @php $subtotal = $detail['harga'] * $detail['jumlah']; @endphp
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4">
                                                    <input type="checkbox" name="selected_products[]" value="{{ $id }}"
                                                        data-subtotal="{{ $subtotal }}"
                                                        class="product-checkbox rounded border-gray-300 text-green-600 focus:ring-green-500 w-5 h-5 cursor-pointer">
                                                </td>

                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-4">
                                                        <div
                                                            class="h-16 w-16 flex-shrink-0 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden">
                                                            @if(isset($detail['foto']) && $detail['foto'])
                                                                <img class="h-full w-full object-cover"
                                                                    src="{{ \Illuminate\Support\Facades\Storage::url($detail['foto']) }}"
                                                                    alt="{{ $detail['nama'] }}">
                                                            @else
                                                                <div class="flex items-center justify-center h-full text-gray-400">
                                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="1.5"
                                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <div class="font-medium text-gray-900">{{ $detail['nama'] }}</div>
                                                            @if(isset($detail['satuan']))
                                                                <div class="text-xs text-gray-500">{{ $detail['satuan'] }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="px-6 py-4 text-sm text-gray-600">
                                                    Rp {{ number_format($detail['harga'], 0, ',', '.') }}
                                                </td>

                                                <td class="px-6 py-4">
                                                    {{-- Note: Form ini harus di luar form checkout utama jika menggunakan HTML
                                                    standar,
                                                    namun karena nesting form dilarang, kita gunakan 'form' attribute atau JS.
                                                    Solusi simple: Gunakan JS atau endpoint terpisah.
                                                    Di sini saya gunakan form terpisah per baris tapi hati-hati nesting.
                                                    UNTUK KEAMANAN HTML: Update quantity sebaiknya via AJAX atau tombol di luar
                                                    form checkout.
                                                    Di bawah ini adalah solusi visual, pastikan logika backend update terpisah.
                                                    --}}
                                                    <div class="flex items-center gap-2">
                                                        <input type="number" form="update-form-{{ $id }}" name="jumlah"
                                                            value="{{ $detail['jumlah'] }}" min="1"
                                                            class="w-16 px-2 py-1.5 text-sm border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 text-center">

                                                        <button type="submit" form="update-form-{{ $id }}"
                                                            class="text-green-600 hover:text-green-800 text-xs font-medium">
                                                            Update
                                                        </button>
                                                    </div>
                                                </td>

                                                <td class="px-6 py-4 text-right text-sm font-bold text-gray-900">
                                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                                </td>

                                                <td class="px-6 py-4 text-center">
                                                    <button type="submit" form="delete-form-{{ $id }}"
                                                        class="text-gray-400 hover:text-red-600 transition-colors"
                                                        onclick="return confirm('Hapus item ini?')">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div
                                class="px-6 py-6 bg-gray-50 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                                <div class="flex flex-col md:flex-row items-center gap-2 md:gap-6">
                                    <span class="text-sm text-gray-500">Total Dipilih: <span id="selectedCount"
                                            class="font-medium text-gray-900">0</span> item</span>
                                    <div class="text-xl md:text-2xl font-bold text-gray-900">
                                        Total: <span class="text-green-600" id="displayTotal">Rp 0</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 w-full md:w-auto">
                                    <a href="{{ route('produk.index') }}"
                                        class="flex-1 md:flex-none px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-white hover:border-green-600 hover:text-green-600 transition-all text-sm text-center">
                                        Belanja Lagi
                                    </a>
                                    <button type="submit" id="btnCheckout" disabled
                                        class="flex-1 md:flex-none px-6 py-2.5 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition-all text-sm disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                        Checkout
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>

                        {{-- Hidden Forms for Update and Delete to avoid nesting inside main form --}}
                        @foreach($cart as $id => $detail)
                            <form id="update-form-{{ $id }}" action="{{ route('cart.update', $id) }}" method="POST"
                                class="hidden">
                                @csrf @method('PATCH')
                            </form>
                            <form id="delete-form-{{ $id }}" action="{{ route('cart.destroy', $id) }}" method="POST"
                                class="hidden">
                                @csrf @method('DELETE')
                            </form>
                        @endforeach

                    @else
                        <div class="text-center py-20 px-6">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 mb-6">
                                <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Keranjang kosong</h3>
                            <p class="text-gray-500 mb-8">Yuk, isi keranjangmu dengan produk pilihan!</p>
                            <a href="{{ route('produk.index') }}"
                                class="inline-flex items-center px-6 py-2.5 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all">
                                Mulai Belanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer id="footer" class="bg-white border-t border-slate-100 pt-16 pb-8 font-sans relative overflow-hidden">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-12 mb-16 items-start">
                <div class="lg:col-span-5">
                    <a href="/" class="inline-block mb-6">
                        <img src="{{ asset('images/logo2.png') }}" alt="AgriSmart Logo"
                            class="h-16 lg:h-20 w-auto object-contain">
                    </a>
                    <p class="text-slate-500 leading-relaxed mb-8 pr-0 lg:pr-12">
                        Platform digital terintegrasi untuk pertanian cerdas. Solusi IoT inovatif untuk masa depan
                        pangan Indonesia yang berkelanjutan.
                    </p>
                    <div class="flex items-center gap-3">
                        @foreach(['facebook', 'instagram', 'twitter'] as $social)
                            <a href="#"
                                class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-500 border border-slate-100 transition-all duration-300 hover:bg-green-600 hover:text-white hover:scale-110 hover:shadow-lg group">
                                <span class="sr-only">{{ ucfirst($social) }}</span>
                                @if($social == 'facebook')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                @elseif($social == 'instagram')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4.001-1.793-4.001-4.001s1.792-4.001 4.001-4.001c2.21 0 4.001 1.793 4.001 4.001s-1.791 4.001-4.001 4.001zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                                @else
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                    </svg>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <h5 class="font-bold text-slate-900 mb-6">Menu Utama</h5>
                    <ul class="space-y-4">
                        @foreach(['Beranda' => '/', 'Tentang Kami' => '#tentang-kami', 'Layanan' => '#layanan', 'Produk' => route('produk.index'), 'Kontak' => '#kontak'] as $label => $link)
                            <li>
                                <a href="{{ $link }}"
                                    class="text-slate-500 text-sm font-medium hover:text-green-600 transition-all duration-200 block hover:translate-x-1">
                                    {{ $label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="lg:col-span-2">
                    <h5 class="font-bold text-slate-900 mb-6">Layanan</h5>
                    <ul class="space-y-4">
                        @foreach(['Konsultasi Tani' => '#', 'Marketplace Panen' => '#', 'Monitoring IoT' => '#', 'Edukasi & Pelatihan' => route('edukasi.index')] as $label => $link)
                            <li>
                                <a href="{{ $link }}"
                                    class="text-slate-500 text-sm font-medium hover:text-green-600 transition-all duration-200 block hover:translate-x-1">
                                    {{ $label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="lg:col-span-3">
                    <h5 class="font-bold text-slate-900 mb-6">Hubungi Kami</h5>
                    <div class="space-y-5">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-600 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p class="text-sm text-slate-500 leading-snug">
                                Jl. Pertanian Modern No. 88,<br>Jakarta Selatan, Indonesia
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <a href="mailto:info@agrismart.id"
                                class="text-sm text-slate-500 hover:text-green-600 transition-colors">
                                info@agrismart.id
                            </a>
                        </div>

                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <a href="tel:+6281234567890"
                                class="text-sm text-slate-500 hover:text-green-600 transition-colors">
                                +62 812 3456 7890
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-8 flex flex-col justify-center items-center gap-4">
                <p class="text-sm text-slate-500 text-center">
                    &copy; {{ date('Y') }} <span class="text-green-600 font-bold">AgriSmart</span>. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- BACK TO TOP BUTTON -->
    <button id="backToTop"
        class="fixed bottom-6 right-4 sm:bottom-8 sm:right-8 bg-green-600 hover:bg-green-700 text-white p-2.5 sm:p-3 rounded-xl shadow-lg shadow-green-600/30 translate-y-20 opacity-0 transition-all duration-500 z-50">
        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18">
            </path>
        </svg>
    </button>

    {{-- SCRIPT INITIALIZATION --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Init AOS
        AOS.init({
            once: true,
            offset: 50,
            duration: 800,
        });

        // Back to Top Logic
        const backToTopBtn = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopBtn.classList.remove('translate-y-20', 'opacity-0');
            } else {
                backToTopBtn.classList.add('translate-y-20', 'opacity-0');
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const checkAll = document.getElementById('checkAll');
            const checkboxes = document.querySelectorAll('.product-checkbox');
            const displayTotal = document.getElementById('displayTotal');
            const selectedCount = document.getElementById('selectedCount');
            const btnCheckout = document.getElementById('btnCheckout');

            function formatRupiah(angka) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
            }

            function calculateTotal() {
                let total = 0;
                let count = 0;

                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        total += parseFloat(cb.dataset.subtotal);
                        count++;
                    }
                });

                displayTotal.textContent = formatRupiah(total);
                selectedCount.textContent = count;

                // Disable button jika tidak ada yang dipilih
                if (count > 0) {
                    btnCheckout.removeAttribute('disabled');
                } else {
                    btnCheckout.setAttribute('disabled', 'true');
                }
            }

            // Event: Pilih Semua
            if (checkAll) {
                checkAll.addEventListener('change', function () {
                    checkboxes.forEach(cb => cb.checked = checkAll.checked);
                    calculateTotal();
                });
            }

            // Event: Pilih Satu per Satu
            checkboxes.forEach(cb => {
                cb.addEventListener('change', function () {
                    // Uncheck "Select All" jika salah satu unchecked
                    if (!this.checked) {
                        checkAll.checked = false;
                    }
                    // Check "Select All" jika semua checked
                    else if (document.querySelectorAll('.product-checkbox:checked').length === checkboxes.length) {
                        checkAll.checked = true;
                    }
                    calculateTotal();
                });
            });
        });
    </script>
</body>

</html>