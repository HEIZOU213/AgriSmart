<div class="min-h-screen bg-gray-100">
    
    {{-- Memuat Navigasi Utama (Navbar) --}}
    @include('layouts.navigation')

    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <main>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex">
                            
                            {{-- Sidebar Menu --}}
                            <div class="w-1/4 pr-6 border-r border-gray-200">
                                <h3 class="text-lg font-semibold mb-4">Menu Petani</h3>
                                
                                <ul class="space-y-2">
                                    <li>
                                        <a href="{{ route('petani.dashboard') }}" 
                                           class="block hover:text-indigo-600 {{ request()->routeIs('petani.dashboard') ? 'font-bold text-indigo-600' : '' }}">
                                            Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('petani.produk.index') }}" 
                                           class="block hover:text-indigo-600 {{ request()->routeIs('petani.produk.*') ? 'font-bold text-indigo-600' : '' }}">
                                            Kelola Produk Saya
                                        </a>
                                    </li>
                                    {{-- [LINK PESANAN MASUK YANG PASTI MUNCUL] --}}
                                    <li>
                                        <a href="{{ route('petani.pesanan.index') }}" 
                                           class="block hover:text-indigo-600 {{ request()->routeIs('petani.pesanan.*') ? 'font-bold text-indigo-600' : '' }}">
                                            Pesanan Masuk
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            
                            {{-- Main Content --}}
                            <div class="w-3/4 pl-6">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>