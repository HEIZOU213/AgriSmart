<x-konsumen-layout>
    <x-slot name="header">
        {{ __('Riwayat Pesanan') }}
    </x-slot>

    <div class="space-y-6">

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="p-4 bg-green-100 border-l-4 border-green-500 text-green-800 rounded-r-lg shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Daftar Pesanan (Kartu) --}}
        @forelse ($pesanan as $item)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all">
                
                {{-- Header Kartu --}}
                <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100 flex flex-wrap justify-between items-center gap-4">
                    <div class="flex items-center gap-4 text-sm">
                        <span class="font-bold text-gray-900 bg-white px-3 py-1 rounded-lg border border-gray-200">
                            #{{ $item->kode_pesanan }}
                        </span>
                        <span class="text-gray-500 flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $item->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>

                    @php
                        $statusConfig = [
                            'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                            'paid' => 'bg-blue-100 text-blue-700 border-blue-200',
                            'shipping' => 'bg-purple-100 text-purple-700 border-purple-200',
                            'done' => 'bg-green-100 text-green-700 border-green-200',
                            'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                        ];
                        $class = $statusConfig[$item->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide border {{ $class }}">
                        {{ $item->status }}
                    </span>
                </div>

                {{-- Body Kartu --}}
                <div class="p-6 flex flex-col sm:flex-row justify-between items-center gap-6">
                    <div class="text-center sm:text-left">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Tagihan</p>
                        <p class="text-3xl font-black text-gray-900">
                            <span class="text-lg text-gray-400 font-normal mr-1">Rp</span>{{ number_format($item->total_harga, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('konsumen.pesanan.show', $item->id) }}" 
                           class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl transition-all shadow-md hover:-translate-y-0.5">
                            Lihat Detail
                        </a>
                        
                        <form action="{{ route('konsumen.pesanan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Arsipkan pesanan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="p-3 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-colors border border-transparent hover:border-red-100" 
                                    title="Arsipkan Pesanan">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16 px-4 bg-white rounded-2xl border border-dashed border-gray-300">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Belum ada pesanan</h3>
                <p class="text-gray-500 mt-1 mb-6">Riwayat belanja Anda akan muncul di sini.</p>
                <a href="{{ route('produk.index') }}" class="px-6 py-2.5 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition-colors">
                    Mulai Belanja
                </a>
            </div>
        @endforelse

        <div class="mt-6">
            {{ $pesanan->links() }}
        </div>

    </div>
</x-konsumen-layout>