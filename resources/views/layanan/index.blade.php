<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO META TAGS --}}
    <meta name="description"
        content="AgriSmart IoT Services - Pantau Kebun Durian Anda secara real-time dengan teknologi perkebunan durian cerdas.">
    <title>Sensor Kebun Durian - {{ config('app.name', 'AgriSmart') }}</title>

    {{-- FONT: Plus Jakarta Sans --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- LIBRARY ANIMASI AOS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- TAILWIND & SCRIPTS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- CUSTOM STYLES --}}
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Scrollbar Green Theme */
        ::-webkit-scrollbar {
            width: 8px;
        }

        @media (min-width: 640px) {
            ::-webkit-scrollbar {
                width: 10px;
            }
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

        /* Custom Animation Utilities */
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }
    </style>
</head>

<body
    class="font-sans antialiased text-slate-700 bg-green-50 flex flex-col min-h-screen selection:bg-green-500 selection:text-white overflow-x-hidden">

    {{-- NAVBAR --}}
    <x-navbar />

    {{-- MAIN CONTENT --}}
    <main class="flex-1 w-full">

        {{-- ================================================
        HERO SECTION
        ================================================ --}}
        <section class="relative overflow-hidden pt-24 pb-12 sm:pt-28 lg:pt-32 lg:pb-20 bg-slate-50">
            {{-- Background Spin Tengah --}}
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="w-[280px] h-[280px] sm:w-[500px] sm:h-[500px] lg:w-[800px] lg:h-[800px] opacity-5">
                    <div class="w-full h-full animate-[spin_30s_linear_infinite]">
                        <img src="{{ asset('images/nav-logo.png') }}" alt="Background"
                            class="w-full h-full object-contain">
                    </div>
                </div>
            </div>

            {{-- Konten Utama Hero --}}
            <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
                <div class="text-center" data-aos="fade-up">
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-green-100/50 text-green-700 text-[10px] sm:text-xs font-bold tracking-wider uppercase mb-3 border border-green-200/50 shadow-sm">
                        Smart Durian Farming
                    </span>
                    <h2
                        class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-slate-900 mb-4 sm:mb-6 leading-tight break-words">
                        Pantau Kebun Durian
                        <span class="text-green-600 inline-block">Real-time</span>
                    </h2>
                    <p class="text-base sm:text-lg text-slate-600 max-w-xl sm:max-w-2xl mx-auto px-2 leading-relaxed">
                        Integrasikan teknologi sensor tanah dan cuaca untuk hasil Panen Durian yang lebih optimal dan efisien.
                    </p>
                </div>
            </div>
        </section>

        {{-- ================================================
        CONTENT SECTION (Form & Grid Device)
        ================================================ --}}
        <section class="py-8 sm:py-16 lg:py-24 relative bg-white overflow-hidden">

            {{-- Background Decorations --}}
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-[300px] sm:w-[800px] h-[400px] bg-gradient-to-br from-green-50/20 via-green-50/10 to-transparent rounded-full blur-3xl">
                </div>
                <div
                    class="absolute bottom-0 right-0 w-[200px] sm:w-[600px] h-[300px] sm:h-[600px] bg-gradient-to-tl from-green-50/15 to-transparent rounded-full blur-3xl translate-x-1/3 translate-y-1/3">
                </div>
                <div class="absolute inset-0 opacity-[0.015]"
                    style="background-image: radial-gradient(circle at 1px 1px, rgb(167 243 208) 1px, transparent 0); background-size: 40px 40px;">
                </div>
            </div>

            {{-- Main Content Container --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                {{-- PESAN SUKSES / ERROR --}}
                @if(session('success') || session('error'))
                    <div class="max-w-4xl mx-auto mb-6 sm:mb-8" data-aos="fade-down">
                        <div
                            class="p-4 rounded-2xl flex items-start sm:items-center gap-3 border shadow-sm {{ session('success') ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5 sm:mt-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ session('success') ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' }}" />
                            </svg>
                            <span
                                class="font-medium text-sm leading-tight">{{ session('success') ?? session('error') }}</span>
                        </div>
                    </div>
                @endif

                {{-- ================================================
                LOGIC TAMPILAN BERDASARKAN ROLE
                ================================================ --}}
                @if(Auth::check())
                    {{-- $userRole sudah dikirim dari Controller --}}

                    {{-- === TAMPILAN PEKEBUN / ADMIN === --}}
                    @if(in_array($userRole, ['pekebun', 'petani', 'admin']))

                        <div x-data="{
                            modalUploadOpen: false,
                            modalEditOpen: false,
                            editDevice: { id: '', name: '', serial_number: '', pin_code: '' }
                        }">

                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

                                {{-- === KOLOM KIRI: FORM INPUT DEVICE === --}}
                                <div class="lg:col-span-4 lg:sticky lg:top-28 w-full space-y-4">
                                    <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-100 shadow-xl">

                                        {{-- Form Header --}}
                                        <div class="mb-5 sm:mb-6">
                                            <h3 class="font-bold text-lg text-slate-900">Hubungkan Sensor</h3>
                                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                                Masukkan Serial Number & PIN perangkat. Perangkat baru akan otomatis terdaftar dan tersimpan di database Anda.
                                            </p>
                                        </div>

                                        {{-- Form Claim Device --}}
                                        <form action="{{ route('layanan.claim') }}" method="POST" class="space-y-4">
                                            @csrf

                                            {{-- Input: Serial Number --}}
                                            <div>
                                                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1 block pl-1">
                                                    Serial Number Perangkat
                                                </label>
                                                <input type="text" name="serial_number" required placeholder="Contoh: SN-AGRI-01 atau SN-ESP32-01"
                                                    class="w-full px-4 py-3 rounded-xl bg-slate-50/50 border border-slate-200 text-slate-800 font-semibold text-base sm:text-sm placeholder:font-normal placeholder:text-slate-400
                                                    hover:bg-white hover:border-green-200
                                                    focus:outline-none focus:ring-0 focus:shadow-none focus:border-slate-200
                                                    focus:hover:bg-white focus:hover:border-green-200 transition-colors">
                                            </div>

                                            {{-- Input: PIN Code / Password --}}
                                            <div x-data="{ showPinInput: false }">
                                                <div class="flex items-center justify-between mb-1 pl-1">
                                                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">
                                                        PIN Code / Password
                                                    </label>
                                                    <button type="button" @click="showPinInput = !showPinInput" class="text-[11px] font-semibold text-green-600 hover:text-green-700">
                                                        <span x-text="showPinInput ? 'Sembunyikan' : 'Lihat PIN'"></span>
                                                    </button>
                                                </div>
                                                <input :type="showPinInput ? 'text' : 'password'" name="pin_code" required placeholder="Masukkan PIN / Password" 
                                                    class="w-full px-4 py-3 rounded-xl bg-slate-50/50 border border-slate-200 text-slate-800 font-semibold text-base sm:text-sm placeholder:font-normal placeholder:text-slate-400
                                                    hover:bg-white hover:border-green-200
                                                    focus:outline-none focus:ring-0 focus:shadow-none focus:border-slate-200
                                                    focus:hover:bg-white focus:hover:border-green-200 transition-colors">
                                            </div>

                                            {{-- Input: Nama Kebun / Blok --}}
                                            <div>
                                                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1 block pl-1">
                                                    Nama Kebun / Lokasi Sensor
                                                </label>
                                                <input type="text" name="name" required placeholder="Misal: Durian Musang King Blok A" class="w-full px-4 py-3 rounded-xl bg-slate-50/50 border border-slate-200 text-slate-800 font-semibold text-base sm:text-sm placeholder:font-normal placeholder:text-slate-400
                                                    hover:bg-white hover:border-green-200
                                                    focus:outline-none focus:ring-0 focus:shadow-none focus:border-slate-200
                                                    focus:hover:bg-white focus:hover:border-green-200 transition-colors">
                                            </div>

                                            {{-- Submit Button --}}
                                            <button type="submit"
                                                class="w-full mt-2 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-green-600/20 active:scale-95 flex items-center justify-center gap-2 text-sm sm:text-base">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                <span>Hubungkan & Simpan Sensor</span>
                                            </button>
                                        </form>

                                        {{-- Tombol Bantuan Upload Massal --}}
                                        <div class="mt-4 pt-4 border-t border-slate-100 text-center">
                                            <button type="button" @click="modalUploadOpen = true"
                                                    class="w-full py-2.5 px-3 bg-slate-50 hover:bg-green-50 text-slate-700 hover:text-green-700 rounded-xl text-xs font-bold border border-slate-200 hover:border-green-200 transition-all flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                                </svg>
                                                <span>Upload Massal PIN & Password (CSV)</span>
                                            </button>
                                            <p class="text-[11px] text-slate-400 mt-1.5">Punya banyak sensor? Daftarkan sekaligus lewat file atau tempel teks.</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- === KOLOM KANAN: LIST PERANGKAT TERHUBUNG === --}}
                                <div class="lg:col-span-8 w-full">
                                    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden">

                                        {{-- Header List Device --}}
                                        <div class="px-5 sm:px-6 py-4 sm:py-5 flex flex-wrap items-center justify-between gap-3 border-b border-slate-100">
                                            <div>
                                                <h3 class="font-bold text-slate-900 text-base sm:text-lg">Perangkat Saya</h3>
                                                <p class="text-xs text-slate-500">Kelola dan pantau semua sensor perkebunan Anda di sini.</p>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <button type="button" @click="modalUploadOpen = true"
                                                        class="px-3 py-1.5 rounded-xl bg-green-50 hover:bg-green-100 text-green-700 text-xs font-bold border border-green-200 transition-colors inline-flex items-center gap-1.5 shadow-sm">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                                    <span>Upload Massal</span>
                                                </button>
                                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold whitespace-nowrap">
                                                    {{ isset($myDevices) ? count($myDevices) : 0 }} Unit
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Body List Device (Dengan horizontal scroll aman untuk mobile) --}}
                                        <div class="p-4 sm:p-6 space-y-3.5 overflow-x-auto">
                                            @if(isset($myDevices) && count($myDevices) > 0)
                                                {{-- Loop setiap device --}}
                                                @foreach ($myDevices as $dev)
                                                    <div class="p-4 sm:p-5 rounded-2xl bg-slate-50/70 border border-slate-200/80 hover:bg-white hover:border-green-300 hover:shadow-md transition-all duration-200 min-w-[280px]">
                                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                                                            {{-- Info Device --}}
                                                            <div class="flex items-start sm:items-center gap-3.5 flex-1 min-w-0">
                                                                {{-- Icon --}}
                                                                <div class="w-11 h-11 bg-white rounded-xl flex items-center justify-center text-green-600 shadow-sm border border-slate-100 flex-shrink-0">
                                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                            d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                                                    </svg>
                                                                </div>

                                                                {{-- Text Info --}}
                                                                <div class="flex-1 min-w-0">
                                                                    <div class="flex flex-wrap items-center gap-2">
                                                                        <h4 class="font-bold text-slate-900 text-sm sm:text-base break-words">
                                                                            {{ $dev->name }}
                                                                        </h4>
                                                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $dev->mode === 'AUTO' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                                                            {{ $dev->mode }}
                                                                        </span>
                                                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $dev->is_pump_on ? 'bg-green-100 text-green-700' : 'bg-slate-200 text-slate-600' }}">
                                                                            Pompa: {{ $dev->is_pump_on ? 'HIDUP' : 'MATI' }}
                                                                        </span>
                                                                    </div>

                                                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1 text-xs">
                                                                        {{-- Serial Number --}}
                                                                        <span class="text-slate-500 font-mono font-semibold break-all">
                                                                            SN: <span class="text-slate-800">{{ $dev->serial_number }}</span>
                                                                        </span>

                                                                        {{-- PIN View/Hide Toggle --}}
                                                                        <div x-data="{ showPin: false }" class="inline-flex items-center gap-1.5 bg-white px-2 py-0.5 rounded-md border border-slate-200 shadow-2xs">
                                                                            <span class="text-[10px] uppercase font-bold text-slate-400">PIN:</span>
                                                                            <span class="font-mono text-xs font-bold text-slate-700 select-all"
                                                                                  x-text="showPin ? '{{ $dev->pin_code }}' : '••••••'"></span>
                                                                            <button type="button" @click="showPin = !showPin"
                                                                                    class="text-slate-400 hover:text-green-600 transition-colors p-0.5"
                                                                                    :title="showPin ? 'Sembunyikan PIN' : 'Lihat PIN'">
                                                                                <svg x-show="!showPin" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                                                </svg>
                                                                                <svg x-show="showPin" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                                                                                </svg>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{-- Action Buttons --}}
                                                            <div class="flex items-center gap-2 self-end sm:self-center flex-shrink-0">
                                                                {{-- Tombol Buka Monitoring --}}
                                                                <a href="{{ route('layanan.show', $dev->serial_number) }}"
                                                                   class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-bold shadow-sm transition-all duration-200 flex items-center gap-1.5"
                                                                   title="Buka Dashboard Monitoring Realtime">
                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                                                    </svg>
                                                                    <span>Pantau</span>
                                                                </a>

                                                                {{-- Tombol Edit --}}
                                                                <button type="button"
                                                                        @click="editDevice = {
                                                                            id: '{{ $dev->id }}',
                                                                            name: '{{ addslashes($dev->name) }}',
                                                                            serial_number: '{{ $dev->serial_number }}',
                                                                            pin_code: '{{ addslashes($dev->pin_code) }}'
                                                                        }; modalEditOpen = true;"
                                                                        class="p-2 bg-white hover:bg-slate-100 text-slate-600 hover:text-slate-900 rounded-xl text-xs font-semibold border border-slate-200 transition-colors shadow-2xs"
                                                                        title="Edit Nama / PIN Perangkat">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                                    </svg>
                                                                </button>

                                                                {{-- Tombol Hapus / Putuskan --}}
                                                                <form action="{{ route('layanan.destroy', $dev->id) }}" method="POST"
                                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus perangkat {{ $dev->serial_number }} dari sistem?')"
                                                                      class="inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                            class="p-2 bg-white hover:bg-red-50 text-slate-400 hover:text-red-600 rounded-xl text-xs font-semibold border border-slate-200 hover:border-red-200 transition-colors shadow-2xs"
                                                                            title="Hapus Perangkat">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                        </svg>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                {{-- Empty State: Tidak ada device --}}
                                                <div class="py-10 flex flex-col items-center justify-center text-center px-4 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50/50">
                                                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-white rounded-full flex items-center justify-center mb-3 text-slate-300 shadow-sm border border-slate-100">
                                                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2 2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                        </svg>
                                                    </div>
                                                    <h4 class="text-slate-900 font-bold text-sm">Belum Ada Sensor Terhubung</h4>
                                                    <p class="text-slate-500 text-xs mt-1 max-w-sm leading-relaxed">
                                                        Hubungkan sensor pertama Anda lewat form di sebelah kiri atau unggah massal PIN dan password perangkat.
                                                    </p>
                                                    <button type="button" @click="modalUploadOpen = true"
                                                            class="mt-4 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-bold shadow-sm transition-all flex items-center gap-1.5">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                                        <span>Upload Massal Sekarang</span>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- === MODAL 1: UPLOAD MASSAL PIN & PASSWORD === --}}
                            <div x-show="modalUploadOpen"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs overflow-y-auto"
                                 style="display: none;"
                                 @keydown.escape.window="modalUploadOpen = false">

                                <div @click.away="modalUploadOpen = false"
                                     x-show="modalUploadOpen"
                                     x-transition:enter="transition ease-out duration-250"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-7 shadow-2xl border border-slate-100 my-8">

                                    {{-- Modal Header --}}
                                    <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                                        <div>
                                            <h3 class="text-lg font-bold text-slate-900">Upload Massal PIN & Password</h3>
                                            <p class="text-xs text-slate-500 mt-0.5">Daftarkan banyak sensor sekaligus tanpa perlu input manual di database.</p>
                                        </div>
                                        <button type="button" @click="modalUploadOpen = false" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>

                                    {{-- Download Template Info Card --}}
                                    <div class="mt-4 p-3.5 bg-green-50/70 rounded-2xl border border-green-200/80 flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-xl bg-green-600 text-white flex items-center justify-center shrink-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800">Format Template CSV</p>
                                                <p class="text-[11px] text-slate-500">Unduh contoh format CSV untuk pengisian cepat.</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('layanan.template') }}"
                                           class="px-3 py-1.5 bg-white hover:bg-green-600 text-green-700 hover:text-white rounded-xl text-xs font-bold border border-green-300 transition-all shadow-2xs shrink-0 flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            <span>Unduh CSV</span>
                                        </a>
                                    </div>

                                    {{-- Form Upload --}}
                                    <form action="{{ route('layanan.upload') }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
                                        @csrf

                                        {{-- 1. Opsi File Upload --}}
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                                Pilih File CSV / TXT
                                            </label>
                                            <input type="file" name="file" accept=".csv,.txt,text/plain"
                                                   class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 border border-slate-200 rounded-xl cursor-pointer bg-slate-50/50 p-1">
                                        </div>

                                        {{-- 2. Opsi Paste Teks --}}
                                        <div>
                                            <div class="flex items-center justify-between mb-1.5">
                                                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                                                    Atau Tempel Teks Daftar Sensor
                                                </label>
                                                <span class="text-[10px] text-slate-400">1 baris = 1 perangkat</span>
                                            </div>
                                            <textarea name="batch_text" rows="4"
                                                      placeholder="SN-AGRI-001, 123456, Kebun Durian Blok A&#10;SN-AGRI-002, 654321, Kebun Durian Blok B"
                                                      class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50/50 border border-slate-200 text-xs font-mono text-slate-800 placeholder:text-slate-400 focus:bg-white focus:outline-none focus:border-green-500 transition-colors"></textarea>
                                            <p class="text-[11px] text-slate-500 mt-1">
                                                Format: <code class="bg-slate-100 px-1 py-0.5 rounded text-slate-700 font-semibold">nomor_seri, pin_password, nama_kebun</code> (bisa pisahkan koma atau titik koma).
                                            </p>
                                        </div>

                                        {{-- Action Buttons --}}
                                        <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                                            <button type="button" @click="modalUploadOpen = false"
                                                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                                                Batal
                                            </button>
                                            <button type="submit"
                                                    class="px-5 py-2.5 rounded-xl bg-green-600 hover:bg-green-700 text-white text-xs font-bold transition-all shadow-md shadow-green-600/20 flex items-center gap-1.5">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                                <span>Mulai Upload & Simpan</span>
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            {{-- === MODAL 2: EDIT PERANGKAT & PIN === --}}
                            <div x-show="modalEditOpen"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs overflow-y-auto"
                                 style="display: none;"
                                 @keydown.escape.window="modalEditOpen = false">

                                <div @click.away="modalEditOpen = false"
                                     x-show="modalEditOpen"
                                     x-transition:enter="transition ease-out duration-250"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-100 my-8">

                                    {{-- Modal Header --}}
                                    <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                                        <div>
                                            <h3 class="text-lg font-bold text-slate-900">Edit Perangkat Sensor</h3>
                                            <p class="text-xs text-slate-500 mt-0.5">Ubah nama atau PIN/Password perangkat ini.</p>
                                        </div>
                                        <button type="button" @click="modalEditOpen = false" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>

                                    {{-- Form Edit --}}
                                    <form :action="'{{ url('/layanan/devices') }}/' + editDevice.id" method="POST" class="mt-4 space-y-4">
                                        @csrf
                                        @method('PUT')

                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                                Nama Sensor / Kebun
                                            </label>
                                            <input type="text" name="name" x-model="editDevice.name" required
                                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-semibold text-slate-800 focus:bg-white focus:border-green-500 focus:outline-none transition-colors">
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                                Serial Number
                                            </label>
                                            <input type="text" name="serial_number" x-model="editDevice.serial_number" required
                                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-mono font-semibold text-slate-800 focus:bg-white focus:border-green-500 focus:outline-none transition-colors">
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                                PIN Code / Password
                                            </label>
                                            <input type="text" name="pin_code" x-model="editDevice.pin_code" required
                                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-mono font-semibold text-slate-800 focus:bg-white focus:border-green-500 focus:outline-none transition-colors">
                                            <p class="text-[11px] text-slate-400 mt-1">Pastikan PIN sesuai dengan yang dikonfigurasikan di alat ESP32 Anda.</p>
                                        </div>

                                        <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                                            <button type="button" @click="modalEditOpen = false"
                                                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                                                Batal
                                            </button>
                                            <button type="submit"
                                                    class="px-5 py-2.5 rounded-xl bg-green-600 hover:bg-green-700 text-white text-xs font-bold transition-all shadow-md shadow-green-600/20">
                                                Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>

                        {{-- === TAMPILAN USER / KONSUMEN (RESTRICTED ACCESS) === --}}
                    @elseif(in_array($userRole, ['user', 'konsumen']))
                        <div class="max-w-lg mx-auto px-4" data-aos="zoom-in">
                            <div class="p-6 sm:p-8 text-center">

                                {{-- Icon Akses Terbatas --}}
                                <div
                                    class="w-14 h-14 sm:w-16 sm:h-16 bg-green-50 rounded-2xl flex items-center justify-center mx-auto mb-5 sm:mb-6 text-green-600 shadow-sm">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>

                                {{-- Content Pesan Restriksi --}}
                                <h3 class="text-xl sm:text-2xl font-bold text-slate-900 mb-2">Akses Terbatas</h3>
                                <p class="text-slate-500 text-sm mb-8 px-2 leading-relaxed">
                                    Fitur Smart Farming ini dikhususkan untuk akun Pekebun.
                                </p>

                            </div>
                        </div>

                        {{-- === TAMPILAN ROLE LAIN (FALLBACK) === --}}
                    @else
                        <div class="max-w-lg mx-auto text-center bg-yellow-50 rounded-2xl p-6 border border-yellow-100 mx-4">
                            <h3 class="font-bold text-yellow-800 text-sm">Role Belum Dikonfigurasi: {{ $userRole ?? 'NULL' }}
                            </h3>
                        </div>
                    @endif

                    {{-- === TAMPILAN GUEST (BELUM LOGIN) === --}}
                @else
                    <div class="max-w-md mx-auto px-4" data-aos="zoom-in">
                        <div class="bg-white rounded-3xl p-6 sm:p-8 text-center border border-slate-100 shadow-xl">
                            <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2">Login Diperlukan</h3>
                            <p class="text-slate-500 text-sm mb-6">Masuk ke akun Pekebun Anda untuk mengakses dashboard.</p>

                            {{-- Tombol Login --}}
                            <a href="{{ route('login') }}"
                                class="block w-full py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-green-600/20 text-sm">
                                Masuk Sekarang
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>

    {{-- FOOTER --}}
    <x-footer />

    {{-- TOMBOL BACK TO TOP --}}
    <x-back-button />

    {{-- SCRIPT INITIALIZATION --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi AOS
        AOS.init({ once: true, offset: 50, duration: 800 });
    </script>
</body>

</html>

