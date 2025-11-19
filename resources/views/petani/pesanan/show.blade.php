<x-petani-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pesanan ') }} ({{ $pesanan->kode_pesanan }})
        </h2>
    </x-slot>

    <div class="text-gray-900">
        {{-- Notifikasi Sukses atau Error --}}
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
                        <p class="text-2xl font-bold capitalize text-red-600">{{ $pesanan->status }}</p>
                    </div>

                    {{-- Form untuk Update Status --}}
                    <form action="{{ route('petani.pesanan.update', $pesanan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label for="status" class="block text-sm font-medium text-gray-700 mt-4">Ubah Status:</label>
                        <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="pending" {{ $pesanan->status == 'pending' ? 'selected' : '' }}>01. Pending (Menunggu Pembayaran)</option>
                            <option value="paid" {{ $pesanan->status == 'paid' ? 'selected' : '' }}>02. Paid (Pembayaran Diterima)</option>
                            <option value="shipping" {{ $pesanan->status == 'shipping' ? 'selected' : '' }}>03. Shipping (Siap Dikirim / Dikirim)</option>
                            <option value="done" {{ $pesanan->status == 'done' ? 'selected' : '' }}>04. Done (Selesai)</option>
                            <option value="cancelled" {{ $pesanan->status == 'cancelled' ? 'selected' : '' }}>05. Cancelled (Dibatalkan)</option>
                        </select>

                        <button type="submit" class="mt-4 w-full px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">
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
                        <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->user->nama }}</dd>
                        <dt class="text-sm font-medium text-gray-500">Total Tagihan</dt>
                        <dd class="mt-1 text-sm font-bold text-gray-900">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</dd>
                        <dt class="text-sm font-medium text-gray-500">Alamat Kirim</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">{{ $pesanan->alamat_kirim }}</dd>
                    </dl>
                </div>

                {{-- Daftar Produk yang Dibeli --}}
                <div class="bg-white shadow sm:rounded-lg p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold mb-3 border-b pb-2">Produk yang Dibeli</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jml</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($pesanan->detailPesanan as $detail)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $detail->produk ? $detail->produk->nama_produk : '[Produk Dihapus]' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $detail->jumlah }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right">Rp {{ number_format($detail->harga_satuan * $detail->jumlah, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Chat Log & Form --}}
                <div class="mt-6 bg-white shadow sm:rounded-lg border border-gray-200">
                    <h3 class="text-lg font-semibold mb-3 p-6 border-b">Log Pesan (Chat)</h3>
                    
                    {{-- Area Tampilan Chat --}}
                    <div class="p-6 space-y-4 max-h-96 overflow-y-auto">
                        @forelse($pesanLog as $pesan)
                            <div class="flex {{ $pesan->user_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-xs lg:max-w-md p-4 rounded-lg {{ $pesan->user_id == Auth::id() ? 'bg-green-100 text-green-900' : 'bg-gray-100 text-gray-800' }}">
                                    <p class="text-sm font-bold">{{ $pesan->user->nama }} ({{ $pesan->user->role }})</p>
                                    <p class="text-md mt-1">{{ $pesan->body }}</p>
                                    <p class="text-xs text-gray-500 mt-2 text-right">{{ $pesan->created_at->format('d M, H:i') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center">Belum ada pesan. Mulai percakapan.</p>
                        @endforelse
                    </div>

                    {{-- Form Kirim Pesan --}}
                    <div class="p-6 border-t bg-gray-50">
                        <form action="{{ route('pesan.store', $pesanan->id) }}" method="POST">
                            @csrf
                            <label for="body" class="block text-sm font-medium text-gray-700">Kirim Balasan:</label>
                            <textarea name="body" id="body" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Tulis pesan Anda di sini... (Contoh: Baik, pesanan akan segera saya batalkan.)"></textarea>
                            @error('body')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <button type="submit" class="mt-3 w-full px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700">
                                Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</x-petani-layout>