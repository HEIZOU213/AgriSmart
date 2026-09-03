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
        <section class="relative overflow-hidden pt-20 pb-12 lg:pt-32 lg:pb-24 bg-gradient-to-b from-green-50/50 to-white">
            <!-- Background Decoration (Gaya Lama yang Diperbarui) -->
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(22,163,74,0.03)_0,transparent_50%)]"></div>
                <div class="w-[800px] h-[800px] lg:w-[1200px] lg:h-[1200px] opacity-[0.03] text-green-900 mix-blend-multiply">
                    <div class="w-full h-full animate-[spin_40s_linear_infinite] flex items-center justify-center">
                        <img src="{{ asset('images/nav-logo.png') }}" alt="Background Decorative"
                            class="w-3/4 h-3/4 object-contain scale-150">
                    </div>
                </div>
            </div>

            <!-- Hero Content -->
            <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
                <div class="text-center" data-aos="fade-up" data-aos-duration="1000">
                    <span
                        class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full bg-white/80 backdrop-blur-md text-green-700 text-xs sm:text-sm font-bold tracking-widest uppercase mb-6 border border-green-200/50 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all cursor-default">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        Edukasi Pertanian Modern
                    </span>
                    <h2 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-slate-900 mb-6 tracking-tight">
                        Edukasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-500 block sm:inline">Pertanian Modern</span>
                    </h2>
                    <p class="text-base sm:text-lg lg:text-xl text-slate-600 max-w-2xl mx-auto px-2 leading-relaxed">
                        Mengoptimalkan potensi pertanian dengan teknologi, riset, dan metode terkini untuk masa depan yang berkelanjutan.
                    </p>
                </div>
            </div>
        </section>

        <!-- ========== ARTIKEL EDUKASI SECTION ========== -->
        <section class="py-12 sm:py-16 lg:py-20 relative bg-white overflow-hidden">
            
            <!-- Artikel Container -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                <!-- Cek apakah ada artikel edukasi -->
                @if(isset($daftarEdukasi) && !$daftarEdukasi->isEmpty())
                    <!-- Grid Artikel (Gaya Lama: Horizontal Cards) -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-10">
                        @foreach($daftarEdukasi as $index => $item)
                            <!-- Single Artikel Card -->
                            <article class="group" data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 50 }}">
                                <a href="{{ route('edukasi.show', $item->slug) }}"
                                    class="block bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border border-slate-200 hover:border-green-300 hover:-translate-y-1 flex flex-col md:flex-row h-full">

                                    <!-- Gambar Sampul -->
                                    <div class="relative w-full md:w-5/12 aspect-video overflow-hidden bg-slate-50 flex-shrink-0">
                                        @if($item->foto_sampul)
                                            <img src="{{ asset('storage/' . $item->foto_sampul) }}" alt="{{ $item->judul }}"
                                                loading="lazy"
                                                class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                        @else
                                            <!-- Placeholder jika tidak ada gambar -->
                                            <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-emerald-50 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif

                                        <!-- Overlay Gradient -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10"></div>

                                        <!-- Kategori Badge Overlay -->
                                        <div class="absolute top-4 left-4 z-20">
                                            <span class="inline-flex items-center px-2.5 py-1 bg-white/95 backdrop-blur-sm text-green-700 text-[10px] sm:text-xs font-bold uppercase tracking-wider rounded-md border border-green-100">
                                                {{ $item->kategoriEdukasi->nama_kategori ?? 'Tips' }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Konten Artikel -->
                                    <div class="flex-1 p-5 sm:p-6 md:p-7 flex flex-col justify-between bg-white">
                                        
                                        <div>
                                            <!-- Tanggal -->
                                            <div class="flex items-center gap-2 mb-3">
                                                <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                                                <span class="text-[11px] sm:text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                                    {{ $item->updated_at->format('d M Y') }}
                                                </span>
                                            </div>

                                            <!-- Judul Artikel -->
                                            <h3 class="text-lg sm:text-xl md:text-2xl font-bold text-slate-900 mb-3 sm:mb-4 line-clamp-2 group-hover:text-green-600 transition-colors duration-300 leading-snug">
                                                {{ $item->judul }}
                                            </h3>

                                            <!-- Preview Konten -->
                                            <p class="hidden sm:block text-slate-500 text-sm leading-relaxed mb-6 flex-grow line-clamp-2 lg:line-clamp-3 font-medium">
                                                {{ Str::limit(strip_tags($item->isi_konten), 130) }}
                                            </p>
                                        </div>

                                        <!-- Footer Artikel (Author & Link) -->
                                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 mt-auto">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center border border-green-100">
                                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <span class="text-xs sm:text-sm font-semibold text-slate-700">Admin</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-green-600 font-bold text-xs sm:text-sm">
                                                <span class="relative overflow-hidden">
                                                    <span class="block transition-transform duration-300 group-hover:-translate-y-full">Baca</span>
                                                    <span class="absolute inset-0 transition-transform duration-300 translate-y-full group-hover:translate-y-0 text-green-500">Baca</span>
                                                </span>
                                                <svg class="w-4 h-4 transition-all duration-300 group-hover:translate-x-1 group-hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
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
                        <div class="text-center py-12 lg:py-20 bg-white/50 backdrop-blur-sm rounded-3xl border-2 border-dashed border-green-200">
                            <div class="w-20 h-20 lg:w-24 lg:h-24 mx-auto mb-6 bg-white rounded-full flex items-center justify-center shadow-md">
                                <svg class="w-10 h-10 lg:w-12 lg:h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg lg:text-xl font-bold text-slate-900 mb-2">Konten Segera Hadir!</h3>
                            <p class="text-slate-500 text-sm max-w-md mx-auto px-4">Kami sedang menyiapkan artikel edukatif berkualitas tinggi untuk meningkatkan pengetahuan pertanian Anda. Nantikan segera!</p>
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