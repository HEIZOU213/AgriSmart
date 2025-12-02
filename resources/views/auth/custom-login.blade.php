<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Masuk - AgriSmart</title>

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
        
        {{-- Dekorasi Blob Background (Hanya di sisi kiri) --}}
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
                    <span class="text-[10px] md:text-xs font-bold uppercase tracking-widest">Selamat Datang</span>
                </div>
                {{-- Font Responsif --}}
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 mb-2 tracking-tight">
                    Masuk ke <span class="text-green-600">AgriSmart</span>
                </h1>
                <p class="text-slate-500 text-sm md:text-base font-medium">Kelola pertanian cerdas Anda dalam satu genggaman.</p>
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

            {{-- FORM LOGIN --}}
            <form action="{{ route('login') }}" method="POST" class="space-y-4 md:space-y-5">
                @csrf
                
                {{-- Input Email --}}
                <div class="group">
                    <label for="email" class="block text-sm font-bold text-slate-700 mb-1.5 md:mb-2 ml-1">Email</label>
                    <div class="relative">
                        <input type="email" name="email" id="email" required
                            class="w-full pl-11 pr-4 py-3 md:py-3.5 rounded-xl md:rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 text-sm md:text-base font-medium placeholder-slate-400"
                            placeholder="nama@email.com">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                    </div>
                </div>

                {{-- Input Password --}}
                <div class="group">
                    <div class="flex items-center justify-between mb-1.5 md:mb-2 ml-1">
                        <label for="password" class="block text-sm font-bold text-slate-700">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-bold text-green-600 hover:text-green-700 hover:underline">Lupa Sandi?</a>
                        @endif
                    </div>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="w-full pl-11 pr-4 py-3 md:py-3.5 rounded-xl md:rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 text-sm md:text-base font-medium placeholder-slate-400"
                            placeholder="••••••••">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                </div>

                {{-- Tombol Login --}}
                <div class="pt-2">
                    <button type="submit" class="group w-full py-3.5 md:py-4 bg-green-600 text-white font-bold rounded-xl md:rounded-2xl hover:bg-green-700 shadow-lg shadow-green-600/30 hover:shadow-green-600/50 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2 text-sm md:text-base">
                        <span>Masuk Sekarang</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </div>
            </form>

            {{-- Footer Link --}}
            <div class="mt-6 md:mt-8 text-center pt-5 md:pt-6 border-t border-slate-100">
                <p class="text-slate-500 text-xs md:text-sm font-medium">Belum punya akun?</p>
                <a href="{{ route('register') }}" class="inline-block mt-2 text-green-600 text-sm md:text-base font-bold hover:text-green-800 transition-colors hover:underline decoration-2 underline-offset-4">
                    Buat Akun Baru
                </a>
            </div>
        </div>
    </div>

    {{-- 
        BAGIAN KANAN: GAMBAR & DEKORASI 
        - hidden: Hilang total di HP (supaya form full screen)
        - lg:flex: Muncul hanya di layar besar (Laptop/PC)
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
            </div>
            <h2 class="text-4xl font-extrabold text-white mb-6 leading-tight">
                Selamat Datang di <br> <span class="text-green-300">AgriSmart</span>
            </h2>
            <p class="text-green-50 text-lg leading-relaxed font-medium opacity-90">
                "Pantau lahan, pasar, dan hasil panen Anda secara realtime dengan teknologi AgriSmart."
            </p>

            {{-- Slider Dots --}}
            <div class="flex justify-center gap-2 mt-8">
                <div class="w-8 h-2 bg-white rounded-full"></div>
                <div class="w-2 h-2 bg-white/30 rounded-full"></div>
                <div class="w-2 h-2 bg-white/30 rounded-full"></div>
            </div>
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