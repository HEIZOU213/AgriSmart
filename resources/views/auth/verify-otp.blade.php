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

                {{-- Pesan Sukses (Dari Register atau Resend) --}}
                @if (session('success'))
                    <div id="success-alert" class="mb-4 sm:mb-6 p-3 sm:p-4 bg-green-50 text-green-700 rounded-lg sm:rounded-xl flex items-start gap-2 sm:gap-3 text-xs sm:text-sm border border-green-100">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                {{-- AREA PESAN ALERT AJAX (Akan muncul tanpa refresh) --}}
                <div id="alert-container" class="hidden mb-4 p-3 rounded-lg text-sm text-center"></div>

                {{-- Error Message (Laravel Validation) --}}
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

                {{-- TOMBOL RESEND AJAX --}}
                <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                    <p class="text-slate-500 text-sm mb-3 font-medium">Belum menerima kode?</p>
                    
                    <button type="button" id="resend-btn" onclick="kirimUlangOtp()"
                        class="px-5 py-2.5 rounded-lg text-sm font-bold transition-all duration-300 flex items-center justify-center mx-auto gap-2 shadow-sm w-full sm:w-auto
                        disabled:bg-slate-100 disabled:text-slate-400 disabled:cursor-not-allowed
                        bg-green-50 text-green-700 hover:bg-green-100 hover:shadow-md border border-green-100">
                        
                        {{-- Ikon Jam --}}
                        <svg id="timer-icon" class="w-4 h-4 animate-pulse hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>

                        {{-- Teks Tombol --}}
                        <span id="resend-text">Kirim Ulang Kode</span>
                    </button>
                </div>

                {{-- Ganti Email --}}
                <div class="mt-4 text-center">
                    <a href="{{ route('login.otp') }}" class="text-xs sm:text-sm font-medium text-slate-400 hover:text-slate-600 transition-colors">
                        Bukan email Anda? <span class="underline">Ganti Email</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- BAGIAN KANAN: DEKORASI --}}
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

    {{-- Script AOS & Logic AJAX --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, disable: 'mobile' });

        // --- LOGIC AJAX RESEND & TIMER ---
        
        // Ambil sisa waktu dari Controller (Server)
        let timeLeft = {{ $waitTime ?? 0 }};
        const btn = document.getElementById('resend-btn');
        const btnText = document.getElementById('resend-text');
        const icon = document.getElementById('timer-icon');
        const alertBox = document.getElementById('alert-container');
        const successAlert = document.getElementById('success-alert');

        // Fungsi Timer Mundur
        function startTimer() {
            // Matikan tombol
            btn.disabled = true;
            icon.classList.remove('hidden');
            btn.classList.remove('bg-green-50', 'text-green-700', 'hover:bg-green-100', 'border-green-100');
            btn.classList.add('bg-slate-100', 'text-slate-400');
            
            // Update teks awal dengan pembulatan
            btnText.innerText = `Mohon tunggu ${Math.ceil(timeLeft)} detik`;

            const interval = setInterval(() => {
                timeLeft--; 
                
                if (timeLeft <= 0) {
                    clearInterval(interval);
                    // Timer Selesai: Hidupkan tombol kembali
                    btn.disabled = false;
                    icon.classList.add('hidden');
                    btnText.innerText = "Kirim Ulang Kode";
                    
                    // Style tombol aktif
                    btn.classList.add('bg-green-50', 'text-green-700', 'hover:bg-green-100', 'border-green-100');
                    btn.classList.remove('bg-slate-100', 'text-slate-400');
                } else {
                    // Timer Jalan: Update teks
                    btnText.innerText = `Mohon tunggu ${Math.ceil(timeLeft)} detik`;
                }
            }, 1000);
        }

        // Fungsi AJAX Kirim Ulang (Tanpa Refresh)
        async function kirimUlangOtp() {
            // 1. Ubah tampilan jadi loading
            btn.disabled = true;
            btnText.innerText = "Mengirim...";
            alertBox.className = "hidden"; // Sembunyikan alert AJAX lama
            if(successAlert) successAlert.style.display = 'none'; // Sembunyikan alert session sukses lama

            try {
                // 2. Request ke Server
                const response = await fetch("{{ route('otp.resend') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                });

                const data = await response.json();

                // 3. Cek Hasil
                alertBox.classList.remove('hidden');
                if (response.ok && data.status === 'success') {
                    // SUKSES
                    alertBox.className = "mb-4 p-3 rounded-lg text-sm text-center bg-green-100 text-green-700 border border-green-200 font-medium";
                    alertBox.innerHTML = `
                        <div class="flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            ${data.message}
                        </div>`;
                    
                    // [RESET WAKTU JADI 60 DETIK]
                    timeLeft = 60; 
                    startTimer();
                } else {
                    // GAGAL / ERROR
                    alertBox.className = "mb-4 p-3 rounded-lg text-sm text-center bg-red-100 text-red-700 border border-red-200";
                    alertBox.innerText = data.message || "Terjadi kesalahan.";
                    
                    // Kembalikan tombol agar bisa diklik lagi (kecuali kena limit)
                    if(response.status !== 429) {
                        btn.disabled = false;
                        btnText.innerText = "Kirim Ulang Kode";
                    }
                }

            } catch (error) {
                console.error(error);
                btn.disabled = false;
                btnText.innerText = "Kirim Ulang Kode";
                alert("Gagal koneksi internet. Silakan coba lagi.");
            }
        }

        // Jalankan timer otomatis jika saat halaman dibuka waktu masih tersisa (dari server)
        if (timeLeft > 0) {
            startTimer();
        }
    </script>
</body>
</html>