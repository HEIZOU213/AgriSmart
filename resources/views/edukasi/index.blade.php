<x-public-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8 text-center">
                <h1 class="text-4xl font-extrabold text-gray-900">
                    Pusat Edukasi AgriSmart
                </h1>
                <p class="mt-2 text-lg text-gray-500">
                    Tingkatkan pengetahuan dan kemampuan Anda di bidang pertanian modern.
                </p>
            </div>

            @if(isset($daftarEdukasi) && !$daftarEdukasi->isEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($daftarEdukasi as $item)
                        <div class="bg-white overflow-hidden shadow rounded-lg flex flex-col border border-gray-200">
                            
                            {{-- [KODE BARU] Tampilkan Foto Sampul Edukasi --}}
                            <a href="{{ route('edukasi.show', $item->slug) }}">
                                @if($item->foto_sampul)
                                    <img src="{{ asset('storage/' . $item->foto_sampul) }}" alt="{{ $item->judul }}" class="h-48 w-full object-cover">
                                @else
                                    {{-- Placeholder jika tidak ada foto --}}
                                    <div class="h-48 w-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500">Gambar Edukasi</span>
                                    </div>
                                @endif
                            </a>
                            
                            <div class="p-6 flex-grow">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $item->judul }}</h3>
                                <p class="text-gray-500 text-sm mb-4">
                                    Oleh Admin | {{ $item->created_at->format('d M Y') }}
                                </p>
                                <p class="text-gray-600 line-clamp-4">
                                    {{ Str::limit(strip_tags($item->isi_konten), 200) }}
                                </p>
                            </div>
                            <div class="p-6 bg-gray-50 border-t border-gray-200">
                                <a href="{{ route('edukasi.show', $item->slug) }}" class="font-medium text-green-600 hover:text-green-700">
                                    Baca Selengkapnya &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Link Paginasi --}}
                <div class="mt-8">
                    {{ $daftarEdukasi->links() }}
                </div>
            @else
                <p class="text-center text-gray-500">Belum ada konten edukasi.</p>
            @endif
        </div>
    </div>
</x-public-layout>