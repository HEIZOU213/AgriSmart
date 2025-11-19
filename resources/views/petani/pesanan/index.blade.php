<x-petani-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pesanan Masuk (Produk Saya)') }}
            </h2>
        </div>
    </x-slot>

    <div class="text-gray-900">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Pesanan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($pesananMasuk as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->kode_pesanan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->user->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap capitalize">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->status == 'done' ? 'bg-green-100 text-green-800' : ($item->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('petani.pesanan.show', $item->id) }}" class="text-indigo-600 hover:text-indigo-900">Lihat & Konfirmasi</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                            Belum ada pesanan masuk untuk produk Anda.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $pesananMasuk->links() }}
        </div>
    </div>
</x-petani-layout>