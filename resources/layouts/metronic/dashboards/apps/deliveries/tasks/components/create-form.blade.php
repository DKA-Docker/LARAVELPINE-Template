<div x-init="$dispatch('init-map')">
    <div class="space-y-8 animate-fade-in">

        @if ($errors->any())
            <div class="kt-card border-none bg-red-50 rounded-2xl p-5 flex items-center gap-4 animate-scale-in border border-red-100 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-red-500 flex items-center justify-center shadow-lg shadow-red-200">
                    <i class="ki-filled ki-cross-circle text-white text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-xs font-black text-red-900 uppercase tracking-widest leading-none mb-1">{{ __('dashboard.task.create.validation_error.title') }}</span>
                    <p class="text-[11px] text-red-600 font-bold uppercase tracking-tight">{{ __('dashboard.task.create.validation_error.message') }}</p>
                </div>
            </div>
        @endif

        <div class="flex md:flex-row flex-col gap-8">

            {{-- SECTION 1: DESTINASI & WILAYAH --}}
            <div class="kt-card md:w-1/2 border-none shadow-xl shadow-gray-100 rounded-3xl overflow-hidden ring-1 ring-gray-100">
                <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                    <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest flex items-center gap-2">
                        <i class="ki-filled ki-geolocation text-red-500"></i> {{ __('dashboard.task.create.region.title') }}
                    </h3>
                </div>
                <div class="kt-card-content p-8">
                    <div class="flex flex-col gap-2 mb-8">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-wider ml-1">{{ __('dashboard.task.create.region.destination_label') }}</label>

                        @if(!empty($formData['destination']))
                            {{-- SELECTED STATE: CARD DISPLAY --}}
                            <div class="relative bg-white border border-blue-100 rounded-2xl p-4 shadow-sm group animate-fade-in ring-4 ring-blue-50/50">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex items-start gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                                            <i class="ki-filled ki-map text-xl"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-black text-gray-800 uppercase leading-none mb-1">
                                                {{ $selectedDestinationDetail['receipt_name'] ?? 'Unknown Receiver' }}
                                            </h4>
                                            <p class="text-[10px] text-gray-500 font-bold uppercase leading-tight mb-2">
                                                {{ $selectedDestinationDetail['receipt_address'] ?? 'No Address' }}
                                            </p>
                                            <div class="inline-flex items-center gap-2 px-2 py-1 bg-gray-100 rounded-lg">
                                                <i class="ki-filled ki-briefcase text-gray-400 text-xs"></i>
                                                <span class="text-[9px] font-black text-gray-500 uppercase">
                                                     {{ $selectedDestinationDetail['request']['name'] ?? 'No Request Title' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" wire:click="unselectDestination" class="p-2 hover:bg-red-50 text-gray-300 hover:text-red-500 rounded-xl transition-all">
                                        <i class="ki-filled ki-trash text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            {{-- SEARCH STATE --}}
                            <div class="relative">
                                <input wire:model.live.debounce.300ms="destinationSearch"
                                       type="text"
                                       class="kt-input h-14 rounded-2xl border-gray-100 focus:ring-4 focus:ring-red-50 font-bold text-gray-700 shadow-sm transition-all pl-12"
                                       placeholder="{{ __('dashboard.task.create.region.select_destination') }}">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="ki-filled ki-magnifier text-xl text-gray-300"></i>
                                </div>

                                {{-- DROPDOWN --}}
                                @if(strlen($destinationSearch) >= 1)
                                    <div class="absolute z-50 mt-2 w-full bg-white border border-gray-100 rounded-2xl shadow-2xl max-h-64 overflow-y-auto p-2 animate-fade-in">
                                        @forelse($destinations as $dest)
                                            <div wire:click="$set('formData.destination', '{{ $dest['id'] }}')"
                                                 class="p-3 hover:bg-red-50/50 cursor-pointer rounded-xl mb-1 transition-all group border border-transparent hover:border-red-100">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <div class="text-[11px] font-black text-gray-800 group-hover:text-red-600 uppercase transition-colors mb-0.5">
                                                            {{ $dest['receipt_name'] }}
                                                        </div>
                                                        <div class="text-[9px] text-gray-400 font-bold uppercase truncate max-w-[200px]">
                                                            {{ $dest['receipt_address'] }}
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                         <span class="text-[8px] font-black text-gray-300 group-hover:text-red-400 uppercase bg-gray-50 group-hover:bg-red-100 px-2 py-1 rounded-lg">
                                                            {{ $dest['request']['name'] ?? 'N/A' }}
                                                         </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="px-4 py-8 text-center">
                                                <i class="ki-outline ki-search-list text-3xl text-gray-200 mb-2"></i>
                                                <p class="text-[10px] text-gray-400 font-black uppercase">{{ __('dashboard.task.create.crew.not_found') }}</p>
                                            </div>
                                        @endforelse
                                    </div>
                                @endif
                            </div>
                        @endif
                        @error('formData.destination') <span class="text-red-500 text-[10px] font-bold ml-1 italic">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-6 p-6 bg-gray-50/50 rounded-3xl border border-gray-100">
                        {{-- PROVINSI --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-[9px] font-black text-gray-400 uppercase ml-1">{{ __('dashboard.task.create.region.province') }}</label>
                            <select wire:model.live="formData.geos.province" class="form-select kt-input h-11 text-xs rounded-xl border-gray-200 focus:ring-blue-50 font-semibold">
                                <option value="">{{ __('dashboard.task.create.region.select_province') }}</option>
                                @foreach($provinces ?? [] as $prov)
                                    <option value="{{ $prov['id'] }}">{{ $prov['name'] }}</option>
                                @endforeach
                            </select>
                            @error('formData.geos.province') <span class="text-red-500 text-[9px] font-bold ml-1 italic">{{ $message }}</span> @enderror
                        </div>

                        {{-- KOTA / KABUPATEN --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-[9px] font-black text-gray-400 uppercase ml-1">{{ __('dashboard.task.create.region.city') }}</label>
                            <select wire:model.live="formData.geos.regency" class="form-select kt-input h-11 text-xs rounded-xl border-gray-200 focus:ring-blue-50 font-semibold"
                                    wire:loading.attr="disabled" wire:target="formData.geos.province"
                                    @if(empty($regencies)) disabled @endif>
                                <option value="">{{ __('dashboard.task.create.region.select_city') }}</option>
                                @foreach($regencies ?? [] as $reg)
                                    <option value="{{ $reg['id'] }}">{{ $reg['name'] }}</option>
                                @endforeach
                            </select>
                            @error('formData.geos.regency') <span class="text-red-500 text-[9px] font-bold ml-1 italic">{{ $message }}</span> @enderror
                        </div>

                        {{-- KECAMATAN --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-[9px] font-black text-gray-400 uppercase ml-1">{{ __('dashboard.task.create.region.district') }}</label>
                            <select wire:model.live="formData.geos.district" class="form-select kt-input h-11 text-xs rounded-xl border-gray-200 focus:ring-blue-50 font-semibold"
                                    wire:loading.attr="disabled" wire:target="formData.geos.regency"
                                    @if(empty($districts)) disabled @endif>
                                <option value="">{{ __('dashboard.task.create.region.select_district') }}</option>
                                @foreach($districts ?? [] as $dist)
                                    <option value="{{ $dist['id'] }}">{{ $dist['name'] }}</option>
                                @endforeach
                            </select>
                            @error('formData.geos.district') <span class="text-red-500 text-[9px] font-bold ml-1 italic">{{ $message }}</span> @enderror
                        </div>

                        {{-- DESA / KELURAHAN --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-[9px] font-black text-gray-400 uppercase ml-1">{{ __('dashboard.task.create.region.village') }}</label>
                            <select wire:model.live="formData.geos.village" class="form-select kt-input h-11 text-xs rounded-xl border-gray-200 focus:ring-blue-50 font-semibold"
                                    wire:loading.attr="disabled" wire:target="formData.geos.district"
                                    @if(empty($villages)) disabled @endif>
                                <option value="">{{ __('dashboard.task.create.region.select_village') }}</option>
                                @foreach($villages ?? [] as $vil)
                                    <option value="{{ $vil['id'] }}">{{ $vil['name'] }}</option>
                                @endforeach
                            </select>
                            @error('formData.geos.village') <span class="text-red-500 text-[9px] font-bold ml-1 italic">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 mt-6">
                        <label class="text-[9px] font-black text-gray-400 uppercase ml-1">{{ __('dashboard.task.create.region.postal_code') }}</label>
                        <input type="text" wire:model="formData.geos.postal_code" class="kt-input h-12 rounded-xl border-gray-100 focus:ring-4 focus:ring-gray-50 font-mono text-center text-sm shadow-sm" placeholder="{{ __('dashboard.task.create.region.postal_code_placeholder') }}">
                    </div>
                </div>
            </div>

            {{-- SECTION 2: DRIVER ASSIGNMENT --}}
            <div class="kt-card md:w-1/2 border-none shadow-xl shadow-gray-100 rounded-3xl overflow-hidden ring-1 ring-gray-100">
                <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                    <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest flex items-center gap-2">
                        <i class="ki-filled ki-delivery-3 text-blue-600"></i> {{ __('dashboard.task.create.crew.title') }}
                    </h3>
                </div>

                <div class="kt-card-content p-8 ">
                    <div class="flex flex-col gap-4 relative">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-wider ml-1">{{ __('dashboard.task.create.crew.list_label') }}</label>

                        <div class="flex flex-wrap gap-2 min-h-[40px] items-center">
                            @forelse($formData['assigned'] as $id => $name)
                                <span class="inline-flex items-center gap-3 px-4 py-2 bg-gray-900 text-white text-[10px] font-black rounded-xl shadow-lg shadow-gray-200 animate-scale-in">
                                {{ strtoupper($name) }}
                                <button type="button" wire:click.prevent="removeDriver('{{ $id }}')" class="hover:text-red-400 transition-colors">
                                    <i class="ki-filled ki-cross text-xs"></i>
                                </button>
                            </span>
                            @empty
                                <span class="text-[10px] text-gray-400 font-bold italic">{{ __('dashboard.task.create.crew.empty_list') }}</span>
                            @endforelse
                        </div>
                        @error('formData.assigned') <div class="mt-2"><span class="text-red-500 text-[10px] font-bold italic">{{ $message }}</span></div> @enderror

                        <div class="relative mt-2">
                            <input wire:model.live.debounce.300ms="driverSearch" type="text" class="kt-input h-14 rounded-2xl border-gray-100 focus:ring-4 focus:ring-blue-50 font-bold pl-12" placeholder="{{ __('dashboard.task.create.crew.search_placeholder') }}">
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
                                        <p class="text-[10px] text-gray-400 font-black uppercase">{{ __('dashboard.task.create.crew.not_found') }}</p>
                                    </div>
                                @endforelse
                            </div>
                        @endif
                    </div>
                </div>
                <div class="kt-card-content p-1 w-full">
                    <div class="grid gap-6 p-6 bg-gray-50/50 rounded-3xl border border-gray-100 w-full">
                        <div class="flex flex-col gap-4 relative">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-wider ml-1">{{ __('dashboard.task.create.vehicle.category_label') }}</label>
                            {{-- ubah ukuran kolom grid-cols-1--}}
                            <div class="grid grid-cols-1 gap-3 mt-2 w-full">
                                @foreach($vehicleCategories as $cat)
                                    @php
                                        $isSelected = ($formData['vehicle_category'] === $cat->name);
                                    @endphp
                                    <label wire:key="cat-{{ $cat->id }}"
                                           class="relative flex items-center p-3 rounded-xl border transition-all group cursor-pointer {{ $isSelected ? 'bg-blue-50 border-blue-200 shadow-sm' : 'bg-white border-gray-100 hover:bg-blue-50' }}">

                                        {{-- Radio Input Hidden --}}
                                        <input type="radio" wire:model.live="formData.vehicle_category" value="{{ $cat->name }}" class="absolute opacity-0 w-full h-full cursor-pointer z-10">

                                        <div class="flex grow items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                                                <i class="ki-filled {{ $cat->name == 'Mobil' ? 'ki-car' : 'ki-bus' }} text-xl {{ $isSelected ? 'text-blue-600' : 'text-gray-400' }}"></i>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-black {{ $isSelected ? 'text-blue-900' : 'text-gray-800' }} uppercase tracking-tight">{{ $cat->name }}</span>
                                                <span class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter line-clamp-1" title="{{ $cat->description }}">{{ $cat->description ?? 'No description' }}</span>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('formData.vehicle_category') <div class="mt-2"><span class="text-red-500 text-[10px] font-bold ml-1 italic">{{ $message }}</span></div> @enderror

                            @if(!empty($formData['vehicle_category']))
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-wider ml-1 mt-4 block">{{ __('dashboard.task.create.vehicle.unit_label') }}</label>
                                <select wire:model="formData.vehicle_id" class="form-select kt-input h-11 text-xs rounded-xl border-gray-200 focus:ring-blue-50 font-semibold w-full">
                                    <option value="">{{ __('dashboard.task.create.vehicle.select_unit') }}</option>
                                    @foreach($availableVehicles as $veh)
                                        <option value="{{ $veh->id }}">{{ $veh->name }} - {{ $veh->plate }}</option>
                                    @endforeach
                                </select>
                                @error('formData.vehicle_id') <span class="text-red-500 text-[10px] font-bold ml-1 italic">{{ $message }}</span> @enderror
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- SECTION 3: INFORMASI TUGAS & MAPBOX --}}
        <div class="kt-card border-none shadow-2xl shadow-gray-200/50 rounded-3xl overflow-hidden ring-1 ring-gray-100">
            <div class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 p-6 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center backdrop-blur-md">
                        <i class="ki-filled ki-map text-xl text-emerald-400"></i>
                    </div>
                    <div>
                        <h3 class="text-white font-black text-lg tracking-tight">{{ __('dashboard.task.create.info.title') }}</h3>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">{{ __('dashboard.task.create.info.subtitle') }}</p>
                    </div>
                </div>
            </div>

            <div class="kt-card-content p-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <div class="space-y-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] ml-1">{{ __('dashboard.task.create.info.task_name') }}</label>
                            <input wire:model="formData.name" class="kt-input focus:ring-4 focus:ring-emerald-50 border-gray-100 rounded-2xl h-14 font-bold text-gray-700 shadow-sm" type="text" placeholder="{{ __('dashboard.task.create.info.task_name_placeholder') }}"/>
                            @error('formData.name') <span class="text-red-500 text-[10px] font-bold ml-1 italic">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-2 relative" id="map-search-container">
                            <label class="text-[10px] font-black text-blue-600 uppercase tracking-[0.15em] ml-1 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-ping"></span>
                                {{ __('dashboard.task.create.info.search_location') }}
                            </label>
                            <div class="relative group">
                                <input type="text" id="map-search-input" class="kt-input bg-gray-100 cursor-not-allowed border-gray-100 rounded-2xl h-14 pl-12 font-medium shadow-sm transition-all" placeholder="{{ __('dashboard.task.create.info.search_location_placeholder') }}" autocomplete="off" readonly disabled>
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="ki-outline ki-magnifier text-xl text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                                </div>
                                <div id="autocomplete-results" class="hidden absolute z-[110] w-full mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 max-h-60 overflow-y-auto"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-2xl border border-dashed border-gray-200">
                            <div class="flex flex-col gap-1">
                                <label class="text-[9px] font-black text-gray-400 uppercase">{{ __('dashboard.task.create.info.latitude') }}</label>
                                <input type="text" id="lat-display" wire:model="formData.geos.latitude" class="bg-transparent border-none p-0 font-mono text-xs text-blue-700 font-bold focus:ring-0" readonly>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-[9px] font-black text-gray-400 uppercase">{{ __('dashboard.task.create.info.longitude') }}</label>
                                <input type="text" id="lng-display" wire:model="formData.geos.longitude" class="bg-transparent border-none p-0 font-mono text-xs text-blue-700 font-bold focus:ring-0" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 relative group">
                        <div wire:ignore id="map" class="w-full h-[480px] shadow-2xl rounded-3xl overflow-hidden ring-4 ring-gray-50 transition-all group-hover:ring-emerald-50"
                             data-lng="{{ $formData['geos']['longitude'] }}" data-lat="{{ $formData['geos']['latitude'] }}"></div>
                        <div class="absolute bottom-4 right-4 bg-white/80 backdrop-blur-md px-4 py-2 rounded-xl border border-white shadow-lg pointer-events-none">
                            <span class="text-[10px] font-black text-gray-800 uppercase italic">{{ __('dashboard.task.create.info.live_map') }}</span>
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
                                <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tighter leading-none mb-2">{{ __('dashboard.task.create.manifest.title') }}</h3>
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em]">
                                        {{ __('dashboard.task.create.manifest.destination') }} <span class="text-blue-600">{{ $currentDest['receipt_name'] }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="bg-gray-900 rounded-2xl p-4 flex items-center gap-4 shadow-xl shadow-gray-200">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                                        <i class="ki-filled ki-box text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <span class="text-[8px] font-black text-gray-400 uppercase block mb-1">{{ __('dashboard.task.create.manifest.total_qty') }}</span>
                                        <span class="text-xl font-black text-white leading-none">
                                        {{ number_format(collect($currentDest['packages'])->sum('qty'), 0, ',', '.') }}
                                    </span>
                                    </div>
                                </div>

                                <div class="bg-white border border-gray-100 rounded-2xl p-2 px-4 shadow-sm">
                                    <label class="text-[8px] font-black text-gray-400 uppercase block">{{ __('dashboard.task.create.manifest.show_items') }}</label>
                                    <select wire:model.live="perPage" class="bg-transparent text-xs font-black text-gray-900 border-none p-0 focus:ring-0 cursor-pointer">
                                        <option value="5">5 {{ __('dashboard.task.create.manifest.items') }}</option>
                                        <option value="10">10 {{ __('dashboard.task.create.manifest.items') }}</option>
                                        <option value="20">20 {{ __('dashboard.task.create.manifest.items') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="overflow-hidden rounded-2xl border border-gray-50 shadow-inner bg-gray-50/30">
                            <table class="w-full text-left">
                                <thead>
                                <tr class="bg-white border-b border-gray-100">
                                    <th class="px-6 py-4 text-[9px] font-black text-gray-400 uppercase tracking-widest">{{ __('dashboard.task.create.table.index') }}</th>
                                    <th class="px-6 py-4 text-[9px] font-black text-gray-400 uppercase tracking-widest">{{ __('dashboard.task.create.table.product') }}</th>
                                    <th class="px-6 py-4 text-center text-[9px] font-black text-gray-400 uppercase tracking-widest">{{ __('dashboard.task.create.table.unit') }}</th>
                                    <th class="px-6 py-4 text-right text-[9px] font-black text-gray-400 uppercase tracking-widest">{{ __('dashboard.task.create.table.qty') }}</th>
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
                                                <span class="text-[9px] text-gray-400 font-bold uppercase mt-1">{{ __('dashboard.task.create.table.item_ref') }} {{ substr($pkg['id'], 0, 8) }}</span>
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
                                {{ __('dashboard.task.create.pagination.page') }} {{ $currentPage }} <span class="mx-2 text-gray-200">/</span> {{ $totalPages }}
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
                            <h4 class="text-xs font-black text-gray-400 uppercase tracking-[0.5em]">{{ __('dashboard.task.create.waiting.title') }}</h4>
                            <p class="text-[10px] text-gray-300 font-bold uppercase mt-2">{{ __('dashboard.task.create.waiting.subtitle') }}</p>
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
                {{ __('dashboard.task.create.actions.discard') }}
            </a>
            <button wire:click="submit" wire:loading.attr="disabled" class="group relative overflow-hidden bg-gray-900 px-12 py-5 rounded-2xl shadow-2xl transition-all hover:bg-emerald-600 active:scale-95 disabled:opacity-50">
                <div class="relative z-10 flex items-center gap-3">
                    <span wire:loading.remove wire:target="submit" class="text-[11px] font-black text-white uppercase tracking-[0.2em]">{{ __('dashboard.task.create.actions.confirm') }}</span>
                    <span wire:loading wire:target="submit" class="text-[11px] font-black text-white uppercase tracking-[0.2em]">{{ __('dashboard.task.create.actions.synchronizing') }}</span>
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
