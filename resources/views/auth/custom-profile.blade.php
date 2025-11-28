<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AgriSmart') }} - Edit Profil</title>

    {{-- FONT MODERN --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- SCRIPT TAILWIND (CDN) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    
    {{-- ================= NAVBAR ATAS (FIXED & MENYATU) ================= --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 shadow-sm">
        
        {{-- 1. BAGIAN KIRI: LOGO & BRAND --}}
        <div class="flex items-center gap-2">
            {{-- Ikon Logo Hijau Kotak (Sesuai Gambar Referensi) --}}
            <div class="bg-green-600 p-1.5 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                    <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
                    <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
                </svg>                  
            </div>
            
            {{-- Teks Brand & Badge Role Dinamis --}}
            <div class="flex items-center">
                <span class="font-extrabold text-xl text-gray-900 tracking-tight mr-3">AgriSmart</span>
                
                @if(Auth::user()->role === 'admin')
                    <span class="px-2.5 py-0.5 text-xs font-bold tracking-wide text-indigo-600 bg-indigo-100 rounded-full">Admin</span>
                @elseif(Auth::user()->role === 'petani')
                    <span class="px-2.5 py-0.5 text-xs font-bold tracking-wide text-green-600 bg-green-100 rounded-full">Petani</span>
                @else
                    <span class="px-2.5 py-0.5 text-xs font-bold tracking-wide text-gray-600 bg-gray-100 rounded-full">Konsumen</span>
                @endif
            </div>
        </div>

        {{-- 2. BAGIAN KANAN: USER DROPDOWN --}}
        <div class="relative">
            <button id="profileUserBtn" class="flex items-center gap-3 focus:outline-none group p-1 rounded-full hover:bg-gray-100 transition-colors">
                <div class="text-right hidden md:block leading-tight">
                    <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                </div>
                
                @if(Auth::user()->foto_profil)
                    <img class="h-9 w-9 rounded-full object-cover ring-2 ring-gray-200 group-hover:ring-green-500 transition" src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="{{ Auth::user()->name }}">
                @else
                    <div class="h-9 w-9 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold ring-2 ring-gray-200 group-hover:ring-green-500 transition">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
                
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition hidden sm:block">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                </svg>
            </button>

            {{-- Dropdown Menu Content --}}
            <div id="profileUserDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.15)] border border-gray-100 py-2 z-50 origin-top-right focus:outline-none">
                <div class="px-4 py-3 border-b border-gray-100 md:hidden">
                    <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->email }}</p>
                </div>

                {{-- Link Kembali ke Dashboard Sesuai Role --}}
                <div class="py-1">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700">
                            <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>
                            Dashboard Admin
                        </a>
                    @elseif(Auth::user()->role === 'petani')
                        <a href="{{ route('petani.dashboard') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700">
                            <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>
                            Dashboard Petani
                        </a>
                    @else
                         <a href="{{ route('homepage') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700">
                            <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>
                            Ke Beranda
                        </a>
                    @endif
                </div>

                <div class="border-t border-gray-100 my-1"></div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="group flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                        <svg class="mr-3 h-5 w-5 text-red-500 group-hover:text-red-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" /></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>
    {{-- ================= END NAVBAR ================= --}}


    {{-- ================= KONTEN UTAMA ================= --}}
    {{-- Wrapper dengan padding-top (pt-24) agar konten tidak tertutup navbar fixed --}}
    <div class="pt-24 pb-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Header Halaman Profil --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Pengaturan Akun</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola informasi profil dan keamanan akun Anda.</p>
            </div>
            {{-- Tombol Kembali Cepat (Opsional, mobile friendly) --}}
             <div class="md:hidden">
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800">
                        &larr; Kembali ke Dashboard
                    </a>
                @elseif(Auth::user()->role === 'petani')
                    <a href="{{ route('petani.dashboard') }}" class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-800">
                        &larr; Kembali ke Dashboard
                    </a>
                @endif
             </div>
        </div>

        {{-- Flash Messages (Notifikasi Sukses) --}}
        @if (session('status') === 'profile-updated')
            <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm flex items-center animate-fade-in-down">
                <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <p class="font-bold">Berhasil!</p>
                    <p class="text-sm">Informasi profil Anda telah diperbarui.</p>
                </div>
            </div>
        @endif
        @if (session('status') === 'password-updated')
            <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm flex items-center animate-fade-in-down">
                <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                 <div>
                    <p class="font-bold">Berhasil!</p>
                    <p class="text-sm">Kata sandi Anda telah diperbarui.</p>
                </div>
            </div>
        @endif

        {{-- 1. CARD FORMULIR EDIT PROFIL --}}
        <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 bg-gray-50 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Informasi Pribadi</h3>
                <p class="text-sm text-gray-500 mt-1">Perbarui foto profil dan detail kontak Anda.</p>
            </div>
            
            <div class="p-6 sm:p-8">
                <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    {{-- Foto Profil Section --}}
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 pb-6 border-b border-gray-100">
                        <div class="shrink-0 relative group">
                            @if($user->foto_profil)
                                <img class="h-24 w-24 object-cover rounded-full ring-4 ring-white shadow-lg group-hover:ring-green-100 transition" src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil" />
                            @else
                                <div class="h-24 w-24 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white text-3xl font-bold ring-4 ring-white shadow-lg group-hover:ring-green-100 transition">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 w-full">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Unggah Foto Baru</label>
                            <input type="file" name="foto_profil" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2.5 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-bold
                                file:bg-green-50 file:text-green-700
                                hover:file:bg-green-100
                                cursor-pointer transition"
                            />
                            <p class="mt-2 text-xs text-gray-400">Format: JPG, PNG. Ukuran maks: 2MB. Disarankan rasio persegi.</p>
                            @error('foto_profil') <span class="text-red-500 text-xs font-medium mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Grid Input Nama & Email --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                                </div>
                                <input id="name" name="name" type="text" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition" value="{{ old('name', $user->name) }}" required>
                            </div>
                            @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                       <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                             <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                {{-- [PERUBAHAN] Hapus 'readonly', 'bg-gray-100', 'cursor-not-allowed'. Tambahkan focus ring. --}}
                                <input id="email" name="email" type="email" 
                                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition" 
                                       value="{{ old('email', $user->email) }}" required>
                            </div>
                            {{-- [PERUBAHAN] Tambahkan pesan error jika email sudah dipakai orang lain --}}
                            @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    {{-- Input Telepon --}}
                    <div>
                        <label for="no_telepon" class="block text-sm font-bold text-gray-700 mb-2">No. Telepon / WhatsApp</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" /></svg>
                            </div>
                             <input id="no_telepon" name="no_telepon" type="text" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition" value="{{ old('no_telepon', $user->no_telepon) }}" placeholder="Contoh: 081234567890">
                        </div>
                    </div>

                    {{-- Input Alamat --}}
                    <div>
                        <label for="alamat" class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap</label>
                        <div class="relative">
                            <textarea id="alamat" name="alamat" rows="3" class="w-full pl-4 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition resize-none" placeholder="Masukkan alamat lengkap Anda...">{{ old('alamat', $user->alamat ?? '') }}</textarea>
                             <div class="absolute top-3 right-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="flex justify-end pt-4">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- 2. CARD FORMULIR GANTI PASSWORD --}}
        <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 bg-gray-50 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Keamanan Akun</h3>
                <p class="text-sm text-gray-500 mt-1">Perbarui kata sandi Anda untuk menjaga keamanan akun.</p>
            </div>
            
            <div class="p-6 sm:p-8">
                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <label for="current_password" class="block text-sm font-bold text-gray-700 mb-2">Password Saat Ini</label>
                        <div class="relative">
                             <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                            </div>
                            <input id="current_password" name="current_password" type="password" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent transition" autocomplete="current-password">
                        </div>
                        @error('current_password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                             <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                                </div>
                                <input id="password" name="password" type="password" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent transition" autocomplete="new-password">
                            </div>
                            @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                             <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                                </div>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent transition" autocomplete="new-password">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-black focus:ring-4 focus:ring-gray-300 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    {{-- ================= END KONTEN UTAMA ================= --}}


    {{-- SCRIPT JAVASCRIPT MANUAL UNTUK DROPDOWN --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileUserBtn = document.getElementById('profileUserBtn');
            const profileUserDropdown = document.getElementById('profileUserDropdown');

            if (profileUserBtn && profileUserDropdown) {
                // Toggle dropdown saat tombol diklik
                profileUserBtn.addEventListener('click', function(event) {
                    event.stopPropagation(); // Mencegah event bubbling ke document
                    profileUserDropdown.classList.toggle('hidden');
                });

                // Tutup dropdown saat mengklik di luar dropdown
                document.addEventListener('click', function(event) {
                    if (!profileUserBtn.contains(event.target) && !profileUserDropdown.contains(event.target)) {
                        profileUserDropdown.classList.add('hidden');
                    }
                });

                // Tutup dropdown saat tombol escape ditekan
                document.addEventListener('keydown', function(event) {
                    if (event.key === 'Escape' && !profileUserDropdown.classList.contains('hidden')) {
                        profileUserDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>

</body>
</html>