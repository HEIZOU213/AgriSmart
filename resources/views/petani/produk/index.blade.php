<x-petani-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-xl md:text-2xl text-slate-900 leading-tight">
                    {{ __('Katalog Produk & Panen Durian') }}
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola stok siap kirim, pre-order booking panen, dan etalase kebun Anda</p>
            </div>
            <a href="{{ route('petani.produk.create') }}" 
               class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm font-bold shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Produk Baru
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Pesan Sukses --}}
        @if (session('success'))
            <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center text-green-700 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-xs sm:text-sm font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- Midtrans Configuration Warning --}}
        @if(!Auth::user()->hasCustomMidtrans())
            <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <div>
                        <h4 class="font-bold text-amber-900 text-sm">Konfigurasi Midtrans Diperlukan</h4>
                        <p class="text-xs text-amber-800 mt-0.5">Anda harus mengisi kredensial akun Midtrans sebelum dapat menambah atau menjual produk. Pembayaran konsumen akan langsung masuk ke rekening Midtrans Anda.</p>
                    </div>
                </div>
                <a href="{{ route('petani.midtrans.index') }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-amber-600 text-white text-xs font-bold rounded-lg hover:bg-amber-700 transition flex-shrink-0">
                    Atur Midtrans Sekarang
                </a>
            </div>
        @endif

        {{-- 4 Stat Cards Ringkasan Katalog (Sesuai Mobile) --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
            {{-- Total Produk --}}
            <div class="bg-white rounded-2xl p-4 md:p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <span class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">Katalog</span>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_produk'] ?? 0 }}</div>
                    <div class="text-xs font-semibold text-slate-500 mt-0.5">Total Produk</div>
                </div>
            </div>

            {{-- Ready Stock --}}
            <div class="bg-white rounded-2xl p-4 md:p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-[10px] font-bold uppercase text-emerald-600 tracking-wider">Siap Kirim</span>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-emerald-700">{{ $stats['ready_stock_count'] ?? 0 }}</div>
                    <div class="text-xs font-semibold text-slate-500 mt-0.5">Ready Stock</div>
                </div>
            </div>

            {{-- Booking Panen --}}
            <div class="bg-white rounded-2xl p-4 md:p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-[10px] font-bold uppercase text-amber-600 tracking-wider">Pre-Order</span>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-amber-700">{{ $stats['booking_panen_count'] ?? 0 }}</div>
                    <div class="text-xs font-semibold text-slate-500 mt-0.5">Booking Panen</div>
                </div>
            </div>

            {{-- Total Stok --}}
            <div class="bg-white rounded-2xl p-4 md:p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <span class="text-[10px] font-bold uppercase text-blue-600 tracking-wider">Volume</span>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-slate-900">{{ number_format($stats['total_stok'] ?? 0, 0, ',', '.') }}</div>
                    <div class="text-xs font-semibold text-slate-500 mt-0.5">Total Stok Sedia</div>
                </div>
            </div>
        </div>

        {{-- Filter Tabs & Search Bar --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-3 md:p-4 shadow-sm flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
            {{-- Tabs: Semua, Ready Stock, Booking Panen --}}
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0">
                @php
                    $currentTipe = request('tipe_produk', 'all');
                @endphp
                <a href="{{ route('petani.produk.index', array_merge(request()->except(['page', 'tipe_produk']), ['tipe_produk' => 'all'])) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition whitespace-nowrap {{ $currentTipe === 'all' ? 'bg-green-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua ({{ $stats['total_produk'] ?? 0 }})
                </a>
                <a href="{{ route('petani.produk.index', array_merge(request()->except(['page', 'tipe_produk']), ['tipe_produk' => 'ready_stock'])) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition whitespace-nowrap flex items-center gap-1.5 {{ $currentTipe === 'ready_stock' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                    <span class="w-2 h-2 rounded-full {{ $currentTipe === 'ready_stock' ? 'bg-white' : 'bg-emerald-500' }}"></span>
                    Ready Stock ({{ $stats['ready_stock_count'] ?? 0 }})
                </a>
                <a href="{{ route('petani.produk.index', array_merge(request()->except(['page', 'tipe_produk']), ['tipe_produk' => 'booking_panen'])) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition whitespace-nowrap flex items-center gap-1.5 {{ $currentTipe === 'booking_panen' ? 'bg-amber-600 text-white shadow-sm' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }}">
                    <span class="w-2 h-2 rounded-full {{ $currentTipe === 'booking_panen' ? 'bg-white' : 'bg-amber-500' }}"></span>
                    Booking Panen ({{ $stats['booking_panen_count'] ?? 0 }})
                </a>
            </div>

            {{-- Form Pencarian --}}
            <form action="{{ route('petani.produk.index') }}" method="GET" class="relative flex-1 md:max-w-xs">
                @if(request('tipe_produk'))
                    <input type="hidden" name="tipe_produk" value="{{ request('tipe_produk') }}">
                @endif
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama produk..."
                       class="w-full pl-9 pr-8 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none font-medium text-slate-800 placeholder-slate-400">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                @if(request('q'))
                    <a href="{{ route('petani.produk.index', request()->except(['q', 'page'])) }}" class="absolute right-2.5 top-2.5 text-slate-400 hover:text-slate-600 text-xs font-bold">✕</a>
                @endif
            </form>
        </div>

        {{-- Tabel Daftar Produk --}}
        @if(isset($produk) && $produk->isNotEmpty())
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left min-w-[760px] divide-y divide-slate-100">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Produk</th>
                                <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori</th>
                                <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tipe Penjualan</th>
                                <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Harga</th>
                                <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Stok</th>
                                <th scope="col" class="px-5 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @foreach ($produk as $item)
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    {{-- Foto & Nama --}}
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            @if($item->foto_produk)
                                                <img src="{{ asset('storage/' . $item->foto_produk) }}" alt="{{ $item->nama_produk }}" class="w-12 h-12 object-cover rounded-xl border border-slate-200 shadow-sm flex-shrink-0">
                                            @else
                                                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                </div>
                                            @endif
                                            <div class="min-w-0 max-w-[220px]">
                                                <p class="font-bold text-slate-900 truncate">{{ $item->nama_produk }}</p>
                                                <p class="text-xs text-slate-400 truncate">{{ Str::limit($item->deskripsi, 35) }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kategori --}}
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700">
                                            {{ $item->kategoriProduk->nama_kategori ?? 'Umum' }}
                                        </span>
                                    </td>

                                    {{-- Tipe Penjualan --}}
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if($item->tipe_produk === 'booking_panen')
                                            <div class="flex flex-col gap-0.5">
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                    Booking Panen
                                                </span>
                                                @if($item->estimasi_panen)
                                                    <span class="text-[10px] text-amber-800 font-medium ml-0.5">
                                                        Panen: {{ $item->estimasi_panen }}
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Ready Stock
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Harga --}}
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <span class="font-bold text-slate-900 text-sm">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                        <span class="text-xs text-slate-400">/ {{ $item->satuan_display }}</span>
                                    </td>

                                    {{-- Stok --}}
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold {{ ($item->stok ?? 0) > 5 ? 'bg-emerald-50 text-emerald-700' : (($item->stok ?? 0) > 0 ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-700') }}">
                                            {{ $item->stok }} {{ $item->satuan_display }}
                                        </span>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-5 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('petani.produk.edit', $item->id) }}"
                                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('petani.produk.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini dari katalog?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-bold rounded-lg transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Link Paginasi --}}
            <div class="mt-4">
                {{ $produk->links() }}
            </div>
        @else
            {{-- Tampilan Kosong --}}
            <div class="p-8 bg-white border border-slate-200 rounded-2xl text-center shadow-sm">
                <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <h3 class="font-bold text-slate-800 text-base">Belum Ada Produk</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    @if(request('q') || request('tipe_produk'))
                        Tidak ditemukan produk dengan filter yang dipilih. Coba reset filter pencarian Anda.
                    @else
                        Mulai tawarkan hasil panen durian segar atau olahan durian Anda kepada ribuan pembeli.
                    @endif
                </p>
                <div class="mt-4 flex items-center justify-center gap-2">
                    @if(request('q') || request('tipe_produk'))
                        <a href="{{ route('petani.produk.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl text-xs font-bold hover:bg-slate-200 transition">
                            Reset Filter
                        </a>
                    @endif
                    <a href="{{ route('petani.produk.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-xl text-xs font-bold hover:bg-green-700 transition">
                        + Tambah Produk Baru
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-petani-layout>

