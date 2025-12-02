<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Daftar - AgriSmart</title>

    {{-- FONT: Plus Jakarta Sans --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- AOS Animation --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Animasi Blob */
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
    </style>
</head>

<body class="bg-white min-h-screen flex selection:bg-green-500 selection:text-white overflow-x-hidden">

    {{-- 
        BAGIAN KIRI: FORMULIR 
        - w-full: Penuh di HP
        - lg:w-1/2: Setengah di Laptop
    --}}
    <div class="w-full lg:w-1/2 min-h-screen flex flex-col justify-center px-5 sm:px-8 md:px-12 lg:px-16 xl:px-24 py-8 relative z-10 bg-white">
        
        {{-- Dekorasi Blob Background (Versi Mobile Lebih Kecil) --}}
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none opacity-40">
            <div class="absolute top-0 -left-10 w-40 h-40 md:w-64 md:h-64 bg-green-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
            <div class="absolute top-0 right-0 w-40 h-40 md:w-64 md:h-64 bg-emerald-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-0 left-10 w-40 h-40 md:w-64 md:h-64 bg-teal-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>
        </div>

        {{-- Konten Formulir --}}
        <div class="relative w-full" data-aos="fade-right" data-aos-duration="1000">
            
            {{-- Header --}}
            <div class="mb-6 md:mb-8">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-50 rounded-full text-green-700 mb-3 md:mb-4 border border-green-100">
                    <span class="text-[10px] md:text-xs font-bold uppercase tracking-widest">Pembeli Baru</span>
                </div>
                {{-- Ukuran Font Responsif: text-2xl di HP, text-4xl di PC --}}
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 mb-2 tracking-tight">
                    Buat Akun <span class="text-green-600">AgriSmart</span>
                </h1>
                <p class="text-slate-500 text-sm md:text-base font-medium">Belanja hasil panen segar langsung dari petani.</p>
            </div>

            {{-- Error Message --}}
            @if ($errors->any())
                <div class="mb-5 md:mb-6 p-3 md:p-4 bg-red-50 text-red-700 rounded-xl md:rounded-2xl flex items-start gap-3 text-xs md:text-sm border border-red-100">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <ul class="list-disc list-inside font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM --}}
            <form action="{{ route('register') }}" method="POST" class="space-y-4 md:space-y-5">
                @csrf
                
                {{-- Nama Lengkap --}}
                <div class="group">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5 md:mb-2 ml-1">Nama Lengkap</label>
                    <div class="relative">
                        <input type="text" name="name" required
                            class="w-full pl-11 pr-4 py-3 md:py-3.5 rounded-xl md:rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 text-sm md:text-base font-medium placeholder-slate-400"
                            placeholder="Nama Lengkap Anda">
                        <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>

                {{-- Email --}}
                <div class="group">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5 md:mb-2 ml-1">Email</label>
                    <div class="relative">
                        <input type="email" name="email" required
                            class="w-full pl-11 pr-4 py-3 md:py-3.5 rounded-xl md:rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 text-sm md:text-base font-medium placeholder-slate-400"
                            placeholder="nama@email.com">
                        <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                    </div>
                </div>

                {{-- Grid Password: 1 Kolom di HP, 2 Kolom di Desktop --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
                    {{-- Password --}}
                    <div class="group">
                        <label class="block text-sm font-bold text-slate-700 mb-1.5 md:mb-2 ml-1">Kata Sandi</label>
                        <div class="relative">
                            <input type="password" name="password" required
                                class="w-full pl-11 pr-4 py-3 md:py-3.5 rounded-xl md:rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 text-sm md:text-base font-medium placeholder-slate-400"
                                placeholder="••••••••">
                            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="group">
                        <label class="block text-sm font-bold text-slate-700 mb-1.5 md:mb-2 ml-1">Ulangi Sandi</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" required
                                class="w-full pl-11 pr-4 py-3 md:py-3.5 rounded-xl md:rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 text-sm md:text-base font-medium placeholder-slate-400"
                                placeholder="••••••••">
                            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Alert Info Petani --}}
                <div class="bg-blue-50 border border-blue-100 rounded-xl md:rounded-2xl p-3 md:p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-xs sm:text-sm text-blue-700 font-medium leading-relaxed">
                        Ingin daftar sebagai <strong>Petani</strong>? Hubungi Admin untuk verifikasi.
                    </p>
                </div>

                {{-- Tombol Submit --}}
                <div class="pt-2">
                    <button type="submit" class="group w-full py-3.5 md:py-4 bg-green-600 text-white font-bold rounded-xl md:rounded-2xl hover:bg-green-700 shadow-lg shadow-green-600/30 hover:shadow-green-600/50 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2 text-sm md:text-base">
                        <span>Daftar Sekarang</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </button>
                </div>
            </form>

            {{-- Footer Link --}}
            <div class="mt-6 md:mt-8 text-center pt-5 md:pt-6 border-t border-slate-100">
                <p class="text-slate-500 text-xs md:text-sm font-medium">Sudah punya akun?</p>
                <a href="{{ route('login') }}" class="inline-block mt-2 text-green-600 text-sm md:text-base font-bold hover:text-green-800 transition-colors hover:underline decoration-2 underline-offset-4">
                    Masuk ke Akun
                </a>
            </div>
        </div>
    </div>

    {{-- 
        BAGIAN KANAN: GAMBAR & DEKORASI 
        - hidden: Hilang di HP
        - lg:flex: Muncul di Laptop
    --}}
    <div class="hidden lg:flex lg:w-1/2 relative bg-green-900 items-center justify-center overflow-hidden">
        
        {{-- Background Image --}}
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?q=80&w=1000&auto=format&fit=crop" 
                 alt="Pertanian Modern" 
                 class="w-full h-full object-cover opacity-60 mix-blend-overlay">
        </div>

        {{-- Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-br from-green-600/90 to-teal-900/90 mix-blend-multiply"></div>

        {{-- Dekorasi Pattern --}}
        <div class="absolute inset-0 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:32px_32px] opacity-10"></div>

        {{-- Teks Sambutan di Kanan --}}
        <div class="relative z-10 max-w-lg px-12 text-center" data-aos="fade-up" data-aos-delay="200">
            <div class="w-20 h-20 bg-white/10 backdrop-blur-md rounded-3xl mx-auto flex items-center justify-center mb-8 border border-white/20 shadow-2xl">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-4xl font-extrabold text-white mb-6 leading-tight">
                Bergabung dengan Ekosistem <br> <span class="text-green-300">Pertanian Cerdas</span>
            </h2>
            <p class="text-green-50 text-lg leading-relaxed font-medium opacity-90">
                "Dukung petani lokal dan dapatkan hasil panen berkualitas terbaik langsung dari sumbernya."
            </p>
        </div>
    </div>

    {{-- Script AOS --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            disable: 'mobile' 
        });
    </script>
</body>
</html>