<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $produk->nama_produk }} - AgriSmart</title>

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

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f0fdf4; }
        ::-webkit-scrollbar-thumb { background: #16a34a; border-radius: 4px; }
    </style>
</head>

<body class="font-sans antialiased text-slate-700 bg-green-50 flex flex-col min-h-screen selection:bg-green-500 selection:text-white">

<x-navbar />

    {{-- MAIN CONTENT --}}
    <main class="flex-1 pt-24 pb-12 relative overflow-hidden">
        
        {{-- BACKGROUND DECORATIONS --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute top-20 left-10 w-72 h-72 bg-green-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-20 right-10 w-72 h-72 bg-emerald-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-lime-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            {{-- TOMBOL KEMBALI --}}
            <div class="mb-6">
                <a href="{{ route('produk.index') }}" class="group inline-flex items-center text-slate-500 hover:text-green-600 font-medium transition-all duration-300">
                    <div class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center shadow-sm group-hover:bg-green-600 group-hover:border-green-600 group-hover:text-white transition-all mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </div>
                    <span class="text-sm">Kembali ke Daftar Produk</span>
                </a>
            </div>

            {{-- FLASH MESSAGE --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded-2xl flex justify-between items-center shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-green-600 hover:text-green-800"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl flex justify-between items-center shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-red-600 hover:text-red-800"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @endif

            {{-- MAIN PRODUCT CARD --}}
            <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-0 md:gap-8">

                    {{-- KOLOM KIRI: GAMBAR (Lebar 5/12) --}}
                    <div class="md:col-span-5 bg-slate-50 relative group p-6 md:p-8 flex items-center justify-center">
                        <div class="relative w-full aspect-square rounded-2xl overflow-hidden shadow-lg border border-slate-200 bg-white">
                            @if($produk->foto_produk)
                                <img src="{{ asset('storage/' . $produk->foto_produk) }}" 
                                     alt="{{ $produk->nama_produk }}" 
                                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 bg-slate-50">
                                    <svg class="w-20 h-20 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm font-medium">Gambar Tidak Tersedia</span>
                                </div>
                            @endif

                            {{-- Badge Kategori --}}
                            <div class="absolute top-4 left-4">
                                <span class="px-4 py-1.5 bg-green-600 text-white text-xs font-bold uppercase tracking-wider rounded-lg shadow-md">
                                    {{ $produk->kategoriProduk->nama_kategori ?? 'Umum' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: DETAIL (Lebar 7/12) --}}
                    <div class="md:col-span-7 p-6 md:p-10 flex flex-col justify-between">
                        <div>
                            {{-- Header Title & Price --}}
                            <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-6">
                                <div>
                                    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight mb-2">
                                        {{ $produk->nama_produk }}
                                    </h1>
                                    {{-- Fake Rating --}}
                                    <div class="flex items-center gap-2">
                                        
                                        <span class="text-sm text-slate-400 font-medium">(Produk Terbaru)</span>
                                    </div>
                                </div>
                                <div class="text-left sm:text-right">
                                    <p class="text-sm text-slate-400 mb-1">Harga per {{ $produk->satuan ?? 'kg' }}</p>
                                    <p class="text-3xl font-bold text-green-600 tracking-tight">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Separator --}}
                            <div class="h-px bg-slate-100 w-full mb-6"></div>

                            {{-- INFORMASI PENJUAL (Card Style) --}}
                            <div class="bg-white border border-slate-200 rounded-xl p-4 mb-6 shadow-sm hover:shadow-md transition-shadow">
                                <h3 class="text-xs font-bold text-green-600 uppercase tracking-wider mb-3">Informasi Petani / Penjual</h3>
                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0">
                                        @if(isset($produk->user->foto_profil) && $produk->user->foto_profil)
                                            <img class="h-14 w-14 rounded-full object-cover border-2 border-green-100" src="{{ asset('storage/' . $produk->user->foto_profil) }}" alt="{{ $produk->user->name }}">
                                        @else
                                            <div class="h-14 w-14 rounded-full bg-green-100 flex items-center justify-center text-green-600 border-2 border-white">
                                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-base font-bold text-slate-900">{{ $produk->user->name ?? 'AgriSmart Member' }}</p>
                                        <div class="flex items-center mt-1 text-sm text-slate-500">
                                            <svg class="w-4 h-4 text-red-500 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            {{ $produk->user->alamat ?? 'Lokasi tidak tersedia' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-8">
                                <h3 class="text-sm font-bold text-slate-900 mb-2">Deskripsi Produk</h3>
                                <div class="prose prose-sm prose-green text-slate-600 leading-relaxed">
                                    <p>{{ $produk->deskripsi }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- ACTION SECTION (Cart Form) --}}
                        <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200">
                            <form action="{{ route('cart.store', $produk->id) }}" method="POST">
                                @csrf
                                <div class="flex flex-col sm:flex-row items-end gap-4">
                                    
                                    {{-- Input Jumlah --}}
                                    <div class="w-full sm:w-1/3">
                                        <label for="jumlah" class="block text-xs font-bold text-slate-500 uppercase mb-2">Jumlah ({{ $produk->satuan ?? 'kg' }})</label>
                                        <div class="relative flex items-center">
                                            <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="absolute left-0 w-10 h-full text-slate-500 hover:text-green-600 bg-transparent rounded-l-lg">
                                                -
                                            </button>
                                            <input type="number" id="jumlah" name="jumlah" value="1" min="1" max="{{ $produk->stok }}" 
                                                   class="w-full pl-10 pr-10 border-slate-300 rounded-xl shadow-sm focus:border-green-500 focus:ring-green-500 text-center font-bold text-lg h-12">
                                            <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="absolute right-0 w-10 h-full text-slate-500 hover:text-green-600 bg-transparent rounded-r-lg">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                    
                                    {{-- Tombol Beli --}}
                                    <div class="w-full sm:w-2/3">
                                        <button type="submit" 
                                                class="w-full flex justify-center items-center h-12 px-6 rounded-xl shadow-lg shadow-green-600/30 text-base font-bold text-white transition-all duration-300 
                                                {{ $produk->stok > 0 ? 'bg-green-600 hover:bg-green-700 hover:scale-[1.02] active:scale-95' : 'bg-slate-400 cursor-not-allowed' }}"
                                                {{ $produk->stok <= 0 ? 'disabled' : '' }}>
                                            
                                            @if($produk->stok > 0)
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                + Keranjang
                                            @else
                                                Stok Habis
                                            @endif
                                        </button>
                                    </div>
                                </div>
                                
                                {{-- Status Stok --}}
                                <div class="mt-4 flex items-center justify-between sm:justify-start sm:gap-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $produk->stok > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        <span class="w-2 h-2 rounded-full mr-2 {{ $produk->stok > 0 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                        {{ $produk->stok > 0 ? 'Stok Tersedia: ' . $produk->stok . ' ' . ($produk->satuan ?? 'kg') : 'Stok Habis' }}
                                    </span>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-white border-t border-slate-100 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-sm text-slate-500">
                &copy; {{ date('Y') }} <span class="text-green-600 font-bold">AgriSmart</span>. All Rights Reserved.
            </p>
        </div>
    </footer>

</body>
</html>