<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-900 leading-tight">
            {{ __('Kelola Penarikan Dana') }}
        </h2>
    </x-slot>

    <div class="py-6">
        
        {{-- Flash Message --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm relative">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm relative">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full min-w-[700px] divide-y divide-slate-200">
                    <thead class="bg-green-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Pekebun</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Info Bank</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Jumlah</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($requests as $wd)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $wd->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-900">{{ $wd->user->name }}</div>
                                <div class="text-xs text-slate-500">{{ $wd->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-900 font-bold">{{ $wd->nama_bank }}</div>
                                <div class="text-sm text-slate-500">{{ $wd->nomor_rekening }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-slate-900">
                                Rp {{ number_format($wd->jumlah, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($wd->status == 'pending')
                                    <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-amber-50 text-amber-700">
                                        Menunggu
                                    </span>
                                @elseif($wd->status == 'approved')
                                    <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-green-50 text-green-700">
                                        Selesai
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-red-50 text-red-600">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                @if($wd->status == 'pending')
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('admin.withdraw.approve', $wd->id) }}" method="POST" onsubmit="return confirm('Pastikan Anda SUDAH MENTRANSFER uang ke rekening pekebun durian secara manual. Lanjutkan?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center text-white bg-green-600 hover:bg-green-700 px-3 py-2 rounded-xl text-xs font-bold shadow-sm transition-colors">
                                                ✅ Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.withdraw.reject', $wd->id) }}" method="POST" onsubmit="return confirm('Yakin ingin MENOLAK permintaan ini? Saldo akan otomatis dikembalikan ke pekebun.');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center bg-red-50 text-red-600 hover:bg-red-600 hover:text-white px-3 py-2 rounded-xl text-xs font-bold transition-colors">
                                                ❌ Tolak
                                            </button>
                                        </form>
                                    </div>
                                @elseif($wd->status == 'approved')
                                    <span class="text-green-600 text-xs font-bold">Telah Ditransfer</span>
                                @else
                                    <span class="text-red-500 text-xs font-bold">Ditolak & Dikembalikan</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-slate-50 text-slate-400 p-4 rounded-full mb-3">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <p class="font-bold text-slate-900">Belum ada riwayat penarikan dana</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($requests->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                {{ $requests->links() }}
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
