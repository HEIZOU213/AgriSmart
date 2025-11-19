{{-- 
  Ini adalah Layout Khusus Admin.
  File ini MEMBUNGKUS layout 'app' (Breeze) 
  dan menambahkan Sidebar Admin.
--}}
<x-app-layout>
    {{-- 
      Slot 'header' ini akan diteruskan ke 'app.blade.php'.
      Kita mengambilnya dari variabel $header yang dikirim oleh view.
    --}}
    <x-slot name="header">
        {{ $header }}
    </x-slot>

    {{-- Konten Utama Halaman --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-6">

                {{-- KOLOM KIRI: SIDEBAR MENU ADMIN --}}
                <div class="w-full md:w-1/4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="font-semibold text-lg mb-4">Menu Admin</h3>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('admin.dashboard') }}" 
                                       class="block hover:text-indigo-600 {{ request()->routeIs('admin.dashboard') ? 'font-bold text-indigo-600' : '' }}">
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.konten-edukasi.index') }}" 
                                       class="block hover:text-indigo-600 {{ request()->routeIs('admin.konten-edukasi.*') ? 'font-bold text-indigo-600' : '' }}">
                                        Konten Edukasi
                                    </a>
                                </li>
                                {{-- 
                                <li>
                                    <a href="#" class="block hover:text-indigo-600">
                                        Kategori Produk
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="block hover:text-indigo-600">
                                        Kelola Pesanan
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="block hover:text-indigo-600">
                                        Kelola Pengguna
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="block hover:text-indigo-600">
                                        Mitra
                                    </a>
                                </li> 
                                --}}
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: KONTEN UTAMA DARI VIEW --}}
                <div class="w-full md:w-3/4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            {{-- Di sinilah konten dari view (index, create, edit) akan dimasukkan --}}
                            {{ $slot }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>