<x-konsumen-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Keranjang Belanja Anda</h1>

            {{-- Pesan Sukses atau Error --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md border border-green-200">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md border border-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
                
                {{-- [LOGIKA BARU] Cek apakah keranjang memiliki isi --}}
                @if(count($cart) > 0)
                    
                    {{-- JIKA ADA ISI: Tampilkan Tabel --}}
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php $totalKeseluruhan = 0; @endphp
                            @foreach($cart as $id => $detail)
                                @php 
                                    $subtotal = $detail['harga'] * $detail['jumlah'];
                                    $totalKeseluruhan += $subtotal;
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if(isset($detail['foto']) && $detail['foto'])
                                                 <img class="h-10 w-10 rounded-full object-cover mr-3" src="{{ \Illuminate\Support\Facades\Storage::url($detail['foto']) }}" alt="">
                                            @endif
                                            <div class="text-sm font-medium text-gray-900">{{ $detail['nama'] }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($detail['harga'], 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="jumlah" value="{{ $detail['jumlah'] }}" min="1" class="w-16 border-gray-300 rounded-md shadow-sm text-sm focus:border-green-500 focus:ring-green-500">
                                            <button type="submit" class="ml-2 text-indigo-600 hover:text-indigo-900 text-sm font-medium">Update</button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <form action="{{ route('cart.destroy', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="p-6 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                        <div class="text-xl font-bold text-gray-900">
                            Total: <span class="text-green-600">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('checkout.index') }}" 
                           class="px-6 py-3 bg-green-600 text-white rounded-md font-medium shadow-sm hover:bg-green-700 transition-colors">
                           Lanjut ke Checkout &rarr;
                        </a>
                    </div>

                @else
                    {{-- JIKA KOSONG: Tampilkan Pesan Kosong (Empty State) --}}
                    <div class="text-center py-16 px-6">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Keranjang Anda kosong</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada produk yang Anda tambahkan.</p>
                        <div class="mt-6">
                            <a href="{{ route('produk.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Mulai Belanja
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-konsumen-layout>