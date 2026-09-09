<x-petani-layout>
    <x-slot name="header">
        {{-- [INI ADALAH TEMPAT TOMBOL SEHARUSNYA BERADA] --}}
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Produk Panen Durian Saya') }}
            </h2>
            {{-- Tombol Utama di Header --}}
            <a href="{{ route('petani.produk.create') }}" 
               class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700">
                + Tambah Produk Baru
            </a>
        </div>
    </x-slot>

    <div class="text-gray-900">
        {{-- Pesan Sukses --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if(isset($produk) && !$produk->isEmpty())
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left min-w-[700px] divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Foto</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Nama Produk</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Kategori</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Harga</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Stok</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($produk as $item)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($item->foto_produk)
                                            <img src="{{ asset('storage/' . $item->foto_produk) }}" alt="{{ $item->nama_produk }}" class="w-16 h-16 object-cover rounded-xl shadow-sm">
                                        @else
                                            <span class="text-gray-400 text-xs">Tanpa Foto</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $item->nama_produk }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $item->kategoriProduk->nama_kategori }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $item->stok }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('petani.produk.edit', $item->id) }}" class="text-xs px-2.5 py-1 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition">Edit</a>
                                            <form action="{{ route('petani.produk.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs px-2.5 py-1 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 font-semibold transition">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    {{-- Pesan Empty List --}}
                                    <td colspan="6" class="px-6 py-8 whitespace-nowrap text-center text-gray-500">
                                        Anda belum memiliki produk Panen Durian untuk dijual.
                                        <a href="{{ route('petani.produk.create') }}" class="text-green-600 hover:text-green-800 ml-2 font-medium">
                                            Klik di sini untuk menambahkannya.
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Link Paginasi --}}
            <div class="mt-4">
                @if(isset($produk))
                    {{ $produk->links() }}
                @endif
            </div>

        @else
             {{-- Tampilan jika $produk kosong (Jika ada data, ini tidak akan muncul) --}}
             <div class="p-4 border border-gray-200 rounded-lg text-center text-gray-500">
                 <p class="mb-3">Anda belum memiliki produk Panen Durian untuk dijual.</p>
                 <a href="{{ route('petani.produk.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-md font-medium hover:bg-green-700">
                     + Tambah Produk Baru
                 </a>
             </div>
        @endif
        
    </div>
</x-petani-layout>

