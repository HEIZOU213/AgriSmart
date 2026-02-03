<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Chat - {{ $receiver->name }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Scrollbar Configuration */
        ::-webkit-scrollbar {
            width: 8px;
        }

        @media (min-width: 640px) {
            ::-webkit-scrollbar {
                width: 10px;
            }
        }

        ::-webkit-scrollbar-track {
            background: #f0fdf4;
        }

        ::-webkit-scrollbar-thumb {
            background: #16a34a;
            border-radius: 5px;
            border: 2px solid #f0fdf4;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #15803d;
        }

        /* Custom Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.2s ease-out forwards;
        }
    </style>
</head>

<body class="font-sans antialiased bg-green-50 h-screen w-full overflow-hidden flex flex-col text-slate-700">
    <div class="w-full h-full">
        <div class="mx-auto max-w-1xl h-full">
            <div class="bg-white overflow-hidden flex flex-col h-full border-x border-slate-200 relative shadow-lg">

                <div class="bg-white border-b border-slate-100 p-3 flex items-center gap-3 shadow-sm z-20">
                    <a href="{{ $backUrl ?? route('chat.index') }}"
                        class="p-2 rounded-full hover:bg-slate-100 transition text-slate-600" title="Kembali">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>

                    <div class="relative">
                        <div
                            class="h-10 w-10 rounded-full bg-gradient-to-br from-green-100 to-emerald-200 flex items-center justify-center text-green-700 font-bold text-lg border border-white shadow-sm">
                            {{ substr($receiver->name, 0, 1) }}
                        </div>
                        <span id="status-dot"
                            class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white bg-slate-400"></span>
                    </div>

                    <div class="flex flex-col justify-center">
                        <h2 class="font-bold text-base text-slate-800 leading-none">
                            {{ $receiver->name }}
                        </h2>
                        <span id="status-text"
                            class="text-xs text-slate-500 mt-1 font-medium transition-colors duration-300">
                            Memuat status...
                        </span>
                    </div>
                </div>

                <div class="absolute inset-0 z-0 bg-slate-50"
                    style="background-image: url('{{ asset('images/logo2.png') }}'); background-size: 500px; background-repeat: no-repeat; background-position: center; opacity: 0.6; top: 30px;">
                </div>

                <div id="chat-box"
                    class="relative z-10 flex-1 p-4 overflow-y-auto space-y-2 scroll-smooth bg-transparent">
                    <div id="loading-msg" class="text-center text-slate-400 text-sm mt-10">Memuat percakapan...</div>
                </div>

                <div id="reply-preview-box"
                    class="hidden relative z-20 px-4 py-3 bg-slate-50 border-t border-slate-200 flex items-center justify-between animate-fade-in-up">
                    <div class="flex-1 flex items-center overflow-hidden">
                        <div
                            class="bg-white border-l-4 border-green-600 rounded-r-md p-3 shadow-sm text-sm w-full overflow-hidden border border-slate-100">
                            <div class="text-green-700 font-bold text-xs mb-1 flex items-center">
                                <span class="mr-1">Membalas</span>
                                <span id="reply-to-name" class="truncate">Reply Name</span>
                            </div>
                            <div class="text-slate-600 text-xs truncate" id="reply-to-text">Message Content</div>
                        </div>
                    </div>
                    <button onclick="cancelReply()"
                        class="ml-3 p-1.5 text-slate-400 hover:text-red-500 hover:bg-slate-200 rounded-full transition-colors flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="relative z-10 px-4 py-3 bg-white border-t border-slate-100">
                    <form id="chat-form" class="flex items-center gap-3">
                        <input type="hidden" id="reply-input-id" value="">
                        <div
                            class="flex-1 min-w-0 bg-slate-50 rounded-2xl border border-slate-200 flex items-center px-4 py-2 focus-within:bg-white shadow-sm transition-all">
                            <textarea id="message-input" rows="1"
                                class="w-full border-none bg-transparent focus:outline-none focus:ring-0 resize-none py-1.5 text-sm sm:text-base max-h-32 placeholder-slate-400 text-slate-800"
                                placeholder="Ketik pesan..." style="font-family: inherit; line-height: 1.5;">{{ $prefilledText ?? '' }}</textarea>
                        </div>
                        <button type="submit"
                            class="flex-shrink-0 w-11 h-11 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all duration-200 shadow-lg shadow-green-600/20 flex items-center justify-center active:scale-95 transform focus:outline-none focus:ring-2 focus:ring-green-300">
                            <svg class="w-5 h-5 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Configuration
        const config = {
            receiverId: "{{ $receiver->id }}",
            currentUserId: "{{ Auth::id() }}",
            csrfToken: "{{ csrf_token() }}",
            urls: {
                // [PERBAIKAN] Menggunakan route() agar URL dinamis sesuai hosting/localhost
                messages: (id) => "{{ route('ajax.chat.messages', ':id') }}".replace(':id', id) + `?t=${new Date().getTime()}`,
                send: "{{ route('ajax.chat.send') }}",
                offline: "{{ route('chat.offline') }}"
            }
        };

        // DOM Elements
        const ui = {
            chatBox: document.getElementById('chat-box'),
            chatForm: document.getElementById('chat-form'),
            messageInput: document.getElementById('message-input'),
            statusDot: document.getElementById('status-dot'),
            statusText: document.getElementById('status-text'),
            loadingMsg: document.getElementById('loading-msg'),
            reply: {
                box: document.getElementById('reply-preview-box'),
                inputId: document.getElementById('reply-input-id'),
                name: document.getElementById('reply-to-name'),
                text: document.getElementById('reply-to-text')
            }
        };

        const abortController = new AbortController();
        let pollInterval = null;
        let isFetching = false;
        const notifSound = new Audio('https://assets.mixkit.co/active_storage/sfx/2354/2354-preview.mp3');

        // [BARU] Auto-focus dan resize jika ada pesan bawaan (dari Produk)
        document.addEventListener("DOMContentLoaded", function() {
            const textBox = ui.messageInput;
            if (textBox.value.trim() !== "") {
                textBox.style.height = 'auto';
                textBox.style.height = (textBox.scrollHeight) + 'px';
                textBox.focus();
                // Pindahkan kursor ke akhir teks
                const val = textBox.value; 
                textBox.value = ''; 
                textBox.value = val;
            }
        });

        // --- REPLY LOGIC ---
        window.triggerReply = function (id, name, message) {
            ui.reply.inputId.value = id;
            ui.reply.name.innerText = name;
            ui.reply.text.innerText = message;
            ui.reply.box.classList.remove('hidden');
            ui.messageInput.focus();
        };

        window.cancelReply = function () {
            ui.reply.inputId.value = '';
            ui.reply.box.classList.add('hidden');
        };

        ui.messageInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                ui.chatForm.dispatchEvent(new Event('submit'));
            }
        });

        // --- FETCH MESSAGES ---
        async function fetchMessages() {
            if (isFetching) return;
            isFetching = true;

            try {
                const response = await fetch(config.urls.messages(config.receiverId), {
                    signal: abortController.signal,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                if (!response.ok) throw new Error('Network err');
                const json = await response.json();

                updateStatusUI(json.user_status);
                renderSmartChat(json.data);

                if (ui.loadingMsg) ui.loadingMsg.remove();

            } catch (error) {
                // Silent error (expected on abort)
            } finally {
                isFetching = false;
            }
        }

        // --- RENDERING ---
        function renderSmartChat(messages) {
            if (messages.length === 0) {
                if (!document.getElementById('empty-msg')) {
                    ui.chatBox.innerHTML = `<div id="empty-msg" class="flex flex-col items-center justify-center h-full text-slate-400 opacity-70"><p class="text-sm font-medium">Belum ada pesan.</p></div>`;
                }
                return;
            } else {
                const empty = document.getElementById('empty-msg');
                if (empty) empty.remove();
            }

            const isScrolledToBottom = ui.chatBox.scrollHeight - ui.chatBox.scrollTop <= ui.chatBox.clientHeight + 150;
            let lastDate = null;

            messages.forEach(msg => {
                const msgId = `msg-${msg.id}`;
                const dateObj = new Date(msg.created_at);
                const dateString = dateObj.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });

                // Date Header
                const dateId = `date-${dateString.replace(/\s/g, '-')}`;
                if (!document.getElementById(dateId) && lastDate !== dateString) {
                    ui.chatBox.insertAdjacentHTML('beforeend',
                        `<div id="${dateId}" class="flex justify-center my-4"><span class="bg-slate-100 text-slate-500 text-[10px] px-3 py-1 rounded-full font-bold shadow-sm opacity-90 border border-slate-200">${dateString}</span></div>`
                    );
                }
                lastDate = dateString;

                let existingMsg = document.getElementById(msgId);

                if (existingMsg) {
                    // Update Read Status
                    if (msg.sender_id == config.currentUserId) {
                        const checkEl = existingMsg.querySelector('.check-status');
                        if (checkEl) {
                            const currentRead = checkEl.getAttribute('data-read') == '1';
                            // [PERBAIKAN] Tambahkan '== 1' agar 0 tidak dianggap true
                            if (msg.is_read == 1 && !currentRead) {
                                checkEl.setAttribute('data-read', '1');
                                checkEl.classList.remove('text-slate-400');
                                checkEl.classList.add('text-blue-500', 'font-bold');
                            }
                        }
                    }
                } else {
                    // Remove Temp Message
                    if (msg.sender_id == config.currentUserId) {
                        const temps = document.querySelectorAll('.temp-message');
                        temps.forEach(t => {
                            if (t.innerText.includes(msg.message)) t.remove();
                        });
                    }

                    const isMe = msg.sender_id == config.currentUserId;
                    const align = isMe ? 'justify-end' : 'justify-start';
                    const bubbleColor = isMe ?
                        'bg-green-100 text-slate-800 rounded-tr-none shadow-sm border border-green-200' :
                        'bg-white text-slate-800 rounded-tl-none shadow-sm border border-slate-100';

                    const time = dateObj.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                    let checkStatus = '';
                    if (isMe) {
                        // [PERBAIKAN] Tambahkan '== 1' disini juga
                        const colorClass = (msg.is_read == 1) ? 'text-blue-500 font-bold' : 'text-slate-400';
                        checkStatus = `<span class="${colorClass} ml-1 text-[11px] check-status" data-read="${msg.is_read}">✓✓</span>`;
                    }

                    // Reply HTML Construction
                    let replyHtml = '';
                    if (msg.reply_to) {
                        const replyName = msg.reply_to.sender_id == config.currentUserId ? "Anda" : (msg.reply_to.sender ? msg.reply_to.sender.name : "Pengguna");
                        replyHtml = `
                            <div class="mb-1 p-1.5 rounded bg-black/5 border-l-4 border-green-600 text-xs cursor-pointer opacity-80 hover:opacity-100 transition" onclick="document.getElementById('msg-${msg.reply_to_id}')?.scrollIntoView({behavior: 'smooth', block: 'center'})">
                                <div class="font-bold text-green-700 text-[10px] mb-0.5">${replyName}</div>
                                <div class="truncate text-slate-600 italic line-clamp-1">${msg.reply_to.message}</div>
                            </div>
                        `;
                    }

                    const safeName = isMe ? "Anda" : "{{ $receiver->name }}";
                    // [SARAN] Penggunaan replace manual untuk sanitasi rentan terhadap XSS jika pesan berisi karakter lain.
                    const safeMsg = msg.message.replace(/'/g, "\\'").replace(/"/g, '&quot;');

                    const html = `
                        <div id="${msgId}" class="flex ${align} mb-2 group animate-fade-in-up">
                             <div class="max-w-[85%] sm:max-w-[70%] min-w-[100px] flex gap-2 ${isMe ? 'flex-row-reverse' : 'flex-row'} items-end group">
                                
                                <button onclick="triggerReply('${msg.id}', '${safeName}', '${safeMsg}')" 
                                    class="mb-3 opacity-0 group-hover:opacity-100 transition bg-slate-100 hover:bg-slate-200 rounded-full p-1.5 text-slate-500 shadow-sm border border-slate-200" title="Balas">
                                    <svg class="w-3 h-3 transform scale-x-[-1]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                </button>

                                <div class="px-3 py-2 rounded-2xl ${bubbleColor} text-sm relative shadow-sm w-full">
                                    ${replyHtml}
                                    <div class="break-words leading-relaxed mb-1 text-xs text-slate-900 font-medium">${msg.message}</div>
                                    <div class="flex justify-end items-center -mb-1 mt-1 opacity-70 select-none">
                                        <span class="text-[10px] mr-1 text-slate-500">${time}</span>
                                        ${checkStatus}
                                    </div>
                                </div>
                            </div>
                        </div>`;

                    // [SARAN] insertAdjacentHTML dengan input user berpotensi XSS jika 'msg.message' tidak disanitasi total di backend.
                    ui.chatBox.insertAdjacentHTML('beforeend', html);

                    if (!isMe) notifSound.play().catch(e => { });
                }
            });

            if (isScrolledToBottom) {
                ui.chatBox.scrollTop = ui.chatBox.scrollHeight;
            }
        }

        function updateStatusUI(status) {
            if (!status) return;
            if (status.is_online) {
                ui.statusDot.className = "absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white bg-green-500 animate-pulse";
                ui.statusText.className = "text-xs text-green-600 mt-1 font-bold";
                ui.statusText.innerText = "Online";
            } else {
                ui.statusDot.className = "absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white bg-slate-400";
                ui.statusText.className = "text-xs text-slate-500 mt-1 font-medium";
                ui.statusText.innerText = status.text;
            }
        }

        // --- SEND MESSAGE ---
        ui.chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const text = ui.messageInput.value;
            const replyId = ui.reply.inputId.value;
            const replyNamePreview = ui.reply.name.innerText;
            const replyTextPreview = ui.reply.text.innerText;

            if (!text.trim()) return;

            const fakeTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            let tempReplyHtml = '';
            if (replyId) {
                tempReplyHtml = `
                    <div class="mb-1 p-1.5 rounded bg-black/5 border-l-4 border-green-600 text-xs opacity-80">
                        <div class="font-bold text-green-700 text-[10px] mb-0.5">${replyNamePreview}</div>
                        <div class="truncate text-slate-600 italic line-clamp-1">${replyTextPreview}</div>
                    </div>
                `;
            }

            const tempHtml = `
                <div class="flex justify-end mb-2 group animate-pulse temp-message">
                     <div class="max-w-[85%] sm:max-w-[70%] flex gap-2 flex-row-reverse items-end">
                        <div class="px-3 py-2 rounded-2xl bg-green-100 text-slate-800 border border-green-200 rounded-tr-none shadow-sm text-sm relative w-full">
                            ${tempReplyHtml}
                            <div class="break-words leading-relaxed mb-1 text-[15px] font-medium">${text}</div>
                            <div class="flex justify-end items-center -mb-1 mt-1 opacity-70">
                                <span class="text-[10px] mr-1 text-slate-500">${fakeTime}</span>
                                <span class="text-slate-400 ml-1 text-[11px]">✓✓</span>
                            </div>
                        </div>
                    </div>
                </div>`;

            const emptyMsg = document.getElementById('empty-msg');
            if (emptyMsg) emptyMsg.remove();

            ui.chatBox.insertAdjacentHTML('beforeend', tempHtml);
            ui.chatBox.scrollTop = ui.chatBox.scrollHeight;

            ui.messageInput.value = '';
            ui.messageInput.style.height = 'auto';
            cancelReply();
            ui.messageInput.focus();

            try {
                const response = await fetch(config.urls.send, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': config.csrfToken
                    },
                    body: JSON.stringify({
                        receiver_id: config.receiverId,
                        message: text,
                        // [PERBAIKAN] Jika replyId kosong, kirim null (agar lolos validasi database)
                        reply_to_id: replyId || null 
                    })
                });
                if (response.ok) fetchMessages();
            } catch (error) {
                console.error(error);
            }
        });

        ui.messageInput.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        function setStatusOffline() {
            if (pollInterval) {
                clearInterval(pollInterval);
                pollInterval = null;
            }
            const data = new FormData();
            data.append('_token', config.csrfToken);
            navigator.sendBeacon(config.urls.offline, data);
        }

        function setStatusOnline() {
            fetchMessages();
            if (!pollInterval) {
                // [PERBAIKAN] Meningkatkan interval ke 3000ms agar aman untuk Shared Hosting
                pollInterval = setInterval(fetchMessages, 3000);
            }
        }

        window.addEventListener('beforeunload', setStatusOffline);
        document.addEventListener('visibilitychange', function () {
            if (document.visibilityState === 'hidden') {
                setStatusOffline();
            } else {
                setStatusOnline();
            }
        });

        setStatusOnline();
    </script>
</body>

</html>