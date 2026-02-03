<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Keranjang Belanja AgriSmart - Kelola produk pertanian segar pilihan Anda.">

    <title>Keranjang Belanja - {{ config('app.name', 'AgriSmart') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f0fdf4;
        }

        ::-webkit-scrollbar-thumb {
            background: #16a34a;
            border-radius: 5px;
            border: 2px solid #f0fdf4;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #15803d;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        @media (max-width: 640px) {
            .cart-item-grid {
                display: grid;
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }
            
            .product-info-mobile {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .quantity-control-mobile {
                display: flex;
                align-items: center;
                justify-content: space-between;
                width: 100%;
            }
            
            .mobile-action-buttons {
                display: flex;
                gap: 0.5rem;
                margin-top: 0.5rem;
            }
        }
    </style>
</head>

<body
    class="font-sans antialiased text-slate-700 bg-green-50 flex flex-col min-h-screen selection:bg-green-500 selection:text-white">

    <x-navbar />

    <main class="flex-1">
        <section class="relative overflow-hidden pt-20 pb-6 sm:pt-28 lg:pt-32 lg:pb-12 bg-slate-50">
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="w-[200px] h-[200px] sm:w-[400px] sm:h-[400px] lg:w-[800px] lg:h-[800px] opacity-5">
                    <div class="w-full h-full animate-[spin_30s_linear_infinite]">
                        <img src="{{ asset('images/nav-logo.png') }}" alt="Background"
                            class="w-full h-full object-contain">
                    </div>
                </div>
            </div>

            <div class="relative z-10 container mx-auto px-3 sm:px-6 lg:px-8 max-w-4xl">
                <div class="text-center" data-aos="fade-up">
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-green-100/50 text-green-700 text-[10px] sm:text-xs font-bold tracking-wider uppercase mb-3 border border-green-200/50 shadow-sm">
                        Checkout Process
                    </span>
                    <h1
                        class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-slate-900 mb-3 sm:mb-6 leading-tight break-words">
                        Keranjang
                        <span class="text-green-600 inline-block">Belanja</span>
                    </h1>
                    <p class="text-sm sm:text-lg text-slate-600 max-w-xl sm:max-w-2xl mx-auto px-2 leading-relaxed">
                        Periksa kembali produk pilihan Anda sebelum melanjutkan ke pembayaran.
                    </p>
                </div>
            </div>
        </section>

        <section class="py-4 lg:py-10 bg-white relative font-sans">
            <div class="container mx-auto px-3 sm:px-6 lg:px-8 max-w-7xl relative z-10 pb-32 lg:pb-0">

                @if (session('success'))
                    <div class="mb-4 p-3 sm:p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-3 shadow-sm"
                        data-aos="fade-down">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium text-xs sm:text-sm">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-3 sm:p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center gap-3 shadow-sm"
                        data-aos="fade-down">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium text-xs sm:text-sm">{{ session('error') }}</span>
                    </div>
                @endif

                @if(isset($cart) && count($cart) > 0)
                    <form action="{{ route('checkout.index') }}" method="GET" id="cartForm">
                        <div class="flex flex-col lg:flex-row gap-4 lg:gap-8">

                            <div class="w-full lg:w-3/4 space-y-4">

                                <div
                                    class="hidden lg:flex items-center bg-white p-4 rounded-lg shadow-sm border border-slate-200 text-sm text-slate-500">
                                    <div class="w-[45%] flex items-center gap-4">
                                        <input type="checkbox" id="checkAllDesktop"
                                            class="master-checkbox w-4 h-4 rounded border-slate-300 text-green-600 focus:ring-green-500 cursor-pointer">
                                        <label for="checkAllDesktop"
                                            class="cursor-pointer text-slate-700 font-medium select-none">
                                            Pilih Semua <span class="text-slate-400 font-normal">({{ count($cart) }})</span>
                                        </label>
                                    </div>
                                    <div class="w-[20%] text-center">Harga Satuan</div>
                                    <div class="w-[20%] text-center">Kuantitas</div>
                                    <div class="w-[15%] text-right">Total Harga</div>
                                </div>

                                @foreach($groupedCart as $penjual => $items)
                                    <div
                                        class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden store-group">

                                        <div class="p-3 sm:p-4 border-b border-slate-100 flex items-center gap-3 bg-slate-50/50">
                                            <input type="checkbox"
                                                class="store-checkbox w-4 h-4 rounded border-slate-300 text-green-600 focus:ring-green-500 cursor-pointer">
                                            <div class="flex items-center gap-2 cursor-pointer hover:opacity-80">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-700" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                                    </path>
                                                </svg>
                                                <span class="font-bold text-slate-800 text-xs sm:text-sm">{{ $penjual }}</span>
                                            </div>
                                        </div>

                                        <div class="flex flex-col">
                                            @foreach($items as $item)
                                                <div
                                                    class="p-3 sm:p-4 border-b border-slate-100 last:border-0 flex flex-col sm:flex-row gap-3 sm:gap-4 items-center sm:items-start relative group {{ ($item->stok ?? 0) < 1 ? 'bg-slate-50 opacity-75' : '' }} cart-item-grid">

                                                    <div class="flex items-start gap-3 w-full sm:w-[45%]">
                                                        <div class="pt-6 sm:pt-6">
                                                            @if(($item->stok ?? 0) > 0)
                                                                <input type="checkbox" name="selected[]" value="{{ $item->cart_id }}"
                                                                    class="item-checkbox w-4 h-4 rounded border-slate-300 text-green-600 focus:ring-green-500 cursor-pointer"
                                                                    data-price="{{ $item->harga }}" data-name="{{ $item->nama_produk }}"
                                                                    data-product-id="{{ $item->id }}" id="checkbox-{{ $item->id }}">
                                                            @else
                                                                <input type="checkbox" disabled
                                                                    class="w-4 h-4 rounded border-slate-200 bg-slate-100 text-slate-300 cursor-not-allowed">
                                                            @endif
                                                        </div>

                                                        <a href="{{ route('produk.show', $item->id) }}"
                                                            class="block w-16 h-16 sm:w-24 sm:h-24 flex-shrink-0 border border-slate-200 rounded-md overflow-hidden bg-slate-100 {{ ($item->stok ?? 0) < 1 ? 'grayscale' : '' }} relative">
                                                            @if($item->foto)
                                                                <img src="{{ asset('storage/' . $item->foto) }}"
                                                                    alt="{{ $item->nama_produk }}" class="w-full h-full object-cover">
                                                            @else
                                                                <div
                                                                    class="w-full h-full flex items-center justify-center text-slate-300">
                                                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                                        </path>
                                                                    </svg>
                                                                </div>
                                                            @endif

                                                            @if(($item->stok ?? 0) < 1)
                                                                <div
                                                                    class="absolute inset-0 bg-black/10 flex items-center justify-center">
                                                                    <span
                                                                        class="bg-red-600 text-white text-[8px] px-1.5 py-0.5 sm:text-[10px] sm:px-2 sm:py-1 rounded font-bold">HABIS</span>
                                                                </div>
                                                            @endif
                                                        </a>

                                                        <div class="flex-1 min-w-0 flex flex-col justify-center h-16 sm:h-24 py-1 product-info-mobile">
                                                            <a href="{{ route('produk.show', $item->id) }}"
                                                                class="text-xs sm:text-sm font-medium text-slate-800 line-clamp-2 leading-snug hover:text-green-600">
                                                                {{ $item->nama_produk }}
                                                            </a>

                                                            <div class="mt-0.5 sm:mt-1 flex items-center gap-1">
                                                                <span class="text-[9px] sm:text-[10px] text-slate-500">Stok:</span>
                                                                <span
                                                                    class="text-[9px] sm:text-sm font-bold {{ ($item->stok ?? 0) > 0 ? 'text-green-600' : 'text-red-500' }}">
                                                                    {{ $item->stok ?? 0 }} {{ $item->satuan ?? '' }}
                                                                </span>
                                                            </div>

                                                            <div class="sm:hidden mt-1 flex justify-between items-center">
                                                                <div class="font-bold text-green-600 text-sm">
                                                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="hidden sm:flex w-[20%] items-center justify-center pt-6">
                                                        <span class="text-sm font-medium text-slate-700">Rp
                                                            {{ number_format($item->harga, 0, ',', '.') }}</span>
                                                    </div>

                                                    <div
                                                        class="w-full sm:w-[20%] flex items-center justify-between sm:justify-center sm:pt-6 quantity-control-mobile">
                                                        <div class="sm:hidden text-xs text-slate-400">Jumlah:</div>

                                                        @if(($item->stok ?? 0) > 0)
                                                            <div class="flex items-center border border-slate-300 rounded-sm">
                                                                <button type="button"
                                                                    class="btn-qty decrease w-6 h-6 sm:w-7 sm:h-7 flex items-center justify-center text-slate-600 hover:bg-slate-100 border-r border-slate-300 transition-colors"
                                                                    data-id="{{ $item->id }}">−</button>

                                                                <input type="number" name="quantities[{{ $item->id }}]"
                                                                    id="qty-{{ $item->id }}"
                                                                    value="{{ min($item->jumlah, ($item->stok ?? 0)) }}"
                                                                    data-max="{{ $item->stok ?? 0 }}"
                                                                    data-name="{{ $item->nama_produk }}"
                                                                    class="qty-input w-8 h-6 sm:w-10 sm:h-7 text-center text-xs sm:text-sm font-medium text-slate-700 border-none focus:ring-0 p-0">

                                                                <button type="button"
                                                                    class="btn-qty increase w-6 h-6 sm:w-7 sm:h-7 flex items-center justify-center text-slate-600 hover:bg-slate-100 border-l border-slate-300 transition-colors"
                                                                    data-id="{{ $item->id }}">+</button>
                                                            </div>
                                                        @else
                                                            <div class="text-xs text-red-500 italic font-medium">Stok Habis</div>
                                                        @endif
                                                    </div>

                                                    <div
                                                        class="hidden sm:flex w-[15%] flex-col items-end justify-center pt-6 relative">
                                                        <span class="font-bold text-green-600 text-sm item-subtotal"
                                                            id="subtotal-{{ $item->id }}">
                                                            Rp
                                                            {{ number_format($item->harga * min($item->jumlah, ($item->stok ?? 0)), 0, ',', '.') }}
                                                        </span>

                                                        <button type="button"
                                                            class="mt-2 text-slate-400 hover:text-red-500 transition-colors flex items-center gap-1 text-xs group/del"
                                                            onclick="openDeleteModal('delete-form-{{ $item->id }}')"
                                                            title="Hapus Produk">
                                                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    
                                                    <div class="sm:hidden w-full flex justify-between items-center mt-2 mobile-action-buttons">
                                                        <div class="flex flex-col">
                                                            <span class="text-[10px] text-slate-400">Subtotal</span>
                                                            <span class="font-bold text-green-600 text-sm item-subtotal" id="subtotal-mobile-{{ $item->id }}">
                                                                Rp {{ number_format($item->harga * min($item->jumlah, ($item->stok ?? 0)), 0, ',', '.') }}
                                                            </span>
                                                        </div>
                                                        
                                                        <button type="button"
                                                            class="p-1.5 rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition-colors"
                                                            onclick="openDeleteModal('delete-form-{{ $item->id }}')">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            <div class="hidden lg:block w-1/4">
                                <div class="sticky top-24 space-y-4">
                                    <div class="bg-white p-5 rounded-lg shadow-sm border border-slate-200">
                                        <h3 class="font-bold text-slate-800 mb-4">Ringkasan Belanja</h3>

                                        <div class="space-y-3 text-sm mb-5 pb-5 border-b border-dashed border-slate-200">
                                            <div id="cart-details-list"
                                                class="flex flex-col gap-2 text-xs text-slate-600 mb-3 border-b border-slate-100 pb-3"
                                                style="display: none;"></div>

                                            <div class="flex justify-between items-center">
                                                <span class="text-slate-500">Total Harga (<span
                                                        id="total-items-count">0</span> barang)</span>
                                                <span class="font-bold text-slate-700" id="summary-subtotal">Rp 0</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-slate-500">Biaya Transaksi</span>
                                                <span class="font-medium text-slate-700">Rp 0</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-slate-500">Biaya Layanan</span>
                                                <span class="font-medium text-slate-700">Rp 0</span>
                                            </div>
                                        </div>

                                        <div class="flex justify-between items-center mb-6">
                                            <div>
                                                <span class="block font-bold text-lg text-slate-800">Total Tagihan</span>
                                            </div>
                                            <span class="font-bold text-xl text-green-600" id="grand-total">Rp 0</span>
                                        </div>

                                        <button type="submit" id="checkout-btn-desktop" disabled
                                            class="w-full py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all transform active:scale-95">
                                            Beli Sekarang
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div
                            class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 z-50 lg:hidden">
                            <div class="container mx-auto px-3 py-3">
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" id="checkAllMobile"
                                            class="master-checkbox w-4 h-4 sm:w-5 sm:h-5 rounded border-slate-300 text-green-600 focus:ring-green-500">
                                        <label for="checkAllMobile"
                                            class="text-xs text-slate-500 font-medium whitespace-nowrap">
                                            Semua <span class="text-slate-400">({{ count($cart) }})</span>
                                        </label>
                                    </div>
                                    <div class="flex-1 flex justify-end items-center gap-2 sm:gap-3">
                                        <div class="text-right">
                                            <div class="text-[10px] text-slate-400">Total Tagihan</div>
                                            <div class="text-sm sm:text-base font-bold text-green-600 leading-none" id="mobile-total">
                                                Rp 0</div>
                                        </div>
                                        <button type="submit" id="checkout-btn-mobile" disabled
                                            class="px-4 py-2 sm:px-6 sm:py-2.5 bg-green-600 text-white font-bold rounded text-xs sm:text-sm disabled:opacity-50 disabled:bg-slate-300">
                                            Checkout (<span id="mobile-count">0</span>)
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                    @foreach($groupedCart as $items)
                        @foreach($items as $item)
                            <form id="delete-form-{{ $item->id }}" action="{{ route('cart.destroy', $item->id) }}" method="POST"
                                class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endforeach
                    @endforeach

                @else
                    <div class="flex flex-col items-center justify-center py-12 sm:py-16 text-center bg-white rounded-lg shadow-sm border border-slate-200"
                        data-aos="zoom-in">
                        <div class="w-24 h-24 sm:w-32 sm:h-32 bg-slate-50 rounded-full flex items-center justify-center mb-4 sm:mb-6">
                            <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" alt="Empty Cart"
                                class="w-12 h-12 sm:w-16 sm:h-16 opacity-50 grayscale">
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-800 mb-1">Keranjangmu Kosong</h3>
                        <p class="text-xs sm:text-sm text-slate-500 mb-6 sm:mb-8">Sepertinya kamu belum menambahkan apapun.</p>
                        <a href="{{ route('produk.index') }}"
                            class="px-6 py-2 sm:px-10 sm:py-2.5 bg-green-600 text-white font-bold rounded text-sm shadow hover:bg-green-700 transition-colors">
                            Belanja Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <div id="custom-alert" class="relative z-[100] hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/40 transition-opacity backdrop-blur-sm"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
                <div
                    class="relative transform overflow-hidden rounded-xl sm:rounded-2xl bg-white p-4 sm:p-6 text-left shadow-2xl transition-all w-full max-w-sm animate-[bounceIn_0.3s_ease-out]">

                    <div class="mx-auto flex h-12 w-12 sm:h-14 sm:w-14 items-center justify-center rounded-full bg-green-50 mb-4 sm:mb-5">
                        <svg class="h-6 w-6 sm:h-8 sm:w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>

                    <div class="text-center">
                        <h3 class="text-base sm:text-lg font-bold leading-6 text-slate-800" id="modal-title">
                            Stok Terbatas!
                        </h3>
                        <div class="mt-2">
                            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed" id="modal-message">
                                Jumlah yang Anda minta melebihi stok yang tersedia.
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 sm:mt-6">
                        <button type="button" onclick="closeCustomAlert()"
                            class="inline-flex w-full justify-center rounded-lg sm:rounded-xl bg-green-600 px-3 py-2.5 sm:py-3 text-xs sm:text-sm font-bold text-white hover:bg-green-700 transition-all transform active:scale-95 focus:outline-none">
                            Mengerti
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div id="delete-modal" class="relative z-[100] hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/40 transition-opacity backdrop-blur-sm"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">

                <div
                    class="relative transform overflow-hidden rounded-xl sm:rounded-2xl bg-white p-4 sm:p-6 text-left shadow-2xl transition-all w-full max-w-sm animate-[bounceIn_0.3s_ease-out]">

                    <div class="mx-auto flex h-12 w-12 sm:h-14 sm:w-14 items-center justify-center rounded-full bg-green-50 mb-4 sm:mb-5">
                        <svg class="h-6 w-6 sm:h-8 sm:h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </div>

                    <div class="text-center">
                        <h3 class="text-base sm:text-lg font-bold leading-6 text-slate-800">
                            Hapus Produk?
                        </h3>
                        <div class="mt-2">
                            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                                Apakah Anda yakin ingin menghapus produk ini dari keranjang belanja Anda?
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 sm:mt-6 flex gap-2 sm:gap-3">
                        <button type="button" onclick="closeDeleteModal()"
                            class="flex-1 justify-center rounded-lg sm:rounded-xl bg-slate-100 px-3 py-2.5 sm:py-3 text-xs sm:text-sm font-bold text-slate-600 hover:bg-slate-200 transition-all focus:outline-none">
                            Batal
                        </button>
                        <button type="button" onclick="confirmDeleteAction()"
                            class="flex-1 justify-center rounded-lg sm:rounded-xl bg-green-600 px-3 py-2.5 sm:py-3 text-xs sm:text-sm font-bold text-white hover:bg-green-700 transition-all transform active:scale-95 focus:outline-none">
                            Ya, Hapus
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="hidden lg:block">
        <x-footer />
    </div>

    <x-back-button />

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        if (typeof AOS !== 'undefined') {
            AOS.init({ once: true, offset: 50, duration: 800 });
        }

        function closeCustomAlert() {
            document.getElementById('custom-alert').classList.add('hidden');
        }

        function showStockAlert(productName, maxStock) {
            const modal = document.getElementById('custom-alert');
            const msg = document.getElementById('modal-message');

            msg.innerHTML = `Maaf, stok untuk <strong>"${productName}"</strong> hanya tersisa <strong>${maxStock}</strong>.`;
            modal.classList.remove('hidden');
        }

        let deleteTargetId = null;

        function openDeleteModal(formId) {
            deleteTargetId = formId;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            deleteTargetId = null;
            document.getElementById('delete-modal').classList.add('hidden');
        }

        function confirmDeleteAction() {
            if (deleteTargetId) {
                const form = document.getElementById(deleteTargetId);
                if (form) {
                    form.submit();
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const masterCheckboxes = document.querySelectorAll('.master-checkbox');
            const storeCheckboxes = document.querySelectorAll('.store-checkbox');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const checkoutBtns = [
                document.getElementById('checkout-btn-desktop'),
                document.getElementById('checkout-btn-mobile')
            ];

            const els = {
                summarySubtotal: document.getElementById('summary-subtotal'),
                grandTotal: document.getElementById('grand-total'),
                mobileTotal: document.getElementById('mobile-total'),
                totalItemsCount: document.getElementById('total-items-count'),
                mobileCount: document.getElementById('mobile-count'),
                cartDetailsList: document.getElementById('cart-details-list')
            };

            function debounce(func, timeout = 500) {
                let timer;
                return (...args) => {
                    clearTimeout(timer);
                    timer = setTimeout(() => { func.apply(this, args); }, timeout);
                };
            }

            const updateCartDatabase = debounce((id, quantity) => {
                fetch(`/cart/update-quantity/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ quantity: quantity })
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        console.log('Database updated:', data);
                    })
                    .catch(error => {
                        console.error('Error updating cart:', error);
                    });
            }, 500);

            const formatRupiah = (number) => {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(number);
            };

            function updateItemSubtotal(id, qty) {
                const checkbox = document.getElementById(`checkbox-${id}`);
                if (!checkbox) return;

                const price = parseFloat(checkbox.dataset.price);
                const subtotalEl = document.getElementById(`subtotal-${id}`);
                const subtotalMobileEl = document.getElementById(`subtotal-mobile-${id}`);
                const newSubtotal = price * qty;

                if (subtotalEl) {
                    subtotalEl.innerText = formatRupiah(newSubtotal);
                }
                if (subtotalMobileEl) {
                    subtotalMobileEl.innerText = formatRupiah(newSubtotal);
                }
            }

            function calculateTotal() {
                let total = 0;
                let count = 0;
                let detailsHTML = '';

                itemCheckboxes.forEach(cb => {
                    if (cb.checked) {
                        const id = cb.getAttribute('data-product-id');
                        const price = parseFloat(cb.dataset.price);
                        const name = cb.dataset.name;

                        const qtyInput = document.getElementById(`qty-${id}`);
                        const qty = qtyInput ? (parseInt(qtyInput.value) || 0) : 0;

                        const itemTotal = price * qty;
                        total += itemTotal;
                        count++;

                        detailsHTML += `
                        <div class="flex justify-between items-start">
                            <span class="w-[65%] line-clamp-1" title="${name}">
                                ${name} 
                                <span class="text-slate-400 text-[10px] block">(${qty} x ${formatRupiah(price)})</span>
                            </span>
                            <span class="font-medium text-slate-700">${formatRupiah(itemTotal)}</span>
                        </div>
                    `;
                    }
                });

                const formattedTotal = formatRupiah(total);

                if (els.summarySubtotal) els.summarySubtotal.innerText = formattedTotal;
                if (els.grandTotal) els.grandTotal.innerText = formattedTotal;
                if (els.mobileTotal) els.mobileTotal.innerText = formattedTotal;

                if (els.totalItemsCount) els.totalItemsCount.innerText = count;
                if (els.mobileCount) els.mobileCount.innerText = count;

                if (els.cartDetailsList) {
                    els.cartDetailsList.innerHTML = detailsHTML;
                    els.cartDetailsList.style.display = count > 0 ? 'flex' : 'none';
                }

                checkoutBtns.forEach(btn => {
                    if (btn) {
                        btn.disabled = count === 0;
                        if (count === 0) {
                            btn.classList.add('opacity-50', 'cursor-not-allowed');
                        } else {
                            btn.classList.remove('opacity-50', 'cursor-not-allowed');
                        }
                    }
                });
            }

            function checkMasterState() {
                const allItems = Array.from(itemCheckboxes);
                const allChecked = allItems.length > 0 && allItems.every(c => c.checked);
                masterCheckboxes.forEach(m => m.checked = allChecked);
            }

            masterCheckboxes.forEach(master => {
                master.addEventListener('change', function () {
                    const isChecked = this.checked;
                    masterCheckboxes.forEach(m => m.checked = isChecked);
                    storeCheckboxes.forEach(store => store.checked = isChecked);
                    itemCheckboxes.forEach(item => item.checked = isChecked);
                    calculateTotal();
                });
            });

            storeCheckboxes.forEach(storeCb => {
                storeCb.addEventListener('change', function () {
                    const storeGroup = this.closest('.store-group');
                    const childItems = storeGroup.querySelectorAll('.item-checkbox');
                    childItems.forEach(item => item.checked = this.checked);
                    checkMasterState();
                    calculateTotal();
                });
            });

            itemCheckboxes.forEach(itemCb => {
                itemCb.addEventListener('change', function () {
                    const storeGroup = this.closest('.store-group');
                    const storeCb = storeGroup.querySelector('.store-checkbox');
                    const allItemsInStore = storeGroup.querySelectorAll('.item-checkbox');
                    const allCheckedInStore = Array.from(allItemsInStore).every(c => c.checked);

                    storeCb.checked = allCheckedInStore;
                    checkMasterState();
                    calculateTotal();
                });
            });

            document.querySelectorAll('.btn-qty').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.dataset.id;
                    const input = document.getElementById(`qty-${id}`);
                    if (!input) return;

                    let val = parseInt(input.value) || 1;

                    const maxStock = parseInt(input.dataset.max);
                    const productName = input.dataset.name;

                    const isIncrease = this.classList.contains('increase');

                    if (isIncrease) {
                        if (val >= maxStock) {
                            showStockAlert(productName, maxStock);
                            return;
                        }
                        val++;
                    } else {
                        if (val > 1) val--;
                    }

                    input.value = val;
                    updateItemSubtotal(id, val);
                    calculateTotal();
                    updateCartDatabase(id, val);
                });
            });

            document.querySelectorAll('.qty-input').forEach(input => {
                input.addEventListener('change', function () {
                    let val = parseInt(this.value);
                    const id = this.id.replace('qty-', '');

                    const maxStock = parseInt(this.dataset.max);
                    const productName = this.dataset.name;

                    if (isNaN(val) || val < 1) {
                        val = 1;
                    }

                    if (val > maxStock) {
                        showStockAlert(productName, maxStock);
                        val = maxStock;
                    }

                    this.value = val;
                    updateItemSubtotal(id, val);
                    calculateTotal();
                    updateCartDatabase(id, val);
                });
            });

            calculateTotal();
        });
    </script>
</body>

</html>