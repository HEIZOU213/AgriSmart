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
                <div class="bg-white shadow sm:rounded-lg p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold mb-3 border-b pb-2">Status & Aksi</h3>
                    <div class="mb-4 text-center">
                        <p class="text-sm text-gray-500">Status Saat Ini:</p>
                        <p class="text-2xl font-bold capitalize {{ $pesanan->status == 'done' ? 'text-green-600' : ($pesanan->status == 'cancelled' ? 'text-red-600' : 'text-green-600') }}">{{ $pesanan->status }}</p>
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

                        <button type="submit" class="mt-4 w-full px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700">
                            Konfirmasi Perubahan Status
                        </button>
                    </form>
                </div>
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

