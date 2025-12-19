<div class="space-y-6">
    {{-- CARD 1: INFORMASI TUGAS & MAPBOX --}}
    <div class="kt-card">
        <div class="kt-card-header">
            <h3 class="kt-card-title">Informasi Utama & Lokasi Koordinat</h3>
        </div>
        <div class="kt-card-content p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="space-y-5">
                    <div class="flex flex-col gap-2">
                        <label class="kt-form-label text-[11px] font-bold text-gray-500 uppercase tracking-wider">Nama Task</label>
                        <input wire:model="formData.name" class="kt-input kt-input-lg" type="text" placeholder="Contoh: Pengiriman Elektronik Batch A"/>
                        @error('formData.name') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-2 relative" id="map-search-container">
                        <label class="kt-form-label text-[11px] font-bold text-blue-600 uppercase tracking-wider flex items-center gap-2">
                            <i class="ki-filled ki-geolocation text-blue-600"></i> Cari Alamat / Lokasi
                        </label>
                        <div class="relative">
                            <input type="text" id="map-search-input" class="kt-input kt-input-lg pl-10" placeholder="Ketik nama jalan, gedung, atau tempat..." autocomplete="off">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="ki-outline ki-magnifier text-lg"></i>
                            </div>

                            <div id="autocomplete-results" class="hidden absolute z-[110] w-full mt-1 bg-white dark:bg-neutral-900 border border-gray-200 dark:border-neutral-800 rounded-xl shadow-2xl max-h-60 overflow-y-auto">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <label class="text-[11px] font-bold text-gray-500 uppercase">Latitude</label>
                            <input type="text" id="lat-display" wire:model="formData.geos.latitude" class="kt-input font-mono text-xs" readonly>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-[11px] font-bold text-gray-500 uppercase">Longitude</label>
                            <input type="text" id="lng-display" wire:model="formData.geos.longitude" class="kt-input font-mono text-xs" readonly>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 relative">
                    <div wire:ignore id="map" class="w-full h-[450px] shadow-inner overflow-hidden rounded-xl"
                         data-lng="{{ $formData['geos']['longitude'] }}" data-lat="{{ $formData['geos']['latitude'] }}"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex md:flex-row flex-col gap-5">
        {{-- CARD 2: DESTINASI & WILAYAH --}}
        <div class="kt-card md:w-1/2">
            <div class="kt-card-header">
                <h3 class="kt-card-title">Lokasi Tujuan & Wilayah</h3>
            </div>
            <div class="kt-card-content p-6">
                <div class="flex flex-col gap-4 mb-6">
                    <label class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Pilih Destinasi Utama</label>
                    <select wire:model.live="formData.destination" class="form-select kt-input kt-input-lg">
                        <option value="">-- Pilih Alamat Tujuan --</option>
                        @foreach($destinations as $dest)
                            <option value="{{ $dest['id'] }}">{{ $dest['receipt_name'] }} | {{ $dest['receipt_address'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 border-t border-gray-100 pt-5">
                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase">Provinsi</label>
                        <select wire:model.live="formData.geos.province" class="form-select kt-input text-xs">
                            <option value="">-- Pilih Provinsi --</option>
                            @foreach($provinces as $prov)
                                <option value="{{ $prov['id'] }}">{{ $prov['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase">Kota/Kab</label>
                        <select wire:model.live="formData.geos.regency" class="form-select kt-input text-xs"
                                wire:loading.attr="disabled" wire:target="formData.geos.province"
                                @if(empty($regencies)) disabled @endif>
                            <option value="">-- Pilih Kota --</option>
                            @foreach($regencies as $reg)
                                <option value="{{ $reg['id'] }}">{{ $reg['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase">Kecamatan</label>
                        <select wire:model.live="formData.geos.district" class="form-select kt-input text-xs"
                                wire:loading.attr="disabled" wire:target="formData.geos.regency"
                                @if(empty($districts)) disabled @endif>
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach($districts as $dist)
                                <option value="{{ $dist['id'] }}">{{ $dist['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase">Desa/Kelurahan</label>
                        <select wire:model.live="formData.geos.village" class="form-select kt-input text-xs"
                                wire:loading.attr="disabled" wire:target="formData.geos.district"
                                @if(empty($villages)) disabled @endif>
                            <option value="">-- Pilih Desa --</option>
                            @foreach($villages as $vil)
                                <option value="{{ $vil['id'] }}">{{ $vil['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-2 mt-4">
                    <label class="text-[10px] font-bold text-gray-400 uppercase">Kode Pos</label>
                    <input type="text" wire:model="formData.geos.postal_code" class="kt-input text-xs" placeholder="Ketik kode pos...">
                </div>
            </div>
        </div>

        {{-- CARD 3: DRIVER (ASSIGNED) --}}
        <div class="kt-card md:w-1/2">
            <div class="kt-card-header">
                <h3 class="kt-card-title">Personel Driver</h3>
            </div>
            <div class="kt-card-content p-6">
                <div class="flex flex-col gap-3 relative">
                    <label class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Cari Driver</label>
                    <div class="flex flex-wrap gap-2 mb-1">
                        @foreach($formData['assigned'] as $id => $name)
                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-blue-600 text-white text-[10px] font-bold rounded-lg shadow-sm">
                                {{ $name }}
                                <button type="button" wire:click.prevent="removeDriver('{{ $id }}')">
                                    <i class="ki-filled ki-cross-circle text-xs"></i>
                                </button>
                            </span>
                        @endforeach
                    </div>
                    <input wire:model.live.debounce.300ms="driverSearch" type="text" class="kt-input kt-input-lg" placeholder="Ketik nama driver...">

                    @if(strlen($driverSearch) >= 1)
                        <div class="absolute z-[100] mt-[75px] w-full bg-white border border-gray-200 rounded-xl shadow-2xl max-h-48 overflow-y-auto">
                            @forelse($suggestions as $driver)
                                <div wire:click="addDriver('{{ $driver['id'] }}', '{{ trim(($driver['information']['first_name'] ?? '') . ' ' . ($driver['information']['last_name'] ?? '')) ?: $driver['credential']['username'] }}')"
                                     class="px-4 py-3 hover:bg-blue-50 cursor-pointer border-b border-gray-50 last:border-0">
                                    <div class="text-xs font-bold text-gray-800">{{ $driver['information']['first_name'] ?? '' }} {{ $driver['information']['last_name'] ?? '' }}</div>
                                    <div class="text-[9px] text-gray-400 uppercase">{{ $driver['contact']['email'] ?? '' }}</div>
                                </div>
                            @empty
                                <div class="px-4 py-3 text-gray-400 text-xs italic">Tidak ada driver ditemukan...</div>
                            @endforelse
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION 4: TABEL ITEM (COMPACT) --}}
    <div class="py-2" id="order_receipt_body">
        <div class="kt-card shadow-sm border border-gray-100 overflow-hidden rounded-2xl">
            <div class="h-[6px] bg-gradient-to-r from-blue-600 to-emerald-400"></div>

            <div class="p-6">
                @if($currentDest)
                    <div class="flex items-center gap-4 mb-5">
                        <div class="flex-1">
                            <h3 class="text-lg font-black text-gray-900 uppercase tracking-tight">Rincian Barang Elektronik</h3>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                Tujuan: <span class="text-blue-600">{{ $currentDest['receipt_name'] }}</span>
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="relative flex items-center bg-white dark:bg-neutral-900 border border-gray-200 dark:border-neutral-800 rounded-2xl p-1 pr-4 shadow-sm">
                                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-lg shadow-blue-200 dark:shadow-none">
                                    <i class="ki-filled ki-vial text-white text-lg"></i>
                                </div>
                                <div class="ml-3">
                                    <span class="text-[9px] font-black text-gray-400 uppercase leading-none block">Total Quantity</span>
                                    <span class="text-lg font-black text-gray-900 dark:text-white leading-none">
                                        {{ number_format(collect($currentDest['packages'])->sum('qty'), 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col bg-gray-50 dark:bg-neutral-800/50 px-3 py-2 rounded-xl border border-gray-200 dark:border-neutral-800">
                                <span class="text-[8px] font-black text-gray-400 uppercase mb-0.5">Tampilkan</span>
                                <select wire:model.live="perPage" class="bg-transparent text-xs font-bold text-gray-700 dark:text-neutral-200 outline-none cursor-pointer">
                                    <option value="5">5 Rows</option>
                                    <option value="10">10 Rows</option>
                                    <option value="20">20 Rows</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="kt-scrollable-x-auto border border-gray-100 rounded-xl">
                        <table class="kt-table w-full">
                            <thead class="bg-gray-50/80">
                            <tr>
                                <th class="px-4 py-2 text-left w-12 text-[9px] font-black text-gray-400 uppercase">#</th>
                                <th class="px-4 py-2 text-left text-[9px] font-black text-gray-400 uppercase">Nama Produk</th>
                                <th class="px-4 py-2 text-center w-24 text-[9px] font-black text-gray-400 uppercase">Unit</th>
                                <th class="px-4 py-2 text-right w-24 text-[9px] font-black text-gray-400 uppercase">Qty</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                            @php
                                $allPkgs = collect($currentDest['packages']);
                                $totalItems = $allPkgs->count();
                                $totalPages = ceil($totalItems / $perPage);
                                $packages = $allPkgs->slice(($currentPage - 1) * $perPage, $perPage);
                            @endphp
                            @foreach($packages as $index => $pkg)
                                <tr wire:key="row-{{ $pkg['id'] }}-{{ $currentPage }}" class="hover:bg-blue-50/40 transition-colors group">
                                    <td class="px-4 py-2 text-[10px] font-bold text-gray-300">
                                        {{ (($currentPage - 1) * $perPage) + $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <span class="text-[11px] font-bold text-gray-700 uppercase leading-tight break-words block max-w-md">
                                            {{ $pkg['name'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <span class="px-2 py-0.5 rounded bg-gray-100 text-[9px] font-black text-gray-400 uppercase">
                                            {{ $pkg['unit']['name'] ?? 'PCS' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        <span class="text-xs font-black text-gray-900">{{ $pkg['qty'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($totalPages > 1)
                        <div class="mt-5 flex flex-col md:flex-row justify-between items-center gap-4">
                            <span class="text-[9px] text-gray-400 font-bold uppercase tracking-[0.2em]">
                                Halaman {{ $currentPage }} / {{ $totalPages }}
                            </span>
                            <div class="flex items-center gap-1">
                                <button type="button" wire:click.prevent="setPage({{ max(1, $currentPage - 1) }})"
                                        class="w-7 h-7 flex items-center justify-center rounded-md border border-gray-200 {{ $currentPage == 1 ? 'opacity-20 cursor-not-allowed' : 'hover:bg-white text-blue-600 shadow-sm' }}"
                                        @if($currentPage == 1) disabled @endif>
                                    <i class="ki-filled ki-arrow-left text-[10px]"></i>
                                </button>

                                @for($i = 1; $i <= $totalPages; $i++)
                                    <button type="button" wire:click.prevent="setPage({{ $i }})"
                                            class="w-7 h-7 text-[10px] font-black rounded-md transition-all {{ $currentPage == $i ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-100' }}">
                                        {{ $i }}
                                    </button>
                                @endfor

                                <button type="button" wire:click.prevent="setPage({{ min($totalPages, $currentPage + 1) }})"
                                        class="w-7 h-7 flex items-center justify-center rounded-md border border-gray-200 {{ $currentPage == $totalPages ? 'opacity-20 cursor-not-allowed' : 'hover:bg-white text-blue-600 shadow-sm' }}"
                                        @if($currentPage == $totalPages) disabled @endif>
                                    <i class="ki-filled ki-arrow-right text-[10px]"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="py-16 flex flex-col items-center justify-center grayscale opacity-30">
                        <i class="ki-outline ki-delivery-2 text-6xl mb-3"></i>
                        <p class="text-[10px] font-black uppercase tracking-[0.4em]">Belum Ada Destinasi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- BUTTON ACTION --}}
    <div class="flex gap-4 justify-end pt-4">
        <button type="button" class="kt-btn kt-btn-light font-bold text-xs uppercase tracking-widest">Batalkan</button>
        <button wire:click="submit" wire:loading.attr="disabled" class="kt-btn kt-btn-secondary font-bold text-xs uppercase tracking-widest px-8 shadow-lg" type="button">
            <span wire:loading.remove wire:target="submit">Simpan Tugas</span>
            <span wire:loading wire:target="submit">Memproses...</span>
        </button>
    </div>
</div>
