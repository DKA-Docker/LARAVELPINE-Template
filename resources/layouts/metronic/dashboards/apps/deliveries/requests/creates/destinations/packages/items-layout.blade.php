<div class="kt-card border-none bg-blue-50/30 rounded-2xl ring-1 ring-blue-100">
    <div class="p-5 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></div>
            <h3 class="font-bold text-blue-900">Daftar Barang (Item)</h3>
        </div>
        <button class="text-xs font-bold text-blue-700 hover:text-blue-900 underline decoration-2 underline-offset-4 transition-all" type="button" wire:click="add">
            + Tambah Item Barang
        </button>
    </div>

    <div class="px-4 pb-4 space-y-3">
        @if(count($packages) == 0)
            <div class="bg-white rounded-xl p-6 text-center border border-blue-100">
                <p class="text-sm text-gray-500 italic">Klik tombol di atas untuk memasukkan detail barang.</p>
            </div>
        @endif

        @foreach ($packages as $index => $package)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" wire:key="packages-{{ $index }}">
                {{-- HEADER ITEM --}}
                <div class="px-4 py-3 flex items-center justify-between cursor-pointer bg-gradient-to-r from-blue-50 to-transparent" wire:click="toggle({{ $index }})">
                    <span class="text-sm font-semibold text-gray-700">
                         #{{ $index + 1 }} - <span class="text-blue-600">{{ $package['name'] ?: 'Item Baru' }}</span>
                         @if($package['qty']) <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-700 text-[10px] rounded-full">{{ $package['qty'] }} Qty</span> @endif
                    </span>
                    <button class="text-gray-400 hover:text-red-500" type="button" wire:click.stop="delete({{ $index }})">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>

                {{-- FORM ITEM --}}
                <div class="{{ ($open[$index] ?? false) ? 'block' : 'hidden' }} p-5 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-3 space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Nama Barang</label>
                            <input class="kt-input text-sm border-gray-100 focus:ring-blue-50 rounded-lg" type="text" placeholder="Contoh: Monitor LCD 24 Inch" wire:model.defer="packages.{{ $index }}.name" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Jumlah (Qty)</label>
                            <input class="kt-input text-sm border-gray-100 focus:ring-blue-50 rounded-lg" type="number" wire:model.defer="packages.{{ $index }}.qty" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <div class="space-y-1">
                            <label class="text-[10px] font-medium text-gray-500">Lebar (W)</label>
                            <input class="kt-input bg-white text-xs border-gray-100 rounded-md" type="text" wire:model.defer="packages.{{ $index }}.dimension_width" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-medium text-gray-500">Panjang (L)</label>
                            <input class="kt-input bg-white text-xs border-gray-100 rounded-md" type="number" wire:model.defer="packages.{{ $index }}.dimension_weight" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-medium text-gray-500">Tinggi (H)</label>
                            <input class="kt-input bg-white text-xs border-gray-100 rounded-md" type="number" wire:model.defer="packages.{{ $index }}.dimension_height" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-medium text-gray-500">Berat (Kg)</label>
                            <input class="kt-input bg-white text-xs border-gray-100 rounded-md" type="number" wire:model.defer="packages.{{ $index }}.heavy" />
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
