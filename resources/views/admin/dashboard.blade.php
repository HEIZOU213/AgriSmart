<x-admin-layout>
    <div class="space-y-8">
        
        {{-- 1. Header Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-1">
                    Dashboard Overview
                </p>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">
                    {{ Auth::user()->nama }} <span class="text-2xl">🌱</span>
                </h2>
                <p class="text-gray-500 dark:text-gray-400 mt-1">
                    Ringkasan statistik ekosistem AgriSmart hari ini.
                </p>
            </div>
            <div class="flex items-center gap-2 bg-white dark:bg-gray-800 rounded-full px-4 py-2 shadow-sm border border-gray-100 dark:border-gray-700">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>
                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Live Update</span>
                <span class="text-gray-300">|</span>
                <span class="text-sm font-bold text-gray-800 dark:text-white">{{ now()->format('d M Y') }}</span>
            </div>
        </div>

        {{-- 2. Stats Overview: Bento Grid Layout --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            {{-- Card 1: Total User --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border-l-4 border-indigo-500 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase">Total Pengguna</p>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $stats['total_users'] }}</h3>
                    </div>
                    <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg text-indigo-600 dark:text-indigo-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-gray-400">
                    <span class="text-indigo-600 font-medium bg-indigo-50 px-2 py-0.5 rounded mr-2">Database</span>
                    <span>Seluruh akun terdaftar</span>
                </div>
            </div>

            {{-- Card 2: Petani --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border-l-4 border-emerald-500 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase">Mitra Petani</p>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $stats['total_petani'] }}</h3>
                    </div>
                    <div class="p-2 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg text-emerald-600 dark:text-emerald-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-gray-400">
                    <span class="text-emerald-600 font-medium bg-emerald-50 px-2 py-0.5 rounded mr-2">Produsen</span>
                    <span>Penyedia komoditas</span>
                </div>
            </div>

            {{-- Card 3: Konsumen --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border-l-4 border-orange-400 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase">Konsumen</p>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $stats['total_konsumen'] }}</h3>
                    </div>
                    <div class="p-2 bg-orange-50 dark:bg-orange-900/30 rounded-lg text-orange-500 dark:text-orange-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-gray-400">
                    <span class="text-orange-600 font-medium bg-orange-50 px-2 py-0.5 rounded mr-2">Pembeli</span>
                    <span>Target pasar aktif</span>
                </div>
            </div>

            {{-- Card 4: Artikel --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border-l-4 border-sky-500 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase">Artikel Edukasi</p>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $stats['total_konten_edukasi'] }}</h3>
                    </div>
                    <div class="p-2 bg-sky-50 dark:bg-sky-900/30 rounded-lg text-sky-600 dark:text-sky-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-gray-400">
                    <span class="text-sky-600 font-medium bg-sky-50 px-2 py-0.5 rounded mr-2">Literasi</span>
                    <span>Konten terpublikasi</span>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>