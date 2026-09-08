@props([
    'name',
    'id' => null,
    'value' => null,
    'options' => [],
    'placeholder' => '-- Pilih Opsi --',
    'required' => false,
    'searchable' => false,
    'onchange' => null,
    'customWrapId' => null,
    'customInputId' => null,
    'colorMap' => [
        'kritis'      => 'red',
        'bermasalah'  => 'red',
        'mati'        => 'red',
        'buruk'       => 'red',
        'batal'       => 'red',
        'cancelled'   => 'red',
        'perawatan'   => 'amber',
        'kurang_sehat'=> 'amber',
        'sedang'      => 'amber',
        'pending'     => 'amber',
        'sehat'       => 'emerald',
        'baik'        => 'emerald',
        'siap_tanam'  => 'emerald',
        'selesai'     => 'emerald',
        'aktif'       => 'emerald',
        'done'        => 'emerald',
        'paid'        => 'emerald',
        'shipping'    => 'blue',
        'vegetatif'   => 'blue',
        'generatif'   => 'purple',
        'produktif'   => 'purple',
    ]
])

@php
    $id = $id ?? $name;
    $initialValue = old($name, $value ?? '');

    $optionsArr = $options instanceof \Illuminate\Support\Collection ? $options->all() : (array)$options;
    $isList = array_is_list($optionsArr);

    // Format options uniformly into array of ['value' => ..., 'label' => ...]
    $formattedOptions = [];
    foreach ($optionsArr as $key => $opt) {
        if (is_object($opt)) {
            $optVal = $opt->id ?? $opt->value ?? $key;
            if (isset($opt->nama_lahan)) {
                $optLbl = $opt->nama_lahan . (!empty($opt->lokasi) ? " ({$opt->lokasi})" : (!empty($opt->luas_ha) ? " ({$opt->luas_ha} Ha)" : ''));
            } elseif (isset($opt->kode_pohon)) {
                $optLbl = $opt->kode_pohon . (!empty($opt->nama_varietas) ? " - {$opt->nama_varietas}" : '');
            } elseif (isset($opt->kode_bibit)) {
                $optLbl = $opt->kode_bibit . (!empty($opt->nama_varietas) ? " - {$opt->nama_varietas}" : '') . (isset($opt->jumlah) ? " (Sedia: {$opt->jumlah})" : '');
            } else {
                $optLbl = $opt->nama_kategori ?? $opt->nama ?? $opt->label ?? $opt->name ?? $opt->title ?? $optVal;
            }
            $formattedOptions[] = [
                'value' => (string)$optVal,
                'label' => (string)$optLbl,
                'varietas' => $opt->nama_varietas ?? null,
                'lahan' => $opt->lahan_id ?? null,
                'stok' => $opt->jumlah ?? null,
            ];
        } elseif (is_array($opt) && (isset($opt['value']) || isset($opt['id']))) {
            $optVal = $opt['value'] ?? $opt['id'];
            $optLbl = $opt['nama_kategori'] ?? $opt['label'] ?? $opt['name'] ?? $opt['nama'] ?? $optVal;
            $formattedOptions[] = [
                'value' => (string)$optVal,
                'label' => (string)$optLbl,
                'varietas' => $opt['nama_varietas'] ?? $opt['varietas'] ?? null,
                'lahan' => $opt['lahan_id'] ?? $opt['lahan'] ?? null,
                'stok' => $opt['jumlah'] ?? $opt['stok'] ?? null,
            ];
        } elseif ($isList) {
            $formattedOptions[] = ['value' => (string)$opt, 'label' => (string)$opt];
        } else {
            $formattedOptions[] = ['value' => (string)$key, 'label' => (string)$opt];
        }
    }

    // Find initial label
    $initialLabel = '';
    foreach ($formattedOptions as $opt) {
        if ((string)$opt['value'] === (string)$initialValue) {
            $initialLabel = $opt['label'];
            break;
        }
    }
@endphp

