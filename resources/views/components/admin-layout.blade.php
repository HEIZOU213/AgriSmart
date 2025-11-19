{{-- FILE: resources/views/components/admin-layout.blade.php --}}
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
                        <div class="flex flex-col md:flex-row gap-6">
                            
                            {{-- Sidebar Menu --}}
                            <div class="w-full md:w-1/4 md:pr-6 md:border-r border-gray-200">
                                <h3 class="text-lg font-semibold mb-4">Menu Admin</h3>
                                
                                <ul class="space-y-2">
                                    {{-- Link Dashboard --}}
                                    <li>
                                        <a href="{{ route('admin.dashboard') }}" 
                                           class="block hover:text-indigo-600 {{ request()->routeIs('admin.dashboard') ? 'font-bold text-indigo-600' : '' }}">
                                            Dashboard
                                        </a>
                                    </li>

                                    {{-- Link Konten Edukasi --}}
                                    <li>
                                        <a href="{{ route('admin.konten-edukasi.index') }}" 
                                           class="block hover:text-indigo-600 {{ request()->routeIs('admin.konten-edukasi.*') ? 'font-bold text-indigo-600' : '' }}">
                                            Konten Edukasi
                                        </a>
                                    </li>
                                    
                                    {{-- Link Kelola Akun Pengguna --}}
                                    <li>
                                        <a href="{{ route('admin.users.index') }}" 
                                           class="block hover:text-indigo-600 {{ request()->routeIs('admin.users.*') ? 'font-bold text-indigo-600' : '' }}">
                                            Kelola Akun Pengguna
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            
                            {{-- Main Content --}}
                            <div class="w-full md:w-3/4 md:pl-6">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>