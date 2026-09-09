<x-petani-layout>
    
    {{-- Slot untuk Judul Halaman --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Produk Panen Durian Baru') }}
            </h2>
            <a href="{{ route('petani.produk.index') }}" 
               class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Kembali ke Daftar Produk
            </a>
        </div>
    </x-slot>

    {{-- Slot untuk Konten Utama --}}
    <div class="text-gray-900">
        
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

        <div class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-7 shadow-sm">
            <form action="{{ route('petani.produk.store') }}" method="POST" enctype="multipart/form-data"
                  x-data="{ 
                      tipe: '{{ old('tipe_produk', request('tipe', 'ready_stock')) }}',
                      estimasi: '{{ old('estimasi_panen', '') }}'
                  }">
                @csrf 
                
                <div class="space-y-6">
                    {{-- 1. Pilihan Tipe Penjualan Produk (Ready Stock vs Booking Panen) --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-800 mb-2">
                            Tipe Penjualan Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="hidden" name="tipe_produk" :value="tipe">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            {{-- Option 1: Ready Stock --}}
                            <div @click="tipe = 'ready_stock'"
                                 :class="tipe === 'ready_stock' ? 'border-emerald-500 bg-emerald-50/50 ring-2 ring-emerald-500/20' : 'border-slate-200 bg-slate-50/50 hover:border-slate-300'"
                                 class="relative cursor-pointer rounded-2xl border p-4 transition-all duration-200 flex items-start gap-3">
                                <div :class="tipe === 'ready_stock' ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500'"
                                     class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-sm text-slate-900">Ready Stock</span>
                                        <span :class="tipe === 'ready_stock' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500'"
                                              class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full">Siap Kirim</span>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1">Stok buah atau produk sudah tersedia di kebun dan siap langsung dikirim ke pembeli.</p>
                                </div>
                            </div>

                            {{-- Option 2: Booking Panen --}}
                            <div @click="tipe = 'booking_panen'"
                                 :class="tipe === 'booking_panen' ? 'border-amber-500 bg-amber-50/50 ring-2 ring-amber-500/20' : 'border-slate-200 bg-slate-50/50 hover:border-slate-300'"
                                 class="relative cursor-pointer rounded-2xl border p-4 transition-all duration-200 flex items-start gap-3">
                                <div :class="tipe === 'booking_panen' ? 'bg-amber-600 text-white' : 'bg-slate-200 text-slate-500'"
                                     class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-sm text-slate-900">Booking Panen</span>
                                        <span :class="tipe === 'booking_panen' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-500'"
                                              class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full">Pre-Order Pohon</span>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1">Pemesanan awal sebelum panen tiba dengan DP Rp 100.000 / pohon (minimal 2 kg).</p>
                                </div>
                            </div>
                        </div>
                        @error('tipe_produk')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 2. Banner Informasi & Input Jadwal Panen (Hanya tampil jika Booking Panen) --}}
                    <div x-show="tipe === 'booking_panen'" x-cloak class="p-4 bg-amber-50/80 border border-amber-200 rounded-2xl space-y-3">
                        <div class="flex items-start gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-amber-900 text-xs sm:text-sm">Mekanisme Booking Panen Kebun</h4>
                                <p class="text-xs text-amber-800 mt-0.5 leading-relaxed">
                                    Konsumen membayar Down Payment (DP) tetap <strong>Rp 100.000</strong> per pemesanan. Saat panen raya, pekebun mengukur timbangan aktual lalu konsumen melunasi via scan QR kuitansi.
                                </p>
                            </div>
                        </div>

                        <div>
                            <label for="estimasi_panen" class="block text-xs font-bold text-amber-900 mb-1">
                                Jadwal Panen Resmi Kebun (Estimasi Panen) <span class="text-red-500">*</span>
                            </label>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <div class="relative flex-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-amber-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <input type="text" id="estimasi_panen" name="estimasi_panen" x-model="estimasi"
                                           placeholder="Cth: 15 Oktober 2026 atau Akhir November 2026"
                                           class="pl-9 block w-full border-amber-300 rounded-xl shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm bg-white">
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-amber-800 whitespace-nowrap font-medium">Atau pilih tanggal:</span>
                                    <input type="date" min="{{ date('Y-m-d') }}"
                                           @change="if($event.target.value) {
                                               const d = new Date($event.target.value + 'T00:00:00');
                                               const mNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                                               estimasi = d.getDate() + ' ' + mNames[d.getMonth()] + ' ' + d.getFullYear();
                                           }"
                                           class="border-amber-300 rounded-xl shadow-sm text-xs bg-white py-2 px-3 cursor-pointer text-slate-700">
                                </div>
                            </div>
                            @error('estimasi_panen')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- 3. Nama Produk --}}
                    <div>
                        <label for="nama_produk" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Nama Produk / Varietas Panen <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_produk" name="nama_produk" 
                               value="{{ old('nama_produk', request('varietas') ? (str_starts_with(strtolower(request('varietas')), 'durian') ? request('varietas') : 'Durian ' . request('varietas')) : '') }}" 
                               placeholder="Cth: Durian Musang King Grade A Kebun Sendiri"
                               class="block w-full border-gray-300 rounded-xl shadow-sm focus:border-green-500 focus:ring-green-500 text-sm py-2.5 px-3.5">
                        @error('nama_produk')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 4. Kategori Produk --}}
                    <div>
                        <label for="kategori_produk_id" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Kategori Produk <span class="text-red-500">*</span>
                        </label>
                        <x-custom-dropdown 
                            name="kategori_produk_id" 
                            id="kategori_produk_id" 
                            placeholder="-- Pilih Kategori --" 
                            :options="$kategori" 
                            :value="old('kategori_produk_id')" 
                            searchable 
                            required 
                        />
                        @error('kategori_produk_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 5. Harga, Stok, dan Satuan --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="harga" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Harga Satuan (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="harga" name="harga" value="{{ old('harga', request('harga')) }}" 
                                   placeholder="Cth: 150000"
                                   class="block w-full border-gray-300 rounded-xl shadow-sm focus:border-green-500 focus:ring-green-500 text-sm py-2.5 px-3.5">
                            @error('harga')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="stok" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Jumlah Stok <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="stok" name="stok" value="{{ old('stok', request('stok')) }}" 
                                   placeholder="Cth: 20"
                                   class="block w-full border-gray-300 rounded-xl shadow-sm focus:border-green-500 focus:ring-green-500 text-sm py-2.5 px-3.5">
                            @error('stok')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="satuan" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Satuan Ukuran
                            </label>
                            <select id="satuan" name="satuan"
                                    class="block w-full border-gray-300 rounded-xl shadow-sm focus:border-green-500 focus:ring-green-500 text-sm py-2.5 px-3.5 bg-white">
                                <option value="kg" {{ old('satuan', 'kg') == 'kg' ? 'selected' : '' }}>Kg (Kilogram)</option>
                                <option value="buah" {{ old('satuan') == 'buah' ? 'selected' : '' }}>Buah</option>
                                <option value="pohon" {{ old('satuan') == 'pohon' ? 'selected' : '' }}>Pohon</option>
                                <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>Pcs / Pack</option>
                                <option value="bibit" {{ old('satuan') == 'bibit' ? 'selected' : '' }}>Bibit</option>
                            </select>
                            @error('satuan')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- 6. Deskripsi Produk --}}
                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi Produk</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" 
                                  placeholder="Jelaskan kualitas durian, ciri khas rasa, keunggulan kebun Anda, atau catatan pemesanan..." 
                                  class="block w-full border-gray-300 rounded-xl shadow-sm focus:border-green-500 focus:ring-green-500 text-sm p-3.5">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 7. Upload Foto Produk --}}
                    <div>
                        <label for="foto_produk" class="block text-sm font-semibold text-slate-700 mb-1.5">Foto Produk (Maks. 3 MB)</label>
                        <input type="file" id="foto_produk" name="foto_produk" 
                               class="block w-full text-xs text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-slate-50 focus:outline-none file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-green-100 file:text-green-700 hover:file:bg-green-200">
                        @error('foto_produk')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <a href="{{ route('petani.produk.index') }}" 
                           class="px-5 py-2.5 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-xl text-xs font-bold transition">
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-bold shadow-sm transition">
                            Simpan & Publikasikan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-petani-layout>


