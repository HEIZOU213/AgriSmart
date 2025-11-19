<x-petani-layout>
    <x-slot name="header">
        {{-- [INI ADALAH TEMPAT TOMBOL SEHARUSNYA BERADA] --}}
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Produk Panen Saya') }}
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
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($produk as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->foto_produk)
                                    <img src="{{ asset('storage/' . $item->foto_produk) }}" alt="{{ $item->nama_produk }}" class="w-16 h-16 object-cover rounded">
                                @else
                                    <span class="text-gray-400 text-xs">Tanpa Foto</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->nama_produk }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->kategoriProduk->nama_kategori }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->stok }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('petani.produk.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form action="{{ route('petani.produk.destroy', $item->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            {{-- Pesan Empty List --}}
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                Anda belum memiliki produk panen untuk dijual.
                                <a href="{{ route('petani.produk.create') }}" class="text-indigo-600 hover:text-indigo-900 ml-2 font-medium">
                                    Klik di sini untuk menambahkannya.
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Link Paginasi --}}
            <div class="mt-4">
                @if(isset($produk))
                    {{ $produk->links() }}
                @endif
            </div>

        @else
             {{-- Tampilan jika $produk kosong (Jika ada data, ini tidak akan muncul) --}}
             <div class="p-4 border border-gray-200 rounded-lg text-center text-gray-500">
                 <p class="mb-3">Anda belum memiliki produk panen untuk dijual.</p>
                 <a href="{{ route('petani.produk.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-md font-medium hover:bg-green-700">
                     + Tambah Produk Baru
                 </a>
             </div>
        @endif
        
    </div>
</x-petani-layout>