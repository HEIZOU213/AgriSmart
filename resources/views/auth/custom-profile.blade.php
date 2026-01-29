<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Edit Profil - {{ config('app.name', 'AgriSmart') }}</title>

    {{-- FONT: Plus Jakarta Sans (Sesuai Index) --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- TAILWIND & SCRIPTS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        [x-cloak] { display: none !important; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f0fdf4; }
        ::-webkit-scrollbar-thumb { background: #16a34a; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #15803d; }
    </style>
</head>

<body class="font-sans antialiased text-slate-700 bg-green-50 flex flex-col min-h-screen selection:bg-green-500 selection:text-white"
      x-data="{ sidebarOpen: false }">

    {{-- NAVBAR --}}
    <x-navbar />

    {{-- PHP LOGIC (Tidak Dirubah) --}}
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

    {{-- BACKGROUND DECORATIONS (Sesuai Index) --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-gradient-to-br from-green-100/40 via-green-50/20 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-gradient-to-tl from-green-100/30 to-transparent rounded-full blur-3xl translate-x-1/3 translate-y-1/3"></div>
        <div class="absolute inset-0 opacity-[0.015]" style="background-image: radial-gradient(circle at 1px 1px, rgb(22 163 74) 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>

    {{-- MAIN CONTAINER --}}
    <main class="flex-1 w-full pt-24 pb-12 sm:pt-28 sm:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- HEADER HALAMAN --}}
            <div class="mb-8 sm:mb-12">
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Pengaturan Akun</h1>
                <p class="text-slate-500 mt-1">Kelola informasi profil dan keamanan akun Anda.</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8 lg:gap-10">
                
                {{-- ================================================
                     SIDEBAR NAVIGASI
                ================================================ --}}
                
                {{-- Mobile Toggle Button --}}
                <div class="lg:hidden mb-4">
                    <button @click="sidebarOpen = !sidebarOpen" 
                            class="flex items-center gap-2 px-4 py-2.5 bg-white border border-green-200 rounded-xl shadow-sm text-slate-700 font-semibold w-full hover:bg-green-50 transition-colors">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <span>Menu Pengaturan</span>
                    </button>
                </div>

                {{-- Sidebar Container --}}
                <aside class="lg:w-72 flex-shrink-0">
                    <div :class="sidebarOpen ? 'fixed inset-0 z-50 flex' : 'hidden lg:block'" class="lg:sticky lg:top-28 lg:h-fit">
                        
                        {{-- Mobile Backdrop --}}
                        <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 bg-black/40 lg:hidden"></div>

                        {{-- Menu Content --}}
                        <div class="relative w-4/5 max-w-xs bg-white lg:bg-white lg:w-full h-full lg:h-auto p-6 lg:p-6 lg:rounded-2xl lg:border lg:border-green-100 lg:shadow-lg overflow-y-auto transition-transform duration-300"
                             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0 lg:transform-none'">
                            
                            {{-- Header Mobile Sidebar --}}
                            <div class="lg:hidden flex items-center justify-between mb-6">
                                <span class="text-lg font-bold text-slate-900">Menu</span>
                                <button @click="sidebarOpen = false" class="text-slate-400 hover:text-red-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>

                            {{-- Menu Links --}}
                            <nav class="space-y-2">
                                {{-- 1. Kelola Profile --}}
                                <a href="#section-profile" @click="sidebarOpen = false"
                                   class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 bg-green-50 text-green-700 border border-green-100 shadow-sm font-semibold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    <span>Kelola Profile</span>
                                </a>

                                {{-- 2. Ganti Password --}}
                                <a href="#section-password" @click="sidebarOpen = false"
                                   class="group flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-green-600 transition-all duration-300 font-medium">
                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                    <span>Ganti Password</span>
                                </a>

                                <div class="my-4 border-t border-slate-100"></div>

                                {{-- 3. Kembali ke Dashboard --}}
                                @if($user->role === 'admin' || $user->role === 'petani')
                                    @php
                                        $dashboardRoute = ($user->role === 'admin') ? route('admin.dashboard') : route('petani.dashboard');
                                    @endphp
                                    <a href="{{ $dashboardRoute }}"
                                       class="group flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-green-600 transition-all duration-300 font-medium">
                                        <svg class="w-5 h-5 text-slate-400 group-hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                                        <span>Dashboard</span>
                                    </a>
                                @endif

                                {{-- 4. Logout --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="group w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-all duration-300 font-medium text-left">
                                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                        <span>Keluar</span>
                                    </button>
                                </form>
                            </nav>
                        </div>
                    </div>
                </aside>

                {{-- ================================================
                     KONTEN UTAMA
                ================================================ --}}
                <div class="flex-1 space-y-8">

                    {{-- Flash Messages --}}
                    @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
                        <div class="p-4 bg-emerald-50 text-emerald-700 rounded-2xl border border-emerald-200 flex items-start gap-3 shadow-sm animate-fade-in-down">
                            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <div>
                                <p class="font-bold">Berhasil Disimpan!</p>
                                <p class="text-sm opacity-90">Perubahan data akun Anda telah berhasil diperbarui.</p>
                            </div>
                        </div>
                    @endif

                    {{-- FORM 1: EDIT PROFIL --}}
                    <div id="section-profile" class="bg-white rounded-3xl p-6 sm:p-10 border border-green-50 shadow-xl relative overflow-hidden scroll-mt-32">
                        
                        {{-- Header Form --}}
                        <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-100">
                            <div>
                                <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Profil Saya</h2>
                                <p class="text-sm text-slate-500 mt-1">Perbarui foto dan detail pribadi Anda.</p>
                            </div>
                            <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                        </div>

                        <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            {{-- Foto Profil Section --}}
                            <div class="flex flex-col sm:flex-row items-center gap-6 sm:gap-8 mb-8">
                                <div class="relative group cursor-pointer">
                                    <div id="profile-photo-preview" class="w-32 h-32 rounded-full overflow-hidden border-4 border-green-50 shadow-lg group-hover:border-green-200 transition-all duration-300">
                                        @if($formPhotoUrl)
                                            <img src="{{ $formPhotoUrl }}" alt="Foto Profil" class="object-cover w-full h-full">
                                        @else
                                            <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400 text-4xl font-bold">{{ $initials }}</div>
                                        @endif
                                    </div>
                                    <label for="foto_profil" class="absolute bottom-0 right-0 bg-green-600 hover:bg-green-700 text-white p-2.5 rounded-full shadow-lg cursor-pointer transition-transform hover:scale-110">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    </label>
                                    <input type="file" id="foto_profil" name="foto_profil" class="hidden" accept="image/*" />
                                </div>
                                <div class="text-center sm:text-left">
                                    <h3 class="font-bold text-slate-900">Foto Profil</h3>
                                    <p class="text-xs text-slate-500 mt-1 max-w-[200px]">Format: JPG, PNG, GIF. Maksimal 2MB. Klik ikon kamera untuk mengubah.</p>
                                    @error('foto_profil') <span class="text-red-500 text-xs font-medium mt-2 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-5">
                                {{-- Nama --}}
                                <div class="group">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                                        class="w-full px-4 py-3 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium placeholder:text-slate-400">
                                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                {{-- Email --}}
                                <div class="group">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email</label>
                                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                                        class="w-full px-4 py-3 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium placeholder:text-slate-400">
                                    @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                {{-- Telepon --}}
                                <div class="group md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">No. WhatsApp / Telepon</label>
                                    <input id="no_telepon" name="no_telepon" type="text" value="{{ old('no_telepon', $user->no_telepon) }}"
                                        class="w-full px-4 py-3 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium placeholder:text-slate-400">
                                </div>

                                {{-- Alamat --}}
                                <div class="group md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap</label>
                                    <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap Anda..."
                                        class="w-full px-4 py-3 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium placeholder:text-slate-400 resize-none">{{ old('alamat', $user->alamat ?? '') }}</textarea>
                                </div>
                            </div>

                            {{-- Tombol Save --}}
                            <div class="flex justify-end pt-4 border-t border-slate-100 mt-6">
                                <button type="submit" id="saveProfileBtn" disabled
                                    class="group px-8 py-3.5 bg-slate-200 text-slate-400 font-bold rounded-2xl transition-all duration-300 flex items-center gap-2 cursor-not-allowed">
                                    <span>Simpan Perubahan</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- FORM 2: GANTI PASSWORD --}}
                    <div id="section-password" class="bg-white rounded-3xl p-6 sm:p-10 border border-green-50 shadow-xl relative overflow-hidden scroll-mt-32">
                        
                        <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-100">
                            <div>
                                <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Ganti Password</h2>
                                <p class="text-sm text-slate-500 mt-1">Pastikan password Anda kuat dan aman.</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                        </div>

                        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                            @csrf
                            @method('put')

                            <div class="group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Password Saat Ini</label>
                                <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                                    class="w-full px-4 py-3 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium">
                                @error('current_password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid md:grid-cols-2 gap-5">
                                <div class="group">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password Baru</label>
                                    <input id="password" name="password" type="password" autocomplete="new-password"
                                        class="w-full px-4 py-3 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium">
                                    @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div class="group">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                                        class="w-full px-4 py-3 rounded-2xl bg-slate-50 border-2 border-transparent focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 outline-none text-slate-900 font-medium">
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit"
                                    class="group px-8 py-3.5 bg-slate-900 hover:bg-black text-white font-bold rounded-2xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 shadow-lg flex items-center gap-2">
                                    <span>Update Password</span>
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </main>

    {{-- FOOTER --}}
    <x-footer />
    
    {{-- BACK TO TOP --}}
    <x-back-button />

    {{-- JAVASCRIPT: Logic Deteksi Perubahan & Preview Foto --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = ['name', 'email', 'no_telepon', 'alamat'].map(id => document.getElementById(id));
            const photoInput = document.getElementById('foto_profil');
            const saveBtn = document.getElementById('saveProfileBtn');
            const photoPreviewContainer = document.getElementById('profile-photo-preview');

            // Simpan nilai awal
            const originalValues = {};
            inputs.forEach(input => { if(input) originalValues[input.id] = input.value; });

            const checkChanges = () => {
                let hasChanges = photoInput.files.length > 0;
                inputs.forEach(input => {
                    if (input && input.value !== originalValues[input.id]) hasChanges = true;
                });

                if (hasChanges) {
                    saveBtn.disabled = false;
                    // Style Active Button (Hijau)
                    saveBtn.className = "group px-8 py-3.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-2xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 shadow-lg shadow-green-200 flex items-center gap-2 cursor-pointer";
                } else {
                    saveBtn.disabled = true;
                    // Style Disabled Button (Abu-abu)
                    saveBtn.className = "group px-8 py-3.5 bg-slate-200 text-slate-400 font-bold rounded-2xl transition-all duration-300 flex items-center gap-2 cursor-not-allowed";
                }
            };

            // Listener Input Text
            inputs.forEach(input => { if(input) input.addEventListener('input', checkChanges); });
            
            // Listener Input File (Foto)
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