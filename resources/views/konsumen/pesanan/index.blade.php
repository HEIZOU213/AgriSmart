<x-konsumen-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-green-100 rounded-lg text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Riwayat Pesanan') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-6 pb-12">

        {{-- Flash Message Modern --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" class="relative p-4 mb-4 text-sm text-green-800 rounded-xl bg-green-50 border border-green-200 shadow-sm flex items-start gap-3" role="alert">
                <svg class="w-5 h-5 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="flex-1">
                    <span class="font-medium">Berhasil!</span> {{ session('success') }}
                </div>
                <button @click="show = false" class="text-green-600 hover:text-green-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif

        {{-- Daftar Pesanan --}}
        <div class="grid gap-6">
            @forelse ($pesanan as $item)
                {{-- Logic Status Badge --}}
                @php
                    $statusStyles = [
                        'pending'   => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'ring' => 'ring-yellow-600/20', 'icon' => '🕒'],
                        'paid'      => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'ring' => 'ring-blue-600/20', 'icon' => '💳'],
                        'shipping'  => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'ring' => 'ring-purple-600/20', 'icon' => '🚚'],
                        'done'      => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'ring' => 'ring-green-600/20', 'icon' => '✅'],
                        'cancelled' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'ring' => 'ring-red-600/20', 'icon' => '❌'],
                    ];
                    $style = $statusStyles[$item->status] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'ring' => 'ring-gray-600/20', 'icon' => '📦'];
                @endphp

                <div class="group bg-white rounded-2xl p-0 shadow-sm border border-gray-100 hover:shadow-lg hover:border-green-200 transition-all duration-300 relative overflow-hidden">
                    
                    {{-- Dekorasi Background Hover --}}
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-green-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-xl"></div>

                    <div class="p-6 relative z-10">
                        {{-- Baris Atas: ID & Tanggal vs Status --}}
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-bold text-green-600 bg-green-100 px-2 py-0.5 rounded text-center">ORDER</span>
                                        <h3 class="font-bold text-lg text-gray-900 font-mono tracking-tight">#{{ $item->kode_pesanan }}</h3>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-0.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ $item->created_at->format('d F Y, H:i') }} WIB
                                    </p>
                                </div>
                            </div>

                            {{-- Badge Status Modern --}}
                            <div class="self-start md:self-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide ring-1 ring-inset {{ $style['bg'] }} {{ $style['text'] }} {{ $style['ring'] }}">
                                    <span>{{ $style['icon'] }}</span> {{ $item->status }}
                                </span>
                            </div>
                        </div>

                        <hr class="border-dashed border-gray-200 mb-6">

                        {{-- Baris Bawah: Total & Action --}}
                        <div class="flex flex-col sm:flex-row justify-between items-end sm:items-center gap-6">
                            
                            {{-- Total Harga --}}
                            <div>
                                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Total Tagihan</p>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-sm text-gray-500 font-medium">Rp</span>
                                    <span class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight">{{ number_format($item->total_harga, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            {{-- Actions Buttons --}}
                            <div class="flex items-center gap-3 w-full sm:w-auto">
                                {{-- Tombol Detail --}}
                                <a href="{{ route('konsumen.pesanan.show', $item->id) }}" 
                                   class="flex-1 sm:flex-none text-center px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Lihat Detail
                                </a>
                                
                                {{-- Tombol Arsip (Icon only untuk desktop, full text untuk mobile jika perlu) --}}
                                <form action="{{ route('konsumen.pesanan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengarsipkan/menghapus riwayat pesanan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-colors border border-gray-200 hover:border-red-200 group" 
                                            title="Hapuskan Pesanan">
                                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-gray-300 shadow-sm">
                    <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
                        <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada riwayat pesanan</h3>
                    <p class="text-gray-500 mb-8 max-w-sm mx-auto">Sepertinya Anda belum melakukan transaksi apapun. Yuk, mulai penuhi kebutuhan pertanian Anda!</p>
                    <a href="{{ route('produk.index') }}" class="inline-flex items-center px-8 py-3 bg-green-600 text-white font-bold rounded-full hover:bg-green-700 transition shadow-lg hover:shadow-green-600/30 transform hover:-translate-y-1">
                        Mulai Belanja Sekarang
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-8 flex justify-center">
            {{ $pesanan->links() }}
        </div>

    </div>
</x-konsumen-layout>