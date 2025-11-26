@php
    $layout = 'app-layout'; // Default untuk Konsumen
    if(Auth::user()->role === 'petani') {
        $layout = 'petani-layout';
    } elseif(Auth::user()->role === 'admin') {
        $layout = 'admin-layout';
    }
@endphp

<x-dynamic-component :component="$layout">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kotak Masuk Pesan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Daftar Percakapan</h3>

                    {{-- Pesan Sukses --}}
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md border border-green-200 flex justify-between items-center">
                            {{ session('success') }}
                            <button onclick="this.parentElement.style.display='none'" class="text-green-800 font-bold">&times;</button>
                        </div>
                    @endif
                    
                    <div class="space-y-4">
                        @forelse($chats as $chat)
                            <div class="relative group block border border-gray-200 rounded-xl hover:bg-green-50 transition bg-white overflow-hidden">
                                
                                {{-- Link Utama --}}
                                <a href="{{ route('chat.show', $chat->id) }}" class="block p-4 pr-14 w-full">
                                    <div class="flex justify-between items-start">
                                        <div class="flex gap-4 overflow-hidden">
                                            {{-- Avatar --}}
                                            <div class="flex-shrink-0">
                                                <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-lg border border-green-200">
                                                    @php
                                                        $namaLawan = '';
                                                        if(Auth::user()->role == 'petani') {
                                                            $namaLawan = $chat->user->name; 
                                                        } else {
                                                            $namaLawan = $chat->detailPesanan->first()->produk->user->name ?? 'Petani';
                                                        }
                                                    @endphp
                                                    {{ substr($namaLawan, 0, 1) }}
                                                </div>
                                            </div>

                                            <div class="min-w-0">
                                                <h4 class="text-md font-bold text-gray-900 truncate group-hover:text-green-700">
                                                    {{ $namaLawan }}
                                                </h4>
                                                <p class="text-xs text-gray-500 mt-1 truncate">
                                                    No. Pesanan: <span class="font-medium">{{ $chat->kode_pesanan }}</span> 
                                                    &bull; Rp {{ number_format($chat->total_harga, 0, ',', '.') }}
                                                </p>
                                                <div class="mt-2">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                                        {{ ucfirst($chat->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex flex-col items-end flex-shrink-0 ml-2">
                                            <span class="text-xs text-gray-400 whitespace-nowrap">{{ $chat->updated_at->diffForHumans() }}</span>
                                            <div class="mt-2 flex items-center text-green-600 text-sm font-medium group-hover:underline">
                                                Buka <span class="ml-1">&rarr;</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                {{-- Tombol Hapus --}}
                                <div class="absolute top-3 right-3 z-10">
                                    <form action="{{ route('chat.destroy', $chat->id) }}" method="POST" onsubmit="return confirm('Hapus percakapan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-full transition bg-white shadow-sm border border-gray-100" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <p class="text-gray-500">Belum ada percakapan aktif.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>