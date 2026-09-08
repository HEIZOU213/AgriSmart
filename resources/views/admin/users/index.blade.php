<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-900 leading-tight">
            {{ __('Kelola Akun Pengguna') }}
        </h2>
        {{-- Tombol Tambah dihapus dari sini agar lebih rapi --}}
    </x-slot>

    <div class="py-6">
        
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            {{-- KARTU PETANI (HIJAU) --}}
            <a href="{{ route('admin.users.petani') }}" class="group relative bg-white rounded-2xl shadow-sm hover:shadow-md border border-slate-200 hover:border-green-300 h-64 flex flex-col justify-center items-center text-center cursor-pointer transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                
                <div class="relative z-10 transition-colors duration-300">
                    <div class="w-20 h-20 mx-auto bg-green-50 text-green-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-green-600 group-hover:text-white transition-all shadow-sm">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 group-hover:text-green-700">Akun Pekebun Durian</h3>
                    <p class="text-slate-500 mt-2">Kelola {{ $countPetani }} mitra penjual</p>
                    <span class="mt-4 inline-block text-xs font-bold uppercase tracking-wider text-green-700 bg-green-50 px-3 py-1 rounded-full border border-green-200">
                        + Tambah / Edit Pekebun
                    </span>
                </div>
            </a>

            {{-- KARTU KONSUMEN --}}
            <a href="{{ route('admin.users.konsumen') }}" class="group relative bg-white rounded-2xl shadow-sm hover:shadow-md border border-slate-200 hover:border-green-300 h-64 flex flex-col justify-center items-center text-center cursor-pointer transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                
                <div class="relative z-10 transition-colors duration-300">
                    <div class="w-20 h-20 mx-auto bg-green-50 text-green-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-green-600 group-hover:text-white transition-all shadow-sm">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 group-hover:text-green-700">Akun Konsumen</h3>
                    <p class="text-slate-500 mt-2">Kelola {{ $countKonsumen }} pembeli terdaftar</p>
                    <span class="mt-4 inline-block text-xs font-bold uppercase tracking-wider text-green-700 bg-green-50 px-3 py-1 rounded-full border border-green-200">
                        Lihat Daftar Pembeli
                    </span>
                </div>
            </a>

        </div>
    </div>
</x-admin-layout>
