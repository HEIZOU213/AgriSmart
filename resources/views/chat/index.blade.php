@php
    // Logika penentuan layout berdasarkan role user
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    
                    {{-- Header List --}}
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Pesan Masuk</h3>
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                            {{ count($chats) }} Pesan
                        </span>
                    </div>

                    {{-- Flash Message Success --}}
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
                            {{-- Note: Data diakses sebagai Array ($chat['key']) karena Controller mengembalikan Collection/Array --}}
                            <div class="group relative block border border-gray-200 rounded-2xl hover:border-green-700 hover:shadow-md transition-all duration-200 bg-white overflow-hidden">
                                <div class="flex flex-col sm:flex-row sm:items-center p-4 gap-4">
                                    
                                    {{-- Wrapper Link Utama --}}
                                    <a href="{{ route('chat.show', $chat['user_id']) }}" class="flex-1 flex items-center gap-4 min-w-0 cursor-pointer">
                                        
                                        {{-- Avatar & Indikator --}}
                                        <div class="relative flex-shrink-0">
                                            <div class="h-12 w-12 rounded-full bg-gradient-to-br from-green-100 to-emerald-200 flex items-center justify-center text-green-700 font-bold text-lg border border-white shadow-sm">
                                                {{-- Ambil inisial nama --}}
                                                {{ substr($chat['name'], 0, 1) }}
                                            </div>
                                            
                                            {{-- Dot indikator jika ada pesan belum dibaca --}}
                                            @if($chat['unread_count'] > 0)
                                                <span class="absolute top-0 right-0 block h-3 w-3 rounded-full ring-2 ring-white bg-red-500"></span>
                                            @endif
                                        </div>

                                        {{-- Informasi Chat --}}
                                        <div class="min-w-0 flex-1">
                                            <div class="flex justify-between items-center mb-1">
                                                <h4 class="text-base font-bold text-gray-900 truncate group-hover:text-green-700 transition-colors">
                                                    {{ $chat['name'] }}
                                                </h4>
                                                <span class="text-xs text-gray-400 whitespace-nowrap ml-2 bg-gray-50 px-2 py-1 rounded-lg">
                                                    {{ $chat['time'] }}
                                                </span>
                                            </div>
                                            
                                            <div class="flex items-center justify-between gap-2">
                                                <p class="text-sm text-gray-500 truncate w-full pr-4">
                                                    {{ Str::limit($chat['last_message'], 50) }}
                                                </p>

                                                @if($chat['unread_count'] > 0)
                                                    <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                                                        {{ $chat['unread_count'] }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        @empty
                            {{-- Tampilan Kosong --}}
                            <div class="text-center py-16 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                </div>
                                <h3 class="text-gray-900 font-medium">Belum ada pesan</h3>
                                <p class="text-gray-500 text-sm mt-1">Percakapan Anda akan muncul di sini.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>