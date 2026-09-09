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

        {{-- Midtrans Configuration Warning --}}
        @if(!Auth::user()->hasCustomMidtrans())
            <div class="mb-4 p-4 bg-amber-50 border border-amber-200 rounded-xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <div>
                        <h4 class="font-bold text-amber-900 text-sm">Konfigurasi Midtrans Diperlukan</h4>
                        <p class="text-xs text-amber-800 mt-0.5">Anda harus mengisi kredensial akun Midtrans sebelum dapat menambah atau menjual produk. Pembayaran konsumen akan langsung masuk ke rekening Midtrans Anda.</p>
                    </div>
                </div>
                <a href="{{ route('petani.midtrans.index') }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-amber-600 text-white text-xs font-bold rounded-lg hover:bg-amber-700 transition flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Atur Midtrans Sekarang
                </a>
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

