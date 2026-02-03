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
                    <dd class="mt-1 text-lg font-bold text-green-600">Rp
                        {{ number_format($pesanan->total_harga, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">Alamat Kirim</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->alamat_kirim }}</dd>
                </div>
            </div>

            {{-- Tombol Chat Penjual --}}
            <div class="mt-6 pt-4 border-t border-gray-100">
                @php
                    // Ambil ID Penjual dari produk pertama di pesanan
                    $sellerId = optional($pesanan->detailPesanan->first()->produk)->user_id;

                    // Siapkan pesan otomatis dengan Nomor Pesanan
                    $chatText = "Halo, saya ingin bertanya mengenai pesanan #" . $pesanan->kode_pesanan;
                @endphp

                @if($sellerId)
                    <a href="{{ route('chat.show', ['userId' => $sellerId, 'text' => $chatText, 'back_url' => url()->current()]) }}"
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-bold rounded-lg hover:bg-green-700 transition shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        Chat Penjual
                    </a>
                @else
                    <button disabled
                        class="inline-flex items-center px-4 py-2 bg-gray-400 text-white text-sm font-bold rounded-lg cursor-not-allowed">
                        Penjual Tidak Tersedia
                    </button>
                @endif
            </div>
        </div>

        <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-sm font-bold text-gray-700">Produk Dibeli</h3>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase">Jml</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase">Harga</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($pesanan->detailPesanan as $detail)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $detail->produk->nama_produk ?? '[Dihapus]' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $detail->jumlah }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 text-right">Rp
                                {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900 text-right">Rp
                                {{ number_format($detail->harga_satuan * $detail->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-konsumen-layout>