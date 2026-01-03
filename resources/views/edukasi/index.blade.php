<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="Pusat Edukasi Pertanian AgriSmart. Pelajari teknik pertanian modern, tips budidaya, dan inovasi teknologi pertanian terkini.">
    <meta name="keywords" content="Edukasi Pertanian, Tips Budidaya, Teknologi Pertanian, AgriSmart, Petani Digital">
    <meta property="og:title" content="Edukasi - {{ config('app.name', 'AgriSmart') }}">
    <meta property="og:description" content="Tingkatkan pengetahuan bertani dengan panduan dari ahli.">
    <meta property="og:image" content="{{ asset('images/hero1.png') }}">

    <!-- Favicon & Title -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>Edukasi - {{ config('app.name', 'AgriSmart') }}</title>

    <!-- External Stylesheets -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Scrollbar Styling */
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

        /* Animasi Floating */
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

        /* Line Clamp untuk text truncation */
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

        /* Animasi Background Blobs */
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
    class="font-sans antialiased text-slate-700 bg-green-50 flex flex-col min-h-screen selection:bg-green-50 selection:text-white">

    <!-- Navigation Component -->
    <x-navbar />

    <main class="flex-1">

        <!-- ========== HERO SECTION ========== -->
        <section class="relative overflow-hidden pt-20 pb-12 lg:pt-28 lg:pb-16 bg-slate-50">
            <!-- Background Decoration -->
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="w-[600px] h-[600px] lg:w-[800px] lg:h-[800px] opacity-5">
                    <div class="w-full h-full animate-[spin_30s_linear_infinite]">
                        <img src="{{ asset('images/nav-logo.png') }}" alt="Background Decorative"
                            class="w-full h-full object-contain">
                    </div>
                </div>
            </div>

            <!-- Hero Content -->
            <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
                <div class="text-center" data-aos="fade-up">
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-green-100/50 text-green-700 text-xs font-bold tracking-wider uppercase mb-4 border border-green-200/50 shadow-sm">
                        Edukasi Pertanian Modern
                    </span>
                    <h2 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-slate-900 mb-4 sm:mb-6">
                        Edukasi <span class="text-green-600 block sm:inline">Pertanian Modern</span>
                    </h2>
                    <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto px-2">
                        Mengoptimalkan potensi pertanian dengan teknologi dan metode terkini
                    </p>
                </div>
            </div>
        </section>

        <!-- ========== ARTIKEL EDUKASI SECTION ========== -->
        <section class="py-12 sm:py-16 lg:py-24 relative bg-white overflow-hidden">

            <!-- Background Decoration -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-gradient-to-br from-gray-50/20 via-gray-50/10 to-transparent rounded-full blur-3xl">
                </div>
                <div
                    class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-gradient-to-tl from-gray-50/15 to-transparent rounded-full blur-3xl translate-x-1/3 translate-y-1/3">
                </div>

                <!-- Decorative Circles -->
                <div
                    class="hidden sm:block absolute top-20 right-[10%] w-32 h-32 border border-gray-100/20 rounded-full">
                </div>
                <div
                    class="hidden sm:block absolute bottom-32 left-[8%] w-24 h-24 border border-gray-100/20 rounded-full">
                </div>

                <!-- Dot Grid Background -->
                <div class="absolute inset-0 opacity-[0.015]"
                    style="background-image: radial-gradient(circle at 1px 1px, rgb(209 213 219) 1px, transparent 0); background-size: 40px 40px;">
                </div>
            </div>

            <!-- Artikel Container -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                <!-- Cek apakah ada artikel edukasi -->
                @if(isset($daftarEdukasi) && !$daftarEdukasi->isEmpty())
                    <!-- Grid Artikel -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
                        @foreach($daftarEdukasi as $index => $item)
                            <!-- Single Artikel Card -->
                            <article class="group" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                                <a href="{{ route('edukasi.show', $item->slug) }}"
                                    class="block h-full bg-white rounded-xl sm:rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-500 border border-green-100 hover:border-green-300 hover:-translate-y-1 flex flex-col md:flex-row">

                                    <!-- Gambar Sampul -->
                                    <div
                                        class="relative w-full md:w-2/5 h-48 sm:h-40 md:h-auto overflow-hidden bg-green-50 flex-shrink-0">
                                        @if($item->foto_sampul)
                                            <img src="{{ asset('storage/' . $item->foto_sampul) }}" alt="{{ $item->judul }}"
                                                loading="lazy"
                                                class="w-full h-full object-cover transition-all duration-700 group-hover:scale-105">
                                        @else
                                            <!-- Placeholder jika tidak ada gambar -->
                                            <div
                                                class="w-full h-full bg-gradient-to-br from-green-50 to-emerald-50 flex items-center justify-center min-h-[192px] sm:min-h-[160px] md:min-h-[250px]">
                                                <svg class="w-12 h-12 md:w-16 md:h-16 text-green-200" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif

                                        <!-- Overlay Gradient -->
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                        </div>

                                        <!-- Tanggal Update -->
                                        <div class="absolute top-3 left-3 md:top-4 md:left-4">
                                            <div
                                                class="flex items-center gap-1.5 px-2.5 py-1.5 bg-white/95 backdrop-blur-sm rounded-lg shadow-sm">
                                                <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span class="text-[10px] sm:text-xs font-medium text-green-600">
                                                    {{ $item->updated_at->format('d M Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Konten Artikel -->
                                    <div class="flex-1 p-4 sm:p-5 md:p-6 flex flex-col">
                                        <!-- Kategori -->
                                        <div class="mb-2 sm:mb-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-50 text-green-600 text-[10px] sm:text-xs font-medium uppercase tracking-wider rounded-md sm:rounded-lg border border-green-200">
                                                {{ $item->kategoriEdukasi->nama_kategori ?? 'Tips' }}
                                            </span>
                                        </div>

                                        <!-- Judul Artikel -->
                                        <h3
                                            class="text-base sm:text-lg md:text-xl font-bold text-slate-900 mb-2 sm:mb-3 line-clamp-2 group-hover:text-green-600 transition-colors duration-300 leading-snug">
                                            {{ $item->judul }}
                                        </h3>

                                        <!-- Preview Konten -->
                                        <p
                                            class="hidden md:block text-slate-600 text-sm leading-relaxed mb-4 flex-grow line-clamp-2 lg:line-clamp-3">
                                            {{ Str::limit(strip_tags($item->isi_konten), 140) }}
                                        </p>

                                        <!-- Footer Artikel (Author & Link) -->
                                        <div
                                            class="flex items-center justify-between pt-3 sm:pt-4 border-t border-green-50 sm:border-green-100 mt-auto">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span class="text-xs text-green-600 font-medium">Admin</span>
                                            </div>
                                            <div
                                                class="flex items-center gap-1 text-green-600 font-medium text-xs sm:text-sm ml-auto">
                                                <span>Selengkapnya</span>
                                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform group-hover:translate-x-1"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12 sm:mt-16" data-aos="fade-up" data-aos-delay="200">
                        <div class="flex justify-center">
                            {{ $daftarEdukasi->links() }}
                        </div>
                    </div>

                @else
                    <!-- State Kosong: Tidak ada artikel -->
                    <div class="max-w-2xl mx-auto px-4" data-aos="fade-up">
                        <div class="text-center py-12 sm:py-16 px-6 bg-white rounded-3xl border border-green-200">
                            <div class="relative inline-flex mb-6">
                                <div
                                    class="w-20 h-20 sm:w-24 sm:h-24 bg-green-50 rounded-2xl flex items-center justify-center">
                                    <svg class="w-10 h-10 sm:w-12 sm:h-12 text-green-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl sm:text-2xl font-bold text-slate-900 mb-3">Konten Segera Hadir!</h3>
                            <p class="text-slate-600 leading-relaxed max-w-md mx-auto mb-6 text-sm sm:text-base">
                                Kami sedang menyiapkan artikel edukatif berkualitas tinggi untuk meningkatkan pengetahuan
                                pertanian Anda. Nantikan konten menarik dari kami segera!
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <!-- ========== FOOTER SECTION ========== -->
    <x-footer />

    <!-- ========== BACK TO TOP BUTTON ========== -->
    <x-back-button />

    <!-- ========== EXTERNAL SCRIPTS ========== -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi AOS (Animate On Scroll)
        AOS.init({
            once: true,
            offset: 50,
            duration: 800,
        });
    </script>
</body>

</html>