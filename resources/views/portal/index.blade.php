<x-portal-selection-layout title="Pilih Portal">

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Header --}}
    <div class="mb-10 text-center" data-aos="fade-up">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-700 rounded-full text-xs font-bold uppercase tracking-widest border border-green-200 mb-4">
            Perkebunan Durian Cerdas
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-3">
            Selamat Datang, <span class="text-green-600">{{ Auth::user()->name }}</span>
        </h1>
        <p class="text-slate-500 text-base max-w-xl mx-auto">
            Pilih portal yang ingin Anda kelola. Setiap sistem dirancang terstruktur untuk mengelola perkebunan secara profesional.
        </p>
    </div>

    {{-- Grid Portal --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach($portals as $index => $portal)
        <div data-aos="fade-up" data-aos-delay="{{ $index * 80 }}" class="group relative bg-white rounded-2xl border border-slate-200 hover:border-green-300 shadow-sm hover:shadow-md transition-all duration-300 {{ $portal['active'] ? 'hover:-translate-y-1' : 'opacity-60' }} p-6 flex flex-col">

            {{-- Status Badge --}}
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center">
                    {!! $portal['icon'] !!}
                </div>
                @if($portal['active'])
                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-full bg-green-50 text-green-700 uppercase tracking-wider">Aktif</span>
                @else
                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-full bg-slate-100 text-slate-400 uppercase tracking-wider">Segera Hadir</span>
                @endif
            </div>

            {{-- Info --}}
            <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-green-700 transition-colors">
                {{ $portal['name'] }}
            </h3>
            <p class="text-sm text-slate-500 leading-relaxed flex-1 mb-5">
                {{ $portal['description'] }}
            </p>

            {{-- Button --}}
            @if($portal['active'])
                <a href="{{ $portal['route'] }}" class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl transition-colors duration-200">
                    Masuk Portal
                </a>
            @else
                <button disabled class="w-full px-4 py-2.5 bg-slate-100 text-slate-400 text-sm font-bold rounded-xl cursor-not-allowed">
                    Tahap Pengembangan
                </button>
            @endif
        </div>
        @endforeach
    </div>
</div>

</x-portal-selection-layout>
