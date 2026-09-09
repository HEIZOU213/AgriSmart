<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-slate-900 leading-tight">
                {{ __('Tambah Pengguna Baru') }}
            </h2>
            <a href="{{ route('admin.users.index') }}" 
               class="text-sm font-bold text-slate-500 hover:text-green-600 transition-colors">
                &larr; Kembali ke Daftar Pengguna
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        
        {{-- Menampilkan Error Validasi (jika ada) --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm">
                <strong class="font-bold">Whoops!</strong> Ada masalah dengan input Anda.<br><br>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            {{-- Form ini mengirim data ke Admin\UserController@store --}}
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf 
                
                <div class="space-y-5">
                    {{-- Nama --}}
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nama</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                               class="block w-full rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 transition">
                        @error('nama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" 
                               class="block w-full rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 transition">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Password</label>
                        <input type="password" id="password" name="password" 
                               class="block w-full rounded-xl border border-slate-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 transition">
                        <p class="mt-1 text-xs text-slate-400">Wajib diisi (minimal 8 karakter).</p>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Role (Peran) --}}
                    <div>
                        <label for="role" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Role (Peran)</label>
                        <x-custom-dropdown 
                            name="role" 
                            id="role" 
                            placeholder="-- Pilih Role --" 
                            :options="[
                                'pekebun' => 'Pekebun',
                                'user' => 'User'
                            ]" 
                            :value="old('role')" 
                            required 
                        />
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="flex justify-end pt-4 border-t border-slate-100 mt-6">
                        <button type="submit" 
                                class="px-6 py-2.5 bg-green-600 text-white rounded-xl text-sm font-bold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors shadow-sm">
                            Simpan Pengguna
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
