<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inbox / Request Akun Petani') }}
        </h2>
    </x-slot>

    <div class="text-gray-900">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama & Kontak</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pesan / Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pesan as $p)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $p->created_at->format('d M Y') }} <br>
                                <span class="text-xs">{{ $p->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $p->nama }}</div>
                                <div class="text-sm text-gray-500">{{ $p->email }}</div>
                                <div class="text-sm text-green-600 font-medium">{{ $p->no_hp }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $p->pesan }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                {{-- Tombol WA untuk Admin menghubungi Petani --}}
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $p->no_hp) }}" target="_blank" class="text-green-600 hover:text-green-900 mr-3">
                                    Hubungi WA
                                </a>
                                <form action="{{ route('admin.kontak.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pesan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">Tidak ada pesan baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">
                {{ $pesan->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>