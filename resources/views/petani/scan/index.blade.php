<x-petani-layout>
    <div class="p-4 sm:p-6 lg:p-8 max-w-4xl mx-auto" x-data="qrScanner()">
        {{-- Header --}}
        <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Scanner QR Code Pesanan</h1>
                <p class="text-sm sm:text-base text-slate-500 mt-1">
                    Scan E-Kwitansi atau QR Code pesanan pembeli untuk verifikasi, penimbangan durian, atau pelunasan panen.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('petani.pesanan.index') }}" class="px-4 py-2 text-sm font-semibold rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 transition">
                    Daftar Pesanan
                </a>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center gap-3">
                <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Camera Scanner Viewport --}}
            <div class="lg:col-span-7 space-y-4">
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="relative bg-slate-950 rounded-xl overflow-hidden aspect-square flex flex-col items-center justify-center text-white shadow-inner">
                        {{-- Video container for html5-qrcode --}}
                        <div id="qr-reader" class="w-full h-full"></div>

                        {{-- Overlay reticle when scanning --}}
                        <div x-show="scanning" class="absolute inset-0 pointer-events-none flex items-center justify-center">
                            <div class="w-3/4 h-3/4 border-2 border-dashed border-emerald-400/70 rounded-2xl animate-pulse relative">
                                <span class="absolute top-2 left-2 w-4 h-4 border-t-2 border-l-2 border-emerald-400"></span>
                                <span class="absolute top-2 right-2 w-4 h-4 border-t-2 border-r-2 border-emerald-400"></span>
                                <span class="absolute bottom-2 left-2 w-4 h-4 border-b-2 border-l-2 border-emerald-400"></span>
                                <span class="absolute bottom-2 right-2 w-4 h-4 border-b-2 border-r-2 border-emerald-400"></span>
                            </div>
                        </div>

                        {{-- Placeholder when camera is stopped --}}
                        <div x-show="!scanning" class="text-center p-6 space-y-3">
                            <div class="w-16 h-16 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center mx-auto text-emerald-400 shadow">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-slate-200">Kamera Scanner Sedang Nonaktif</p>
                            <p class="text-xs text-slate-400 max-w-xs">Klik tombol di bawah untuk mengaktifkan kamera smartphone atau webcam Anda.</p>
                        </div>
                    </div>

                    {{-- Camera Action Buttons --}}
                    <div class="mt-4 flex items-center justify-between gap-3">
                        <button type="button"
                                @click="toggleCamera()"
                                :class="scanning ? 'bg-rose-600 hover:bg-rose-700 text-white' : 'bg-emerald-600 hover:bg-emerald-700 text-white'"
                                class="flex-1 py-2.5 px-4 rounded-xl font-semibold text-sm shadow-sm transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            <span x-text="scanning ? 'Hentikan Kamera' : 'Buka Kamera Scanner'"></span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Manual Input & Scan Result Panel --}}
            <div class="lg:col-span-5 space-y-6">
                {{-- Manual Code Input Form --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <h3 class="text-base font-bold text-slate-900 mb-2">Input Manual Kode / Kwitansi</h3>
                    <p class="text-xs text-slate-500 mb-4">Jika kamera tidak tersedia, ketikkan kode pesanan (contoh: BKG-20260909-XXXX) atau nomor kwitansi pembeli.</p>

                    <form action="{{ route('petani.scan.verify') }}" method="POST" @submit.prevent="submitManual()">
                        @csrf
                        <div class="space-y-3">
                            <input type="text"
                                   x-model="manualCode"
                                   placeholder="Contoh: BKG-20260908-ABC123"
                                   class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-mono uppercase focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                            <button type="submit"
                                    :disabled="loading || !manualCode"
                                    class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 disabled:opacity-50 text-white text-sm font-semibold transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <span>Verifikasi Kode</span>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Live Scanned Result Card --}}
                <div x-show="result" x-cloak class="bg-emerald-50 rounded-2xl border border-emerald-200 p-6 shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-200 text-emerald-900"
                              x-text="result?.is_booking ? 'Booking Buah Durian' : 'Pesanan Reguler'"></span>
                        <span class="text-xs font-semibold text-emerald-800 capitalize" x-text="'Status: ' + result?.status"></span>
                    </div>

                    <div>
                        <p class="text-xs text-emerald-700 font-medium">Kode Pesanan</p>
                        <h4 class="text-lg font-bold text-emerald-950 font-mono" x-text="result?.kode_pesanan"></h4>
                        <template x-if="result?.kwitansi_nomor">
                            <p class="text-xs text-emerald-800 font-mono mt-0.5" x-text="'No. Kwitansi: ' + result?.kwitansi_nomor"></p>
                        </template>
                    </div>

                    <div class="bg-white/80 rounded-xl p-3 text-xs space-y-1.5 border border-emerald-100">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Nama Pembeli:</span>
                            <span class="font-bold text-slate-800" x-text="result?.pembeli"></span>
                        </div>
                        <template x-if="result?.is_booking">
                            <div class="space-y-1">
                                <div class="flex justify-between">
                                    <span class="text-slate-500">DP Dibayar:</span>
                                    <span class="font-semibold text-emerald-700" x-text="'Rp ' + Number(result?.dp_amount || 0).toLocaleString('id-ID')"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Berat Timbang:</span>
                                    <span class="font-bold text-slate-800" x-text="result?.berat_aktual_kg ? (result?.berat_aktual_kg + ' Kg') : 'Belum Ditimbang'"></span>
                                </div>
                                <template x-if="result?.sisa_pelunasan > 0">
                                    <div class="flex justify-between border-t border-slate-100 pt-1">
                                        <span class="text-slate-700 font-bold">Sisa Pelunasan:</span>
                                        <span class="font-bold text-amber-600" x-text="'Rp ' + Number(result?.sisa_pelunasan).toLocaleString('id-ID')"></span>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>

                    <a :href="result?.redirect_url"
                       class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm text-center block shadow transition">
                        Buka Halaman Detail & Penimbangan &rarr;
                    </a>
                </div>

                {{-- Error Alert --}}
                <div x-show="errorMessage" x-cloak class="bg-rose-50 rounded-2xl border border-rose-200 p-4 text-rose-800 text-sm flex items-start gap-2.5">
                    <svg class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <p x-text="errorMessage"></p>
                </div>
            </div>
        </div>
    </div>

    {{-- Script html5-qrcode --}}
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        function qrScanner() {
            return {
                scanning: false,
                html5QrCode: null,
                manualCode: '',
                loading: false,
                result: null,
                errorMessage: '',

                init() {
                    // Ready
                },

                toggleCamera() {
                    if (this.scanning) {
                        this.stopCamera();
                    } else {
                        this.startCamera();
                    }
                },

                startCamera() {
                    this.errorMessage = '';
                    this.result = null;

                    if (typeof Html5Qrcode === 'undefined') {
                        this.errorMessage = 'Library scanner belum selesai dimuat. Silakan periksa koneksi internet atau gunakan input manual.';
                        return;
                    }

                    this.html5QrCode = new Html5Qrcode("qr-reader");
                    const config = { fps: 10, qrbox: { width: 250, height: 250 } };

                    this.html5QrCode.start(
                        { facingMode: "environment" },
                        config,
                        (decodedText) => {
                            this.onScanSuccess(decodedText);
                        },
                        (error) => {
                            // Ignored per frame error
                        }
                    ).then(() => {
                        this.scanning = true;
                    }).catch(err => {
                        this.scanning = false;
                        this.errorMessage = 'Gagal mengakses kamera: ' + (err.message || err);
                    });
                },

                stopCamera() {
                    if (this.html5QrCode && this.scanning) {
                        this.html5QrCode.stop().then(() => {
                            this.scanning = false;
                        }).catch(err => console.error(err));
                    } else {
                        this.scanning = false;
                    }
                },

                onScanSuccess(decodedText) {
                    // Stop camera temporarily upon detection
                    this.stopCamera();
                    this.verifyCode(decodedText);
                },

                submitManual() {
                    if (!this.manualCode.trim()) return;
                    this.verifyCode(this.manualCode.trim());
                },

                verifyCode(code) {
                    this.loading = true;
                    this.errorMessage = '';
                    this.result = null;

                    fetch('{{ route("petani.scan.verify") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ code: code })
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.loading = false;
                        if (data.success) {
                            this.result = data.data;
                        } else {
                            this.errorMessage = data.message || 'Pesanan tidak ditemukan atau bukan pesanan produk Anda.';
                        }
                    })
                    .catch(err => {
                        this.loading = false;
                        this.errorMessage = 'Gagal memverifikasi kode pesanan.';
                    });
                }
            }
        }
    </script>
</x-petani-layout>
