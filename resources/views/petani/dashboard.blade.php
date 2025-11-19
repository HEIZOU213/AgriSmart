<x-petani-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ringkasan Penjualan (Petani)') }}
        </h2>
    </x-slot>

    <div class="text-gray-900 space-y-8">
        
        <h3 class="text-2xl font-bold border-b pb-2">Metrik Utama Penjualan</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Total Produk --}}
            <div class="bg-indigo-100 p-6 rounded-lg shadow-md">
                <p class="text-sm font-medium text-indigo-700">Total Produk Aktif Saya</p>
                <p class="text-3xl font-extrabold text-indigo-900 mt-1">{{ $stats['total_products'] }}</p>
            </div>
            {{-- Total Barang Terjual (Unit) --}}
            <div class="bg-teal-100 p-6 rounded-lg shadow-md">
                <p class="text-sm font-medium text-teal-700">Total Barang Terjual (Unit)</p>
                <p class="text-3xl font-extrabold text-teal-900 mt-1">{{ $stats['total_sales_items'] }}</p>
            </div>
            {{-- Pesanan Masuk --}}
            <div class="bg-yellow-100 p-6 rounded-lg shadow-md">
                <p class="text-sm font-medium text-yellow-700">Pesanan Masuk Unik</p>
                <p class="text-3xl font-extrabold text-yellow-900 mt-1">{{ $stats['incoming_orders'] }}</p>
            </div>
            {{-- Total Pendapatan --}}
            <div class="bg-green-100 p-6 rounded-lg shadow-md">
                <p class="text-sm font-medium text-green-700">Total Pendapatan Kotor</p>
                <p class="text-2xl font-extrabold text-green-900 mt-1">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
            </div>
        </div>

        <h3 class="text-2xl font-bold border-b pb-2 pt-4">Tindakan Cepat</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Kelola Produk --}}
            <div class="p-6 border border-gray-200 rounded-lg">
                <p class="text-lg font-semibold mb-3">Produk & Inventaris</p>
                <a href="{{ route('petani.produk.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md font-medium hover:bg-indigo-700">
                    Kelola Produk Saya &rarr;
                </a>
            </div>
            {{-- Kelola Pesanan --}}
            <div class="p-6 border border-gray-200 rounded-lg">
                <p class="text-lg font-semibold mb-3">Pesanan Masuk</p>
                <a href="{{ route('petani.pesanan.index') }}" class="px-4 py-2 bg-green-600 text-white rounded-md font-medium hover:bg-green-700">
                    Lihat Pesanan & Konfirmasi &rarr;
                </a>
            </div>
        </div>
    </div>
</x-petani-layout>