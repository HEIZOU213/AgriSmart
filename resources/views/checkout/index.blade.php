<x-konsumen-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Konfirmasi Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Pesan Error Validasi atau Transaksi --}}
                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                            <strong>Whoops!</strong> Ada masalah dengan input Anda.<br><br>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="flex flex-col md:flex-row gap-8">

                        {{-- Kolom Kiri: Form Alamat --}}
                        <div class="w-full md:w-2/3">
                            <form action="{{ route('checkout.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <h3 class="text-lg font-semibold">Alamat Pengiriman</h3>
                                
                                <div>
                                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Penerima</label>
                                    <input type="text" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                                </div>
                                
                                <div>
                                    <label for="no_telepon" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                                    <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                                </div>
                                
                                <div>
                                    <label for="alamat_kirim" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                                    <textarea name="alamat_kirim" id="alamat_kirim" rows="4" 
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('alamat_kirim', $user->alamat) }}</textarea>
                                    @error('alamat_kirim')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <small class="mt-1 text-xs text-gray-500">Edit jika alamat kirim berbeda dengan alamat profil.</small>
                                </div>

                                <button type="submit" 
                                        class="w-full px-6 py-3 mt-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Buat Pesanan Sekarang
                                </button>
                            </form>
                        </div>

                        {{-- Kolom Kanan: Ringkasan Pesanan --}}
                        <div class="w-full md:w-1/3">
                            <div class="border border-gray-200 rounded-lg p-6 bg-gray-50">
                                <h3 class="text-lg font-semibold border-b pb-2 mb-4">Ringkasan Pesanan</h3>
                                <div class="space-y-2">
                                    @foreach($cart as $id => $detail)
                                        <div class="flex justify-between text-sm">
                                            <span>{{ $detail['jumlah'] }}x {{ $detail['nama'] }}</span>
                                            <span class="font-medium">Rp {{ number_format($detail['harga'] * $detail['jumlah'], 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <hr class="my-4">
                                <div class="flex justify-between text-xl font-bold">
                                    <span>Total</span>
                                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <a href="{{ route('cart.index') }}" class="mt-4 inline-block text-sm text-gray-600 hover:text-gray-900">&larr; Kembali ke Keranjang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-konsumen-layout>