<x-public-layout>

    {{-- Navigation Bar --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-200/50 shadow-sm transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                {{-- Logo --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('homepage') }}" class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <div class="hidden sm:block">
                            <div class="text-xl font-black text-gray-900">AgriSmart</div>
                            <div class="text-xs text-gray-500 font-medium -mt-1">Platform Pertanian Digital</div>
                        </div>
                    </a>
                </div>
                
                {{-- Desktop Menu --}}
                <div class="hidden lg:flex items-center gap-2">
                    <a href="#" class="px-5 py-2.5 text-green-700 bg-green-50 font-bold rounded-xl transition-all">Beranda</a>
                    <a href="{{ route('produk.index') }}" class="px-5 py-2.5 text-gray-700 hover:text-green-600 font-semibold rounded-xl hover:bg-green-50 transition-all">Produk</a>
                    <a href="{{ route('edukasi.index') }}" class="px-5 py-2.5 text-gray-700 hover:text-green-600 font-semibold rounded-xl hover:bg-green-50 transition-all">Edukasi</a>
                    {{-- [UBAH] Link Kontak mengarah ke ID #kontak --}}
                    <a href="#kontak" class="px-5 py-2.5 text-gray-700 hover:text-green-600 font-semibold rounded-xl hover:bg-green-50 transition-all">Kontak</a>
                </div>
                
                {{-- CTA Buttons --}}
                <div class="flex items-center gap-3">
                    @auth
                        {{-- User Menu Dropdown --}}
                        <div class="hidden md:block relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 px-4 py-2.5 text-gray-700 hover:text-green-600 font-semibold rounded-xl hover:bg-green-50 transition-all">
                                <div class="w-8 h-8 bg-gradient-to-br from-green-600 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="hidden lg:inline">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            {{-- Dropdown Menu --}}
                            <div x-show="open" @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">
                                
                                {{-- Dashboard Link (Sesuai Role) --}}
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                        Admin Panel
                                    </a>
                                @elseif(Auth::user()->role === 'petani')
                                    <a href="{{ route('petani.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                        Dashboard Petani
                                    </a>
                                @endif

                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profil Saya
                                </a>

                                @if(Auth::user()->role === 'konsumen')
                                    <a href="{{ route('konsumen.pesanan.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        Pesanan Saya
                                    </a>
                                @endif

                                <div class="border-t border-gray-100 my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        {{-- Login & Register Buttons --}}
                        <a href="{{ route('login') }}" class="hidden md:inline-flex items-center gap-2 px-6 py-2.5 text-gray-700 font-bold rounded-xl border-2 border-gray-200 hover:border-green-600 hover:text-green-600 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Masuk
                        </a>
                        
                        <a href="{{ route('register') }}" class="hidden md:inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl hover:shadow-lg transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Daftar
                        </a>
                    @endauth
                    
                    {{-- Mobile Menu Button --}}
                    <button class="lg:hidden p-2 text-gray-700 hover:text-green-600 hover:bg-gray-100 rounded-xl transition-all" onclick="toggleMobileMenu()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        {{-- Mobile Menu --}}
        <div class="lg:hidden hidden bg-white border-t border-gray-200" id="mobileMenu">
            <div class="px-4 py-4 space-y-2">
                <a href="#" class="block px-4 py-3 text-green-700 bg-green-50 font-semibold rounded-xl transition-all">Beranda</a>
                <a href="{{ route('produk.index') }}" class="block px-4 py-3 text-gray-700 hover:text-green-600 font-semibold rounded-xl hover:bg-green-50 transition-all">Produk</a>
                <a href="{{ route('edukasi.index') }}" class="block px-4 py-3 text-gray-700 hover:text-green-600 font-semibold rounded-xl hover:bg-green-50 transition-all">Edukasi</a>
                <a href="#kontak" class="block px-4 py-3 text-gray-700 hover:text-green-600 font-semibold rounded-xl hover:bg-green-50 transition-all">Kontak</a>
                
                <div class="pt-4 border-t border-gray-200 space-y-2">
                    @auth
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:text-green-600 font-semibold rounded-xl hover:bg-green-50 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profil Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 font-semibold rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:text-green-600 font-semibold rounded-xl hover:bg-green-50 transition-all border-2 border-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="flex items-center justify-center gap-3 px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl hover:shadow-lg transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    
    {{-- Hero Section --}}
    <div class="relative min-h-[90vh] flex items-center justify-center overflow-hidden bg-black pt-20">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/90 via-green-700/85 to-teal-800/90 mix-blend-multiply"></div>
        
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-20 left-10 w-72 h-72 bg-green-400 rounded-full mix-blend-overlay filter blur-3xl animate-blob"></div>
            <div class="absolute top-40 right-20 w-72 h-72 bg-emerald-400 rounded-full mix-blend-overlay filter blur-3xl animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-teal-400 rounded-full mix-blend-overlay filter blur-3xl animate-blob animation-delay-4000"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="space-y-8 animate-fade-in-up">
                <div class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 backdrop-blur-xl rounded-full border border-white/20 shadow-2xl">
                    <div class="flex gap-1">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-ping"></span>
                        <span class="w-2 h-2 bg-emerald-400 rounded-full"></span>
                    </div>
                    <span class="text-sm font-medium text-white">Dipercaya oleh 500+ Petani Indonesia</span>
                </div>
                
                <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-black text-white leading-none tracking-tight">
                    <span class="block">AgriSmart</span>
                    <span class="block mt-2 bg-gradient-to-r from-yellow-200 via-green-200 to-emerald-200 bg-clip-text text-transparent">
                        Masa Depan Pertanian
                    </span>
                </h1>
                
                <p class="max-w-3xl mx-auto text-xl sm:text-2xl text-gray-100 font-light leading-relaxed">
                    Menghubungkan petani dengan teknologi modern. Belajar, berkembang, dan jual hasil panen langsung ke konsumen tanpa perantara.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-8">
                    <a href="{{ route('produk.index') }}" 
                       class="group relative px-10 py-5 bg-white text-green-700 font-bold text-lg rounded-full overflow-hidden shadow-2xl hover:shadow-green-500/50 transition-all duration-500 w-full sm:w-auto">
                        <span class="relative z-10 flex items-center justify-center gap-3">
                            Jelajahi Produk
                            <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-400 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></div>
                    </a>
                    
                    <a href="{{ route('edukasi.index') }}" 
                       class="group px-10 py-5 bg-transparent border-2 border-white/30 backdrop-blur-xl text-white font-bold text-lg rounded-full hover:bg-white/10 hover:border-white/50 transition-all duration-300 w-full sm:w-auto flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Tonton Tutorial
                    </a>
                </div>
                
                <div class="pt-16 animate-bounce">
                    <svg class="w-8 h-8 mx-auto text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Bar --}}
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 py-12 shadow-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center transform hover:scale-110 transition-transform duration-300">
                    <div class="text-5xl font-black text-white mb-2">1K+</div>
                    <div class="text-green-100 font-medium text-lg">Produk Premium</div>
                </div>
                <div class="text-center transform hover:scale-110 transition-transform duration-300">
                    <div class="text-5xl font-black text-white mb-2">500+</div>
                    <div class="text-green-100 font-medium text-lg">Petani Aktif</div>
                </div>
                <div class="text-center transform hover:scale-110 transition-transform duration-300">
                    <div class="text-5xl font-black text-white mb-2">100+</div>
                    <div class="text-green-100 font-medium text-lg">Sumber Pembelajaran</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Education Section --}}
    <div class="py-24 bg-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-green-50 to-transparent"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mb-16">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-1 bg-green-600 rounded-full"></div>
                    <span class="text-green-600 font-bold uppercase tracking-wider text-sm">Pusat Pengetahuan</span>
                </div>
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-gray-900 mb-6 leading-tight">Belajar dari yang Terbaik</h2>
                <p class="text-xl text-gray-600 leading-relaxed">Akses konten terpilih dari para ahli pertanian dan tetap update dengan teknik bertani terkini.</p>
            </div>
            
            @if(isset($edukasi) && !$edukasi->isEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($edukasi as $index => $item)
                        <a href="{{ route('edukasi.show', $item->slug) }}" class="group block {{ $index === 0 ? 'md:col-span-2 md:row-span-2' : '' }}">
                            <div class="relative h-full bg-gradient-to-br from-gray-900 to-gray-800 rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                                <div class="relative h-full min-h-[300px] {{ $index === 0 ? 'md:min-h-[600px]' : '' }}">
                                    @if($item->foto_sampul)
                                        <img src="{{ asset('storage/' . $item->foto_sampul) }}" alt="{{ $item->judul }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-40 group-hover:scale-110 transition-all duration-700">
                                    @else
                                        <div class="absolute inset-0 bg-gradient-to-br from-green-600 to-emerald-600 opacity-80"></div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
                                    <div class="absolute inset-0 p-8 flex flex-col justify-end">
                                        <div class="space-y-4">
                                            <div class="flex items-center gap-3">
                                                <span class="px-4 py-1.5 bg-green-500 text-white text-xs font-bold uppercase tracking-wide rounded-full">Edukasi</span>
                                                <span class="text-gray-300 text-sm">{{ $item->created_at->format('d M Y') }}</span>
                                            </div>
                                            <h3 class="text-2xl {{ $index === 0 ? 'lg:text-4xl' : '' }} font-bold text-white leading-tight group-hover:text-green-400 transition-colors">{{ $item->judul }}</h3>
                                            @if($index === 0)
                                                <p class="text-gray-300 text-lg leading-relaxed line-clamp-3">{{ Str::limit(strip_tags($item->isi_konten), 200) }}</p>
                                            @endif
                                            <div class="flex items-center gap-2 text-green-400 font-semibold pt-2">
                                                <span>Baca Selengkapnya</span>
                                                <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-gray-50 rounded-3xl">
                    <div class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <p class="text-gray-500 text-xl font-medium">Konten edukasi akan segera hadir</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Products Section --}}
    <div class="py-24 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center gap-3 px-6 py-3 bg-emerald-100 rounded-full mb-6">
                    <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path></svg>
                    <span class="text-emerald-700 font-bold text-sm uppercase tracking-wide">Pasar Segar</span>
                </div>
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-gray-900 mb-6 leading-tight">Dari Kebun Langsung ke Meja</h2>
                <p class="text-xl text-gray-600">Produk berkualitas premium dengan harga terbaik, langsung dari petani lokal</p>
            </div>
            
            @if(isset($produk) && !$produk->isEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($produk as $item)
                        <div class="group relative">
                            <div class="relative bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-gray-100">
                                <div class="relative aspect-square overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                                    @if($item->foto_produk)
                                        <img src="{{ asset('storage/' . $item->foto_produk) }}" alt="{{ $item->nama_produk }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-green-200 to-emerald-300 flex items-center justify-center">
                                            <svg class="w-24 h-24 text-green-600 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                                        <a href="{{ route('produk.show', $item->id) }}" class="w-full py-3 bg-white text-green-700 font-bold text-center rounded-2xl transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">Lihat Cepat</a>
                                    </div>
                                    <div class="absolute top-4 left-4 right-4 flex justify-between items-start">
                                        <span class="px-4 py-2 bg-green-500 text-white text-xs font-black uppercase rounded-full shadow-xl backdrop-blur-sm">Segar</span>
                                    </div>
                                </div>
                                <div class="p-6 space-y-4">
                                    <div>
                                        <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-lg mb-3">{{ $item->kategoriProduk->nama_kategori }}</span>
                                        <h3 class="text-lg font-bold text-gray-900 leading-snug line-clamp-2 min-h-[3.5rem]">{{ $item->nama_produk }}</h3>
                                    </div>
                                    <div class="flex items-end justify-between pt-2 border-t border-gray-100">
                                        <div>
                                            <div class="text-xs text-gray-500 mb-1">Mulai dari</div>
                                            <div class="text-2xl font-black text-gray-900">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                                        </div>
                                        <a href="{{ route('produk.show', $item->id) }}" class="w-12 h-12 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-2xl flex items-center justify-center hover:shadow-lg hover:scale-110 transition-all duration-300">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-gray-50 rounded-3xl">
                    <div class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-emerald-100 to-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <p class="text-gray-500 text-xl font-medium">Produk akan segera diluncurkan</p>
                </div>
            @endif
        </div>
    </div>

    {{-- CTA Section --}}
    <div class="relative py-32 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-gray-900 via-green-900 to-emerald-900">
            <div class="absolute inset-0 opacity-20 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZ3JpZCIgd2lkdGg9IjEwMCIgaGVpZ2h0PSIxMDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiPjxwYXRoIGQ9Ik0gMTAwIDAgTCAwIDAgMCAxMDAiIGZpbGw9Im5vbmUiIHN0cm9rZT0id2hpdGUiIHN0cm9rZS13aWR0aD0iMSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNncmlkKSIvPjwvc3ZnPg==')]"></div>
        </div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-green-500 rounded-full blur-3xl opacity-20"></div>
        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="space-y-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur-xl rounded-full border-4 border-white/20 mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight">Siap Mentransformasi<br/>Bisnis Pertanian Anda?</h2>
                <p class="text-xl sm:text-2xl text-gray-300 max-w-3xl mx-auto font-light">Bergabunglah dengan ribuan petani yang telah merangkul pertanian digital</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-8">
                    <a href="{{ route('register') }}" class="group relative px-10 py-5 bg-white text-green-700 font-bold text-lg rounded-full overflow-hidden shadow-2xl hover:shadow-green-500/50 transition-all duration-500 w-full sm:w-auto">
                        <span class="relative z-10 flex items-center justify-center gap-3">
                            Daftar Sekarang
                            <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-400 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></div>
                    </a>
                    <a href="{{ route('login') }}" class="group px-10 py-5 bg-transparent border-2 border-white/30 backdrop-blur-xl text-white font-bold text-lg rounded-full hover:bg-white/10 hover:border-white/50 transition-all duration-300 w-full sm:w-auto flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        Sudah Punya Akun?
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    {{-- [KODE BARU] FITUR KONTAK / REQUEST AKUN PETANI --}}
    <div id="kontak" class="py-24 bg-gray-900 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
            <div class="absolute w-96 h-96 bg-green-600 rounded-full mix-blend-multiply filter blur-3xl opacity-10 -top-10 -left-10 animate-blob"></div>
            <div class="absolute w-96 h-96 bg-emerald-600 rounded-full mix-blend-multiply filter blur-3xl opacity-10 bottom-10 right-10 animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                {{-- Teks Info --}}
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-900/50 border border-green-800/50 backdrop-blur-md mb-6">
                        <span class="text-green-400 text-sm font-bold uppercase tracking-wide">Mitra Petani</span>
                    </div>
                    <h2 class="text-3xl md:text-5xl font-black text-white mb-6 leading-tight">
                        Ingin Menjadi<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-500">Mitra Penjual?</span>
                    </h2>
                    <p class="text-gray-400 text-lg mb-8 leading-relaxed">
                        Bergabunglah dengan ekosistem AgriSmart. Daftarkan diri Anda untuk mulai menjual hasil panen langsung ke ribuan konsumen tanpa perantara.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-green-900/50 rounded-xl text-green-400 border border-green-800/50">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-white font-bold text-lg">Verifikasi Cepat</h4>
                                <p class="text-gray-500 text-sm mt-1">Admin kami akan memverifikasi data Anda dalam 1x24 jam.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-green-900/50 rounded-xl text-green-400 border border-green-800/50">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-white font-bold text-lg">Tingkatkan Pendapatan</h4>
                                <p class="text-gray-500 text-sm mt-1">Jual dengan harga pantas tanpa potongan tengkulak.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Formulir Kontak --}}
                <div class="bg-white rounded-3xl p-8 shadow-2xl border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Formulir Pendaftaran</h3>
                    
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 text-green-800 rounded-xl border border-green-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('kontak.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="nama" required class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition" placeholder="Masukkan nama lengkap Anda">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Nomor WhatsApp</label>
                                <input type="text" name="no_hp" required class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition" placeholder="0812...">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition" placeholder="email@anda.com">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Lokasi / Pesan Singkat</label>
                            <textarea name="pesan" rows="3" required class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition" placeholder="Contoh: Saya petani tomat di Lembang, ingin bergabung..."></textarea>
                        </div>

                        <button type="submit" class="w-full py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
                            Kirim Permintaan
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    
    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(20px, -50px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(50px, 50px) scale(1.05); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fade-in-up 1s ease-out; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .aspect-square { aspect-ratio: 1 / 1; }
        @media (prefers-reduced-motion: reduce) {
            .animate-blob, .animate-fade-in-up, .animate-bounce, .animate-ping { animation: none; }
        }
        .navbar-scrolled { background: rgba(255, 255, 255, 0.95); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); }
    </style>
    
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) { navbar.classList.add('navbar-scrolled'); }
            else { navbar.classList.remove('navbar-scrolled'); }
        });
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobileMenu');
            const button = event.target.closest('button');
            if (!menu.contains(event.target) && !button && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });
    </script>
</x-public-layout>