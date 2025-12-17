<x-petani-layout>
    {{-- Memastikan Font Plus Jakarta Sans dimuat --}}
    @push('styles')
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    @endpush

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-2xl text-slate-800 leading-tight">
                {{ __('Dashboard Petani') }}
            </h2>
            <span class="text-sm font-medium text-slate-500">{{ now()->format('d F Y') }}</span>
        </div>
    </x-slot>

    <div class="py-8 font-sans antialiased text-slate-600">
        
        {{-- HEADER SECTION --}}
        <div class="mb-10" data-aos="fade-down">
            <h3 class="text-3xl font-extrabold text-slate-900">
                Ringkasan <span class="text-green-600">Penjualan</span>
            </h3>
            <p class="text-slate-500 mt-2 text-lg">Pantau performa produk dan pesanan panen secara realtime.</p>
        </div>

        {{-- GRID STATISTIK (Diubah jadi 3 Kolom) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">

            {{-- Card 1: Total Produk (Hijau) --}}
            <div class="group bg-white rounded-3xl p-6 shadow-lg shadow-green-900/5 border border-white hover:border-green-200 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden" data-aos="fade-up" data-aos-delay="0">
                <div class="absolute top-0 right-0 w-32 h-32 bg-green-50 rounded-full mix-blend-multiply filter blur-2xl opacity-50 -mr-10 -mt-10 transition-all group-hover:bg-green-100"></div>
                
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 mb-4 group-hover:scale-110 transition-transform duration-300">
                        {{-- Icon Box --}}
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Produk Aktif</p>
                    <div class="flex items-end gap-2 mt-1">
                        <p class="text-3xl font-black text-slate-800">{{ $stats['total_products'] }}</p>
                        <span class="text-sm font-medium text-slate-400 mb-1">Item</span>
                    </div>
                </div>
            </div>

            {{-- Card 2: Terjual (Biru/Teal) --}}
            <div class="group bg-white rounded-3xl p-6 shadow-lg shadow-green-900/5 border border-white hover:border-teal-200 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <div class="absolute top-0 right-0 w-32 h-32 bg-teal-50 rounded-full mix-blend-multiply filter blur-2xl opacity-50 -mr-10 -mt-10 transition-all group-hover:bg-teal-100"></div>
                
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-teal-100 rounded-2xl flex items-center justify-center text-teal-600 mb-4 group-hover:scale-110 transition-transform duration-300">
                        {{-- Icon Shopping Bag --}}
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Total Terjual</p>
                    <div class="flex items-end gap-2 mt-1">
                        <p class="text-3xl font-black text-slate-800">{{ $stats['total_sales_items'] }}</p>
                        <span class="text-sm font-medium text-slate-400 mb-1">Unit</span>
                    </div>
                </div>
            </div>

            {{-- Card 3: Pesanan Masuk (Kuning/Orange) --}}
            <div class="group bg-white rounded-3xl p-6 shadow-lg shadow-green-900/5 border border-white hover:border-orange-200 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-full mix-blend-multiply filter blur-2xl opacity-50 -mr-10 -mt-10 transition-all group-hover:bg-orange-100"></div>
                
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600 mb-4 group-hover:scale-110 transition-transform duration-300">
                        {{-- Icon Bell/Clipboard --}}
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Pesanan Baru</p>
                    <div class="flex items-end gap-2 mt-1">
                        <p class="text-3xl font-black text-slate-800">{{ $stats['incoming_orders'] }}</p>
                        <span class="text-sm font-medium text-slate-400 mb-1">Pesanan</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</x-petani-layout>