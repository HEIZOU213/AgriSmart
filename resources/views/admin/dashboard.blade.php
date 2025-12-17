<x-admin-layout>
    {{-- Memastikan Font Plus Jakarta Sans --}}
    @push('styles')
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    @endpush

    <div class="space-y-8 py-4">
        
        {{-- 1. HEADER SECTION --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6" data-aos="fade-down">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-bold uppercase tracking-widest border border-green-100 mb-2">
                    Admin Panel
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight">
                    Halo, <span class="text-green-600">{{ Auth::user()->nama }}</span> 👋
                </h2>
                <p class="text-slate-500 mt-2 text-lg font-medium">
                    Pantau pertumbuhan ekosistem AgriSmart hari ini.
                </p>
            </div>

            {{-- Live Date Badge --}}
            <div class="flex items-center gap-3 bg-white px-5 py-3 rounded-2xl shadow-sm border border-slate-100">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
                <div class="flex flex-col">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Live Update</span>
                    <span class="text-sm font-bold text-slate-800">{{ now()->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        {{-- 2. STATS OVERVIEW --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            {{-- Card 1: Total User (Indigo -> Slate/Green Mix) --}}
            <div class="group bg-white rounded-3xl p-6 shadow-lg shadow-green-900/5 border border-white hover:border-green-200 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden" data-aos="fade-up" data-aos-delay="0">
                <div class="absolute top-0 right-0 w-24 h-24 bg-green-50 rounded-full mix-blend-multiply filter blur-xl opacity-70 -mr-6 -mt-6 transition-all group-hover:scale-110"></div>
                
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <span class="px-2 py-1 bg-slate-50 rounded-lg text-xs font-bold text-slate-500">Total</span>
                    </div>
                    
                    <h3 class="text-3xl font-black text-slate-800 mb-1">{{ $stats['total_users'] }}</h3>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Pengguna Terdaftar</p>
                </div>
            </div>

            {{-- Card 2: Mitra Petani (Emerald) --}}
            <div class="group bg-white rounded-3xl p-6 shadow-lg shadow-green-900/5 border border-white hover:border-emerald-200 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-full mix-blend-multiply filter blur-xl opacity-70 -mr-6 -mt-6 transition-all group-hover:scale-110"></div>
                
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-bold">Produsen</span>
                    </div>
                    
                    <h3 class="text-3xl font-black text-slate-800 mb-1">{{ $stats['total_petani'] }}</h3>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Mitra Petani</p>
                </div>
            </div>

            {{-- Card 3: Konsumen (Teal) --}}
            <div class="group bg-white rounded-3xl p-6 shadow-lg shadow-green-900/5 border border-white hover:border-teal-200 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <div class="absolute top-0 right-0 w-24 h-24 bg-teal-50 rounded-full mix-blend-multiply filter blur-xl opacity-70 -mr-6 -mt-6 transition-all group-hover:scale-110"></div>
                
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-teal-50 rounded-2xl flex items-center justify-center text-teal-600 group-hover:bg-teal-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <span class="px-2 py-1 bg-teal-50 text-teal-600 rounded-lg text-xs font-bold">Pembeli</span>
                    </div>
                    
                    <h3 class="text-3xl font-black text-slate-800 mb-1">{{ $stats['total_konsumen'] }}</h3>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Konsumen Aktif</p>
                </div>
            </div>

            {{-- Card 4: Artikel (Sky/Blue) --}}
            <div class="group bg-white rounded-3xl p-6 shadow-lg shadow-green-900/5 border border-white hover:border-sky-200 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                <div class="absolute top-0 right-0 w-24 h-24 bg-sky-50 rounded-full mix-blend-multiply filter blur-xl opacity-70 -mr-6 -mt-6 transition-all group-hover:scale-110"></div>
                
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-sky-50 rounded-2xl flex items-center justify-center text-sky-600 group-hover:bg-sky-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </div>
                        <span class="px-2 py-1 bg-sky-50 text-sky-600 rounded-lg text-xs font-bold">Literasi</span>
                    </div>
                    
                    <h3 class="text-3xl font-black text-slate-800 mb-1">{{ $stats['total_konten_edukasi'] }}</h3>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Artikel Edukasi</p>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    
    <div class="p-6 bg-green-600 rounded-2xl shadow-lg text-white flex items-center justify-between">
        <div>
            <h3 class="text-sm font-medium opacity-80 uppercase tracking-wider">Keuntungan AgriSmart</h3>
            <p class="text-3xl font-black mt-1">
                Rp {{ number_format($stats['pendapatan_bersih'], 0, ',', '.') }}
            </p>
            <p class="text-xs mt-2 opacity-70">Total dari 06% komisi transaksi sukses</p>
        </div>
        <div class="p-3 bg-white/20 rounded-xl">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

    <div class="p-6 bg-blue-600 rounded-2xl shadow-lg text-white flex items-center justify-between">
        <div>
            <h3 class="text-sm font-medium opacity-80 uppercase tracking-wider">Dana Mengendap (Milik Petani)</h3>
            <p class="text-3xl font-black mt-1">
                Rp {{ number_format($stats['uang_titipan'], 0, ',', '.') }}
            </p>
            <p class="text-xs mt-2 opacity-70">Uang yang siap ditarik (Withdraw) oleh petani</p>
        </div>
        <div class="p-3 bg-white/20 rounded-xl">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
    </div>

</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    {{-- Kode kartu user yang lama taruh disini --}}
</div>

    </div>
</x-admin-layout>