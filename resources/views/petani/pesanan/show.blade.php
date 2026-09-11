<x-petani-layout>
   <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pesanan ') }} ({{ $pesanan->kode_pesanan }})
            </h2>
            {{-- Hubungi Pembeli --}}
            <a href="{{ route('chat.show', ['userId' => $pesanan->user_id, 'text' => 'Halo ' . ($pesanan->user->name ?? 'Pelanggan') . ', mengenai pesanan #' . $pesanan->kode_pesanan, 'back_url' => route('petani.pesanan.show', $pesanan->id)]) }}" 
               class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-wider hover:bg-emerald-700 transition shadow-sm">
                Hubungi Pembeli
            </a>
        </div>
    </x-slot>

    <div class="text-gray-900">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- KOLOM KIRI: STATUS DAN AKSI KONFIRMASI --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Card Status Pesanan --}}
                <div class="bg-white shadow sm:rounded-lg p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold mb-3 border-b pb-2">Status & Aksi</h3>
                    <div class="mb-4 text-center">
                        <p class="text-sm text-gray-500">Status Saat Ini:</p>
                        <p class="text-2xl font-bold capitalize {{ $pesanan->status == 'done' ? 'text-green-600' : ($pesanan->status == 'cancelled' ? 'text-red-600' : ($pesanan->status == 'menunggu_pelunasan' ? 'text-amber-600' : 'text-emerald-600')) }}">{{ str_replace('_', ' ', $pesanan->status) }}</p>
                        @if($pesanan->isBookingDurian())
                            <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                Booking Buah Durian
                            </span>
                        @endif
                    </div>

                    {{-- Form untuk Update Status --}}
                    <form action="{{ route('petani.pesanan.update', $pesanan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label for="status" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mt-4 mb-1.5">Ubah Status:</label>
                        <x-custom-dropdown 
                            name="status" 
                            id="status" 
                            :value="$pesanan->status" 
                            :options="[
                                'shipping' => '01. Shipping (Sedang Dikirim)',
                                'done' => '02. Done (Pesanan Selesai)',
                                'cancelled' => '03. Cancelled (Batalkan Pesanan)'
                            ]" 
                            required 
                        />

                        <button type="submit" class="mt-4 w-full px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700 transition">
                            Konfirmasi Perubahan Status
                        </button>

                        <div class="mt-3 pt-3 border-t border-gray-100 text-center">
                            <a href="{{ route('konsumen.pesanan.kwitansi', $pesanan->id) }}" target="_blank"
                               class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 hover:text-emerald-800 underline">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                Buka E-Kwitansi & QR Code
                            </a>
                        </div>
                    </form>
                </div>

                {{-- Penimbangan Buah Durian Pasca Panen --}}
                @if($pesanan->isBookingDurian())
                    <div class="bg-white shadow sm:rounded-lg p-6 border border-emerald-200"
                        x-data="{
                            berat: {{ $pesanan->berat_aktual_kg ?? 0 }},
                            hargaPerKg: {{ $pesanan->detailPesanan->first()?->harga_satuan ?? 0 }},
                            dpAmount: {{ (float) ($pesanan->dp_amount ?: 100000) }},
                            get total() { return (this.berat * this.hargaPerKg) || 0; },
                            get sisa() { return Math.max(0, this.total - this.dpAmount); }
                         }">
                        <div class="flex items-center gap-2 mb-3 border-b border-emerald-100 pb-2">
                            <span class="p-1.5 rounded-lg bg-emerald-100 text-emerald-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                </svg>
                            </span>
                            <h3 class="text-base font-bold text-slate-800">Penimbangan Durian</h3>
                        </div>

                        <div class="text-xs space-y-2 mb-4 bg-emerald-50/70 p-3 rounded-xl border border-emerald-100">
                            <div class="flex justify-between">
                                <span class="text-slate-600">DP Diterima:</span>
                                <span class="font-bold text-emerald-800">Rp {{ number_format($pesanan->dp_amount ?: 100000, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600">Harga / Kg:</span>
                                <span class="font-mono text-slate-900">Rp {{ number_format($pesanan->detailPesanan->first()?->harga_satuan ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <form action="{{ route('petani.pesanan.timbangan', $pesanan->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="berat_aktual_kg" class="block text-xs font-bold text-slate-700 mb-1">
                                    Berat Aktual Buah (Kg):
                                </label>
                                <div class="relative">
                                    <input type="number"
                                           id="berat_aktual_kg"
                                           name="berat_aktual_kg"
                                           step="0.05"
                                           min="0.1"
                                           max="500"
                                           x-model="berat"
                                           value="{{ old('berat_aktual_kg', $pesanan->berat_aktual_kg) }}"
                                           placeholder="Contoh: 3.45"
                                           required
                                           class="w-full rounded-xl border border-slate-300 pr-10 pl-3 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                                    <span class="absolute right-3 top-2 text-xs font-bold text-slate-400">Kg</span>
                                </div>
                            </div>

                            {{-- Live Estimation --}}
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 space-y-1.5 text-xs">
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Estimasi Total:</span>
                                    <span class="font-bold text-slate-900" x-text="'Rp ' + Math.round(total).toLocaleString('id-ID')"></span>
                                </div>
                                <div class="flex justify-between border-t border-slate-200 pt-1">
                                    <span class="font-bold text-emerald-800">Sisa Pelunasan:</span>
                                    <span class="font-bold text-emerald-700" x-text="'Rp ' + Math.round(sisa).toLocaleString('id-ID')"></span>
                                </div>
                            </div>

                            <button type="submit"
                                    class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-sm">
                                {{ $pesanan->berat_aktual_kg ? 'Perbarui Data Timbangan' : 'Simpan Timbangan & Terbitkan Kwitansi' }}
                            </button>
                        </form>

                        {{-- Link Kwitansi & QR --}}
                        <div class="mt-4 pt-3 border-t border-slate-100 text-center">
                            <a href="{{ route('konsumen.pesanan.kwitansi', $pesanan->id) }}" target="_blank"
                               class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 hover:text-emerald-800 underline">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                Buka E-Kwitansi & QR Code
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            {{-- KOLOM KANAN: DETAIL PESANAN --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Detail Pelanggan --}}
                <div class="bg-white shadow sm:rounded-lg p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold mb-3 border-b pb-2">Detail Pelanggan & Pengiriman</h3>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2">
                        <dt class="text-sm font-medium text-gray-500">Nama Pelanggan</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->user->name }}</dd>
                        <dt class="text-sm font-medium text-gray-500">Total Tagihan</dt>
                        <dd class="mt-1 text-sm font-bold text-gray-900">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</dd>
                        <dt class="text-sm font-medium text-gray-500">Alamat Kirim</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">{{ $pesanan->alamat_kirim }}</dd>
                    </dl>
                </div>

                {{-- Daftar Produk yang Dibeli --}}
                <div class="bg-white shadow-sm rounded-2xl p-6 border border-gray-200 overflow-hidden">
                    <h3 class="text-lg font-bold text-gray-800 mb-3 border-b pb-2">Produk yang Dibeli</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[500px] divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Jml</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Harga Satuan</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($pesanan->detailPesanan as $detail)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $detail->produk ? $detail->produk->nama_produk : '[Produk Dihapus]' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $detail->jumlah }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right">Rp {{ number_format($detail->harga_satuan * $detail->jumlah, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                {{-- (BAGIAN LOG PESAN SUDAH DIHAPUS DARI SINI) --}}

            </div>
        </div>
    </div>
</x-petani-layout>

