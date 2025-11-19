{{-- Menggunakan Layout Utama Aplikasi (Tanpa Sidebar Khusus) --}}
<x-app-layout>
    {{-- Header Halaman --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Riwayat Pesanan Saya') }}
            </h2>
            <a href="{{ route('produk.index') }}" class="text-sm text-green-600 hover:text-green-800">
                &larr; Kembali Belanja
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Container Putih Utama --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    
                    {{-- Pesan Sukses --}}
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-md border border-green-100 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    {{-- Tabel Pesanan (Full Width) --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Pesanan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pesan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Tagihan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($pesanan as $item)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                            {{ $item->kode_pesanan }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                            {{ $item->created_at->format('d M Y') }}
                                            <span class="text-xs text-gray-400 block">{{ $item->created_at->format('H:i') }} WIB</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-bold text-green-600">
                                            Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap capitalize">
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'paid' => 'bg-blue-100 text-blue-800',
                                                    'shipping' => 'bg-purple-100 text-purple-800',
                                                    'done' => 'bg-green-100 text-green-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                ];
                                                $class = $statusClasses[$item->status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $class }}">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center gap-3">
                                            <a href="{{ route('konsumen.pesanan.show', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded-md transition-colors">
                                                Detail
                                            </a>
                                            
                                            {{-- Form Arsipkan --}}
                                            <form action="{{ route('konsumen.pesanan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Arsipkan pesanan ini? Pesanan akan disembunyikan dari daftar ini.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors" title="Arsipkan">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3.25h3m-3-3.75h3m-12-3h15.656c.83 0 1.5.67 1.5 1.5v.693c0 .83-.67 1.5-1.5 1.5H6.25c-.83 0-1.5-.67-1.5-1.5V4.5c0-.83.67-1.5 1.5-1.5Z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                                <p class="text-lg font-medium">Belum ada riwayat pesanan.</p>
                                                <p class="text-sm mb-4">Mulai belanja untuk mendukung petani lokal!</p>
                                                <a href="{{ route('produk.index') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                                                    Mulai Belanja
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Link Paginasi --}}
                    <div class="mt-6">
                        {{ $pesanan->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>