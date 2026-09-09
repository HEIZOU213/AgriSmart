<x-petani-layout>
    <div class="p-4 sm:p-6 lg:p-8 max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Pengaturan Akun Midtrans</h1>
            <p class="text-sm sm:text-base text-slate-500 mt-1">
                Kelola kredensial payment gateway Midtrans mandiri Anda. Pembayaran pesanan produk Anda langsung masuk ke akun Anda tanpa perantara dan tanpa potongan admin platform.
            </p>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start gap-3 shadow-sm">
                <svg class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h4 class="font-semibold text-emerald-900">Berhasil Disimpan</h4>
                    <p class="text-sm mt-0.5 text-emerald-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-300 text-rose-800 flex items-start gap-3 shadow-sm">
                <svg class="w-5 h-5 text-rose-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h4 class="font-semibold text-rose-900">Validasi Kredensial Gagal</h4>
                    <p class="text-sm mt-0.5 text-rose-700 leading-relaxed">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800">
                <p class="font-semibold mb-1">Terjadi kesalahan pengisian form:</p>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Status Kredensial Saat Ini --}}
        @if($user->hasCustomMidtrans())
            <div class="mb-6 p-5 rounded-2xl bg-white border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl {{ $user->isMidtransProduction() ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }} flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-bold text-slate-800">Akun Midtrans Terdaftar</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $user->isMidtransProduction() ? 'bg-indigo-100 text-indigo-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $user->isMidtransProduction() ? 'Mode Live / Production' : 'Mode Sandbox / Testing' }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Server Key: <code class="bg-slate-100 px-1 py-0.5 rounded text-[11px]">{{ substr($user->midtrans_server_key, 0, 14) }}...</code> | 
                            Merchant ID: <code class="bg-slate-100 px-1 py-0.5 rounded text-[11px]">{{ $user->midtrans_merchant_id ?: 'Otomatis' }}</code>
                        </p>
                    </div>
                </div>
                <div class="text-xs text-slate-500 bg-slate-50 p-2.5 rounded-xl border border-slate-100 sm:max-w-xs">
                    Jika ada kesalahan kunci atau ingin berganti antara Sandbox &amp; Production, cukup perbarui isian di formulir bawah ini dan klik Simpan.
                </div>
            </div>
        @endif

        {{-- Benefit & Guidance Banner --}}
        <div class="mb-8 rounded-2xl bg-gradient-to-br from-emerald-800 via-teal-900 to-green-950 text-white p-6 sm:p-7 shadow-lg relative overflow-hidden">
            <div class="relative z-10 space-y-3">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-400/20 text-emerald-200 text-xs font-semibold backdrop-blur-sm border border-emerald-300/30">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    100% Penerimaan Langsung Tanpa Admin Fee
                </div>
                <h2 class="text-xl sm:text-2xl font-bold tracking-tight">Sistem Multi-Midtrans Pekebun</h2>
                <p class="text-sm sm:text-base text-emerald-100/90 leading-relaxed">
                    Setiap pekebun memiliki gerbang pembayaran independen. Ketika konsumen memesan Bibit Durian, Booking Buah Durian (DP Booking + Pelunasan), atau Produk Olahan Turunan, dana pembayaran diproses langsung lewat kredensial Midtrans Anda dan masuk langsung ke rekening Anda.
                </p>
                <div class="pt-2 flex flex-wrap gap-4 text-xs sm:text-sm text-emerald-200">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Tanpa penampungan dana pihak ketiga
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Mendukung E-Wallet, QRIS, & Transfer Bank
                    </span>
                </div>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8" x-data="{ showServerKey: false }">
            <form action="{{ route('petani.midtrans.update') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="midtrans_merchant_id" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Merchant ID Midtrans
                    </label>
                    <input type="text"
                           id="midtrans_merchant_id"
                           name="midtrans_merchant_id"
                           value="{{ old('midtrans_merchant_id', $user->midtrans_merchant_id) }}"
                           placeholder="Contoh: G123456789"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition font-mono">
                    <p class="text-xs text-slate-500 mt-1.5">Dapat ditemukan di dashboard Midtrans (pojok kanan atas atau di menu Pengaturan Akun).</p>
                </div>

                <div>
                    <label for="midtrans_client_key" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Client Key
                    </label>
                    <input type="text"
                           id="midtrans_client_key"
                           name="midtrans_client_key"
                           value="{{ old('midtrans_client_key', $user->midtrans_client_key) }}"
                           placeholder="Contoh: SB-Mid-client-XXXXX (Sandbox) atau Mid-client-XXXXX (Production)"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition font-mono">
                    <p class="text-xs text-slate-500 mt-1.5 flex items-center gap-1.5">
                        <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span><strong>Sandbox:</strong> Berawalan <code class="bg-slate-100 px-1 py-0.5 rounded text-[11px]">SB-Mid-client-...</code> | <strong>Production:</strong> Berawalan <code class="bg-slate-100 px-1 py-0.5 rounded text-[11px]">Mid-client-...</code></span>
                    </p>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="midtrans_server_key" class="block text-sm font-semibold text-slate-800">
                            Server Key
                        </label>
                        <button type="button"
                                @click="showServerKey = !showServerKey"
                                class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                            <span x-text="showServerKey ? 'Sembunyikan' : 'Tampilkan'"></span>
                        </button>
                    </div>
                    <input :type="showServerKey ? 'text' : 'password'"
                           id="midtrans_server_key"
                           name="midtrans_server_key"
                           value="{{ old('midtrans_server_key', $user->midtrans_server_key) }}"
                           placeholder="Contoh: SB-Mid-server-XXXXX (Sandbox) atau Mid-server-XXXXX (Production)"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition font-mono">
                    <p class="text-xs text-slate-500 mt-1.5 flex items-center gap-1.5">
                        <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span><strong>Sandbox:</strong> Berawalan <code class="bg-slate-100 px-1 py-0.5 rounded text-[11px]">SB-Mid-server-...</code> | <strong>Production:</strong> Berawalan <code class="bg-slate-100 px-1 py-0.5 rounded text-[11px]">Mid-server-...</code></span>
                    </p>
                    <p class="text-xs text-indigo-600 font-medium mt-1">
                        * Sistem akan otomatis mendeteksi mode Sandbox / Production dan memvalidasi ke server Midtrans saat disimpan.
                    </p>
                </div>

                {{-- Environment Toggle --}}
                <div class="pt-2 border-t border-slate-100">
                    <label class="relative flex items-start gap-3 cursor-pointer p-4 rounded-xl border border-slate-200 hover:bg-slate-50 transition">
                        <input type="checkbox"
                               name="midtrans_is_production"
                               value="1"
                               {{ old('midtrans_is_production', $user->midtrans_is_production) ? 'checked' : '' }}
                               class="mt-1 w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                        <div>
                            <span class="block text-sm font-semibold text-slate-800">Gunakan Mode Production (Live)</span>
                            <span class="block text-xs text-slate-500 mt-0.5">
                                Centang opsi ini jika kredensial di atas adalah akun Live/Production resmi Midtrans. Jika tidak dicentang, sistem akan menggunakan mode Sandbox (Testing).
                            </span>
                        </div>
                    </label>
                </div>

                {{-- Action Buttons --}}
                <div class="pt-4 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('portal.marketplace.dashboard') }}"
                       class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-semibold transition text-center">
                        Kembali ke Dashboard
                    </a>
                    <button type="submit"
                            class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-sm transition inline-flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Pengaturan Midtrans
                    </button>
                </div>
            </form>
        </div>

        {{-- Guide Accordion --}}
        <div class="mt-8 bg-slate-50 rounded-2xl p-6 border border-slate-200">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-3">Panduan Singkat Mendapatkan Kredensial</h3>
            <ol class="text-sm text-slate-600 space-y-2 list-decimal list-inside">
                <li>Daftar atau masuk ke <a href="https://dashboard.midtrans.com" target="_blank" class="text-emerald-600 font-semibold underline">dashboard.midtrans.com</a>.</li>
                <li>Pilih mode akun yang diinginkan: <strong>Sandbox</strong> untuk uji coba atau <strong>Production</strong> untuk transaksi sungguhan.</li>
                <li>Buka menu <strong>Settings</strong> &gt; <strong>Access Keys</strong> di sidebar kiri Midtrans.</li>
                <li>Salin <strong>Merchant ID</strong>, <strong>Client Key</strong>, dan <strong>Server Key</strong> Anda ke form di atas.</li>
                <li>Di menu <strong>Settings</strong> &gt; <strong>Configuration</strong> pada dashboard Midtrans, atur <em>Payment Notification URL</em> ke:
                    <code class="block mt-1 p-2 rounded-lg bg-white border border-slate-200 text-xs font-mono text-emerald-700 break-all select-all">
                        {{ url('/api/midtrans-callback') }}
                    </code>
                </li>
            </ol>
        </div>
    </div>
</x-petani-layout>
