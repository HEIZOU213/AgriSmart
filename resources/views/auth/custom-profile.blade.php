<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AgriSmart') }} - Edit Profil</title>

    {{-- FONT: Plus Jakarta Sans (Sesuai Index) --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    {{-- Scripts & Styles via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Custom Scrollbar Sesuai Index */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f0fdf4; }
        ::-webkit-scrollbar-thumb { background: #16a34a; border-radius: 5px; border: 2px solid #f0fdf4; }
        ::-webkit-scrollbar-thumb:hover { background: #15803d; }

        /* Sidebar Styles Updated */
        .nav-item-active {
            background-color: #16a34a; /* green-600 */
            color: white;
            box-shadow: 0 4px 6px -1px rgba(22, 163, 74, 0.4);
        }
        .nav-item-inactive {
            color: #475569; /* slate-600 */
        }
        .nav-item-inactive:hover {
            background-color: #f0fdf4; /* green-50 */
            color: #16a34a; /* green-600 */
        }

        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="font-sans antialiased text-slate-700 bg-white" x-data="{ sidebarOpen: false }">

    <x-navbar></x-navbar>

    {{-- Definisi ulang $user & Logika Foto --}}
    @php
        $user = Auth::user();
        $formPhotoUrl = null;
        $initials = strtoupper(substr($user->name ?? $user->email, 0, 1));

        if ($user->foto_profil) {
            if (!preg_match('#^https?://#i', $user->foto_profil)) {
                $formPhotoUrl = asset('storage/' . $user->foto_profil);
            } else {
                $cleanUrl = preg_replace('/\?sz=\d+$/', '', $user->foto_profil);
                $formPhotoUrl = preg_replace('/=s\d+-c$/', '=s0-c', $cleanUrl);
            }
        }
    @endphp

    {{-- Main Container --}}
    <div class="container mx-auto px-4 sm:px-6 py-8 sm:py-12 mt-20">
        
        {{-- Header Title Mobile --}}
        <div class="lg:hidden mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Pengaturan Akun</h1>
            <p class="text-slate-500 text-sm">Kelola informasi profil dan keamanan.</p>
        </div>

        {{-- Flex Container --}}
        <div class="flex flex-col lg:flex-row lg:gap-10 lg:items-start">

            {{-- ========================================================= 
                 1. SIDEBAR NAVIGASI 
            ========================================================= --}}
            
            {{-- TOMBOL TOGGLE MOBILE --}}
            <button @click="sidebarOpen = !sidebarOpen" 
                class="lg:hidden fixed bottom-6 right-6 z-50 p-4 bg-green-600 text-white rounded-full shadow-lg hover:bg-green-700 hover:shadow-green-200 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="sidebarOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- WRAPPER SIDEBAR --}}
            <div :class="sidebarOpen ? 'fixed inset-0 z-40 flex' : 'hidden lg:block'" class="lg:contents">
                
                {{-- Overlay Background (Mobile Only) --}}
                <div x-show="sidebarOpen" x-transition.opacity 
                     @click="sidebarOpen = false"
                     class="fixed inset-0 bg-slate-900/50 lg:hidden backdrop-blur-sm"></div>

                {{-- Konten Sidebar --}}
                <aside class="w-full sm:w-72 sm:max-w-xs bg-white lg:bg-transparent shadow-2xl lg:shadow-none h-full lg:h-auto fixed lg:relative left-0 top-0 z-50 lg:z-auto px-6 pb-6 pt-24 lg:p-0 flex-shrink-0 transition-transform duration-300 transform lg:transform-none overflow-y-auto lg:overflow-visible"
                       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
                    
                    {{-- Inner Div Sidebar --}}
                    {{-- HAPUS class 'sticky top-28' agar sidebar ikut bergerak (scroll) bersama halaman --}}
                    <div class="bg-white border border-slate-100 shadow-xl shadow-slate-200/50 rounded-3xl p-6">
                        
                        {{-- Judul Sidebar di Mobile --}}
                        <div class="lg:hidden mb-6 flex items-center justify-between">
                            <h3 class="text-xl font-bold text-slate-900">Menu</h3>
                            <button @click="sidebarOpen = false" class="text-slate-500 hover:text-red-500 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <nav class="space-y-2">
                            {{-- 1. Kelola Profile --}}
                            <a href="#section-profile" id="link-profile" @click="sidebarOpen = false; setActive('link-profile')"
                               class="flex items-center space-x-3 w-full px-4 py-3.5 rounded-2xl transition-all duration-300 nav-item-active group">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="font-semibold text-sm">Kelola Profile</span>
                            </a>

                            {{-- 2. Ganti Password --}}
                            <a href="#section-password" id="link-password" @click="sidebarOpen = false; setActive('link-password')"
                               class="flex items-center space-x-3 w-full px-4 py-3.5 rounded-2xl transition-all duration-300 nav-item-inactive group">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <span class="font-semibold text-sm">Ganti Password</span>
                            </a>

                            {{-- 3. KEMBALI KE DASHBOARD --}}
                            @if($user->role === 'admin' || $user->role === 'petani')
                                @php
                                    $dashboardRoute = ($user->role === 'admin') ? route('admin.dashboard') : route('petani.dashboard');
                                @endphp
                                <a href="{{ $dashboardRoute }}"
                                   class="flex items-center space-x-3 w-full px-4 py-3.5 rounded-2xl transition-all duration-300 nav-item-inactive hover:bg-green-50 text-green-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    <span class="font-semibold text-sm">Kembali ke Dashboard</span>
                                </a>
                            @endif

                            {{-- 4. Tombol Keluar --}}
                            <form method="POST" action="{{ route('logout') }}" class="block w-full pt-4 border-t border-slate-100 mt-2">
                                @csrf
                                <button type="submit" 
                                    class="flex items-center space-x-3 w-full px-4 py-3.5 text-red-600 rounded-2xl transition-all duration-300 hover:bg-red-50 text-left group">
                                    <svg class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span class="font-semibold text-sm">Keluar</span>
                                </button>
                            </form>
                        </nav>
                    </div>
                </aside>
            </div>

            {{-- 2. KONTEN UTAMA --}}
            <div class="flex-1 space-y-8">

                {{-- Flash Messages --}}
                @if (session('status') === 'profile-updated')
                    <div class="p-4 bg-green-50 border-l-4 border-green-600 text-green-700 rounded-r-xl shadow-sm flex items-center animate-pulse">
                        <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <div>
                            <p class="font-bold text-sm">Berhasil!</p>
                            <p class="text-xs sm:text-sm">Informasi profil Anda telah diperbarui.</p>
                        </div>
                    </div>
                @endif
                @if (session('status') === 'password-updated')
                    <div class="p-4 bg-green-50 border-l-4 border-green-600 text-green-700 rounded-r-xl shadow-sm flex items-center animate-pulse">
                        <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <div>
                            <p class="font-bold text-sm">Berhasil!</p>
                            <p class="text-xs sm:text-sm">Kata sandi Anda telah diperbarui.</p>
                        </div>
                    </div>
                @endif

                {{-- CARD 1: FORM EDIT PROFIL --}}
                <div id="section-profile" class="bg-white p-6 sm:p-8 lg:p-10 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 relative overflow-hidden scroll-mt-32">
                    {{-- Dekorasi Blob Background --}}
                    <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-green-50 to-green-100/50 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="border-b border-slate-100 pb-6 mb-8">
                            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-2">Kelola Profile</h2>
                            <p class="text-slate-500 text-sm">Perbarui foto profil dan detail kontak Anda.</p>
                        </div>

                        <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            {{-- Foto Profil --}}
                            <div class="text-center mb-8">
                                <label for="foto_profil" class="cursor-pointer inline-block group relative">
                                    <div class="relative">
                                        <div id="profile-photo-preview" class="w-32 h-32 sm:w-40 sm:h-40 mx-auto rounded-full overflow-hidden shadow-lg border-4 border-white ring-4 ring-green-50 transition-all duration-300 group-hover:ring-green-100 group-hover:scale-105">
                                            @if($formPhotoUrl)
                                                <img src="{{ $formPhotoUrl }}" alt="Foto Profil" class="object-cover w-full h-full">
                                            @else
                                                <div class="w-full h-full bg-green-50 flex items-center justify-center text-green-600 text-4xl font-bold">{{ $initials }}</div>
                                            @endif
                                        </div>
                                        <div class="absolute inset-0 rounded-full flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <i class="fas fa-camera text-white text-3xl"></i>
                                        </div>
                                    </div>
                                    <div class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-50 text-green-700 text-xs font-bold uppercase tracking-wider hover:bg-green-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                        <span>Ganti Foto</span>
                                    </div>
                                </label>
                                <input type="file" id="foto_profil" name="foto_profil" class="hidden" accept="image/*" />
                                @error('foto_profil') <span class="text-red-500 text-xs font-medium mt-2 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                {{-- Input Nama --}}
                                <div class="group">
                                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                                    <div class="relative">
                                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                                            class="w-full px-4 py-3 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium placeholder:text-slate-400 text-sm">
                                    </div>
                                    @error('name') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                                </div>

                                {{-- Input Email --}}
                                <div class="group">
                                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                                    <div class="relative">
                                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                                            class="w-full px-4 py-3 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium placeholder:text-slate-400 text-sm">
                                    </div>
                                    @error('email') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- Input Telepon --}}
                            <div class="group">
                                <label for="no_telepon" class="block text-sm font-semibold text-slate-700 mb-2">No. Telepon / WhatsApp</label>
                                <div class="relative">
                                    <input id="no_telepon" name="no_telepon" type="text" value="{{ old('no_telepon', $user->no_telepon) }}"
                                        class="w-full px-4 py-3 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium placeholder:text-slate-400 text-sm">
                                </div>
                            </div>

                            {{-- Input Alamat --}}
                            <div class="group">
                                <label for="alamat" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap</label>
                                <div class="relative">
                                    <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap Anda..."
                                        class="w-full px-4 py-3 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium resize-none placeholder:text-slate-400 text-sm">{{ old('alamat', $user->alamat ?? '') }}</textarea>
                                </div>
                            </div>

                            {{-- Tombol Simpan --}}
                            <div class="flex justify-end pt-4 border-t border-slate-100 mt-6">
                                <button type="submit" id="saveProfileBtn" disabled
                                    class="w-full sm:w-auto px-8 py-3.5 rounded-2xl font-bold text-white transition-all duration-300 transform shadow-sm flex items-center justify-center gap-2"
                                    style="background-color: #cbd5e1; cursor: not-allowed;">
                                    <span>Simpan Perubahan</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- CARD 2: FORM GANTI PASSWORD --}}
                <div id="section-password" class="bg-white p-6 sm:p-8 lg:p-10 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 relative overflow-hidden scroll-mt-32">
                    <div class="relative z-10">
                        <div class="border-b border-slate-100 pb-6 mb-8">
                            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-2">Keamanan Akun</h2>
                            <p class="text-slate-500 text-sm">Perbarui kata sandi Anda untuk menjaga keamanan akun.</p>
                        </div>

                        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                            @csrf
                            @method('put')

                            <div class="group">
                                <label for="current_password" class="block text-sm font-semibold text-slate-700 mb-2">Password Saat Ini</label>
                                <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                                    class="w-full px-4 py-3 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium placeholder:text-slate-400 text-sm">
                                @error('current_password') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password Baru</label>
                                    <input id="password" name="password" type="password" autocomplete="new-password"
                                        class="w-full px-4 py-3 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium placeholder:text-slate-400 text-sm">
                                    @error('password') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                                </div>
                                <div class="group">
                                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password Baru</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                                        class="w-full px-4 py-3 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium placeholder:text-slate-400 text-sm">
                                </div>
                            </div>

                            <div class="flex justify-end pt-4 border-t border-slate-100 mt-6">
                                <button type="submit"
                                    class="w-full sm:w-auto px-8 py-3.5 rounded-2xl font-bold text-white bg-slate-800 hover:bg-slate-900 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                    <span>Update Password</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        function setActive(id) {
            document.querySelectorAll('nav a').forEach(el => {
                if(el.classList.contains('nav-item-active')) {
                    el.classList.remove('nav-item-active');
                    el.classList.add('nav-item-inactive');
                }
            });
            const activeEl = document.getElementById(id);
            if(activeEl){
                activeEl.classList.remove('nav-item-inactive');
                activeEl.classList.add('nav-item-active');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const inputs = ['name', 'email', 'no_telepon', 'alamat'].map(id => document.getElementById(id));
            const photoInput = document.getElementById('foto_profil');
            const saveBtn = document.getElementById('saveProfileBtn');
            const photoPreviewContainer = document.getElementById('profile-photo-preview');

            const originalValues = {};
            inputs.forEach(input => { if(input) originalValues[input.id] = input.value; });

            const checkChanges = () => {
                let hasChanges = photoInput.files.length > 0;
                inputs.forEach(input => {
                    if (input && input.value !== originalValues[input.id]) hasChanges = true;
                });

                if (hasChanges) {
                    saveBtn.disabled = false;
                    saveBtn.style.backgroundColor = '#16a34a'; // green-600
                    saveBtn.style.cursor = 'pointer';
                    saveBtn.classList.add('hover:bg-green-700', 'hover:shadow-lg', 'hover:-translate-y-0.5');
                } else {
                    saveBtn.disabled = true;
                    saveBtn.style.backgroundColor = '#cbd5e1'; // slate-300
                    saveBtn.style.cursor = 'not-allowed';
                    saveBtn.classList.remove('hover:bg-green-700', 'hover:shadow-lg', 'hover:-translate-y-0.5');
                }
            };

            inputs.forEach(input => { if(input) input.addEventListener('input', checkChanges); });
            
            photoInput.addEventListener('change', (e) => {
                checkChanges();
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        photoPreviewContainer.innerHTML = `<img src="${e.target.result}" class="object-cover w-full h-full">`;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</body>
</html>