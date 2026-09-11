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
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm">
                    </div>

                    {{-- 3. Filter Status --}}
                    <div>
                        <label for="filter_status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <x-custom-dropdown 
                            name="filter_status" 
                            id="filter_status" 
                            placeholder="Semua Status" 
                            :options="[
                                'pending' => 'Pending',
                                'booked' => 'Booked (Booking Panen)',
                                'menunggu_pelunasan' => 'Menunggu Pelunasan',
                                'paid' => 'Sudah Bayar (Perlu Dikirim)',
                                'shipping' => 'Pengiriman',
                                'done' => 'Selesai',
                                'cancelled' => 'Dibatalkan'
                            ]" 
                            :value="request('filter_status')" 
                        />
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
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left min-w-[700px] divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Kode Pesanan</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Pelanggan</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Total</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Status</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($pesananMasuk as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-800">{{ $item->kode_pesanan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $item->user->name ?? 'User Tidak Ditemukan' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $item->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $badgeClasses = [
                                            'pending'            => 'bg-yellow-100 text-yellow-800',
                                            'booked'             => 'bg-indigo-100 text-indigo-800',
                                            'menunggu_panen'     => 'bg-amber-100 text-amber-800',
                                            'menunggu_pelunasan' => 'bg-orange-100 text-orange-800 font-extrabold animate-pulse',
                                            'paid'               => 'bg-blue-100 text-blue-800',
                                            'shipping'           => 'bg-purple-100 text-purple-800',
                                            'done'               => 'bg-emerald-100 text-emerald-800',
                                            'selesai'            => 'bg-emerald-100 text-emerald-800',
                                            'cancelled'          => 'bg-red-100 text-red-800',
                                        ];
                                        $badgeClass = $badgeClasses[$item->status] ?? 'bg-gray-100 text-gray-800';
                                        $statusLabel = str_replace('_', ' ', $item->status);
                                    @endphp
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $badgeClass }}">
                                        {{ ucwords($statusLabel) }}
                                    </span>
                                    @if($item->isBookingDurian())
                                        <span class="block text-[10px] font-bold text-emerald-700 mt-0.5">Booking Durian</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('petani.pesanan.show', $item->id) }}" class="text-xs px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-bold rounded-lg transition">
                                            Lihat & Konfirmasi
                                        </a>
                                        @if ($item->status != 'cancelled')
                                            <a href="{{ route('konsumen.pesanan.kwitansi', $item->id) }}" target="_blank" class="inline-flex items-center gap-1 text-xs px-2.5 py-1.5 bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold rounded-lg transition" title="Lihat E-Kwitansi">
                                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                E-Kwitansi
                                            </a>
                                        @endif
                                    </div>
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
        </div>

        <div class="mt-4">
            {{-- Pastikan controller menggunakan ->withQueryString() agar filter tidak hilang saat ganti halaman --}}
            {{ $pesananMasuk->links() }}
        </div>
    </div>
</x-petani-layout>

