<x-public-layout>
    <div class="py-12 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <article>
                <header class="mb-8">
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-2">
                        {{ $edukasi->judul }}
                    </h1>
                    <p class="text-lg text-gray-500">
                        Oleh Admin | Diterbitkan pada {{ $edukasi->created_at->format('d M Y') }}
                    </p>
                    <p class="mt-2 text-sm font-medium text-indigo-600">
                        Kategori: {{ $edukasi->kategoriEdukasi->nama_kategori }}
                    </p>
                </header>

                {{-- [KODE BARU] Tampilkan Foto Sampul Utama --}}
                @if($edukasi->foto_sampul)
                    <div class="mb-8">
                        <img src="{{ asset('storage/' . $edukasi->foto_sampul) }}" alt="{{ $edukasi->judul }}" class="w-full h-auto max-h-[500px] object-cover rounded-lg shadow-md">
                    </div>
                @endif
                
                <div class="prose prose-lg max-w-none text-gray-700">
                    {!! $edukasi->isi_konten !!}
                </div>

                @if($edukasi->tipe_konten == 'video' && !empty($edukasi->url_video))
                    <div class="mt-8 aspect-w-16 aspect-h-9">
                        <iframe src="{{ str_replace('watch?v=', 'embed/', $edukasi->url_video) }}" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen
                                class="w-full h-full rounded-lg shadow-md"></iframe>
                    </div>
                @endif
            </article>

            <div class="mt-12 pt-8 border-t border-gray-200">
                <a href="{{ route('edukasi.index') }}" class="text-green-600 hover:text-green-700">
                    &larr; Kembali ke Semua Edukasi
                </a>
            </div>

        </div>
    </div>
</x-public-layout>