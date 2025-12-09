@php
    // LOGIKA LAYOUT DINAMIS
    $layout = 'konsumen-layout'; // Default untuk Konsumen
    
    if(Auth::user()->role === 'petani') {
        $layout = 'petani-layout';
    } elseif(Auth::user()->role === 'admin') {
        $layout = 'admin-layout';
    }
@endphp

<x-dynamic-component :component="$layout">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Chat Pesanan #{{ $pesanan->kode_pesanan }}
            </h2>
            <a href="{{ route('chat.index') }}" class="text-sm text-gray-600 hover:text-gray-900">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col h-[500px]">
                
                {{-- AREA PESAN --}}
                <div id="chat-box" class="flex-1 p-6 overflow-y-auto space-y-4 bg-gray-50">
                    <div class="text-center text-gray-400 text-sm">Memuat percakapan...</div>
                </div>

                {{-- AREA INPUT --}}
                <div class="p-4 bg-white border-t border-gray-200">
                    <form id="chat-form" class="flex gap-2">
                        <input type="text" id="message-input" class="flex-1 border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500" placeholder="Tulis pesan..." autocomplete="off">
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            Kirim
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const pesananId = "{{ $pesanan->id }}";
        const currentUserId = "{{ Auth::id() }}";
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');

        async function fetchMessages() {
            try {
                const response = await fetch(`/api/chat/${pesananId}/messages`);
                const messages = await response.json();
                
                chatBox.innerHTML = ''; 
                
                messages.forEach(msg => {
                    const isMe = msg.user_id == currentUserId;
                    const align = isMe ? 'justify-end' : 'justify-start';
                    const color = isMe ? 'bg-green-100 text-green-900' : 'bg-white text-gray-800 border border-gray-200';
                    const date = new Date(msg.created_at);
                    const time = date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                    const userName = msg.user ? msg.user.name : 'User';

                    const html = `
                        <div class="flex ${align}">
                            <div class="max-w-[70%] p-3 rounded-lg shadow-sm ${color}">
                                <div class="text-xs font-bold mb-1 ${isMe ? 'text-green-700' : 'text-gray-500'}">${userName}</div>
                                <div class="text-sm">${msg.body}</div>
                                <div class="text-[10px] text-right mt-1 opacity-70">${time}</div>
                            </div>
                        </div>
                    `;
                    chatBox.innerHTML += html;
                });
            } catch (error) { console.error(error); }
        }

        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const text = messageInput.value;
            if (!text.trim()) return;
            messageInput.value = '';

            try {
                await fetch(`/api/chat/${pesananId}/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ body: text })
                });
                fetchMessages();
            } catch (error) { alert('Gagal kirim'); }
        });

        setInterval(fetchMessages, 3000);
        fetchMessages();
    </script>
</x-dynamic-component>