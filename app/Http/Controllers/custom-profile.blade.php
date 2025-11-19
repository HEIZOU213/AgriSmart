<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - AgriSmart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    {{-- 
      Navbar ini adalah navbar manual. 
      Jika Anda ingin menggunakan layout Breeze (<x-app-layout>), 
      ganti file ini agar meng-extend layout tersebut.
    --}}
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <a class="flex items-center font-bold text-xl text-green-600" href="/">AgriSmart</a>
                <a class="flex items-center text-sm text-gray-700" href="{{ url()->previous() }}">&larr; Kembali</a>
            </div>
        </div>
    </nav>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Pesan Sukses --}}
            @if (session('status') === 'profile-updated')
                <div class="p-4 bg-green-100 text-green-700 rounded-md">Profil berhasil diperbarui.</div>
            @endif
            @if (session('status') === 'password-updated')
                <div class="p-4 bg-green-100 text-green-700 rounded-md">Password berhasil diperbarui.</div>
            @endif

            {{-- Form Update Profil --}}
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Profil</h2>
                <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('patch')

                    <div>
                        <label for="name" class="block text-gray-700 font-medium text-sm mb-1">Nama</label>
                        <input id="name" name="name" type="text" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" :value="old('name', $user->name)" required autofocus>
                    </div>
                    <div>
                        <label for="email" class="block text-gray-700 font-medium text-sm mb-1">Email</label>
                        <input id="email" name="email" type="email" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" :value="old('email', $user->email)" required>
                    </div>
                    <div>
                        <label for="no_telepon" class="block text-gray-700 font-medium text-sm mb-1">No. Telepon</label>
                        <input id="no_telepon" name="no_telepon" type="text" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" :value="old('no_telepon', $user->no_telepon)">
                    </div>
                    <div>
                        <label for="alamat" class="block text-gray-700 font-medium text-sm mb-1">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="3" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('alamat', $user->alamat) }}</textarea>
                    </div>
                    
                    <button type="submit" class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition">Simpan</button>
                </form>
            </div>

            {{-- Form Update Password --}}
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Ubah Password</h2>
                <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf
                    @method('put')
                    
                    <div>
                        <label for="current_password" class="block text-gray-700 font-medium text-sm mb-1">Password Saat Ini</label>
                        <input id="current_password" name="current_password" type="password" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" required>
                        @error('current_password', 'updatePassword') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-gray-700 font-medium text-sm mb-1">Password Baru</label>
                        <input id="password" name="password" type="password" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" required>
                        @error('password', 'updatePassword') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-gray-700 font-medium text-sm mb-1">Konfirmasi Password Baru</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    </div>
                    
                    <button type="submit" class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition">Simpan Password</button>
                </form>
            </div>
            
        </div>
    </div>
</body>
</html>