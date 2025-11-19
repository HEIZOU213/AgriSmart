{{-- Menggunakan layout konsumen baru kita --}}
<x-konsumen-layout>
    
    {{-- Slot untuk Judul Halaman --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pesanan: ') }} {{ $pesanan->kode_pesanan }}
            </h2>
            <a href="{{ route('konsumen.pesanan.index') }}" 
               class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Kembali ke Riwayat Pesanan
            </a>
        </div>
    </x-slot>

    {{-- Slot untuk Konten Utama --}}
    <div class="text-gray-900 space-y-6">

        {{-- Ringkasan Detail Pesanan --}}
        <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">Ringkasan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Tanggal Pesan</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->created_at->format('d M Y, H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 text-sm text-gray-900 capitalize">{{ $pesanan->status }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Total Tagihan</dt>
                    <dd class="mt-1 text-sm font-bold text-red-600">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Alamat Kirim</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->alamat_kirim }}</dd>
                </div>
            </div>
        </div>

        {{-- Daftar Produk yang Dibeli --}}
        <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200">
            <h3 class="text-lg font-semibold mb-4 p-6 border-b">Produk dalam Pesanan Ini</h3>
            
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($pesanan->detailPesanan as $detail)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $detail->produk ? $detail->produk->nama_produk : '[Produk Dihapus]' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $detail->jumlah }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                Rp {{ number_format($detail->harga_satuan * $detail->jumlah, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-700 uppercase">Total Harga Produk</td>
                        <td class="px-6 py-3 text-right text-sm font-bold text-gray-900">
                            Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- [KODE BARU YANG DIGABUNGKAN] Chat Log & Form --}}
        <div class="mt-6 bg-white shadow sm:rounded-lg border border-gray-200">
            <h3 class="text-lg font-semibold mb-3 p-6 border-b">Log Pesan (Chat)</h3>
            
            {{-- Area Tampilan Chat (Variabel $pesanLog dikirim dari Controller) --}}
            <div class="p-6 space-y-4 max-h-96 overflow-y-auto">
                @forelse($pesanLog as $pesan)
                    <div class="flex {{ $pesan->user_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs lg:max-w-md p-4 rounded-lg {{ $pesan->user_id == Auth::id() ? 'bg-indigo-100 text-indigo-900' : 'bg-gray-100 text-gray-800' }}">
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
                    <textarea name="body" id="body" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Tulis pesan Anda di sini... (Contoh: Mohon batalkan pesanan ini)"></textarea>
                    @error('body')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="mt-3 w-full px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
        {{-- [AKHIR KODE BARU] --}}

    </div>
</x-konsumen-layout>