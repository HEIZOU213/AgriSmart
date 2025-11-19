<x-konsumen-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ringkasan Akun (Konsumen)') }}
        </h2>
    </x-slot>

    <div class="text-gray-900 space-y-8">
        
        <h3 class="text-2xl font-bold border-b pb-2">Statistik Pembelanjaan</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Total Pesanan Dibuat --}}
            <div class="bg-indigo-100 p-6 rounded-lg shadow-md">
                <p class="text-sm font-medium text-indigo-700">Total Pesanan Dibuat</p>
                <p class="text-3xl font-extrabold text-indigo-900 mt-1">{{ $stats['total_orders'] }}</p>
            </div>
            {{-- Total Dibelanjakan --}}
            <div class="bg-green-100 p-6 rounded-lg shadow-md">
                <p class="text-sm font-medium text-green-700">Total Pengeluaran</p>
                <p class="text-2xl font-extrabold text-green-900 mt-1">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</p>
            </div>
            {{-- Pesanan Pending --}}
            <div class="bg-yellow-100 p-6 rounded-lg shadow-md">
                <p class="text-sm font-medium text-yellow-700">Pesanan Belum Selesai</p>
                <p class="text-3xl font-extrabold text-yellow-900 mt-1">{{ $stats['orders_pending'] }}</p>
            </div>
        </div>

        <h3 class="text-2xl font-bold border-b pb-2 pt-4">Aktivitas Terbaru</h3>

        @if($stats['last_order'])
            <div class="p-6 border border-gray-200 rounded-lg">
                <p class="text-lg font-semibold mb-3">Pesanan Terakhir Anda ({{ $stats['last_order']->kode_pesanan }})</p>
                <p>Status: <span class="font-bold capitalize">{{ $stats['last_order']->status }}</span></p>
                <p class="text-sm text-gray-600">Total: Rp {{ number_format($stats['last_order']->total_harga, 0, ',', '.') }}</p>
                <a href="{{ route('konsumen.pesanan.show', $stats['last_order']->id) }}" class="mt-3 inline-block px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                    Lihat Detail Pesanan &rarr;
                </a>
            </div>
        @else
            <div class="p-6 border border-gray-200 rounded-lg text-center text-gray-500">
                Anda belum pernah melakukan pemesanan.
            </div>
        @endif
    </div>
</x-konsumen-layout>