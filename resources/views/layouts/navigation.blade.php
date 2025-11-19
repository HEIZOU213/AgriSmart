<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('homepage') }}">
                        <span class="font-bold text-xl text-green-600">AgriSmart</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @php
                        $user = Auth::user();
                        $is_admin = $user->role === 'admin';
                        $is_petani = $user->role === 'petani';
                        $is_konsumen = $user->role === 'konsumen';
                    @endphp

                    {{-- Marketplace & Edukasi: Sembunyikan dari Admin --}}
                    @unless ($is_admin)
                        <x-nav-link :href="route('produk.index')" :active="request()->routeIs('produk.index')">
                            {{ __('Marketplace') }}
                        </x-nav-link>
                        <x-nav-link :href="route('edukasi.index')" :active="request()->routeIs('edukasi.index')">
                            {{ __('Edukasi') }}
                        </x-nav-link>
                    @endunless

                    {{-- Keranjang: Hanya untuk Konsumen (atau Tamu, tapi ini navbar auth) --}}
                    @if ($is_konsumen)
                        <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                            {{ __('Keranjang') }}
                        </x-nav-link>
                    @endif
                    
                    {{-- Link Dashboard Utama --}}
                    @if($is_admin)
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Admin Panel') }}
                        </x-nav-link>
                    @elseif($is_petani)
                        <x-nav-link :href="route('petani.dashboard')" :active="request()->routeIs('petani.dashboard')">
                            {{ __('Petani Dashboard') }}
                        </x-nav-link>
                    @elseif($is_konsumen)
                        {{-- Konsumen lihat Riwayat Pesanan, BUKAN Dashboard --}}
                        <x-nav-link :href="route('konsumen.pesanan.index')" :active="request()->routeIs('konsumen.pesanan.*')">
                            {{ __('Riwayat Pesanan') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center">
                                @if(Auth::user()->foto_profil)
                                    <img class="h-8 w-8 rounded-full object-cover mr-2" src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="{{ Auth::user()->nama }}">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center mr-2 text-green-600 font-bold">
                                        {{ substr(Auth::user()->nama, 0, 1) }}
                                    </div>
                                @endif
                                <div>{{ Auth::user()->nama }}</div>
                            </div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- [FIXED] Dashboard HANYA muncul untuk Admin & Petani --}}
                        @if(!Auth::user()->is_konsumen) 
                             {{-- Catatan: kita pakai logika manual di bawah agar lebih aman --}}
                             @if(Auth::user()->role !== 'konsumen')
                                <x-dropdown-link :href="route('dashboard')">
                                    {{ __('Dashboard') }}
                                </x-dropdown-link>
                             @endif
                        @endif

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil Saya') }}
                        </x-dropdown-link>

                        {{-- Menu Tambahan Khusus Konsumen --}}
                        @if(Auth::user()->role === 'konsumen')
                            <x-dropdown-link :href="route('konsumen.pesanan.index')">
                                {{ __('Pesanan Saya') }}
                            </x-dropdown-link>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <span class="text-red-600">{{ __('Keluar') }}</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
             {{-- Mobile Links --}}
             @unless ($is_admin)
                <x-responsive-nav-link :href="route('produk.index')" :active="request()->routeIs('produk.index')">
                    {{ __('Marketplace') }}
                </x-responsive-nav-link>
            @endunless

            @if ($is_konsumen)
                <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                    {{ __('Keranjang') }}
                </x-responsive-nav-link>
            @endif

            @if($is_admin)
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Admin Panel') }}
                </x-responsive-nav-link>
            @elseif($is_petani)
                <x-responsive-nav-link :href="route('petani.dashboard')" :active="request()->routeIs('petani.dashboard')">
                    {{ __('Petani Dashboard') }}
                </x-responsive-nav-link>
            @elseif($is_konsumen)
                <x-responsive-nav-link :href="route('konsumen.pesanan.index')" :active="request()->routeIs('konsumen.pesanan.*')">
                    {{ __('Riwayat Pesanan') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                {{-- [FIXED] Dashboard Mobile juga disembunyikan untuk Konsumen --}}
                @if(Auth::user()->role !== 'konsumen')
                    <x-responsive-nav-link :href="route('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profil Saya') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>