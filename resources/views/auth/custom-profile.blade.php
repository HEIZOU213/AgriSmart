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
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Informasi Profil</h2>
                            <p class="mt-1 text-sm text-gray-600">Perbarui informasi profil akun dan alamat email Anda.</p>
                        </header>

                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500" value="{{ old('name', $user->name) }}" required autofocus>
                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500" value="{{ old('email', $user->email) }}" required>
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="no_telepon" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                                <input type="text" name="no_telepon" id="no_telepon" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500" value="{{ old('no_telepon', $user->no_telepon) }}">
                                @error('no_telepon') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea name="alamat" id="alamat" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('alamat', $user->alamat) }}</textarea>
                                @error('alamat') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Simpan</button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            {{-- 2. Form Update Password --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Perbarui Password</h2>
                            <p class="mt-1 text-sm text-gray-600">Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.</p>
                        </header>

                        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('put')

                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                                <input type="password" name="current_password" id="current_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                                @error('current_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                                <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                                @error('password_confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Simpan Password</button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>