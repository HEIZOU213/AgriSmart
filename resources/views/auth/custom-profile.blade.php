<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Pesan Sukses --}}
            @if (session('status') === 'profile-updated')
                <div class="p-4 bg-green-100 text-green-700 rounded-md border border-green-200">
                    Profil berhasil diperbarui.
                </div>
            @endif
            @if (session('status') === 'password-updated')
                <div class="p-4 bg-green-100 text-green-700 rounded-md border border-green-200">
                    Password berhasil diperbarui.
                </div>
            @endif

            {{-- 1. Form Informasi Profil --}}
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Profil</h2>
                
                <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    {{-- Foto Profil --}}
                    <div class="flex items-center gap-6">
                        <div class="shrink-0">
                            @if($user->foto_profil)
                                <img class="h-24 w-24 object-cover rounded-full border-4 border-green-100" src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil" />
                            @else
                                <div class="h-24 w-24 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-2xl font-bold border-4 border-white shadow-sm">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ganti Foto</label>
                            <input type="file" name="foto_profil" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-green-50 file:text-green-700
                                hover:file:bg-green-100
                            "/>
                            <p class="mt-1 text-xs text-gray-500">JPG, PNG (Max. 2MB)</p>
                            @error('foto_profil') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Nama & Email --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-gray-700 font-medium text-sm mb-1">Nama Lengkap</label>
                            <input id="name" name="name" type="text" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" value="{{ old('name', $user->name) }}" required>
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-gray-700 font-medium text-sm mb-1">Email</label>
                            <input id="email" name="email" type="email" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" value="{{ old('email', $user->email) }}" required>
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    {{-- Telepon & Alamat --}}
                    <div>
                        <label for="no_telepon" class="block text-gray-700 font-medium text-sm mb-1">No. Telepon</label>
                        <input id="no_telepon" name="no_telepon" type="text" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" value="{{ old('no_telepon', $user->no_telepon) }}" placeholder="0812...">
                    </div>

                    <div>
                        <label for="alamat" class="block text-gray-700 font-medium text-sm mb-1">Alamat Lengkap</label>
                        <textarea id="alamat" name="alamat" rows="2" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Alamat pengiriman/toko...">{{ old('alamat', $user->alamat ?? '') }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-green-600 text-white py-2 px-6 rounded-lg hover:bg-green-700 transition shadow-md font-medium">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            {{-- 2. [KODE BARU] Form Ganti Password --}}
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">Ganti Password</h2>
                    <p class="mt-1 text-sm text-gray-600">Pastikan akun Anda aman dengan menggunakan password yang kuat.</p>
                </header>

                <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                        <input id="current_password" name="current_password" type="password" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" autocomplete="current-password">
                        @error('current_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <input id="password" name="password" type="password" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" autocomplete="new-password">
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" autocomplete="new-password">
                        @error('password_confirmation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-gray-800 text-white py-2 px-6 rounded-lg hover:bg-gray-700 transition shadow-md font-medium">Update Password</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>