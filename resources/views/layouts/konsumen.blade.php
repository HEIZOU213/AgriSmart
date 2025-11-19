{{-- 
  Ini adalah Layout Khusus Konsumen.
  File ini MEMBUNGKUS layout 'app' (Breeze) 
  dan menambahkan Sidebar Konsumen.
--}}
<x-app-layout>
    {{-- Slot 'header' ini akan diteruskan ke 'app.blade.php' --}}
    <x-slot name="header">
        {{ $header }}
    </x-slot>

    {{-- Konten Utama Halaman --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-6">

                {{-- KOLOM KIRI: SIDEBAR MENU KONSUMEN --}}
                <div class="w-full md:w-1/4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="font-semibold text-lg mb-4">Menu Konsumen</h3>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('konsumen.pesanan.index') }}" 
                                       class="block hover:text-indigo-600 {{ request()->routeIs('konsumen.dashboard') ? 'font-bold text-indigo-600' : '' }}">
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('konsumen.pesanan.index') }}" 
                                       class="block hover:text-indigo-600 {{ request()->routeIs('konsumen.pesanan.*') ? 'font-bold text-indigo-600' : '' }}">
                                        Riwayat Pesanan Saya
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KKANAN: KONTEN UTAMA DARI VIEW --}}
                <div class="w-full md:w-3/4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            {{-- Di sinilah konten dari view (index, show) akan dimasukkan --}}
                            {{ $slot }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>