<x-petani-layout>
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
                    <input type="number" name="jumlah" class="w-full border-gray-300 rounded-lg" placeholder="Min. Rp 10.000">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Bank</label>
                        <input type="text" name="bank" class="w-full border-gray-300 rounded-lg" placeholder="BCA / BRI">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. Rekening</label>
                        <input type="text" name="rekening" class="w-full border-gray-300 rounded-lg" placeholder="1234xxxx">
                    </div>
                </div>
                <button type="submit" class="w-full py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700">
                    Ajukan Penarikan
                </button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Penarikan</h3>
            <div class="space-y-4">
                @foreach($riwayat as $wd)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-bold text-gray-800">Rp {{ number_format($wd->jumlah) }}</p>
                        <p class="text-xs text-gray-500">{{ $wd->created_at->format('d M Y') }} • {{ $wd->nama_bank }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-bold rounded 
                        {{ $wd->status == 'approved' ? 'bg-green-100 text-green-700' : ($wd->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                        {{ ucfirst($wd->status) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-petani-layout>