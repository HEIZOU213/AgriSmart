<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pusat Edukasi - AgriSmart</title>

    {{-- FONTS: Plus Jakarta Sans --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- TAILWIND CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- ALPINE JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- CUSTOM STYLE & ANIMATION --}}
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Animasi Blob Background */
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="font-sans antialiased text-slate-700 bg-green-50 flex flex-col min-h-screen selection:bg-green-500 selection:text-white">

    <x-navbar />

                {{-- Desktop Menu --}}
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('produk.index') }}" class="text-slate-600 hover:text-green-600 font-medium transition-colors">Marketplace</a>
                    <a href="{{ route('edukasi.index') }}" class="text-green-600 font-bold">Edukasi</a>
                    <a href="#" class="text-slate-600 hover:text-green-600 font-medium transition-colors">Tentang Kami</a>
                </div>

                {{-- Mobile Menu Button (Placeholder) --}}
                <div class="md:hidden flex items-center">
                    <button class="text-slate-600 hover:text-green-600 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 pt-28 pb-16 relative overflow-hidden">
        
        {{-- BACKGROUND DECORATIONS --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-green-200/40 rounded-full blur-[100px] -mt-20"></div>
            <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-emerald-100/50 rounded-full blur-[80px] animate-blob"></div>
            <div class="absolute top-1/3 left-0 w-[300px] h-[300px] bg-lime-100/50 rounded-full blur-[80px] animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            {{-- HEADER SECTION --}}
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-block py-1 px-3 rounded-full bg-green-100 text-green-700 text-xs font-bold uppercase tracking-wider mb-4 shadow-sm">
                    Knowledge Base
                </span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight mb-4">
                    Pusat Edukasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-600">AgriSmart</span>
                </h1>
                <p class="text-lg text-slate-500 leading-relaxed">
                    Tingkatkan hasil panen Anda dengan wawasan terbaru, teknik pertanian modern, dan panduan ahli langsung dari sumbernya.
                </p>
            </div>

            {{-- GRID CONTENT --}}
            @if(isset($daftarEdukasi) && !$daftarEdukasi->isEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($daftarEdukasi as $item)
                        <article class="flex flex-col bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group h-full">
                            
                            {{-- Foto Sampul --}}
                            <div class="relative h-56 overflow-hidden bg-slate-100">
                                <a href="{{ route('edukasi.show', $item->slug) }}" class="block h-full w-full">
                                    @if($item->foto_sampul)
                                        <img src="{{ asset('storage/' . $item->foto_sampul) }}" 
                                             alt="{{ $item->judul }}" 
                                             class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <span class="text-sm font-medium">No Image</span>
                                        </div>
                                    @endif
                                    
                                    {{-- Overlay Gradient on Hover --}}
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </a>
                            </div>
                            
                            {{-- Content Body --}}
                            <div class="flex-1 p-6 flex flex-col">
                                {{-- Meta Data --}}
                                <div class="flex items-center text-xs text-slate-400 mb-3 space-x-2">
                                    <span class="flex items-center">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Admin
                                    </span>
                                    <span>&bull;</span>
                                    <span class="flex items-center">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $item->created_at->format('d M Y') }}
                                    </span>
                                </div>

                                {{-- Judul --}}
                                <h3 class="text-xl font-bold text-slate-900 mb-3 line-clamp-2 group-hover:text-green-600 transition-colors">
                                    <a href="{{ route('edukasi.show', $item->slug) }}">
                                        {{ $item->judul }}
                                    </a>
                                </h3>

                                {{-- Excerpt --}}
                                <p class="text-slate-500 text-sm leading-relaxed mb-4 line-clamp-3 flex-1">
                                    {{ Str::limit(strip_tags($item->isi_konten), 120) }}
                                </p>

                                {{-- Read More Button --}}
                                <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                                    <a href="{{ route('edukasi.show', $item->slug) }}" class="inline-flex items-center text-sm font-bold text-green-600 hover:text-green-700 transition-colors">
                                        Baca Selengkapnya
                                        <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Link Paginasi --}}
                <div class="mt-12">
                    {{ $daftarEdukasi->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-20 bg-white/60 backdrop-blur-sm rounded-3xl border border-dashed border-slate-300">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Belum ada konten edukasi</h3>
                    <p class="text-slate-500 mt-2">Nantikan artikel menarik dari kami segera.</p>
                </div>
            @endif
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-white border-t border-slate-100 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                {{-- Brand --}}
                <div>
                    <span class="text-2xl font-bold text-green-700 tracking-tight mb-4 inline-block">Agri<span class="text-slate-800">Smart</span></span>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Platform digital terintegrasi untuk pertanian cerdas. Solusi IoT inovatif untuk masa depan pangan Indonesia yang berkelanjutan.
                    </p>
                </div>
                {{-- Links --}}
                <div>
                    <h4 class="font-bold text-slate-900 mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li><a href="/" class="hover:text-green-600 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('produk.index') }}" class="hover:text-green-600 transition-colors">Marketplace</a></li>
                        <li><a href="{{ route('edukasi.index') }}" class="hover:text-green-600 transition-colors">Edukasi</a></li>
                    </ul>
                </div>
                {{-- Contact --}}
                <div>
                    <h4 class="font-bold text-slate-900 mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li>info@agrismart.id</li>
                        <li>+62 812 3456 7890</li>
                        <li>Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-100 pt-8 text-center">
                <p class="text-sm text-slate-500">
                    &copy; {{ date('Y') }} <span class="text-green-600 font-bold">AgriSmart</span>. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

</body>
</html>