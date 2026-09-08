<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-900 leading-tight">
            {{ __('Inbox / Request Akun Pekebun') }}
        </h2>
    </x-slot>

    <div class="py-6">
        
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full min-w-[700px] divide-y divide-slate-200">
                    <thead class="bg-green-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Nama & Kontak</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Pesan / Lokasi</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($pesan as $p)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    <span class="font-medium text-slate-700">{{ $p->created_at->format('d M Y') }}</span> <br>
                                    <span class="text-xs">{{ $p->created_at->format('H:i') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-slate-900">{{ $p->nama }}</div>
                                    <div class="text-sm text-slate-500">{{ $p->email }}</div>
                                    <div class="text-sm text-green-600 font-bold">{{ $p->no_hp }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $p->pesan }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Tombol WA untuk Admin menghubungi Pekebun --}}
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $p->no_hp) }}" target="_blank" class="inline-flex items-center px-3 py-2 bg-green-50 text-green-700 hover:bg-green-600 hover:text-white rounded-lg transition-colors font-bold shadow-sm" title="Hubungi WA">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.896-1.596-5.54-4.24-7.136-7.136l1.292-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                            </svg>
                                            WA
                                        </a>
                                        <form action="{{ route('admin.kontak.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pesan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center px-3 py-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg transition-colors" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-slate-50 text-slate-400 p-4 rounded-full mb-3">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                                        </div>
                                        <p class="font-bold text-slate-900">Tidak ada pesan baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($pesan->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                {{ $pesan->links() }}
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