<div x-data="{
        open: false,
        selectedVal: @js($initialValue),
        selectedLabel: @js($initialLabel),
        search: '',
        colorMap: @js($colorMap),
        options: @js($formattedOptions),
        init() {
            if (!this.selectedLabel && this.selectedVal) {
                const found = this.options.find(o => String(o.value) === String(this.selectedVal));
                if (found) this.selectedLabel = found.label;
            }
        },
        onNativeChange(e) {
            this.selectedVal = e.target.value;
            const found = this.options.find(o => String(o.value) === String(this.selectedVal));
            this.selectedLabel = found ? found.label : '';
        },
        select(val, label) {
            this.selectedVal = val;
            this.selectedLabel = label;
            this.open = false;
            this.search = '';

            const sel = this.$refs.nativeSelect;
            if (sel) {
                sel.value = val;
                sel.dispatchEvent(new Event('change', { bubbles: true }));
            }

            @if($onchange)
                try {
                    const fn = new Function('selectEl', '{{ $onchange }}');
                    fn(sel);
                } catch(e) {
                    console.error('Custom dropdown onchange error:', e);
                }
            @endif

            @if($customWrapId && $customInputId)
                const wrap = document.getElementById('{{ $customWrapId }}');
                const inp = document.getElementById('{{ $customInputId }}');
                if (wrap && inp) {
                    if (val === '__custom__') {
                        wrap.classList.remove('hidden');
                        inp.focus();
                    } else {
                        wrap.classList.add('hidden');
                        inp.value = '';
                    }
                }
            @endif
        },
        getColor(val) {
            const v = String(val).toLowerCase();
            return this.colorMap[v] || null;
        },
        get filteredOptions() {
            if (!this.search) return this.options;
            return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
        }
    }" 
    class="relative w-full text-left"
    @keydown.escape="open = false">

    {{-- Native Hidden Select for full standard HTML form submission, JS crawling, and Laravel validation --}}
    <select name="{{ $name }}" id="{{ $id }}" x-ref="nativeSelect" class="hidden" @change="onNativeChange($event)">
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($formattedOptions as $opt)
            <option value="{{ $opt['value'] }}" 
                    @if(isset($opt['stok'])) data-stok="{{ $opt['stok'] }}" @endif
                    @if(isset($opt['varietas'])) data-varietas="{{ $opt['varietas'] }}" @endif
                    @if(isset($opt['lahan'])) data-lahan="{{ $opt['lahan'] }}" @endif
                    {{ (string)$initialValue === (string)$opt['value'] ? 'selected' : '' }}>
                {{ $opt['label'] }}
            </option>
        @endforeach
    </select>

    {{-- Custom Trigger Button --}}
    <button type="button" 
            @click="open = !open" 
            class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl border bg-white text-left transition-all duration-200 outline-none select-none shadow-sm min-h-[42px] cursor-pointer"
            :class="open ? 'border-green-500 ring-2 ring-green-500/20 shadow-md' : '{{ $errors->has($name) ? 'border-red-400 ring-2 ring-red-100' : 'border-slate-200 hover:border-slate-300' }}'">
        
        <span class="flex items-center gap-2.5 truncate">
            {{-- Status Color Dot if mapped --}}
            <template x-if="getColor(selectedVal)">
                <span class="w-2.5 h-2.5 rounded-full flex-shrink-0"
                      :class="{
                          'bg-red-500 ring-2 ring-red-100': getColor(selectedVal) === 'red',
                          'bg-amber-500 ring-2 ring-amber-100': getColor(selectedVal) === 'amber',
                          'bg-emerald-500 ring-2 ring-emerald-100': getColor(selectedVal) === 'emerald',
                          'bg-blue-500 ring-2 ring-blue-100': getColor(selectedVal) === 'blue',
                          'bg-purple-500 ring-2 ring-purple-100': getColor(selectedVal) === 'purple',
                      }"></span>
            </template>

            <span x-text="selectedLabel || '{{ addslashes($placeholder) }}'" 
                  class="text-sm font-semibold truncate"
                  :class="selectedVal ? 'text-slate-800' : 'text-slate-400'">
                {{ $initialLabel ?: $placeholder }}
            </span>
        </span>

        {{-- Custom Animated Chevron --}}
        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 flex-shrink-0 ml-2" 
             :class="open ? 'rotate-180 text-green-600' : ''"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    {{-- Custom Floating Dropdown Menu --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 translate-y-1 scale-98"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-1 scale-98"
         @click.outside="open = false" 
         x-cloak
         style="display: none;"
         class="absolute left-0 right-0 z-50 mt-1.5 bg-white border border-slate-200/90 rounded-2xl shadow-xl overflow-hidden py-1.5 max-h-64 flex flex-col">

        {{-- Search input if searchable or many options --}}
        @if($searchable || count($formattedOptions) > 8)
        <div class="px-3 py-1.5 border-b border-slate-100">
            <div class="relative">
                <input type="text" 
                       x-model="search" 
                       placeholder="Cari opsi..." 
                       @click.stop
                       class="w-full pl-8 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none font-medium text-slate-800 placeholder-slate-400">
                <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>
        @endif

        {{-- Scrollable List of Options --}}
        <div class="overflow-y-auto divide-y divide-slate-50 max-h-56">
            @if($placeholder)
            <button type="button" 
                    @click="select('', '')"
                    class="w-full text-left px-4 py-2 text-xs text-slate-400 hover:bg-slate-50 transition-colors flex items-center justify-between">
                <span>{{ $placeholder }}</span>
            </button>
            @endif

            <template x-for="opt in filteredOptions" :key="opt.value">
                <button type="button" 
                        @click="select(opt.value, opt.label)"
                        class="w-full text-left px-4 py-2.5 text-sm transition-colors flex items-center justify-between group cursor-pointer"
                        :class="selectedVal === opt.value ? 'bg-green-50/80 text-green-800 font-bold' : 'text-slate-700 hover:bg-green-50/50 hover:text-green-700 font-medium'">
                    
                    <span class="flex items-center gap-2.5 truncate">
                        {{-- Dot status jika ada --}}
                        <template x-if="getColor(opt.value)">
                            <span class="w-2 h-2 rounded-full flex-shrink-0"
                                  :class="{
                                      'bg-red-500': getColor(opt.value) === 'red',
                                      'bg-amber-500': getColor(opt.value) === 'amber',
                                      'bg-emerald-500': getColor(opt.value) === 'emerald',
                                      'bg-blue-500': getColor(opt.value) === 'blue',
                                      'bg-purple-500': getColor(opt.value) === 'purple',
                                  }"></span>
                        </template>

                        <span x-text="opt.label" class="truncate"></span>
                    </span>

                    {{-- Checkmark on selected --}}
                    <template x-if="selectedVal === opt.value">
                        <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </template>
                </button>
            </template>

            <div x-show="filteredOptions.length === 0" class="px-4 py-3 text-xs text-slate-400 text-center italic">
                Tidak ada opsi ditemukan
            </div>
        </div>
    </div>
</div>
