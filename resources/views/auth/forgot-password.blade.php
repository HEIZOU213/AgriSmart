<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Lupa Kata Sandi - AgriSmart</title>
    <x-favicon />

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
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f0fdf4; }
        ::-webkit-scrollbar-thumb { background: #16a34a; border-radius: 5px; border: 2px solid #f0fdf4; }
        ::-webkit-scrollbar-thumb:hover { background: #15803d; }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .focus-visible { outline: 2px solid #10b981; outline-offset: 2px; }
        @media (max-width: 640px) { .touch-target { min-height: 44px; min-width: 44px; } }
    </style>
</head>

<body class="bg-white h-screen overflow-hidden selection:bg-green-500 selection:text-white antialiased">
    <x-preloader />

    <div class="flex flex-col lg:flex-row w-full relative">

        <div class="w-full lg:w-1/2 flex flex-col justify-center px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 py-6 sm:py-8 md:py-10 lg:py-12 h-screen relative z-10 bg-white">
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none opacity-25 sm:opacity-30">
                <div class="absolute -top-8 -left-8 w-32 h-32 sm:w-40 sm:h-40 md:w-48 md:h-48 lg:w-64 lg:h-64 bg-green-100 rounded-full mix-blend-multiply filter blur-2xl sm:blur-3xl opacity-50 animate-blob"></div>
                <div class="absolute -top-4 right-4 w-28 h-28 sm:w-36 sm:h-36 md:w-40 md:h-40 lg:w-56 lg:h-56 bg-emerald-100 rounded-full mix-blend-multiply filter blur-2xl sm:blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
                <div class="absolute bottom-8 left-1/4 w-32 h-32 sm:w-36 sm:h-36 md:w-44 md:h-44 lg:w-60 lg:h-60 bg-teal-100 rounded-full mix-blend-multiply filter blur-2xl sm:blur-3xl opacity-50 animate-blob animation-delay-4000"></div>
            </div>

            <div class="relative w-full max-w-md mx-auto" data-aos="fade-right" data-aos-duration="1000">
                {{-- Logo (Bisa di-klik ke beranda) --}}
                <div class="text-center mb-2">
                    <a href="{{ route('homepage') }}" class="inline-block hover:scale-105 transition-transform duration-300">
                        <div class="relative z-10 w-32 mx-auto flex items-center justify-center drop-shadow-md">
                            <img src="{{ asset('images/nav-logo.png') }}" alt="AgriSmart" class="w-full h-auto object-contain">
                        </div>
                    </a>
                    <p class="text-xs sm:text-sm font-semibold text-slate-400 tracking-widest uppercase mt-1">Lupa Kata Sandi</p>
                    <p class="mt-1 text-xs text-slate-500 font-medium max-w-xs mx-auto">
                        Jangan khawatir. Masukkan email, kami akan mengirimkan OTP untuk atur ulang kata sandi.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-red-50 text-red-700 rounded-lg sm:rounded-xl flex items-start gap-2 sm:gap-3 text-xs sm:text-sm border border-red-100">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="space-y-0.5 sm:space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @if (session('success'))
                    <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-green-50 text-green-700 rounded-lg sm:rounded-xl flex items-start gap-2 sm:gap-3 text-xs sm:text-sm border border-green-100">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST" class="space-y-4 sm:space-y-5">
                    @csrf
                    <div class="space-y-1.5 sm:space-y-2">
                        <label for="email" class="block text-sm font-semibold text-slate-700">Email</label>
                        <div class="relative">
                            <input type="email" name="email" id="email" required
                                class="w-full pl-10 sm:pl-12 pr-3 sm:pr-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 text-sm sm:text-base font-medium placeholder-slate-400 touch-target"
                                placeholder="nama@email.com" autocomplete="email" value="{{ old('email') }}">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400 absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="pt-1 sm:pt-2">
                        <button type="submit" class="w-full py-3 sm:py-3.5 bg-green-600 text-white font-bold rounded-lg sm:rounded-xl hover:bg-green-700 shadow-lg shadow-green-600/20 hover:shadow-green-600/30 active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2 text-sm sm:text-base touch-target">
                            <span>Kirim Kode OTP</span>
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                <div class="mt-6 sm:mt-8 text-center pt-4 sm:pt-6 border-t border-slate-100">
                    <p class="text-slate-500 text-xs sm:text-sm font-medium">Ingat kata sandi Anda?</p>
                    <a href="{{ route('login') }}" class="inline-block mt-1.5 sm:mt-2 text-green-600 font-bold hover:text-green-800 transition-colors hover:underline text-sm sm:text-base touch-target">
                        Kembali ke Masuk
                    </a>
                </div>
            </div>
        </div>

        <div class="hidden lg:flex fixed top-0 right-0 w-1/2 h-screen relative bg-white items-center justify-center overflow-hidden z-20">
            <div class="absolute inset-0 bg-gradient-to-tr from-green-50/50 to-white"></div>
            <div class="absolute inset-0 opacity-10">
                <img src="{{ asset('images/logo2.png') }}" alt="AgriSmart Pattern" class="w-full h-full object-cover">
            </div>
            <div class="relative z-10 max-w-md px-6 lg:px-10 xl:px-12 text-center" data-aos="fade-up" data-aos-delay="200">
                <h2 class="text-2xl lg:text-3xl xl:text-4xl font-bold text-slate-900 mb-4 lg:mb-5 leading-snug">
                    Pemulihan <br> <span class="text-green-600">Akses Cepat</span>
                </h2>
                <p class="text-slate-500 text-base lg:text-lg leading-relaxed font-medium opacity-95">
                    "Kami memastikan keamanan data Anda tetap terjaga dengan verifikasi OTP yang aman dan andal."
                </p>
            </div>
        </div>

    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.addEventListener('touchstart', function (event) {
                if (event.target.tagName === 'INPUT' || event.target.tagName === 'TEXTAREA') {
                    event.target.style.fontSize = '16px';
                }
            });
        });
        AOS.init({ once: true, disable: 'mobile' });
    </script>
</body>
</html>


