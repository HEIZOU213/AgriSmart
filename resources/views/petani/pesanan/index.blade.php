<x-petani-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pesanan Masuk (Produk Saya)') }}
            </h2>
        </div>
    </x-slot>

    <div class="text-gray-900">
        {{-- Alert Sukses --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        {{-- === BAGIAN FILTER START === --}}
        <div class="mb-6 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <form method="GET" action="{{ route('petani.pesanan.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    

                    {{-- 2. Filter Tanggal --}}
                    <div>
                        <label for="filter_tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pesanan</label>
                        <input type="date" 
                               name="filter_tanggal" 
                               id="filter_tanggal"
                               value="{{ request('filter_tanggal') }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    {{-- 3. Filter Status --}}
                    <div>
                        <label for="filter_status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="filter_status" id="filter_status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('filter_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="shipping" {{ request('filter_status') == 'shipping' ? 'selected' : '' }}>Pengiriman</option>
                            <option value="done" {{ request('filter_status') == 'done' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ request('filter_status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    {{-- Tombol Filter & Reset --}}
                    <div class="flex gap-2">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out shadow-sm w-full md:w-auto">
                            Cari
                        </button>
                        
                        @if(request()->hasAny(['filter_produk', 'filter_tanggal', 'filter_status']))
                            <a href="{{ route('petani.pesanan.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out text-center w-full md:w-auto">
                                Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        {{-- === BAGIAN FILTER END === --}}

        {{-- Tabel Data --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
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
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->user->name ?? 'User Tidak Ditemukan' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $item->status == 'done' ? 'bg-green-100 text-green-800' : 
                                      ($item->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                      ($item->status == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('petani.pesanan.show', $item->id) }}" class="text-green-600 hover:text-green-900 font-semibold">
                                    Lihat & Konfirmasi
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 whitespace-nowrap text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-10 w-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="text-base">Tidak ada pesanan yang ditemukan.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{-- Pastikan controller menggunakan ->withQueryString() agar filter tidak hilang saat ganti halaman --}}
            {{ $pesananMasuk->links() }}
        </div>
    </div>
</x-petani-layout>