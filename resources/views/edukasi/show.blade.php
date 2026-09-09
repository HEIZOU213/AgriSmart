<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ Str::limit(strip_tags($edukasi->isi_konten), 160) }}">
    <meta name="keywords" content="Edukasi Durian, AgriSmart, Panduan Berkebun, {{ $edukasi->kategoriEdukasi->nama_kategori ?? 'Budidaya' }}">
    <meta property="og:title" content="{{ $edukasi->judul }} - {{ config('app.name', 'AgriSmart') }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($edukasi->isi_konten), 160) }}">
    @if($edukasi->foto_sampul)
        <meta property="og:image" content="{{ asset('storage/' . $edukasi->foto_sampul) }}">
    @else
        <meta property="og:image" content="{{ asset('images/nav-logo.png') }}">
    @endif

    <x-favicon />
    <title>{{ $edukasi->judul }} - {{ config('app.name', 'AgriSmart') }}</title>

    {{-- FONTS: Plus Jakarta Sans --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- TAILWIND & VITE ASSETS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Styling Typography Konten Artikel */
        .article-content {
            color: #334155;
            font-size: 1.0625rem;
            line-height: 1.85;
            word-break: break-word;
        }

        .article-content p {
            margin-bottom: 1.5rem;
        }

        .article-content h2 {
            font-size: 1.625rem;
            font-weight: 800;
            color: #0f172a;
            margin-top: 2.5rem;
            margin-bottom: 1rem;
            line-height: 1.35;
        }

        .article-content h3 {
            font-size: 1.325rem;
            font-weight: 700;
            color: #1e293b;
            margin-top: 2rem;
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .article-content ul, .article-content ol {
            margin-top: 1rem;
            margin-bottom: 1.5rem;
            padding-left: 1.5rem;
        }

        .article-content ul {
            list-style-type: disc;
        }

        .article-content ol {
            list-style-type: decimal;
        }

        .article-content li {
            margin-bottom: 0.5rem;
            padding-left: 0.35rem;
        }

        .article-content blockquote {
            border-left: 4px solid #16a34a;
            background-color: #f0fdf4;
            padding: 1rem 1.25rem;
            border-radius: 0 0.75rem 0.75rem 0;
            margin: 1.75rem 0;
            font-style: italic;
            color: #166534;
        }

        .article-content img {
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.07);
            margin: 2rem auto;
            max-width: 100%;
            height: auto;
        }

        .article-content a {
            color: #16a34a;
            text-decoration: underline;
            font-weight: 600;
            transition: color 0.2s;
        }

        .article-content a:hover {
            color: #15803d;
        }

        .article-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.75rem 0;
            font-size: 0.95rem;
        }

        .article-content table th, .article-content table td {
            border: 1px solid #e2e8f0;
            padding: 0.75rem 1rem;
            text-align: left;
        }

        .article-content table th {
            background-color: #f8fafc;
            font-weight: 700;
            color: #0f172a;
        }
    </style>
</head>

<body class="font-sans antialiased text-slate-700 bg-slate-50 flex flex-col min-h-screen selection:bg-green-500 selection:text-white overflow-x-hidden">

    <x-preloader />

    {{-- NAVBAR RESMI SISTEM --}}
    <x-navbar />

    @php
        // Cek tipe konten & parse URL Video YouTube
        $hasVideo = ($edukasi->tipe_konten == 'video' && !empty($edukasi->url_video));
        $embedUrl = null;

        if ($hasVideo) {
            $pattern = '/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
            if (preg_match($pattern, $edukasi->url_video, $matches)) {
                $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
            }
        }

        // Estimasi waktu baca
        $wordCount = str_word_count(strip_tags($edukasi->isi_konten));
        $readMinutes = max(1, (int) ceil($wordCount / 180));
    @endphp

    {{-- MAIN CONTENT WRAPPER --}}
    <main class="flex-1 pt-24 sm:pt-28 lg:pt-32 pb-16 relative overflow-hidden">
        
        {{-- Background Spin Tengah (Khas AgriSmart tanpa decorative SVG header) --}}
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none overflow-hidden">
            <div class="h-[280px] w-[280px] opacity-[0.03] sm:h-[500px] sm:w-[500px] lg:h-[800px] lg:w-[800px]">
                <div class="h-full w-full animate-[spin_35s_linear_infinite]">
                    <img src="{{ asset('images/nav-logo.png') }}" alt="Background" class="h-full w-full object-contain">
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            {{-- TOP NAVIGATION & BREADCRUMB BAR (Tata Letak Terpadu & Menarik) --}}
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3 bg-white/90 backdrop-blur-md px-4 sm:px-5 py-2.5 sm:py-3 rounded-2xl border border-slate-200/80 shadow-sm">
                {{-- Breadcrumb Hirarki Navigasi --}}
                <nav class="flex items-center gap-1.5 sm:gap-2 text-xs sm:text-sm font-medium text-slate-500" aria-label="Breadcrumb">
                    <a href="{{ route('homepage') }}" class="hover:text-green-600 transition-colors flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Beranda</span>
                    </a>
                    <span class="text-slate-300">/</span>
                    <a href="{{ route('edukasi.index') }}" class="hover:text-green-600 transition-colors">
                        Edukasi
                    </a>
                    <span class="text-slate-300">/</span>
                    <span class="text-green-700 bg-green-50 border border-green-200/60 px-2.5 py-0.5 rounded-full font-semibold text-[11px] sm:text-xs truncate max-w-[130px] sm:max-w-[220px]">
                        {{ $edukasi->kategoriEdukasi->nama_kategori ?? 'Panduan' }}
                    </span>
                </nav>

                {{-- Tombol Kembali yang Menarik & Interaktif --}}
                <a href="{{ route('edukasi.index') }}"
                    class="group inline-flex items-center gap-2 px-3.5 sm:px-4 py-1.5 sm:py-2 rounded-xl bg-slate-50 hover:bg-green-600 text-slate-700 hover:text-white border border-slate-200/90 hover:border-green-600 text-xs sm:text-sm font-semibold shadow-sm hover:shadow transition-all duration-200">
                    <span class="text-slate-400 group-hover:text-white group-hover:-translate-x-1 transition-all duration-200 font-bold text-sm leading-none">&larr;</span>
                    <span>Kembali ke Pusat Edukasi</span>
                </a>
            </div>

            {{-- ARTICLE CONTAINER CARD --}}
            <article class="bg-white rounded-2xl sm:rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200/80 overflow-hidden">
                
                {{-- MEDIA DISPLAY (Video YouTube atau Foto Sampul) --}}
                @if($hasVideo && $embedUrl)
                    {{-- 16:9 Video Player --}}
                    <div class="w-full bg-black">
                        <div class="relative w-full pb-[56.25%]">
                            <iframe class="absolute top-0 left-0 w-full h-full"
                                    src="{{ $embedUrl }}" 
                                    title="{{ $edukasi->judul }}"
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                    referrerpolicy="strict-origin-when-cross-origin"
                                    allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                @elseif($edukasi->foto_sampul)
                    {{-- Foto Sampul Lebar --}}
                    <div class="relative w-full max-h-[440px] overflow-hidden bg-slate-100">
                        <img src="{{ asset('storage/' . $edukasi->foto_sampul) }}" 
                             alt="{{ $edukasi->judul }}" 
                             class="w-full h-full object-cover">
                    </div>
                @endif

                {{-- KONTEN UTAMA ARTIKEL --}}
                <div class="p-6 sm:p-8 md:p-12">
                    
                    {{-- HEADER ARTIKEL --}}
                    <header class="mb-8 pb-6 border-b border-slate-100">
                        
                        {{-- Tag Kategori & Tipe Konten --}}
                        <div class="flex flex-wrap items-center gap-2.5 mb-4">
                            <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-green-100 text-green-700 border border-green-200/60">
                                {{ $edukasi->kategoriEdukasi->nama_kategori ?? 'Panduan Budidaya' }}
                            </span>

                            @if($edukasi->tipe_konten === 'video')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    Video Edukasi
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                    <svg class="w-3.5 h-3.5 fill-none stroke-current" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    Artikel Panduan
                                </span>
                            @endif

                            <span class="text-xs font-medium text-slate-400">
                                &bull; {{ $readMinutes }} menit baca
                            </span>
                        </div>

                        {{-- Judul Edukasi --}}
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-snug sm:leading-tight mb-5">
                            {{ $edukasi->judul }}
                        </h1>

                        {{-- Info Penulis & Waktu Terbit --}}
                        <div class="flex flex-wrap items-center justify-between gap-4 text-sm text-slate-500 pt-2">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold border border-green-200">
                                    {{ strtoupper(substr($edukasi->user->name ?? 'A', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 leading-tight">
                                        {{ $edukasi->user->name ?? 'Tim Ahli AgriSmart' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 text-xs sm:text-sm font-medium text-slate-500">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>Dipublikasikan: {{ $edukasi->created_at->format('d M Y') }}</span>
                            </div>
                        </div>

                    </header>

                    {{-- ISI KONTEN LENGKAP --}}
                    <div class="article-content">
                        {!! $edukasi->isi_konten !!}
                    </div>

                </div>

                {{-- CARD FOOTER: PESAN & BAGIKAN ARTIKEL --}}
                <div class="bg-slate-50/80 px-6 py-6 sm:px-10 md:px-12 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4"
                     x-data="{ copied: false }">
                    
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3">
                        <a href="{{ route('edukasi.index') }}"
                           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:text-green-600 hover:border-green-300 hover:bg-green-50 shadow-sm transition-all group">
                            <span class="text-slate-400 group-hover:text-green-600 group-hover:-translate-x-1 transition-transform font-bold">&larr;</span>
                            <span>Daftar Edukasi</span>
                        </a>
                        <p class="text-xs text-slate-500 hidden md:block">
                            Bagikan ilmu budidaya ini ke rekan pekebun lainnya.
                        </p>
                    </div>

                    {{-- Tombol Berbagi Sosial Media --}}
                    <div class="flex items-center gap-2">
                        
                        {{-- WhatsApp --}}
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($edukasi->judul . ' - ' . url()->current()) }}"
                           target="_blank" rel="noopener noreferrer"
                           title="Bagikan ke WhatsApp"
                           class="w-9 h-9 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:text-green-600 hover:border-green-300 hover:bg-green-50 shadow-sm transition-all">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                        </a>

                        {{-- Facebook --}}
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                           target="_blank" rel="noopener noreferrer"
                           title="Bagikan ke Facebook"
                           class="w-9 h-9 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:text-blue-600 hover:border-blue-300 hover:bg-blue-50 shadow-sm transition-all">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>

                        {{-- Twitter / X --}}
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($edukasi->judul) }}"
                           target="_blank" rel="noopener noreferrer"
                           title="Bagikan ke X"
                           class="w-9 h-9 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:text-slate-900 hover:border-slate-400 hover:bg-slate-100 shadow-sm transition-all">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>

                        {{-- Copy Link Button --}}
                        <button type="button"
                                @click="navigator.clipboard.writeText('{{ url()->current() }}'); copied = true; setTimeout(() => copied = false, 2500)"
                                title="Salin Tautan"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full bg-white border border-slate-200 text-xs font-semibold text-slate-700 hover:text-green-600 hover:border-green-300 shadow-sm transition-all">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            <span x-text="copied ? 'Tersalin!' : 'Salin'">Salin</span>
                        </button>

                    </div>

                </div>

            </article>

            {{-- ARTIKEL & PANDUAN TERKAIT LAINNYA --}}
            @if(isset($artikelTerkait) && $artikelTerkait->isNotEmpty())
                <div class="mt-14 sm:mt-16">
                    <div class="flex items-center justify-between mb-6 sm:mb-8">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                                Materi Edukasi Lainnya
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                                Perluas wawasan teknik budidaya durian modern Anda
                            </p>
                        </div>
                        <a href="{{ route('edukasi.index') }}" class="text-sm font-semibold text-green-600 hover:text-green-700 transition-colors flex items-center gap-1">
                            <span>Lihat Semua</span>
                            <span>&rarr;</span>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($artikelTerkait as $terkait)
                            <a href="{{ route('edukasi.show', $terkait->slug) }}"
                               class="group bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-green-300 transition-all duration-300 flex flex-col overflow-hidden">
                                
                                {{-- Thumbnail --}}
                                <div class="relative w-full aspect-video overflow-hidden bg-slate-100">
                                    @if($terkait->foto_sampul)
                                        <img src="{{ asset('storage/' . $terkait->foto_sampul) }}"
                                             alt="{{ $terkait->judul }}"
                                             loading="lazy"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-green-50 to-emerald-100 flex items-center justify-center">
                                            <img src="{{ asset('images/nav-logo.png') }}" alt="AgriSmart" class="w-12 h-12 opacity-30 object-contain">
                                        </div>
                                    @endif

                                    <div class="absolute top-3 left-3">
                                        <span class="px-2.5 py-0.5 bg-white/95 backdrop-blur-sm text-green-700 text-[10px] font-bold uppercase tracking-wider rounded-md border border-green-100 shadow-sm">
                                            {{ $terkait->kategoriEdukasi->nama_kategori ?? 'Tips' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Body --}}
                                <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between">
                                    <div>
                                        <span class="text-[11px] font-semibold text-slate-400 block mb-1.5">
                                            {{ $terkait->created_at->format('d M Y') }}
                                        </span>
                                        <h3 class="font-bold text-slate-900 text-sm sm:text-base group-hover:text-green-600 transition-colors line-clamp-2 leading-snug">
                                            {{ $terkait->judul }}
                                        </h3>
                                    </div>

                                    <div class="flex items-center gap-1 text-green-600 font-semibold text-xs mt-4 pt-3 border-t border-slate-100">
                                        <span>Baca Selengkapnya</span>
                                        <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </main>

    {{-- FOOTER RESMI SISTEM AGRISMART --}}
    <x-footer />

    {{-- TOMBOL KEMBALI KE ATAS --}}
    <x-back-button />

</body>
</html>

