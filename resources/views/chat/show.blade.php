<x-app-layout>
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
                
                {{-- AREA PESAN (SCROLLABLE) --}}
                <div id="chat-box" class="flex-1 p-6 overflow-y-auto space-y-4 bg-gray-50">
                    {{-- Pesan akan dimuat di sini oleh JavaScript --}}
                    <div class="text-center text-gray-400 text-sm">Memuat percakapan...</div>
                </div>

                {{-- AREA INPUT --}}
                <div class="p-4 bg-white border-t border-gray-200">
                    <form id="chat-form" class="flex gap-2">
                        <input type="text" id="message-input" class="flex-1 border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500" placeholder="Tulis pesan..." autocomplete="off">
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT REALTIME SEDERHANA --}}
    <script>
        const pesananId = "{{ $pesanan->id }}";
        const currentUserId = "{{ Auth::id() }}";
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');

        // Fungsi untuk memuat pesan
        async function fetchMessages() {
            try {
                const response = await fetch(`/api/chat/${pesananId}/messages`);
                const messages = await response.json();
                
                chatBox.innerHTML = ''; // Bersihkan chat box
                
                messages.forEach(msg => {
                    const isMe = msg.user_id == currentUserId;
                    const align = isMe ? 'justify-end' : 'justify-start';
                    const color = isMe ? 'bg-green-100 text-green-900' : 'bg-white text-gray-800 border border-gray-200';
                    
                    // Format waktu sederhana
                    const date = new Date(msg.created_at);
                    const time = date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

                    // [FIX] Menggunakan msg.user.name (bukan nama)
                    const userName = msg.user ? msg.user.name : 'User';

                    const html = `
                        <div class="flex ${align}">
                            <div class="max-w-[70%] p-3 rounded-lg shadow-sm ${color}">
                                <div class="text-xs font-bold mb-1 ${isMe ? 'text-green-700' : 'text-gray-500'}">
                                    ${userName}
                                </div>
                                <div class="text-sm">${msg.body}</div>
                                <div class="text-[10px] text-right mt-1 opacity-70">${time}</div>
                            </div>
                        </div>
                    `;
                    chatBox.innerHTML += html;
                });
                
                // Auto scroll ke bawah
                // chatBox.scrollTop = chatBox.scrollHeight;
                
            } catch (error) {
                console.error('Error fetching messages:', error);
            }
        }

        // Fungsi kirim pesan
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const text = messageInput.value;
            if (!text.trim()) return;

            // Kosongkan input dulu biar cepat
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
                fetchMessages(); // Refresh pesan setelah kirim
            } catch (error) {
                alert('Gagal mengirim pesan');
            }
        });

        // AUTO REFRESH SETIAP 3 DETIK (POLLING)
        setInterval(fetchMessages, 3000);
        
        // Load pertama kali
        fetchMessages();
    </script>
</x-app-layout>