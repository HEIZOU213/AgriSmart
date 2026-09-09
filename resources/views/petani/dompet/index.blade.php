<x-petani-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dompet & Saldo Penjualan') }}
            </h2>
            <a href="{{ route('portal.marketplace.dashboard') }}" class="text-sm text-green-700 hover:text-green-900 font-medium">
                &larr; Kembali ke Dashboard Toko
            </a>
        </div>
    </x-slot>

    <div class="space-y-4">
        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="p-4 bg-green-100 text-green-700 rounded-xl border border-green-200">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="p-4 bg-red-100 text-red-700 rounded-xl border border-red-200">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="p-4 bg-red-100 text-red-700 rounded-xl border border-red-200">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Dompet Saya</h3>
                <div class="bg-green-50 p-4 rounded-lg border border-green-100 mb-6">
                    <p class="text-sm text-green-600">Saldo Aktif</p>
                    <h1 class="text-3xl font-black text-green-700">Rp {{ number_format($petani->saldo, 0, ',', '.') }}</h1>
                </div>

                <form action="{{ route('petani.dompet.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah Penarikan</label>
                        <input type="number" name="jumlah" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" placeholder="Min. Rp 10.000" min="10000" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Bank</label>
                            <input type="text" name="bank" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" placeholder="BCA / BRI / Mandiri" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">No. Rekening</label>
                            <input type="text" name="rekening" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" placeholder="1234xxxx" required>
                        </div>
                    </div>
                    <button type="submit" class="w-full py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition">
                        Ajukan Penarikan
                    </button>
                </form>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Penarikan</h3>
                <div class="space-y-4">
                    @forelse($riwayat as $wd)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <div>
                                <p class="font-bold text-gray-800">Rp {{ number_format($wd->jumlah, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">{{ $wd->created_at->format('d M Y') }} &bull; {{ $wd->nama_bank }} ({{ $wd->nomor_rekening }})</p>
                            </div>
                            <span class="px-2.5 py-1 text-xs font-bold rounded-lg uppercase tracking-wider
                                {{ $wd->status == 'approved' ? 'bg-green-100 text-green-700' : ($wd->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                {{ ucfirst($wd->status) }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400">
                            <p class="text-sm font-medium">Belum ada riwayat penarikan dana.</p>
                            <p class="text-xs text-gray-400 mt-1">Saldo hasil penjualan panen Anda dapat ditarik kapan saja.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-petani-layout>

