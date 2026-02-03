<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Masuk - AgriSmart</title>

    {{-- FONT: Plus Jakarta Sans --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- AOS Animation --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            /* Hapus overflow-hidden agar scrollbar browser tetap muncul di kanan */
        }

        /* Animasi Blob */
        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        /* Scrollbar Custom */
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

        .focus-visible {
            outline: 2px solid #10b981;
            outline-offset: 2px;
        }

        @media (max-width: 640px) {
            .touch-target {
                min-height: 44px;
                min-width: 44px;
            }
        }
    </style>
</head>

{{-- Hapus 'h-screen' dan 'overflow-hidden' agar scrollbar browser berfungsi normal --}}

<body class="bg-white min-h-screen selection:bg-green-500 selection:text-white antialiased">

    {{-- WRAPPER UTAMA --}}
    <div class="flex flex-col lg:flex-row w-full relative">

        {{--
        BAGIAN KIRI: FORM LOGIN
        - Tetap mengalir natural (flow normal).
        - Jika konten panjang, body akan memanjang dan memunculkan scrollbar di kanan window.
        --}}
        <div
            class="w-full lg:w-1/2 flex flex-col justify-center px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 py-6 sm:py-8 md:py-10 lg:py-12 min-h-screen relative z-10 bg-white">

            {{-- Dekorasi Blob Background --}}
            <div
                class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none opacity-25 sm:opacity-30">
                <div
                    class="absolute -top-8 -left-8 w-32 h-32 sm:w-40 sm:h-40 md:w-48 md:h-48 lg:w-64 lg:h-64 bg-green-100 rounded-full mix-blend-multiply filter blur-2xl sm:blur-3xl opacity-50 animate-blob">
                </div>
                <div
                    class="absolute -top-4 right-4 w-28 h-28 sm:w-36 sm:h-36 md:w-40 md:h-40 lg:w-56 lg:h-56 bg-emerald-100 rounded-full mix-blend-multiply filter blur-2xl sm:blur-3xl opacity-50 animate-blob animation-delay-2000">
                </div>
                <div
                    class="absolute bottom-8 left-1/4 w-32 h-32 sm:w-36 sm:h-36 md:w-44 md:h-44 lg:w-60 lg:h-60 bg-teal-100 rounded-full mix-blend-multiply filter blur-2xl sm:blur-3xl opacity-50 animate-blob animation-delay-4000">
                </div>
            </div>

            {{-- Konten Formulir --}}
            <div class="relative w-full max-w-md mx-auto" data-aos="fade-right" data-aos-duration="1000">

                {{-- Logo & Header --}}
                <div class="text-center mb-6 sm:mb-8 md:mb-10">
                    <h1
                        class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 mb-2 sm:mb-3 tracking-tight leading-tight">
                        Masuk ke <span class="text-green-600">AgriSmart</span>
                    </h1>
                    <p class="text-slate-500 text-sm sm:text-base font-medium max-w-xs mx-auto px-2 sm:px-0">
                        Kelola pertanian cerdas Anda dalam satu genggaman.
                    </p>
                </div>

                {{-- Error Message --}}
                @if ($errors->any())
                    <div
                        class="mb-4 sm:mb-6 p-3 sm:p-4 bg-red-50 text-red-700 rounded-lg sm:rounded-xl flex items-start gap-2 sm:gap-3 text-xs sm:text-sm border border-red-100">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <ul class="space-y-0.5 sm:space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORM LOGIN --}}
                {{-- PERUBAHAN: Action diganti ke login.otp.step1 --}}
                <form action="{{ route('login.otp.step1') }}" method="POST" class="space-y-4 sm:space-y-5">
                    @csrf

                    {{-- Input Email --}}
                    <div class="space-y-1.5 sm:space-y-2">
                        <label for="email" class="block text-sm font-semibold text-slate-700">Email</label>
                        <div class="relative">
                            <input type="email" name="email" id="email" required
                                class="w-full pl-10 sm:pl-12 pr-3 sm:pr-4 py-2.5 sm:py-3 rounded-lg sm:rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 text-sm sm:text-base font-medium placeholder-slate-400 touch-target"
                                placeholder="nama@email.com" autocomplete="email">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400 absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                </path>
                            </svg>
                        </div>
                    </div>

                    {{-- Input Password --}}
                    <div class="space-y-1.5 sm:space-y-2">
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-semibold text-slate-700">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-xs sm:text-sm font-medium text-green-600 hover:text-green-700 hover:underline">
                                    Lupa Sandi?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <input type="password" name="password" id="password" required
                                class="w-full pl-10 sm:pl-12 pr-12 sm:pr-14 py-2.5 sm:py-3 rounded-lg sm:rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 text-sm sm:text-base font-medium placeholder-slate-400 touch-target"
                                placeholder="••••••••" autocomplete="current-password">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400 absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>

                            <button type="button" id="togglePassword"
                                class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-green-600 transition-colors duration-300 focus:outline-none rounded-full p-1 touch-target">
                                <svg id="eyeIcon" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeSlashIcon" class="w-4 h-4 sm:w-5 sm:h-5 hidden" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Tombol Login --}}
                    <div class="pt-1 sm:pt-2">
                        <button type="submit"
                            class="w-full py-3 sm:py-3.5 bg-green-600 text-white font-bold rounded-lg sm:rounded-xl hover:bg-green-700 shadow-lg shadow-green-600/20 hover:shadow-green-600/30 active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2 text-sm sm:text-base touch-target">
                            <span>Masuk Sekarang</span>
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-0.5 transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                {{-- Separator --}}
                <div class="mt-4 sm:mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200"></div>
                        </div>
                        <div class="relative flex justify-center text-xs sm:text-sm">
                            <span class="bg-white px-3 sm:px-4 text-slate-500 font-medium">ATAU</span>
                        </div>
                    </div>
                </div>

                {{-- Tombol Google --}}
                <div class="mt-4 sm:mt-6">
                    <a href="{{ route('socialite.google.redirect') }}"
                        class="w-full flex items-center justify-center gap-2 sm:gap-3 px-3 sm:px-4 py-2.5 sm:py-3 border border-slate-200 rounded-lg sm:rounded-xl shadow-sm text-sm sm:text-base font-semibold text-slate-700 bg-white hover:bg-slate-50 active:scale-[0.98] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 touch-target">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22.56 12.25c0-.78-.1-1.53-.27-2.25H12v4.26h5.92c-.32 1.5-1.17 2.77-2.48 3.52v3.12h4.02c2.35-2.17 3.7-5.37 3.7-9.65z"
                                fill="#4285F4" />
                            <path
                                d="M12 23c3.34 0 6.14-1.1 8.19-2.99l-4.02-3.12c-1.1.74-2.51 1.18-4.17 1.18-3.2 0-5.91-2.16-6.88-5.06H1.07v3.21C3.18 20.53 7.24 23 12 23z"
                                fill="#34A853" />
                            <path
                                d="M5.12 14.12c-.25-.73-.39-1.52-.39-2.32s.14-1.59.39-2.32V6.27H1.07A11.51 11.51 0 0 0 0 11.8c0 1.86.36 3.62 1.07 5.21l4.05-3.15z"
                                fill="#FBBC05" />
                            <path
                                d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.44-3.44C18.14 1.09 15.34 0 12 0 7.24 0 3.18 2.47 1.07 6.27l4.05 3.15c.97-2.9 3.68-5.06 6.88-5.06z"
                                fill="#EA4335" />
                        </svg>
                        <span class="truncate">Masuk dengan Google</span>
                    </a>
                </div>

                {{-- Footer Link --}}
                <div class="mt-6 sm:mt-8 text-center pt-4 sm:pt-6 border-t border-slate-100">
                    <p class="text-slate-500 text-xs sm:text-sm font-medium">Belum punya akun?</p>
                    <a href="{{ route('register') }}"
                        class="inline-block mt-1.5 sm:mt-2 text-green-600 font-bold hover:text-green-800 transition-colors hover:underline text-sm sm:text-base touch-target">
                        Buat Akun Baru
                    </a>
                </div>
            </div>
        </div>

        {{--
        BAGIAN KANAN: GAMBAR & DEKORASI
        - Perubahan KUNCI ada di sini:
        - 'fixed': Agar dia menempel di layar dan tidak ikut scroll.
        - 'right-0 top-0': Menempel di pojok kanan atas.
        - 'h-screen': Tingginya selalu full layar.
        - 'w-1/2': Lebarnya setengah layar.
        --}}
        <div
            class="hidden lg:flex fixed top-0 right-0 w-1/2 h-screen relative bg-white items-center justify-center overflow-hidden z-20">

            {{-- Soft Radial Gradient Background for Clean Look --}}
            <div class="absolute inset-0 bg-gradient-to-tr from-green-50/50 to-white"></div>

            {{-- Subtle Background Image --}}
            <div class="absolute inset-0 opacity-10">
                <img src="images/logo2.png" alt="AgriSmart Pattern" class="w-full h-full object-cover">
            </div>

            {{-- Teks Sambutan di Kanan --}}
            <div class="relative z-10 max-w-md px-6 lg:px-10 xl:px-12 text-center" data-aos="fade-up"
                data-aos-delay="200">
                <h2 class="text-2xl lg:text-3xl xl:text-4xl font-bold text-slate-900 mb-4 lg:mb-5 leading-snug">
                    Selamat Datang di <br> <span class="text-green-600">AgriSmart</span>
                </h2>
                <p class="text-slate-500 text-base lg:text-lg leading-relaxed font-medium opacity-95">
                    "Konektivitas, Data, dan Produktivitas. Solusi pertanian cerdas terintegrasi dari hulu ke hilir."
                </p>
            </div>
        </div>

    </div>

    {{-- Script AOS --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');

            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                if (type === 'text') {
                    eyeIcon.classList.add('hidden');
                    eyeSlashIcon.classList.remove('hidden');
                    eyeSlashIcon.classList.add('text-green-600');
                    eyeSlashIcon.classList.remove('text-slate-400');
                } else {
                    eyeIcon.classList.remove('hidden');
                    eyeSlashIcon.classList.add('hidden');
                    eyeIcon.classList.remove('text-green-600');
                    eyeIcon.classList.add('text-slate-400');
                }
            });

            togglePassword.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    togglePassword.click();
                }
            });

            document.addEventListener('touchstart', function (event) {
                if (event.target.tagName === 'INPUT' || event.target.tagName === 'TEXTAREA') {
                    event.target.style.fontSize = '16px';
                }
            });
        });

        AOS.init({
            once: true,
            disable: 'mobile'
        });
    </script>
</body>

</html>