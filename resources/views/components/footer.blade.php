<footer id="footer" class="bg-white border-t border-slate-100 pt-16 pb-8 font-sans relative overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">
        <!-- Grid Footer -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-12 mb-16 items-start">
            <!-- Kolom 1: Brand & Deskripsi -->
            <div class="lg:col-span-5">
                <!-- Logo -->
                <a href="/" class="inline-block mb-6">
                    <img src="{{ asset('images/logo2.png') }}" alt="AgriSmart Logo" loading="lazy"
                        class="h-16 lg:h-20 w-auto object-contain">
                </a>
                <!-- Deskripsi Singkat -->
                <p class="text-slate-500 leading-relaxed mb-8 pr-0 lg:pr-12">
                    Platform digital terintegrasi untuk pertanian cerdas. Solusi IoT inovatif untuk masa depan
                    pangan Indonesia yang berkelanjutan.
                </p>
                <!-- Media Sosial -->
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

            <!-- Kolom 2: Menu Utama -->
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

            <!-- Kolom 3: Layanan -->
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

            <!-- Kolom 4: Info Kontak -->
            <div class="lg:col-span-3">
                <h5 class="font-bold text-slate-900 mb-6">Hubungi Kami</h5>
                <div class="space-y-5">
                    <!-- Alamat -->
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

                    <!-- Email -->
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <a href="mailto:info@agrismart.id"
                            class="text-sm text-slate-500 hover:text-green-600 transition-colors">info@agrismart.id</a>
                    </div>

                    <!-- Telepon -->
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+6281234567890"
                            class="text-sm text-slate-500 hover:text-green-600 transition-colors">+62 812 3456
                            7890</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-slate-100 pt-8 flex flex-col justify-center items-center gap-4">
            <p class="text-sm text-slate-500 text-center">
                &copy; {{ date('Y') }} <span class="text-green-600 font-bold">AgriSmart</span>. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>