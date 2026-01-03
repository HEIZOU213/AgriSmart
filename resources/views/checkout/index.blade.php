<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Konfirmasi Checkout - {{ config('app.name', 'AgriSmart') }}</title>

    <!-- ==================== STYLESHEETS & FONTS ==================== -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* ==================== SCROLLBAR CUSTOMIZATION ==================== */
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
    </style>
</head>

<body
    class="font-sans antialiased text-slate-700 bg-green-50 flex flex-col min-h-screen selection:bg-green-500 selection:text-white">

    <!-- ==================== NAVBAR COMPONENT ==================== -->
    <x-navbar />

    <main class="flex-1">
        <!-- ==================== HERO SECTION ==================== -->
        <section class="relative overflow-hidden pt-20 pb-6 sm:pt-28 lg:pt-32 lg:pb-12 bg-slate-50">
            <!-- Background Animated Logo -->
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="w-[200px] h-[200px] sm:w-[400px] sm:h-[400px] lg:w-[800px] lg:h-[800px] opacity-5">
                    <div class="w-full h-full animate-[spin_30s_linear_infinite]">
                        <img src="{{ asset('images/nav-logo.png') }}" alt="Background"
                            class="w-full h-full object-contain">
                    </div>
                </div>
            </div>

            <!-- Hero Content -->
            <div class="relative z-10 container mx-auto px-3 sm:px-6 lg:px-8 max-w-4xl">
                <div class="text-center" data-aos="fade-up">
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-green-100/50 text-green-700 text-[10px] sm:text-xs font-bold tracking-wider uppercase mb-3 border border-green-200/50 shadow-sm">
                        Final Step
                    </span>
                    <h1
                        class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-slate-900 mb-3 sm:mb-6 leading-tight">
                        Konfirmasi <span class="text-green-600 inline-block">Pesanan</span>
                    </h1>
                    <p class="text-sm sm:text-lg text-slate-600 max-w-xl sm:max-w-2xl mx-auto px-2 leading-relaxed">
                        Lengkapi informasi pengiriman Anda untuk menyelesaikan proses belanja.
                    </p>
                </div>
            </div>
        </section>

        <!-- ==================== CHECKOUT FORM SECTION ==================== -->
        <section class="py-4 lg:py-10 bg-white relative font-sans">
            <div class="container mx-auto px-3 sm:px-6 lg:px-8 max-w-7xl relative z-10 pb-6 lg:pb-0">

                <!-- ==================== ERROR ALERT ==================== -->
                @if (session('error') || $errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg" data-aos="fade-down">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-bold text-sm mb-1">Terjadi Kesalahan</h3>
                                <ul class="list-disc list-inside text-xs sm:text-sm">
                                    {{ session('error') }}
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- ==================== BACK BUTTON ==================== -->
                <div class="mb-6">
                    <a href="{{ route('cart.index') }}"
                        class="group inline-flex items-center px-4 py-2 text-xs font-semibold text-slate-500 bg-white border border-slate-200 rounded-md hover:bg-green-600 hover:text-white hover:border-green-600 transition-all duration-200 transform active:scale-95 gap-2">
                        <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:-translate-x-1"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Kembali ke Keranjang</span>
                    </a>
                </div>

                <!-- ==================== CHECKOUT FORM ==================== -->
                <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
                    @csrf

                    <!-- Hidden Inputs untuk ID Keranjang yang Dipilih -->
                    @if(isset($selectedCartIds) && is_array($selectedCartIds))
                        @foreach($selectedCartIds as $id)
                            <input type="hidden" name="selected_cart_ids[]" value="{{ $id }}">
                        @endforeach
                    @endif

                    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-start">

                        <!-- ==================== KOLOM KIRI: FORM INPUT ==================== -->
                        <div class="w-full lg:w-2/3">
                            <div class="bg-white rounded-lg border border-slate-200 overflow-hidden" data-aos="fade-up"
                                data-aos-delay="100">
                                <!-- Form Header -->
                                <div
                                    class="p-4 sm:p-6 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                                    <h3 class="font-bold text-slate-800 text-lg">Alamat Pengiriman</h3>
                                </div>

                                <!-- Form Input Fields -->
                                <div class="p-4 sm:p-6 space-y-5">
                                    <!-- Nama Penerima -->
                                    <div>
                                        <label for="nama" class="block text-sm font-semibold text-slate-700 mb-2">Nama
                                            Penerima</label>
                                        <input type="text" id="nama" name="nama" required
                                            class="w-full rounded-lg border-slate-300 focus:border-green-600 focus:ring-0 focus:outline-none text-slate-800 text-sm py-2.5 px-4 placeholder:text-slate-400"
                                            placeholder="Masukkan nama lengkap penerima">
                                    </div>

                                    <!-- Nomor Telepon -->
                                    <div>
                                        <label for="no_telepon"
                                            class="block text-sm font-semibold text-slate-700 mb-2">Nomor Telepon /
                                            WhatsApp</label>
                                        <div class="relative">
                                            <span
                                                class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 text-sm pointer-events-none">+62</span>
                                            <input type="text" id="no_telepon" name="no_telepon" required
                                                class="w-full rounded-lg border-slate-300 focus:border-green-600 focus:ring-0 focus:outline-none text-slate-800 text-sm py-2.5 pl-12 pr-4 placeholder:text-slate-400"
                                                placeholder="8123xxxxxx">
                                        </div>
                                    </div>

                                    <!-- Alamat Lengkap -->
                                    <div>
                                        <label for="alamat_kirim"
                                            class="block text-sm font-semibold text-slate-700 mb-2">Alamat
                                            Lengkap</label>
                                        <textarea name="alamat_kirim" id="alamat_kirim" rows="4" required
                                            class="w-full rounded-lg border-slate-300 focus:border-green-600 focus:ring-0 focus:outline-none text-slate-800 text-sm py-3 px-4 placeholder:text-slate-400 resize-none"
                                            placeholder="Nama Jalan, RT/RW, Nomor Rumah, Kelurahan, Kecamatan"></textarea>
                                        <p class="mt-2 text-xs text-slate-500 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            Pastikan alamat yang Anda masukkan benar.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ==================== KOLOM KANAN: RINGKASAN PESANAN ==================== -->
                        <div class="w-full lg:w-1/3">
                            <div class="sticky top-24 space-y-4">

                                <!-- Ringkasan Container -->
                                <div class="bg-white p-5 rounded-lg border border-slate-200">
                                    <!-- Ringkasan Header -->
                                    <div
                                        class="flex items-center justify-between mb-4 pb-4 border-b border-dashed border-slate-200">
                                        <h3 class="font-bold text-slate-800 text-lg">Ringkasan Pesanan</h3>
                                        <span
                                            class="text-xs font-medium px-2 py-1 bg-green-50 text-green-700 rounded border border-green-100">{{ count($cart) }}
                                            Barang</span>
                                    </div>

                                    <!-- Daftar Item di Keranjang -->
                                    <div class="max-h-[300px] overflow-y-auto pr-1 custom-scrollbar space-y-4 mb-5">
                                        @foreach($cart as $detail)
                                            <div class="flex gap-3 group">
                                                <!-- Gambar Produk -->
                                                <div
                                                    class="w-12 h-12 bg-slate-100 rounded-md flex-shrink-0 border border-slate-200 overflow-hidden relative">
                                                    @if(isset($detail['foto']) && $detail['foto'])
                                                        <img src="{{ asset('storage/' . $detail['foto']) }}"
                                                            alt="{{ $detail['nama'] }}" class="w-full h-full object-cover">
                                                    @else
                                                        <!-- Placeholder jika tidak ada gambar -->
                                                        <div
                                                            class="w-full h-full flex items-center justify-center text-slate-300">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Detail Produk -->
                                                <div class="flex-1 min-w-0">
                                                    <p
                                                        class="text-sm font-semibold text-slate-800 line-clamp-1 group-hover:text-green-600 transition-colors">
                                                        {{ $detail['nama'] }}
                                                    </p>
                                                    <p class="text-[10px] text-slate-500 flex items-center gap-1 mt-0.5">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                            </path>
                                                        </svg>
                                                        {{ $detail['petani'] }}
                                                    </p>
                                                    <div class="flex justify-between items-center mt-1">
                                                        <span class="text-xs text-slate-500">{{ $detail['jumlah'] }} x Rp
                                                            {{ number_format($detail['harga'], 0, ',', '.') }}</span>
                                                        <span class="text-xs font-bold text-slate-700">Rp
                                                            {{ number_format($detail['subtotal'], 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Ringkasan Harga & Tombol Checkout -->
                                    <div
                                        class="space-y-3 pt-4 border-t border-slate-100 bg-slate-50/50 -mx-5 px-5 pb-5 rounded-b-lg">
                                        <!-- Subtotal -->
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-slate-500">Subtotal Produk</span>
                                            <span class="font-medium text-slate-700">Rp
                                                {{ number_format($total, 0, ',', '.') }}</span>
                                        </div>
                                        <!-- Biaya Pengiriman -->
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-slate-500">Biaya Pengiriman</span>
                                            <span class="font-medium text-green-600">Gratis</span>
                                        </div>

                                        <!-- Total Bayar -->
                                        <div
                                            class="flex justify-between items-center pt-2 mt-2 border-t border-dashed border-slate-200">
                                            <span class="font-bold text-slate-800 text-base">Total Bayar</span>
                                            <span class="font-bold text-xl text-green-600">Rp
                                                {{ number_format($total, 0, ',', '.') }}</span>
                                        </div>

                                        <!-- Tombol Submit -->
                                        <button type="submit"
                                            class="w-full mt-4 py-3.5 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                                            <span>Buat Pesanan</span>
                                        </button>

                                        <!-- Footer Note -->
                                        <p class="text-[10px] text-center text-slate-400 mt-2">
                                            Dengan membuat pesanan, Anda menyetujui Syarat & Ketentuan kami.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <!-- ==================== FOOTER COMPONENT ==================== -->
    <x-footer />

    <!-- ==================== BACK TO TOP BUTTON COMPONENT ==================== -->
    <x-back-button />

    <!-- ==================== AOS ANIMATION SCRIPT ==================== -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi AOS Animation
        if (typeof AOS !== 'undefined') {
            AOS.init({ once: true, offset: 50, duration: 800 });
        }
    </script>
</body>

</html>