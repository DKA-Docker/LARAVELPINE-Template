<div x-init="$dispatch('init-map')">
    <div class="space-y-8 animate-fade-in">

        {{-- SECTION 1: INFORMASI TUGAS & MAPBOX --}}
        <div class="kt-card border-none shadow-2xl shadow-gray-200/50 rounded-3xl overflow-hidden ring-1 ring-gray-100">
            <div class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 p-6 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center backdrop-blur-md">
                        <i class="ki-filled ki-map text-xl text-emerald-400"></i>
                    </div>
                    <div>
                        <h3 class="text-white font-black text-lg tracking-tight">Informasi Utama & Geofencing</h3>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Tentukan titik koordinat pengiriman</p>
                    </div>
                </div>
            </div>

            <div class="kt-card-content p-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <div class="space-y-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] ml-1">Nama Task / Pekerjaan</label>
                            <input wire:model="formData.name" class="kt-input focus:ring-4 focus:ring-emerald-50 border-gray-100 rounded-2xl h-14 font-bold text-gray-700 shadow-sm" type="text" placeholder="Contoh: Pengiriman Elektronik Batch A"/>
                            @error('formData.name') <span class="text-red-500 text-[10px] font-bold ml-1 italic">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-2 relative" id="map-search-container">
                            <label class="text-[10px] font-black text-blue-600 uppercase tracking-[0.15em] ml-1 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-ping"></span>
                                Search Location
                            </label>
                            <div class="relative group">
                                <input type="text" id="map-search-input" class="kt-input focus:ring-4 focus:ring-blue-50 border-gray-100 rounded-2xl h-14 pl-12 font-medium shadow-sm transition-all" placeholder="Cari nama gedung atau alamat..." autocomplete="off">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="ki-outline ki-magnifier text-xl text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                </div>
                                <div id="autocomplete-results" class="hidden absolute z-[110] w-full mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 max-h-60 overflow-y-auto"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-2xl border border-dashed border-gray-200">
                            <div class="flex flex-col gap-1">
                                <label class="text-[9px] font-black text-gray-400 uppercase">Latitude</label>
                                <input type="text" id="lat-display" wire:model="formData.geos.latitude" class="bg-transparent border-none p-0 font-mono text-xs text-blue-700 font-bold focus:ring-0" readonly>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-[9px] font-black text-gray-400 uppercase">Longitude</label>
                                <input type="text" id="lng-display" wire:model="formData.geos.longitude" class="bg-transparent border-none p-0 font-mono text-xs text-blue-700 font-bold focus:ring-0" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 relative group">
                        <div wire:ignore id="map" class="w-full h-[480px] shadow-2xl rounded-3xl overflow-hidden ring-4 ring-gray-50 transition-all group-hover:ring-emerald-50"
                             data-lng="{{ $formData['geos']['longitude'] }}" data-lat="{{ $formData['geos']['latitude'] }}"></div>
                        <div class="absolute bottom-4 right-4 bg-white/80 backdrop-blur-md px-4 py-2 rounded-xl border border-white shadow-lg pointer-events-none">
                            <span class="text-[10px] font-black text-gray-800 uppercase italic">Live Map Interface</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex md:flex-row flex-col gap-8">

            {{-- SECTION 2: DESTINASI & WILAYAH --}}
            <div class="kt-card md:w-1/2 border-none shadow-xl shadow-gray-100 rounded-3xl overflow-hidden ring-1 ring-gray-100">
                <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                    <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest flex items-center gap-2">
                        <i class="ki-filled ki-geolocation text-red-500"></i> Region Profiling
                    </h3>
                </div>
                <div class="kt-card-content p-8">
                    <div class="flex flex-col gap-2 mb-8">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-wider ml-1">Destinasi Penerima</label>
                        <select wire:model.live="formData.destination" class="form-select kt-input h-14 rounded-2xl border-gray-100 focus:ring-4 focus:ring-red-50 font-bold text-gray-700 shadow-sm transition-all">
                            <option value="">-- Pilih Alamat Tujuan --</option>
                            @foreach($destinations as $dest)
                                <option value="{{ $dest['id'] }}">{{ $dest['receipt_name'] }} ({{ $dest['receipt_address'] }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-6 p-6 bg-gray-50/50 rounded-3xl border border-gray-100">
                        {{-- PROVINSI --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-[9px] font-black text-gray-400 uppercase ml-1">Provinsi</label>
                            <select wire:model.live="formData.geos.province" class="form-select kt-input h-11 text-xs rounded-xl border-gray-200 focus:ring-blue-50 font-semibold">
                                <option value="">-- Pilih Provinsi --</option>
                                @foreach($provinces ?? [] as $prov)
                                    <option value="{{ $prov['id'] }}">{{ $prov['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- KOTA / KABUPATEN --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-[9px] font-black text-gray-400 uppercase ml-1">Kota/Kab</label>
                            <select wire:model.live="formData.geos.regency" class="form-select kt-input h-11 text-xs rounded-xl border-gray-200 focus:ring-blue-50 font-semibold"
                                    wire:loading.attr="disabled" wire:target="formData.geos.province"
                                    @if(empty($regencies)) disabled @endif>
                                <option value="">-- Pilih Kota --</option>
                                @foreach($regencies ?? [] as $reg)
                                    <option value="{{ $reg['id'] }}">{{ $reg['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- KECAMATAN --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-[9px] font-black text-gray-400 uppercase ml-1">Kecamatan</label>
                            <select wire:model.live="formData.geos.district" class="form-select kt-input h-11 text-xs rounded-xl border-gray-200 focus:ring-blue-50 font-semibold"
                                    wire:loading.attr="disabled" wire:target="formData.geos.regency"
                                    @if(empty($districts)) disabled @endif>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach($districts ?? [] as $dist)
                                    <option value="{{ $dist['id'] }}">{{ $dist['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- DESA / KELURAHAN --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-[9px] font-black text-gray-400 uppercase ml-1">Desa/Kelurahan</label>
                            <select wire:model.live="formData.geos.village" class="form-select kt-input h-11 text-xs rounded-xl border-gray-200 focus:ring-blue-50 font-semibold"
                                    wire:loading.attr="disabled" wire:target="formData.geos.district"
                                    @if(empty($villages)) disabled @endif>
                                <option value="">-- Pilih Desa --</option>
                                @foreach($villages ?? [] as $vil)
                                    <option value="{{ $vil['id'] }}">{{ $vil['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 mt-6">
                        <label class="text-[9px] font-black text-gray-400 uppercase ml-1">Postal Code</label>
                        <input type="text" wire:model="formData.geos.postal_code" class="kt-input h-12 rounded-xl border-gray-100 focus:ring-4 focus:ring-gray-50 font-mono text-center text-sm shadow-sm" placeholder="Ex: 17211">
                    </div>
                </div>
            </div>

            {{-- SECTION 3: DRIVER ASSIGNMENT --}}
            <div class="kt-card md:w-1/2 border-none shadow-xl shadow-gray-100 rounded-3xl overflow-hidden ring-1 ring-gray-100">
                <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                    <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest flex items-center gap-2">
                        <i class="ki-filled ki-delivery-3 text-blue-600"></i> Crew Assignment
                    </h3>
                </div>
                <div class="kt-card-content p-8">
                    <div class="flex flex-col gap-4 relative">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-wider ml-1">Daftar Personel</label>

                        <div class="flex flex-wrap gap-2 min-h-[40px] items-center">
                            @forelse($formData['assigned'] as $id => $name)
                                <span class="inline-flex items-center gap-3 px-4 py-2 bg-gray-900 text-white text-[10px] font-black rounded-xl shadow-lg shadow-gray-200 animate-scale-in">
                                {{ strtoupper($name) }}
                                <button type="button" wire:click.prevent="removeDriver('{{ $id }}')" class="hover:text-red-400 transition-colors">
                                    <i class="ki-filled ki-cross text-xs"></i>
                                </button>
                            </span>
                            @empty
                                <span class="text-[10px] text-gray-400 font-bold italic">Belum ada driver dipilih...</span>
                            @endforelse
                        </div>

                        <div class="relative mt-2">
                            <input wire:model.live.debounce.300ms="driverSearch" type="text" class="kt-input h-14 rounded-2xl border-gray-100 focus:ring-4 focus:ring-blue-50 font-bold pl-12" placeholder="Ketik nama driver...">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center">
                                <i class="ki-filled ki-user text-xl text-gray-300"></i>
                            </div>
                        </div>

                        @if(strlen($driverSearch) >= 1)
                            <div class="absolute z-[100] mt-[105px] w-full bg-white border border-gray-100 rounded-2xl shadow-2xl max-h-56 overflow-y-auto p-2 animate-fade-in">
                                @forelse($suggestions as $driver)
                                    <div wire:click="addDriver('{{ $driver['id'] }}', '{{ trim(($driver['information']['first_name'] ?? '') . ' ' . ($driver['information']['last_name'] ?? '')) ?: $driver['credential']['username'] }}')"
                                         class="px-4 py-3 hover:bg-blue-50 cursor-pointer rounded-xl mb-1 transition-all group">
                                        <div class="text-[11px] font-black text-gray-800 group-hover:text-blue-700 uppercase transition-colors">
                                            {{ $driver['information']['first_name'] ?? '' }} {{ $driver['information']['last_name'] ?? '' }}
                                        </div>
                                        <div class="text-[9px] text-gray-400 font-bold uppercase">{{ $driver['contact']['email'] ?? 'no-email@driver.com' }}</div>
                                    </div>
                                @empty
                                    <div class="px-4 py-10 text-center">
                                        <i class="ki-outline ki-search-list text-3xl text-gray-200 mb-2"></i>
                                        <p class="text-[10px] text-gray-400 font-black uppercase">Tidak Ditemukan</p>
                                    </div>
                                @endforelse
                            </div>
                        @endif
                    </div>

                    <div class="mt-10 p-5 bg-blue-50 rounded-2xl border border-blue-100">
                        <div class="flex items-start gap-4">
                            <i class="ki-filled ki-information text-blue-600 text-2xl"></i>
                            <p class="text-[10px] text-blue-700 font-bold leading-relaxed uppercase tracking-tighter">
                                Driver yang ditugaskan akan menerima notifikasi otomatis pada aplikasi mereka setelah tugas ini disimpan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 4: TABEL ITEM (COMPACT) --}}
        <div class="py-4" id="order_receipt_body">
            <div class="kt-card shadow-2xl shadow-gray-100 rounded-3xl overflow-hidden border border-gray-100">
                <div class="h-2 bg-gradient-to-r from-blue-600 via-indigo-500 to-emerald-400"></div>

                <div class="p-8">
                    @if($currentDest)
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                            <div>
                                <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tighter leading-none mb-2">Inventory Manifest</h3>
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em]">
                                        Destination: <span class="text-blue-600">{{ $currentDest['receipt_name'] }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="bg-gray-900 rounded-2xl p-4 flex items-center gap-4 shadow-xl shadow-gray-200">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                                        <i class="ki-filled ki-box text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <span class="text-[8px] font-black text-gray-400 uppercase block mb-1">Grand Total Qty</span>
                                        <span class="text-xl font-black text-white leading-none">
                                        {{ number_format(collect($currentDest['packages'])->sum('qty'), 0, ',', '.') }}
                                    </span>
                                    </div>
                                </div>

                                <div class="bg-white border border-gray-100 rounded-2xl p-2 px-4 shadow-sm">
                                    <label class="text-[8px] font-black text-gray-400 uppercase block">Show Items</label>
                                    <select wire:model.live="perPage" class="bg-transparent text-xs font-black text-gray-900 border-none p-0 focus:ring-0 cursor-pointer">
                                        <option value="5">5 Items</option>
                                        <option value="10">10 Items</option>
                                        <option value="20">20 Items</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="overflow-hidden rounded-2xl border border-gray-50 shadow-inner bg-gray-50/30">
                            <table class="w-full text-left">
                                <thead>
                                <tr class="bg-white border-b border-gray-100">
                                    <th class="px-6 py-4 text-[9px] font-black text-gray-400 uppercase tracking-widest">Index</th>
                                    <th class="px-6 py-4 text-[9px] font-black text-gray-400 uppercase tracking-widest">Product Description</th>
                                    <th class="px-6 py-4 text-center text-[9px] font-black text-gray-400 uppercase tracking-widest">Unit Type</th>
                                    <th class="px-6 py-4 text-right text-[9px] font-black text-gray-400 uppercase tracking-widest">Quantity</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white/50">
                                @php
                                    $allPkgs = collect($currentDest['packages']);
                                    $totalItems = $allPkgs->count();
                                    $totalPages = ceil($totalItems / $perPage);
                                    $packages = $allPkgs->slice(($currentPage - 1) * $perPage, $perPage);
                                @endphp
                                @foreach($packages as $index => $pkg)
                                    <tr wire:key="row-{{ $pkg['id'] }}-{{ $currentPage }}" class="hover:bg-blue-50/50 transition-all group">
                                        <td class="px-6 py-5">
                                            <span class="text-[11px] font-black text-gray-300 group-hover:text-blue-200 transition-colors">
                                                {{ str_pad((($currentPage - 1) * $perPage) + $loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex flex-col">
                                                <span class="text-[12px] font-black text-gray-800 uppercase leading-tight tracking-tight">
                                                    {{ $pkg['name'] }}
                                                </span>
                                                <span class="text-[9px] text-gray-400 font-bold uppercase mt-1">Item Ref: {{ substr($pkg['id'], 0, 8) }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <span class="px-3 py-1 rounded-full bg-gray-100 text-[9px] font-black text-gray-500 uppercase tracking-tighter">
                                                {{ $pkg['unit']['name'] ?? 'PCS' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-right">
                                            <span class="text-sm font-black text-gray-900 bg-gray-100 px-3 py-1 rounded-lg">{{ $pkg['qty'] }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($totalPages > 1)
                            <div class="mt-8 flex items-center justify-between">
                            <span class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em]">
                                Page {{ $currentPage }} <span class="mx-2 text-gray-200">/</span> {{ $totalPages }}
                            </span>
                                <div class="flex items-center gap-2">
                                    <button type="button" wire:click.prevent="setPage({{ max(1, $currentPage - 1) }})"
                                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-gray-100 shadow-sm transition-all hover:bg-gray-900 hover:text-white disabled:opacity-20"
                                            @if($currentPage == 1) disabled @endif>
                                        <i class="ki-filled ki-arrow-left text-sm"></i>
                                    </button>

                                    <div class="flex bg-gray-100 p-1 rounded-xl">
                                        @for($i = 1; $i <= $totalPages; $i++)
                                            <button type="button" wire:click.prevent="setPage({{ $i }})"
                                                    class="w-8 h-8 text-[10px] font-black rounded-lg transition-all {{ $currentPage == $i ? 'bg-white shadow-sm text-blue-600' : 'text-gray-400 hover:text-gray-600' }}">
                                                {{ $i }}
                                            </button>
                                        @endfor
                                    </div>

                                    <button type="button" wire:click.prevent="setPage({{ min($totalPages, $currentPage + 1) }})"
                                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-gray-100 shadow-sm transition-all hover:bg-gray-900 hover:text-white disabled:opacity-20"
                                            @if($currentPage == $totalPages) disabled @endif>
                                        <i class="ki-filled ki-arrow-right text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="py-24 flex flex-col items-center justify-center bg-gray-50/50 rounded-3xl border border-dashed border-gray-200">
                            <div class="w-20 h-20 rounded-full bg-white flex items-center justify-center shadow-xl mb-6">
                                <i class="ki-outline ki-delivery-2 text-4xl text-gray-200"></i>
                            </div>
                            <h4 class="text-xs font-black text-gray-400 uppercase tracking-[0.5em]">Waiting for Destination</h4>
                            <p class="text-[10px] text-gray-300 font-bold uppercase mt-2">Silakan pilih destinasi untuk melihat manifest</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- SECTION 5: BUTTON ACTION --}}
        <div class="flex items-center justify-end gap-5">
            <a
                href="."
                wire:navigate
                class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-red-500 transition-colors"
            >
                Discard Change
            </a>
            <button wire:click="submit" wire:loading.attr="disabled" class="group relative overflow-hidden bg-gray-900 px-12 py-5 rounded-2xl shadow-2xl transition-all hover:bg-emerald-600 active:scale-95 disabled:opacity-50">
                <div class="relative z-10 flex items-center gap-3">
                    <span wire:loading.remove wire:target="submit" class="text-[11px] font-black text-white uppercase tracking-[0.2em]">Confirm & Save Task</span>
                    <span wire:loading wire:target="submit" class="text-[11px] font-black text-white uppercase tracking-[0.2em]">Synchronizing...</span>
                    <i class="ki-filled ki-check-circle text-emerald-400 group-hover:text-white transition-colors"></i>
                </div>
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-shimmer"></div>
            </button>
        </div>
    </div>

    <style>
        @keyframes fade-in { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes scale-in { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        @keyframes shimmer { 100% { transform: translateX(100%); } }
        .animate-fade-in { animation: fade-in 0.5s ease-out forwards; }
        .animate-scale-in { animation: scale-in 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
        .animate-shimmer { animation: shimmer 2s infinite; }
    </style>
</div>
