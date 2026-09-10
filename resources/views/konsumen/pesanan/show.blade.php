<x-konsumen-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span>{{ __('Detail Pesanan: ') }} {{ $pesanan->kode_pesanan }}</span>
            <a href="{{ route('konsumen.pesanan.index') }}"
                class="text-sm text-gray-500 hover:text-gray-800 font-normal">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="space-y-6">

        <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800">Ringkasan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tanggal Pesan</dt>
                    <dd class="mt-1 text-sm text-gray-900 font-medium">{{ $pesanan->created_at->format('d M Y, H:i') }}
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Status</dt>
                    <dd class="mt-1">
                        <span
                            class="px-2 py-1 text-xs font-bold rounded bg-gray-100 text-gray-800 capitalize">{{ $pesanan->status }}</span>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Tagihan</dt>
                    <dd class="mt-1 text-lg font-bold text-green-600">
                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                        @if($pesanan->isBookingDurian())
                            <span class="block text-xs font-semibold text-emerald-700 mt-0.5">
                                (DP Tetap: Rp {{ number_format($pesanan->dp_amount ?: 100000, 0, ',', '.') }})
                            </span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Alamat Kirim</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->alamat_kirim }}</dd>
                </div>
            </div>

            {{-- Durian Booking Status Banner --}}
            @if($pesanan->isBookingDurian())
                <div class="mt-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <span class="inline-block px-2.5 py-0.5 text-xs font-bold rounded-full bg-emerald-200 text-emerald-900 uppercase">
                                Booking Buah Durian
                            </span>
                            <h4 class="font-bold text-emerald-950 mt-1">Status Penimbangan & Pelunasan</h4>
                            <p class="text-xs text-emerald-800 mt-0.5">
                                @if($pesanan->berat_aktual_kg)
                                    Durian telah dipanen & ditimbang: <strong>{{ $pesanan->berat_aktual_kg }} Kg</strong>.
                                    Total: <strong>Rp {{ number_format($pesanan->total_setelah_timbang, 0, ',', '.') }}</strong> | 
                                    Sisa Pelunasan: <strong class="text-amber-700">Rp {{ number_format($pesanan->sisa_pelunasan, 0, ',', '.') }}</strong>
                                @else
                                    DP sebesar Rp {{ number_format($pesanan->dp_amount ?: 100000, 0, ',', '.') }} berhasil dibayarkan. Sedang menunggu panen & penimbangan oleh pekebun.
                                @endif
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('konsumen.pesanan.kwitansi', $pesanan->id) }}"
                               class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Buka E-Kwitansi & QR
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Actions: Konfirmasi Selesai, Batal, & Chat Penjual --}}
            <div class="mt-6 pt-4 border-t border-gray-100 flex flex-wrap items-center gap-3">
                @if($pesanan->status != 'cancelled')
                    <a href="{{ route('konsumen.pesanan.kwitansi', $pesanan->id) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-lg shadow-sm hover:shadow transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Buka E-Kwitansi & QR
                    </a>
                @endif
                @if($pesanan->status == 'shipping')
                    <form action="{{ route('konsumen.pesanan.selesai', $pesanan->id) }}" method="POST"
                          onsubmit="return confirm('Apakah pesanan sudah Anda terima dengan baik? Tindakan ini akan menyelesaikan pesanan.');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-lg hover:bg-emerald-700 transition shadow-sm hover:shadow">
                            Konfirmasi Pesanan Diterima
                        </button>
                    </form>
                @endif

                @if($pesanan->status == 'pending')
                    <form action="{{ route('pesanan.cancel', $pesanan->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin membatalkan pesanan? Stok produk akan dikembalikan.');">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-100 text-red-600 text-sm font-bold rounded-lg hover:bg-red-200 transition">
                            Batalkan Pesanan
                        </button>
                    </form>
                @endif

                @php
                    // Ambil ID Penjual dari produk pertama di pesanan
                    $sellerId = optional($pesanan->detailPesanan->first()?->produk)->user_id;

                    // Siapkan pesan otomatis dengan Nomor Pesanan
                    $chatText = "Halo, saya ingin bertanya mengenai pesanan #" . $pesanan->kode_pesanan;
                @endphp

                @if($sellerId)
                    <a href="{{ route('chat.show', ['userId' => $sellerId, 'text' => $chatText, 'back_url' => url()->current()]) }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 text-sm font-bold rounded-lg transition">
                        Chat Penjual
                    </a>
                @else
                    <button disabled
                        class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-400 text-sm font-bold rounded-lg cursor-not-allowed">
                        Penjual Tidak Tersedia
                    </button>
                @endif
            </div>
        </div>

        <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-sm font-bold text-gray-700">Produk Dibeli</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full min-w-[500px] divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase whitespace-nowrap">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase whitespace-nowrap">Jml</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase whitespace-nowrap">Harga</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase whitespace-nowrap">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($pesanan->detailPesanan as $detail)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                    {{ $detail->produk->nama_produk ?? '[Dihapus]' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $detail->jumlah }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-right whitespace-nowrap">Rp
                                    {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-900 text-right whitespace-nowrap">Rp
                                    {{ number_format($detail->harga_satuan * $detail->jumlah, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-konsumen-layout>

