<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $edukasi->judul }} - AgriSmart</title>

    {{-- FONTS: Plus Jakarta Sans --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- TAILWIND CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- TAILWIND TYPOGRAPHY PLUGIN --}}
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>

    {{-- ALPINE JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
    </style>
</head>

<body class="font-sans antialiased text-slate-700 bg-green-50 flex flex-col min-h-screen selection:bg-green-500 selection:text-white">

    <x-navbar />

        {{-- Desktop Menu Placeholder (Sesuaikan dengan layout navbar Anda) --}}
        <div class="hidden md:flex space-x-8">
            <a href="{{ route('produk.index') }}" class="text-slate-600 hover:text-green-600 font-medium transition-colors">Marketplace</a>
            <a href="{{ route('edukasi.index') }}" class="text-green-600 font-bold">Edukasi</a>
            <a href="#" class="text-slate-600 hover:text-green-600 font-medium transition-colors">Tentang Kami</a>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 pt-28 pb-16 relative overflow-hidden">
        
        {{-- BACKGROUND DECORATIONS --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute top-0 left-0 w-[600px] h-[600px] bg-green-200/40 rounded-full blur-[100px] -mt-20 -ml-20 animate-blob"></div>
            <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-emerald-100/50 rounded-full blur-[80px] animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            {{-- BREADCRUMB --}}
            <div class="mb-8">
                <a href="{{ route('edukasi.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-green-600 transition-colors group">
                    <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center mr-3 shadow-sm group-hover:bg-green-600 group-hover:border-green-600 group-hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </div>
                    Kembali ke Pusat Edukasi
                </a>
            </div>

            {{-- ARTICLE CARD --}}
            <article class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
                
                {{-- 
                    =============================================
                    BAGIAN MEDIA (VIDEO atau FOTO)
                    Disatukan di sini agar rapi.
                    =============================================
                --}}
                @php
                    // 1. Cek dulu apakah ada video
                    $hasVideo = ($edukasi->tipe_konten == 'video' && !empty($edukasi->url_video));
                    $embedUrl = null;

                    if ($hasVideo) {
                        $pattern = '/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
                        if (preg_match($pattern, $edukasi->url_video, $matches)) {
                            $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                        }
                    }
                @endphp

                {{-- KONDISI 1: Jika Ada Video, Tampilkan Video sebagai Header --}}
                @if($hasVideo && $embedUrl)
                    <div class="w-full bg-black">
                        <div class="relative w-full pb-[56.25%]"> {{-- Aspect Ratio 16:9 --}}
                            <iframe class="absolute top-0 left-0 w-full h-full"
                                    src="{{ $embedUrl }}" 
                                    title="YouTube video player"
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                    referrerpolicy="strict-origin-when-cross-origin"
                                    allowfullscreen>
                            </iframe>
                        </div>
                    </div>

                {{-- KONDISI 2: Jika Tidak Ada Video, tapi Ada Foto Sampul --}}
                @elseif($edukasi->foto_sampul)
                    <div class="relative w-full h-[300px] md:h-[400px] overflow-hidden">
                        <img src="{{ asset('storage/' . $edukasi->foto_sampul) }}" 
                             alt="{{ $edukasi->judul }}" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    </div>
                @endif
                {{-- ============================================= --}}

                <div class="p-6 md:p-10 lg:p-12 relative">
                    
                    {{-- HEADER ARTIKEL --}}
                    {{-- Kita beri margin top negatif (-mt-20) hanya jika yg tampil adalah GAMBAR. 
                         Jika Video, jangan pakai margin negatif agar teks tidak menumpuk di player video --}}
                    <header class="mb-8 {{ (!$hasVideo && $edukasi->foto_sampul) ? '-mt-20 relative z-10' : '' }}">
                        
                        {{-- Kategori --}}
                        <div class="mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-green-600 text-white shadow-md">
                                {{ $edukasi->kategoriEdukasi->nama_kategori ?? 'Umum' }}
                            </span>
                        </div>

                        {{-- Judul --}}
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-900 leading-tight mb-6 {{ (!$hasVideo && $edukasi->foto_sampul) ? 'text-white drop-shadow-md' : '' }}">
                            {{ $edukasi->judul }}
                        </h1>

                        {{-- Metadata --}}
                        <div class="flex items-center space-x-4 text-sm {{ (!$hasVideo && $edukasi->foto_sampul) ? 'text-white/90' : 'text-slate-500' }}">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span>Admin</span>
                            </div>
                            <span>&bull;</span>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>{{ $edukasi->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </header>

                    {{-- Spacer jika pakai Foto Sampul --}}
                    @if(!$hasVideo && $edukasi->foto_sampul) <div class="h-4"></div> @endif

                    {{-- ISI KONTEN --}}
                    <div class="prose prose-lg prose-green max-w-none text-slate-600 leading-relaxed">
                        {!! $edukasi->isi_konten !!}
                    </div>

                </div>

                {{-- FOOTER ARTIKEL --}}
                <div class="bg-slate-50 px-6 py-6 md:px-12 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-sm text-slate-500 font-medium italic">
                        Semoga konten ini bermanfaat untuk pertanian Anda.
                    </p>
                    <div class="flex space-x-2">
                        <button class="w-9 h-9 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-blue-600 hover:border-blue-600 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </button>
                        <button class="w-9 h-9 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-sky-500 hover:border-sky-500 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </button>
                    </div>
                </div>

            </article>

        </div>
    </main>

    <footer class="bg-white border-t border-slate-100 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <span class="text-2xl font-bold text-green-700 tracking-tight inline-block mb-4">Agri<span class="text-slate-800">Smart</span></span>
            <p class="text-sm text-slate-500">
                &copy; {{ date('Y') }} AgriSmart. All Rights Reserved.
            </p>
        </div>
    </footer>

</body>
</html>