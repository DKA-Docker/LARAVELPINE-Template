<div class="space-y-8 animate-fade-in text-left">

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
                        @error('province') <span class="text-red-500 text-[9px] font-bold italic">{{ $message }}</span> @enderror
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

    {{-- SECTION 4: ACTIONS --}}
    <div class="flex flex-col items-end gap-3 pt-10 border-t border-gray-100">
        <div class="flex items-center justify-end gap-5">
            <button type="button" onclick="history.back()" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-red-500 transition-colors">Discard Changes</button>
            <button wire:click="submit" wire:loading.attr="disabled" class="group relative overflow-hidden bg-gray-900 px-12 py-5 rounded-2xl shadow-2xl transition-all hover:bg-emerald-600 active:scale-95 disabled:opacity-50">
                <div class="relative z-10 flex items-center gap-3">
                    <span wire:loading.remove wire:target="submit" class="text-[11px] font-black text-white uppercase tracking-[0.2em]">Confirm & Save Task</span>
                    <span wire:loading wire:target="submit" class="text-[11px] font-black text-white uppercase tracking-[0.2em]">Synchronizing...</span>
                    <i class="ki-filled ki-check-circle text-emerald-400 group-hover:text-white transition-colors"></i>
                </div>
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-shimmer"></div>
            </button>
        </div>

        @error('submit')
        <div class="mt-2 text-red-500 text-[10px] font-bold uppercase tracking-wider italic">
            <i class="ki-filled ki-information-2 text-sm mr-1"></i> {{ $message }}
        </div>
        @enderror
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
