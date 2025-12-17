<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0">
    <title>Daftar - AgriSmart</title>

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
            /* Pastikan overflow-x hidden untuk menghindari horizontal scroll yg tidak perlu */
            overflow-x: hidden;
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

        /* Password match indicator - Hanya hijau ketika cocok */
        .password-match {
            border-color: #10b981 !important;
            background-color: #f0fdf4 !important;
        }

        /* Toggle password icon styling */
        .toggle-password {
            transition: color 0.2s ease;
        }

        .toggle-password:hover {
            color: #059669;
        }

        @media (max-width: 640px) {
            .touch-target {
                min-height: 44px;
                min-width: 44px;
            }

            .register-container {
                padding-top: 1.5rem;
                padding-bottom: 1.5rem;
            }
        }
    </style>
</head>

{{--
PERUBAHAN 1:
- Hapus class 'flex flex-col lg:flex-row' dari body.
- Kita pindahkan struktur flex ke dalam wrapper div baru agar layout fixed bekerja benar.
--}}

<body class="bg-white min-h-screen selection:bg-green-500 selection:text-white antialiased">

    {{-- WRAPPER UTAMA --}}
    <div class="flex flex-col lg:flex-row w-full relative">

        {{-- BAGIAN KIRI: FORM REGISTER (Flow Normal, Scrollbar Browser) --}}
        <div
            class="w-full lg:w-1/2 flex flex-col justify-center px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 py-4 sm:py-6 md:py-8 lg:py-10 register-container relative z-10 bg-white min-h-screen">

            {{-- Dekorasi Blob Background --}}
            <div
                class="blob-container absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none opacity-25 sm:opacity-30">
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
            <div class="relative w-full max-w-md mx-auto form-content" data-aos="fade-right" data-aos-duration="1000">

                {{-- Logo & Header --}}
                <div class="text-center mb-4 sm:mb-6 md:mb-8">
                    <h1
                        class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 mb-2 sm:mb-3 tracking-tight leading-tight">
                        Daftar ke <span class="text-green-600">AgriSmart</span>
                    </h1>
                    <p class="text-slate-500 text-sm sm:text-base font-medium max-w-xs mx-auto px-2 sm:px-0">
                        Kelola pertanian cerdas Anda dalam satu genggaman.
                    </p>
                </div>

                {{-- Error Message --}}
                @if ($errors->any())
                    <div
                        class="mb-3 sm:mb-4 p-3 bg-red-50 text-red-700 rounded-lg flex items-start gap-2 text-xs sm:text-sm border border-red-100">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <ul class="space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORM REGISTER --}}
                <form action="{{ route('register') }}" method="POST" class="space-y-3 sm:space-y-4" id="registerForm">
                    @csrf

                    {{-- Input Nama Lengkap --}}
                    <div class="space-y-1.5">
                        <label for="name" class="block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                        <div class="relative">
                            <input type="text" name="name" id="name" required
                                class="w-full pl-10 sm:pl-12 pr-3 py-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 text-sm sm:text-base font-medium placeholder-slate-400 touch-target"
                                placeholder="Nama Lengkap Anda" autocomplete="name" value="{{ old('name') }}">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400 absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>

                    {{-- Input Email --}}
                    <div class="space-y-1.5">
                        <label for="email" class="block text-sm font-semibold text-slate-700">Email</label>
                        <div class="relative">
                            <input type="email" name="email" id="email" required
                                class="w-full pl-10 sm:pl-12 pr-3 py-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 text-sm sm:text-base font-medium placeholder-slate-400 touch-target"
                                placeholder="nama@email.com" autocomplete="email" value="{{ old('email') }}">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400 absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                </path>
                            </svg>
                        </div>
                    </div>

                    {{-- Grid Password --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        {{-- Input Password --}}
                        <div class="space-y-1.5">
                            <label for="password" class="block text-sm font-semibold text-slate-700">Kata Sandi</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required
                                    class="password-field w-full pl-10 sm:pl-12 pr-12 sm:pr-14 py-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 text-sm sm:text-base font-medium placeholder-slate-400 touch-target"
                                    placeholder="••••••••" autocomplete="new-password">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400 absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                {{-- Toggle Password Button --}}
                                <button type="button" data-toggle="password"
                                    class="toggle-password absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-green-600 transition-colors duration-200 focus:outline-none rounded-full p-1 touch-target">
                                    <svg class="eye-icon w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg class="eye-slash-icon w-4 h-4 sm:w-5 sm:h-5 hidden" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Input Konfirmasi Password --}}
                        <div class="space-y-1.5">
                            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Ulangi
                                Sandi</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="password-confirm-field w-full pl-10 sm:pl-12 pr-12 sm:pr-14 py-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 text-sm sm:text-base font-medium placeholder-slate-400 touch-target"
                                    placeholder="••••••••" autocomplete="new-password">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400 absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{-- Toggle Password Button --}}
                                <button type="button" data-toggle="password-confirm"
                                    class="toggle-password absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-green-600 transition-colors duration-200 focus:outline-none rounded-full p-1 touch-target">
                                    <svg class="eye-icon w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg class="eye-slash-icon w-4 h-4 sm:w-5 sm:h-5 hidden" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Register --}}
                    <div class="pt-1">
                        <button type="submit"
                            class="w-full py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 shadow-lg shadow-green-600/20 hover:shadow-green-600/30 active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2 text-sm sm:text-base touch-target">
                            <span>Daftar Sekarang</span>
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-0.5 transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                {{-- Separator --}}
                <div class="mt-3 sm:mt-4">
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
                <div class="mt-3 sm:mt-4">
                    <a href="{{ route('socialite.google.redirect') }}"
                        class="w-full flex items-center justify-center gap-2 sm:gap-3 px-3 sm:px-4 py-2.5 border border-slate-200 rounded-lg shadow-sm text-sm sm:text-base font-semibold text-slate-700 bg-white hover:bg-slate-50 active:scale-[0.98] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 touch-target">
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
                        <span class="truncate">Daftar dengan Google</span>
                    </a>
                </div>

                {{-- Footer Link --}}
                <div class="mt-4 sm:mt-6 text-center pt-4 border-t border-slate-100">
                    <p class="text-slate-500 text-xs sm:text-sm font-medium">Sudah punya akun?</p>
                    <a href="{{ route('login') }}"
                        class="inline-block mt-1.5 text-green-600 font-bold hover:text-green-800 transition-colors hover:underline text-sm sm:text-base touch-target">
                        Masuk ke Akun
                    </a>
                </div>
            </div>
        </div>

        {{--
        BAGIAN KANAN: GAMBAR & DEKORASI
        - PERUBAHAN 2:
        - Menambahkan: 'fixed top-0 right-0 z-20'
        - Gambar tetap diam (fixed), sementara kiri scrolling.
        --}}
        <div
            class="hidden lg:flex fixed top-0 right-0 w-1/2 h-screen relative bg-white items-center justify-center overflow-hidden z-20">
            <div class="absolute inset-0 bg-gradient-to-tr from-green-50/50 to-white"></div>
            <div class="absolute inset-0 opacity-10">
                <img src="images/logo2.png" alt="AgriSmart Pattern" class="w-full h-full object-cover">
            </div>
            <div class="relative z-10 max-w-md px-6 lg:px-10 xl:px-12 text-center" data-aos="fade-up"
                data-aos-delay="200">
                <h2 class="text-2xl lg:text-3xl xl:text-4xl font-bold text-slate-900 mb-4 leading-snug">
                    Bergabunglah dengan <span class="text-green-600">AgriSmart</span>
                </h2>
                <p class="text-slate-500 text-base lg:text-lg leading-relaxed font-medium opacity-95">
                    "Mulai perjalanan pertanian cerdas Anda bersama ribuan petani dan pembeli terpercaya."
                </p>
            </div>
        </div>
    </div>

    {{-- Script AOS --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi AOS sekali saja
        AOS.init({
            once: true,
            disable: 'mobile'
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Toggle password visibility untuk semua field
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-toggle');
                    const targetField = targetId === 'password'
                        ? document.getElementById('password')
                        : document.getElementById('password_confirmation');

                    const eyeIcon = this.querySelector('.eye-icon');
                    const eyeSlashIcon = this.querySelector('.eye-slash-icon');

                    if (targetField.type === 'password') {
                        targetField.type = 'text';
                        eyeIcon.classList.add('hidden');
                        eyeSlashIcon.classList.remove('hidden');
                    } else {
                        targetField.type = 'password';
                        eyeIcon.classList.remove('hidden');
                        eyeSlashIcon.classList.add('hidden');
                    }
                });
            });

            // Validasi password match
            const passwordField = document.getElementById('password');
            const confirmField = document.getElementById('password_confirmation');

            function validatePasswordMatch() {
                const password = passwordField.value;
                const confirm = confirmField.value;

                if (confirm === '') {
                    confirmField.classList.remove('password-match');
                    return;
                }

                if (password === confirm) {
                    confirmField.classList.add('password-match');
                } else {
                    confirmField.classList.remove('password-match');
                }
            }

            if (confirmField) {
                confirmField.addEventListener('input', validatePasswordMatch);
                passwordField.addEventListener('input', validatePasswordMatch);
            }

            // Mobile experience improvements
            const inputs = document.querySelectorAll('input, button, a');
            inputs.forEach(input => {
                input.addEventListener('touchstart', function () {
                    this.classList.add('active');
                });

                input.addEventListener('touchend', function () {
                    this.classList.remove('active');
                });
            });

            // Prevent zoom on iOS
            document.addEventListener('touchstart', function (event) {
                if (event.target.tagName === 'INPUT' || event.target.tagName === 'TEXTAREA') {
                    event.target.style.fontSize = '16px';
                }
            });
        });
    </script>
</body>

</html>