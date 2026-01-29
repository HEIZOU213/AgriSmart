<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Verifikasi OTP - AgriSmart</title>

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
        
        /* Hilangkan spinner di input number */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield;
        }

        @media (max-width: 640px) {
            .touch-target {
                min-height: 44px;
                min-width: 44px;
            }
        }
    </style>
</head>

<body class="bg-white min-h-screen selection:bg-green-500 selection:text-white antialiased">

    {{-- WRAPPER UTAMA --}}
    <div class="flex flex-col lg:flex-row w-full relative">

        {{-- BAGIAN KIRI: FORM OTP --}}
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 py-6 sm:py-8 md:py-10 lg:py-12 min-h-screen relative z-10 bg-white">

            {{-- Dekorasi Blob Background --}}
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none opacity-25 sm:opacity-30">
                <div class="absolute -top-8 -left-8 w-32 h-32 sm:w-40 sm:h-40 md:w-48 md:h-48 lg:w-64 lg:h-64 bg-green-100 rounded-full mix-blend-multiply filter blur-2xl sm:blur-3xl opacity-50 animate-blob"></div>
                <div class="absolute -top-4 right-4 w-28 h-28 sm:w-36 sm:h-36 md:w-40 md:h-40 lg:w-56 lg:h-56 bg-emerald-100 rounded-full mix-blend-multiply filter blur-2xl sm:blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
                <div class="absolute bottom-8 left-1/4 w-32 h-32 sm:w-36 sm:h-36 md:w-44 md:h-44 lg:w-60 lg:h-60 bg-teal-100 rounded-full mix-blend-multiply filter blur-2xl sm:blur-3xl opacity-50 animate-blob animation-delay-4000"></div>
            </div>

            {{-- Konten Formulir --}}
            <div class="relative w-full max-w-md mx-auto" data-aos="fade-right" data-aos-duration="1000">

                {{-- Header --}}
                <div class="text-center mb-6 sm:mb-8 md:mb-10">
                    <div class="inline-flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 bg-green-100 text-green-600 rounded-2xl mb-4 sm:mb-5">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 mb-2 sm:mb-3 tracking-tight leading-tight">
                        Verifikasi Keamanan
                    </h1>
                    <p class="text-slate-500 text-sm sm:text-base font-medium max-w-xs mx-auto px-2 sm:px-0">
                        Kami telah mengirimkan kode 6 digit ke email:
                        <br>
                        <span class="text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded-lg mt-1 inline-block">{{ session('otp_email') }}</span>
                    </p>
                </div>

                {{-- Error Message --}}
                @if ($errors->any())
                    <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-red-50 text-red-700 rounded-lg sm:rounded-xl flex items-start gap-2 sm:gap-3 text-xs sm:text-sm border border-red-100">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <ul class="space-y-0.5 sm:space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORM OTP --}}
                <form action="{{ route('otp.verify.submit') }}" method="POST" class="space-y-6 sm:space-y-8">
                    @csrf

                    {{-- Input OTP --}}
                    <div class="space-y-2">
                        <label for="otp" class="block text-sm font-semibold text-slate-700 text-center">Masukkan Kode OTP</label>
                        <div class="relative">
                            <input type="number" name="otp" id="otp" required
                                class="w-full py-3 sm:py-4 rounded-lg sm:rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 text-2xl sm:text-3xl font-bold tracking-[0.5em] text-center placeholder-slate-300 touch-target"
                                placeholder="000000" autocomplete="one-time-code">
                        </div>
                        <p class="text-xs text-center text-slate-400 mt-2">Periksa folder Inbox atau Spam email Anda</p>
                    </div>

                    {{-- Countdown Timer Badge --}}
                    <div class="flex justify-center">
                        <div id="timer-badge" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 rounded-full text-slate-600 text-sm font-semibold border border-slate-200">
                            <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span id="countdown">--:--</span>
                        </div>
                    </div>

                    {{-- Tombol Verifikasi --}}
                    <div>
                        <button type="submit" id="submitBtn"
                            class="w-full py-3 sm:py-3.5 bg-green-600 text-white font-bold rounded-lg sm:rounded-xl hover:bg-green-700 shadow-lg shadow-green-600/20 hover:shadow-green-600/30 active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2 text-sm sm:text-base touch-target">
                            <span>Verifikasi Masuk</span>
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                {{-- Kirim Ulang (Hidden by default) --}}
                <div id="resendContainer" class="mt-6 sm:mt-8 text-center pt-4 sm:pt-6 border-t border-slate-100 hidden">
                    <p class="text-slate-500 text-xs sm:text-sm font-medium mb-2">Waktu habis? Jangan khawatir.</p>
                    {{-- Form tersembunyi untuk trigger kirim ulang --}}
                    <form action="{{ route('login.otp.step1') }}" method="POST">
                        @csrf
                        {{-- Kirim ulang email yang ada di session --}}
                        <input type="hidden" name="email" value="{{ session('otp_email') }}">
                        {{-- Password di-bypass/dikosongkan karena di controller bisa kita sesuaikan, atau user login ulang --}}
                        {{-- Catatan: Idealnya buat route khusus resend tanpa password jika session valid.
                             Tapi untuk simpel, kita arahkan user login ulang jika expired. --}}
                        <a href="{{ route('login.otp') }}" class="inline-flex items-center gap-2 text-green-600 font-bold hover:text-green-800 transition-colors hover:underline text-sm sm:text-base cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Kirim Kode Baru
                        </a>
                    </form>
                </div>

                {{-- Ganti Email --}}
                <div id="changeEmailContainer" class="mt-6 text-center">
                    <a href="{{ route('login.otp') }}" class="text-xs sm:text-sm font-medium text-slate-400 hover:text-slate-600 transition-colors">
                        Bukan email Anda? <span class="underline">Ganti Email</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- BAGIAN KANAN: DEKORASI (SAMA PERSIS DENGAN CUSTOM LOGIN) --}}
        <div class="hidden lg:flex fixed top-0 right-0 w-1/2 h-screen relative bg-white items-center justify-center overflow-hidden z-20">
            <div class="absolute inset-0 bg-gradient-to-tr from-green-50/50 to-white"></div>
            <div class="absolute inset-0 opacity-10">
                <img src="{{ asset('images/logo2.png') }}" alt="AgriSmart Pattern" class="w-full h-full object-cover">
            </div>
            <div class="relative z-10 max-w-md px-6 lg:px-10 xl:px-12 text-center" data-aos="fade-up" data-aos-delay="200">
                <h2 class="text-2xl lg:text-3xl xl:text-4xl font-bold text-slate-900 mb-4 lg:mb-5 leading-snug">
                    Selamat Datang di <br> <span class="text-green-600">AgriSmart</span>
                </h2>
                <p class="text-slate-500 text-base lg:text-lg leading-relaxed font-medium opacity-95">
                    "Konektivitas, Data, dan Produktivitas. Solusi pertanian cerdas terintegrasi dari hulu ke hilir."
                </p>
            </div>
        </div>

    </div>

    {{-- Script AOS & Countdown --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, disable: 'mobile' });

        // --- COUNTDOWN LOGIC ---
        // Mengambil waktu kedaluwarsa dari controller
        var countDownDate = new Date("{{ $expires_at }}").getTime();
        var timerBadge = document.getElementById("timer-badge");
        var timerDisplay = document.getElementById("countdown");
        var submitBtn = document.getElementById("submitBtn");
        var resendContainer = document.getElementById("resendContainer");
        var changeEmailContainer = document.getElementById("changeEmailContainer");

        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;

            // Hitung menit dan detik
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Format 2 digit (01:05)
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            timerDisplay.innerHTML = minutes + ":" + seconds;

            // Efek visual jika waktu kurang dari 10 detik
            if (distance < 10000) {
                timerBadge.classList.remove('bg-slate-100', 'text-slate-600', 'border-slate-200');
                timerBadge.classList.add('bg-red-50', 'text-red-600', 'border-red-100');
            }

            // Jika waktu habis
            if (distance < 0) {
                clearInterval(x);
                timerDisplay.innerHTML = "WAKTU HABIS";
                
                // Matikan Tombol Submit
                submitBtn.disabled = true;
                submitBtn.classList.add("bg-slate-300", "cursor-not-allowed", "shadow-none");
                submitBtn.classList.remove("bg-green-600", "hover:bg-green-700", "hover:shadow-green-600/30", "active:scale-[0.98]");
                
                // Tampilkan Opsi Kirim Ulang
                resendContainer.classList.remove("hidden");
                changeEmailContainer.classList.add("hidden");
            }
        }, 1000);
    </script>
</body>
</html>