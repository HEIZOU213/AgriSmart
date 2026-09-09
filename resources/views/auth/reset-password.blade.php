<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Buat Sandi Baru - AgriSmart</title>
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
                    <p class="text-xs sm:text-sm font-semibold text-slate-400 tracking-widest uppercase mt-1">Buat Sandi Baru</p>
                    <p class="mt-1 text-xs text-slate-500 font-medium max-w-xs mx-auto">
                        Pastikan menggunakan kombinasi angka dan huruf yang kuat agar akun Anda tetap aman.
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

                <form action="{{ route('password.reset.update') }}" method="POST" class="space-y-4 sm:space-y-5">
                    @csrf
                    
                    {{-- Input Password Baru --}}
                    <div class="space-y-1.5 sm:space-y-2">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Kata Sandi Baru</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required minlength="8"
                                class="w-full pl-10 sm:pl-12 pr-12 sm:pr-14 py-2.5 sm:py-3 rounded-lg sm:rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 text-sm sm:text-base font-medium placeholder-slate-400 touch-target"
                                placeholder="Minimal 8 karakter">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400 absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <button type="button" id="togglePassword1"
                                class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-green-600 transition-colors duration-300 focus:outline-none rounded-full p-1 touch-target">
                                <svg id="eyeIcon1" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg id="eyeSlashIcon1" class="w-4 h-4 sm:w-5 sm:h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="space-y-1.5 sm:space-y-2">
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Konfirmasi Sandi Baru</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8"
                                class="w-full pl-10 sm:pl-12 pr-12 sm:pr-14 py-2.5 sm:py-3 rounded-lg sm:rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 text-sm sm:text-base font-medium placeholder-slate-400 touch-target"
                                placeholder="Tulis ulang sandi">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400 absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 group-focus-within:text-green-600 transition-colors duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <button type="button" id="togglePassword2"
                                class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-green-600 transition-colors duration-300 focus:outline-none rounded-full p-1 touch-target">
                                <svg id="eyeIcon2" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg id="eyeSlashIcon2" class="w-4 h-4 sm:w-5 sm:h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="pt-1 sm:pt-2">
                        <button type="submit" class="w-full py-3 sm:py-3.5 bg-green-600 text-white font-bold rounded-lg sm:rounded-xl hover:bg-green-700 shadow-lg shadow-green-600/20 hover:shadow-green-600/30 active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2 text-sm sm:text-base touch-target">
                            <span>Simpan Sandi Baru</span>
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                    </div>
                </form>

            </div>
        </div>

        <div class="hidden lg:flex fixed top-0 right-0 w-1/2 h-screen relative bg-white items-center justify-center overflow-hidden z-20">
            <div class="absolute inset-0 bg-gradient-to-tr from-green-50/50 to-white"></div>
            <div class="absolute inset-0 opacity-10">
                <img src="{{ asset('images/logo2.png') }}" alt="AgriSmart Pattern" class="w-full h-full object-cover">
            </div>
            <div class="relative z-10 max-w-md px-6 lg:px-10 xl:px-12 text-center" data-aos="fade-up" data-aos-delay="200">
                <h2 class="text-2xl lg:text-3xl xl:text-4xl font-bold text-slate-900 mb-4 lg:mb-5 leading-snug">
                    Satu Langkah <br> <span class="text-green-600">Terakhir</span>
                </h2>
                <p class="text-slate-500 text-base lg:text-lg leading-relaxed font-medium opacity-95">
                    "Buat kata sandi baru yang kuat agar keamanan data Panen Durian dan akun Anda tetap terjaga."
                </p>
            </div>
        </div>

    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function setupPasswordToggle(toggleId, inputId, eyeIconId, eyeSlashIconId) {
                const togglePassword = document.getElementById(toggleId);
                const passwordInput = document.getElementById(inputId);
                const eyeIcon = document.getElementById(eyeIconId);
                const eyeSlashIcon = document.getElementById(eyeSlashIconId);

                if(!togglePassword) return;

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
            }

            setupPasswordToggle('togglePassword1', 'password', 'eyeIcon1', 'eyeSlashIcon1');
            setupPasswordToggle('togglePassword2', 'password_confirmation', 'eyeIcon2', 'eyeSlashIcon2');

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


