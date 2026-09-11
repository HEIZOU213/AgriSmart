<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-Kwitansi {{ $pesanan->kwitansi_nomor ?? $pesanan->kode_pesanan }} — AgriSmart</title>
    <x-favicon />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @php
        $seller = $pesanan->getPekebun();
        $isProduction = $seller ? $seller->isMidtransProduction() : config('services.midtrans.is_production', false);
        $clientKey = $seller ? $seller->getMidtransClientKey() : config('services.midtrans.client_key');
        $snapUrl = $isProduction 
            ? 'https://app.midtrans.com/snap/snap.js' 
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    @endphp

    @if($pesanan->status === 'menunggu_pelunasan' && !empty($clientKey))
        <script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
    @endif

    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; font-size: 12pt; }
            .print-shadow-none { box-shadow: none !important; border: 1px solid #e2e8f0 !important; }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased min-h-screen py-6 px-4 sm:px-6 lg:px-8">

    @php
        $backUrl = url()->previous();
        if (!$backUrl || $backUrl === url()->current()) {
            $userRole = auth()->user()?->role;
            $backUrl = in_array($userRole, ['petani', 'pekebun']) ? route('petani.pesanan.index') : route('konsumen.pesanan.index');
        }
    @endphp

    {{-- Top Action Bar (No Print) --}}
    <div class="max-w-3xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ $backUrl }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
        <div class="flex items-center gap-3">
            <button onclick="window.print()"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-semibold shadow-sm transition">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak / Simpan PDF
            </button>
            @if($pesanan->status === 'menunggu_pelunasan')
                <button id="pay-button"
                        class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold shadow-md transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Bayar Pelunasan (Rp {{ number_format($pesanan->sisa_pelunasan, 0, ',', '.') }})
                </button>
            @endif
        </div>
    </div>

    {{-- Kwitansi Container --}}
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg border border-slate-200 print-shadow-none overflow-hidden relative">
        
        {{-- Watermark LUNAS jika sudah lunas --}}
        @if($pesanan->isLunas())
            <div class="absolute inset-0 pointer-events-none flex items-center justify-center opacity-10 select-none z-0">
                <span class="text-8xl sm:text-9xl font-black text-emerald-800 -rotate-12 border-8 border-emerald-800 rounded-3xl px-8 py-4 uppercase">
                    LUNAS
                </span>
            </div>
        @endif

        {{-- Header Kwitansi --}}
        <div class="p-6 sm:p-8 bg-gradient-to-r from-emerald-900 to-green-950 text-white relative z-10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2.5 mb-2">
                        <span class="w-8 h-8 rounded-lg bg-emerald-500/30 border border-emerald-400/50 flex items-center justify-center text-emerald-300 font-black text-sm">
                            AS
                        </span>
                        <span class="text-xl font-black tracking-tight text-white">AgriSmart Marketplace</span>
                    </div>
                    <h1 class="text-lg sm:text-xl font-bold text-emerald-100 uppercase tracking-wide">
                        E-Kwitansi Pemesanan & Pelunasan Buah Durian
                    </h1>
                </div>

                <div class="sm:text-right">
                    <p class="text-xs uppercase text-emerald-300 font-semibold tracking-wider">Nomor Kwitansi</p>
                    <p class="text-base sm:text-lg font-mono font-bold text-white mt-0.5">
                        {{ $pesanan->kwitansi_nomor ?? ('KW-' . $pesanan->kode_pesanan) }}
                    </p>
                    <p class="text-xs text-emerald-200 mt-1">
                        {{ $pesanan->created_at ? $pesanan->created_at->translatedFormat('d F Y, H:i') : now()->translatedFormat('d F Y') }} WIB
                    </p>
                </div>
            </div>
        </div>

        {{-- Status Bar --}}
        <div class="px-6 sm:px-8 py-3 bg-slate-50 border-b border-slate-200 flex flex-wrap items-center justify-between gap-3 text-xs sm:text-sm">
            <div class="flex items-center gap-2">
                <span class="font-bold text-slate-600">Kode Pesanan:</span>
                <span class="font-mono font-semibold text-slate-900">{{ $pesanan->kode_pesanan }}</span>
            </div>
            <div>
                @if($pesanan->isLunas())
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-bold">
                        <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        LUNAS / SELESAI
                    </span>
                @elseif($pesanan->status === 'menunggu_pelunasan')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-900 font-bold">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                        MENUNGGU PELUNASAN
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100 text-blue-900 font-bold">
                        DIBOOKING (DP TERBAYAR)
                    </span>
                @endif
            </div>
        </div>

        <div class="p-6 sm:p-8 space-y-8 relative z-10">
            {{-- Parties: Penjual & Pembeli --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6 border-b border-slate-200">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Pekebun Penjual</h3>
                    <p class="font-bold text-slate-900 text-base">{{ $seller?->name ?? 'Pekebun AgriSmart' }}</p>
                    <p class="text-xs text-slate-600 mt-1">{{ $seller?->no_telepon ?? '-' }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $seller?->alamat ?? 'Kebun Durian AgriSmart' }}</p>
                    <p class="text-[11px] text-emerald-700 font-semibold mt-1">Pembayaran Langsung ke Midtrans Pekebun</p>
                </div>

                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Konsumen Pembeli</h3>
                    <p class="font-bold text-slate-900 text-base">{{ $pesanan->user?->name ?? 'Konsumen' }}</p>
                    <p class="text-xs text-slate-600 mt-1">{{ $pesanan->user?->no_telepon ?? '-' }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $pesanan->alamat_kirim ?? '-' }}</p>
                </div>
            </div>

            {{-- Durian Items Table --}}
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Detail Produk Pesanan</h3>
                <div class="border border-slate-200 rounded-xl overflow-hidden">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold text-xs uppercase">
                            <tr>
                                <th class="py-3 px-4">Produk</th>
                                <th class="py-3 px-4 text-center">Harga / Satuan</th>
                                <th class="py-3 px-4 text-center">Jumlah / Berat</th>
                                <th class="py-3 px-4 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($pesanan->detailPesanan as $detail)
                                <tr>
                                    <td class="py-3.5 px-4 font-semibold text-slate-900">
                                        {{ $detail->produk?->nama_produk ?? 'Produk AgriSmart' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-center font-mono">
                                        Rp {{ number_format($detail->harga_satuan ?? ($pesanan->harga_per_kg ?? 0), 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-4 text-center font-bold text-slate-800">
                                        @if($pesanan->berat_aktual_kg)
                                            {{ $pesanan->berat_aktual_kg }} kg
                                        @elseif($pesanan->isBookingDurian())
                                            Menunggu Panen
                                        @else
                                            {{ $detail->jumlah }} {{ $detail->produk?->satuan ?? 'item' }}
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-mono font-bold text-slate-900">
                                        @if($pesanan->total_setelah_timbang)
                                            Rp {{ number_format($pesanan->total_setelah_timbang, 0, ',', '.') }}
                                        @else
                                            Rp {{ number_format(($detail->harga_satuan ?? 0) * ($detail->jumlah ?? 1), 0, ',', '.') }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Calculation & QR Code Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-6 items-start pt-2">
                {{-- QR Code Card --}}
                <div class="sm:col-span-5 bg-slate-50 rounded-2xl p-5 border border-slate-200 text-center space-y-3">
                    <div class="w-44 h-44 mx-auto bg-white p-2.5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-center">
                        <img src="{{ $pesanan->qr_code_url }}" 
                             alt="QR Code Kwitansi" 
                             class="w-full h-full object-contain"
                             onerror="if (!this.dataset.fallback) { this.dataset.fallback='1'; this.src='https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=' + encodeURIComponent('{{ $pesanan->kwitansi_qr_payload }}'); }" />
                    </div>
                    <div>
                        <p class="text-xs font-mono font-bold text-slate-700">{{ $pesanan->kwitansi_nomor }}</p>
                        <p class="text-xs font-bold text-slate-800 mt-1">QR Code Verifikasi & Pelunasan</p>
                        <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                            Pindai QR ini melalui aplikasi scanner pekebun atau smartphone untuk verifikasi keaslian kwitansi dan serah terima durian.
                        </p>
                    </div>
                </div>

                {{-- Financial Summary Breakdown --}}
                <div class="sm:col-span-7 space-y-3 text-sm">
                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200 space-y-3">
                        <div class="flex justify-between items-center text-slate-600">
                            <span>Sistem Transaksi:</span>
                            <span class="font-bold text-slate-800">{{ $pesanan->isBookingDurian() ? 'Booking Buah Durian' : 'Pembelian Langsung (Ready Stock)' }}</span>
                        </div>

                        @if($pesanan->isBookingDurian())
                            <div class="flex justify-between items-center text-slate-600">
                                <span>Down Payment (DP):</span>
                                <span class="font-mono font-semibold text-emerald-700">Rp {{ number_format($pesanan->dp_amount ?: 100000, 0, ',', '.') }}</span>
                            </div>

                            <div class="flex justify-between items-center text-slate-600">
                                <span>Status DP:</span>
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    Terbayar {{ $pesanan->dp_paid_at ? '(' . $pesanan->dp_paid_at->format('d/m/Y') . ')' : '' }}
                                </span>
                            </div>
                        @endif

                        <div class="border-t border-slate-200 pt-2 flex justify-between items-center text-slate-600">
                            <span>Total Tagihan:</span>
                            <span class="font-mono font-bold text-slate-900">
                                @if($pesanan->total_setelah_timbang)
                                    Rp {{ number_format($pesanan->total_setelah_timbang, 0, ',', '.') }}
                                @else
                                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                @endif
                            </span>
                        </div>

                        @if($pesanan->isBookingDurian())
                            <div class="border-t-2 border-slate-300 pt-2 flex justify-between items-center text-base font-bold">
                                <span class="text-slate-900">Sisa Pelunasan:</span>
                                <span class="font-mono {{ ($pesanan->sisa_pelunasan ?? 0) > 0 ? 'text-emerald-700' : 'text-slate-500' }} text-lg">
                                    @if(($pesanan->sisa_pelunasan ?? 0) > 0)
                                        Rp {{ number_format($pesanan->sisa_pelunasan, 0, ',', '.') }}
                                    @else
                                        Rp 0 <span class="text-xs font-semibold text-emerald-600">(Lunas)</span>
                                    @endif
                                </span>
                            </div>
                        @else
                            <div class="border-t-2 border-slate-300 pt-2 flex justify-between items-center text-base font-bold">
                                <span class="text-slate-900">Status Pembayaran:</span>
                                <span class="font-mono text-emerald-700 text-base">
                                    {{ strtoupper($pesanan->status) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Info Note --}}
                    @if($pesanan->isBookingDurian())
                        <p class="text-[11px] text-slate-400 italic">
                            * Catatan: Total harga akhir dihitung berdasarkan berat aktual buah durian saat dipanen dikurangi DP (Rp {{ number_format($pesanan->dp_amount ?: 100000, 0, ',', '.') }}) yang telah dibayarkan di awal.
                        </p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Footer Kwitansi --}}
        <div class="p-6 bg-slate-50 border-t border-slate-200 text-center text-xs text-slate-500">
            <p>E-Kwitansi resmi ini diterbitkan secara otomatis oleh sistem AgriSmart atas nama Pekebun terkait.</p>
            <p class="mt-0.5">Seluruh transaksi diproses langsung secara terenkripsi melalui payment gateway Midtrans.</p>
        </div>
    </div>

    {{-- Midtrans Snap Trigger Script --}}
    @if($pesanan->status === 'menunggu_pelunasan')
        <script>
            document.getElementById('pay-button')?.addEventListener('click', function () {
                const snapToken = @json($pesanan->pelunasan_snap_token);
                if (snapToken && typeof window.snap !== 'undefined') {
                    window.snap.pay(snapToken, {
                        onSuccess: function (result) {
                            window.location.href = "{{ route('payment.finish') }}?order_id=PELUNASAN-{{ $pesanan->kode_pesanan }}";
                        },
                        onPending: function (result) {
                            window.location.reload();
                        },
                        onError: function (result) {
                            alert('Pembayaran gagal atau dibatalkan.');
                        },
                        onClose: function () {
                            // User closed the popup
                        }
                    });
                } else {
                    // Fallback to post form
                    fetch('{{ route("konsumen.pesanan.bayar-pelunasan", $pesanan->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.snap_token && typeof window.snap !== 'undefined') {
                            window.snap.pay(data.snap_token);
                        } else {
                            window.location.reload();
                        }
                    })
                    .catch(() => window.location.reload());
                }
            });
        </script>
    @endif
</body>
</html>
