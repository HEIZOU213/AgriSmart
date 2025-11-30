@php
    // [PERBAIKAN] Gunakan 'konsumen-layout' sebagai default agar ada jarak (padding) dari atas
    $layout = 'konsumen-layout'; 
    
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

    {{-- Konten utama --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Daftar Percakapan</h3>
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                            {{ count($chats) }} Pesan
                        </span>
                    </div>

                    {{-- Pesan Sukses --}}
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200 flex justify-between items-center">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ session('success') }}
                            </span>
                            <button onclick="this.parentElement.style.display='none'" class="text-green-800 hover:text-green-900 font-bold">&times;</button>
                        </div>
                    @endif
                    
                    <div class="space-y-4">
                        @forelse($chats as $chat)
                            <div class="group relative block border border-gray-200 rounded-2xl hover:border-green-400 hover:shadow-md transition-all duration-200 bg-white overflow-hidden">
                                
                                <div class="flex flex-col sm:flex-row sm:items-center p-4 gap-4">
                                    
                                    {{-- Area Klik Utama (Buka Chat) --}}
                                    <a href="{{ route('chat.show', $chat->id) }}" class="flex-1 flex items-center gap-4 min-w-0 cursor-pointer">
                                        {{-- Avatar --}}
                                        <div class="flex-shrink-0">
                                            <div class="h-12 w-12 rounded-full bg-gradient-to-br from-green-100 to-emerald-200 flex items-center justify-center text-green-700 font-bold text-lg border border-white shadow-sm">
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

                                        {{-- Info --}}
                                        <div class="min-w-0 flex-1">
                                            <div class="flex justify-between items-center mb-1">
                                                <h4 class="text-base font-bold text-gray-900 truncate group-hover:text-green-700 transition-colors">
                                                    {{ $namaLawan }}
                                                </h4>
                                                <span class="text-xs text-gray-400 whitespace-nowrap ml-2 bg-gray-50 px-2 py-1 rounded-lg">
                                                    {{ $chat->updated_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            
                                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                                <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-600 font-medium">
                                                    #{{ $chat->kode_pesanan }}
                                                </span>
                                                <span>&bull;</span>
                                                <span>Rp {{ number_format($chat->total_harga, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </a>

                                    {{-- Area Aksi (Hapus) --}}
                                    <div class="flex items-center justify-between sm:justify-end gap-3 pt-3 sm:pt-0 border-t sm:border-t-0 border-gray-100 w-full sm:w-auto">
                                        <a href="{{ route('chat.show', $chat->id) }}" class="text-sm font-bold text-green-600 hover:underline sm:hidden">
                                            Buka Percakapan
                                        </a>

                                        <form action="{{ route('chat.destroy', $chat->id) }}" method="POST" onsubmit="return confirm('Hapus percakapan ini? Pesan tidak bisa dikembalikan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition border border-transparent hover:border-red-100" title="Hapus Percakapan">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="text-center py-16 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                </div>
                                <h3 class="text-gray-900 font-medium">Belum ada pesan</h3>
                                <p class="text-gray-500 text-sm mt-1">Percakapan Anda dengan penjual akan muncul di sini.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>