<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Pengguna Baru') }}
            </h2>
            <a href="{{ route('admin.users.index') }}" 
               class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Kembali ke Daftar Pengguna
            </a>
        </div>
    </x-slot>

    <div class="text-gray-900">
        
        {{-- Menampilkan Error Validasi (jika ada) --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                <strong>Whoops!</strong> Ada masalah dengan input Anda.<br><br>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form ini mengirim data ke Admin\UserController@store --}}
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf 
            
            <div class="space-y-4">
                {{-- Nama --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <small class="text-xs text-gray-500">Wajib diisi (minimal 8 karakter).</small>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Role (Peran) --}}
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Role (Peran)</label>
                    <select name="role" id="role" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Pilih Role --</option>
                        <option value="petani" {{ old('role') == 'petani' ? 'selected' : '' }}>Petani</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Simpan --}}
                <div class="flex justify-end">
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Simpan Pengguna
                    </button>
                </div>

            </div>
        </form>

    </div>
</x-admin-layout>