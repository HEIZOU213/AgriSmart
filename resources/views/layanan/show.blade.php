<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $device->name }} - Monitoring AgriSmart</title>

    {{-- FONT: Plus Jakarta Sans --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- LIBRARY ANIMASI AOS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- JQUERY (Wajib untuk Realtime Update) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- TAILWIND & SCRIPTS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Scrollbar Theme */
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
    </style>
</head>

<body
    class="font-sans antialiased text-slate-700 bg-slate-50 flex flex-col min-h-screen selection:bg-green-500 selection:text-white overflow-x-hidden">

    {{-- NAVBAR --}}
    <x-navbar />

    <main class="flex-1 w-full">

        {{-- ================================================
        HERO SECTION (Device Info & Mode)
        ================================================ --}}
        <section class="relative overflow-hidden bg-slate-50 pt-24 pb-10 sm:pt-28 lg:pt-32 lg:pb-16">

            {{-- Background Spin Tengah --}}
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="h-[280px] w-[280px] opacity-5 sm:h-[500px] sm:w-[500px] lg:h-[800px] lg:w-[800px]">
                    <div class="h-full w-full animate-[spin_30s_linear_infinite]">
                        <img src="{{ asset('images/nav-logo.png') }}" alt="Background"
                            class="h-full w-full object-contain">
                    </div>
                </div>
            </div>

            {{-- Konten Utama --}}
            <div class="relative z-10 container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                {{-- Row 1: Tombol Kembali (Jarak diperpendek ke mb-4) --}}
                <div class="mb-4" data-aos="fade-right">
                    <a href="{{ route('layanan.index') }}"
                        class="group inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition-colors hover:text-green-600">
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-400 shadow-sm transition-all group-hover:border-green-300 group-hover:bg-green-50 group-hover:text-green-600">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </span>
                        <span>Kembali ke Dashboard</span>
                    </a>
                </div>

                {{-- Row 2: Header Utama --}}
                <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-end">

                    {{-- Bagian Kiri: Judul & Status --}}
                    <div class="relative" data-aos="fade-up" data-aos-delay="100">

                        {{-- Baris Badge & Status (Margin bawah dikurangi) --}}
                        <div class="mb-2 flex flex-wrap items-center gap-2">
                            <span
                                class="inline-block rounded-full border border-green-200/50 bg-green-100/50 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-green-700 shadow-sm sm:text-xs">
                                Smart Farming System
                            </span>

                            {{-- Status Indikator (ONLINE/OFFLINE) --}}
                            @if($device->latestSensorData && $device->latestSensorData->created_at->diffInMinutes(now()) < 5)
                                <span
                                    class="flex items-center gap-1.5 rounded-full border border-emerald-100 bg-white px-2.5 py-1 text-[10px] font-bold text-emerald-600 shadow-sm">
                                    <span class="relative flex h-2 w-2">
                                        <span
                                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                                    </span>
                                    ONLINE
                                </span>
                            @else
                                <span
                                    class="rounded-full border border-slate-300 bg-slate-200 px-2.5 py-1 text-[10px] font-bold text-slate-500 shadow-sm">
                                    OFFLINE
                                </span>
                            @endif
                        </div>

                        {{-- Judul Besar (Nama Device) --}}
                        <h1 class="mb-3 text-3xl font-extrabold leading-tight text-slate-900 sm:text-4xl lg:text-5xl">
                            {{ $device->name }}
                        </h1>

                        {{-- Card Mode (Compact & Interactive) --}}
                        <div
                            class="inline-flex items-center gap-3 rounded-full border border-slate-200 bg-white py-1.5 pl-1.5 pr-4 transition-all hover:border-slate-300">

                            {{-- Icon Mode Visual --}}
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full {{ $device->mode == 'AUTO' ? 'bg-green-500 text-white shadow-sm shadow-green-200' : 'bg-amber-100 text-amber-600' }}">
                                @if($device->mode == 'AUTO')
                                    {{-- Icon untuk mode AUTO --}}
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                    </svg>
                                @else
                                    {{-- Icon untuk mode MANUAL --}}
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>

                            {{-- Text Mode --}}
                            <div class="flex flex-col justify-center leading-tight">
                                <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Mode</span>
                                <span class="text-xs font-extrabold uppercase text-slate-800">
                                    {{ $device->mode == 'AUTO' ? 'OTOMATIS' : 'MANUAL' }}
                                </span>
                            </div>

                            {{-- ==================================================
                            TOMBOL SWITCH MODE (BOLAK-BALIK)
                            ================================================== --}}
                            <div class="ml-auto border-l border-slate-100 pl-3">
                                @if($device->mode == 'AUTO')
                                    {{-- Jika AUTO: Tampilkan Tombol Switch ke MANUAL --}}
                                    <form action="{{ route('iot.manual', $device->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="group flex h-7 w-7 items-center justify-center rounded-full bg-slate-50 text-slate-400 transition-all hover:bg-green-50 hover:text-green-600">
                                            <svg class="h-3.5 w-3.5 transition-transform duration-500 group-hover:rotate-180"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    {{-- Jika MANUAL: Tampilkan Tombol Switch ke OTOMATIS --}}
                                    <form action="{{ route('iot.auto', $device->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="group flex h-7 w-7 items-center justify-center rounded-full bg-slate-50 text-slate-400 transition-all hover:bg-green-50 hover:text-green-600">
                                            <svg class="h-3.5 w-3.5 transition-transform duration-500 group-hover:rotate-180"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            {{-- ================================================== --}}

                        </div>
                    </div>

                    {{-- (Optional) Slot Kanan: Bisa diisi info cuaca atau sensor utama di sini jika nanti diperlukan
                    --}}

                </div>
            </div>
        </section>

        {{-- ================================================
        CONTENT SECTION (Sensors & Pump)
        ================================================ --}}
        <section class="py-10 sm:py-16 relative bg-white overflow-hidden min-h-[600px]">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                {{-- Alert Notification untuk Success/Error --}}
                @if(session('success') || session('error'))
                    <div class="max-w-4xl mx-auto mb-8" data-aos="fade-down">
                        <div
                            class="p-4 rounded-2xl flex items-center gap-3 border shadow-sm {{ session('success') ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ session('success') ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' }}" />
                            </svg>
                            <span class="font-medium text-sm">{{ session('success') ?? session('error') }}</span>
                        </div>
                    </div>
                @endif

                {{-- SENSOR GRID (3 Kolom di Desktop) --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                    {{-- Card 1: Kelembaban Tanah --}}
                    <div class="bg-white rounded-[2rem] p-6 sm:p-8 border border-slate-100 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-300 group"
                        data-aos="fade-up" data-aos-delay="100">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Tanah</h3>
                                <div class="text-slate-800 font-bold text-lg">Kelembaban</div>
                            </div>
                            <div
                                class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300 shadow-sm">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-1 mb-4">
                            <span id="moisture-val"
                                class="text-5xl font-extrabold text-slate-900 tracking-tight">{{ $device->latestSensorData->moisture ?? 0 }}</span>
                            <span class="text-xl font-bold text-slate-400">%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden mb-2">
                            <div id="moisture-bar"
                                class="bg-blue-500 h-2.5 rounded-full transition-all duration-1000 ease-out relative overflow-hidden"
                                style="width: {{ $device->latestSensorData->moisture ?? 0 }}%">
                                <div class="absolute inset-0 bg-white/20 w-full h-full animate-[shimmer_2s_infinite]">
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 font-medium flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            Status: <span id="moisture-text"
                                class="text-slate-700 font-bold">{{ ($device->latestSensorData->moisture ?? 0) < 40 ? 'Kering' : 'Basah' }}</span>
                        </p>
                    </div>

                    {{-- Card 2: Suhu --}}
                    <div class="bg-white rounded-[2rem] p-6 sm:p-8 border border-slate-100 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-300 group"
                        data-aos="fade-up" data-aos-delay="200">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Lingkungan
                                </h3>
                                <div class="text-slate-800 font-bold text-lg">Suhu Area</div>
                            </div>
                            <div
                                class="w-10 h-10 rounded-2xl bg-orange-50 text-orange-500 flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition-colors duration-300 shadow-sm">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2a5 5 0 00-2 9v6a2 2 0 004 0v-6a5 5 0 00-2-9z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-1 mb-6">
                            <span id="temp-val"
                                class="text-5xl font-extrabold text-slate-900 tracking-tight">{{ $device->latestSensorData->temperature ?? 0 }}</span>
                            <span class="text-xl font-bold text-slate-400">°C</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span
                                class="px-2.5 py-1 rounded-lg bg-orange-50 text-orange-600 text-[10px] font-bold border border-orange-100 uppercase tracking-wide">
                                Realtime
                            </span>
                        </div>
                    </div>

                    {{-- Card 3: Kelembaban Udara --}}
                    <div class="bg-white rounded-[2rem] p-6 sm:p-8 border border-slate-100 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-300 group"
                        data-aos="fade-up" data-aos-delay="300">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Lingkungan
                                </h3>
                                <div class="text-slate-800 font-bold text-lg">Kelembaban Udara</div>
                            </div>
                            <div
                                class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-500 flex items-center justify-center group-hover:bg-teal-500 group-hover:text-white transition-colors duration-300 shadow-sm">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-1 mb-4">
                            <span id="humidity-val"
                                class="text-5xl font-extrabold text-slate-900 tracking-tight">{{ $device->latestSensorData->humidity ?? 0 }}</span>
                            <span class="text-xl font-bold text-slate-400">%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden mb-2">
                            <div id="humidity-bar"
                                class="bg-teal-500 h-2.5 rounded-full transition-all duration-1000 ease-out"
                                style="width: {{ $device->latestSensorData->humidity ?? 0 }}%"></div>
                        </div>
                        <p class="text-xs text-slate-500 font-medium flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                            Kondisi Udara
                        </p>
                    </div>
                </div>

                {{-- CONTROL PANEL (PUMP) --}}
                <div class="group relative overflow-hidden rounded-[2rem] border border-slate-100 bg-white p-6 transition-all"
                    data-aos="fade-up" data-aos-delay="400">

                    {{-- Decorative Background (Corner) --}}
                    <div
                        class="absolute -mr-16 -mt-16 right-0 top-0 h-48 w-48 rounded-bl-full bg-slate-50 transition-all group-hover:bg-green-50/50">
                    </div>

                    <div class="relative z-10 flex flex-col items-center justify-between gap-5 sm:flex-row">

                        {{-- Bagian Kiri: Status Display --}}
                        <div class="flex w-full items-center gap-4 sm:w-auto">
                            {{-- Icon Container (Diperkecil agar lebih rapat) --}}
                            <div id="pump-icon-container"
                                class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border transition-all duration-500 {{ $device->is_pump_on ? 'bg-green-50 border-green-200 text-green-600 shadow-md shadow-green-100' : 'bg-slate-50 border-slate-100 text-slate-300' }}">
                                <svg class="h-7 w-7 {{ $device->is_pump_on ? 'animate-pulse' : '' }}" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z" />
                                </svg>
                            </div>

                            {{-- Text Info --}}
                            <div>
                                <h3 class="mb-1 text-lg font-bold text-slate-900 sm:text-xl">Kontrol Penyiraman</h3>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-medium text-slate-500">Status:</span>
                                    <span id="pump-status-label"
                                        class="inline-flex items-center rounded-full border px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide transition-colors {{ $device->is_pump_on ? 'bg-green-100 border-green-200 text-green-700' : 'bg-slate-100 border-slate-200 text-slate-500' }}">
                                        {{ $device->is_pump_on ? 'MENYIRAM' : 'STANDBY' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Bagian Kanan: Toggle Button --}}
                        <div class="w-full sm:w-auto">
                            <form action="{{ route('iot.toggle', $device->id) }}" method="POST">
                                @csrf
                                {{-- BUTTON DIBERI ID AGAR BISA DIUPDATE JS --}}
                                <button id="pump-action-btn" type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl px-6 py-3 text-sm font-bold text-white transition-all duration-300 hover:-translate-y-0.5 active:scale-95 sm:w-auto
        {{ $device->is_pump_on
    ? 'bg-gradient-to-br from-red-500 to-rose-600'
    : 'bg-gradient-to-br from-green-500 to-emerald-600' }}">

                                    @if($device->is_pump_on)
                                        {{-- Icon dan teks untuk keadaan ON --}}
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>MATIKAN</span>
                                    @else
                                        {{-- Icon dan teks untuk keadaan OFF --}}
                                        <svg class="h-5 w-5 animate-bounce" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>SIRAM</span>
                                    @endif
                                </button>
                            </form>

                            {{-- Warning Text untuk mode AUTO --}}
                            @if($device->mode == 'AUTO')
                                <p class="mt-2 text-center text-[10px] leading-tight text-slate-400 sm:text-right">
                                    Mode Otomatis aktif.<br>Kontrol mungkin ditimpa.
                                </p>
                            @endif
                        </div>

                    </div>
                </div>

                {{-- Last Update Info --}}
                <div class="mt-8 flex justify-center" data-aos="fade-up" data-aos-delay="500">
                    <div
                        class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-4 py-1.5 text-xs font-medium text-slate-500 transition-colors hover:border-slate-300 hover:bg-slate-100">
                        {{-- Ikon Jam --}}
                        <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                        <span>
                            Terakhir diperbarui:
                            <span id="last-update" class="font-bold text-slate-700">
                                {{ $device->latestSensorData ? $device->latestSensorData->created_at->diffForHumans() : '-' }}
                            </span>
                        </span>
                    </div>
                </div>

            </div>
        </section>

    </main>

    {{-- FOOTER DAN BACK BUTTON --}}
    <x-footer />
    <x-back-button />

    {{-- SCRIPTS --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // ================================================
        // INISIALISASI AOS (ANIMATION ON SCROLL)
        // ================================================
        AOS.init({
            once: true,
            offset: 50,
            duration: 800
        });

        // ================================================
        // LOGIKA REALTIME UPDATE DATA IOT
        // ================================================
        $(document).ready(function () {
            // Serial number device untuk request data
            var serialNumber = "{{ $device->serial_number }}";

            // Fungsi untuk mengambil dan update data secara realtime
            function updateData() {
                $.ajax({
                    url: "/iot/data/" + serialNumber,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        // 1. UPDATE ANGKA SENSOR
                        $('#moisture-val').text(data.moisture);
                        $('#temp-val').text(data.temperature);
                        $('#humidity-val').text(data.humidity);
                        $('#last-update').text(data.last_update);

                        // 2. UPDATE PROGRESS BAR
                        $('#moisture-bar').css('width', data.moisture + '%');
                        $('#humidity-bar').css('width', data.humidity + '%');

                        // 3. UPDATE TEXT STATUS KELEMBABAN TANAH
                        var statusText = data.moisture < 40 ? 'Kering' : 'Basah';
                        $('#moisture-text').text(statusText);

                        // 4. UPDATE VISUAL STATUS POMPA (LABEL & ICON)
                        if (data.pump_status === 'HIDUP') {
                            $('#pump-status-label')
                                .text('MENYIRAM')
                                .removeClass('bg-slate-100 text-slate-500 border-slate-200')
                                .addClass('bg-green-100 text-green-700 border-green-200');

                            $('#pump-icon-container')
                                .removeClass('bg-slate-50 border-slate-100 text-slate-300')
                                .addClass('bg-green-50 border-green-200 text-green-600 shadow-lg shadow-green-100');
                        } else {
                            $('#pump-status-label')
                                .text('STANDBY')
                                .removeClass('bg-green-100 text-green-700 border-green-200')
                                .addClass('bg-slate-100 text-slate-500 border-slate-200');

                            $('#pump-icon-container')
                                .removeClass('bg-green-50 border-green-200 text-green-600 shadow-lg shadow-green-100')
                                .addClass('bg-slate-50 border-slate-100 text-slate-300');
                        }

                        // 5. UPDATE TOMBOL AKSI POMPA (WARNA & TEKS)
                        var btn = $('#pump-action-btn');
                        var btnText = btn.find('span');

                        if (data.pump_status === 'HIDUP') {
                            // Ubah jadi Tombol Merah (MATIKAN)
                            btn.removeClass('from-green-500 to-emerald-600').addClass('from-red-500 to-rose-600');
                            btnText.text('MATIKAN');
                            btn.find('svg').removeClass('animate-bounce'); // Hapus animasi bounce jika aktif
                        } else {
                            // Ubah jadi Tombol Hijau (SIRAM)
                            btn.removeClass('from-red-500 to-rose-600').addClass('from-green-500 to-emerald-600');
                            btnText.text('SIRAM');
                            btn.find('svg').addClass('animate-bounce'); // Tambah animasi bounce jika standby
                        }
                    },
                    error: function (err) {
                        console.log("Menunggu koneksi...");
                    }
                });
            }

            // Polling setiap 2 detik untuk update data
            setInterval(updateData, 2000);
        });
    </script>
</body>

</html>