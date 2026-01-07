<div class="flex flex-col gap-6 lg:gap-8">
    {{-- BASIC INFO CARD --}}
    <div class="kt-card border-none shadow-sm rounded-2xl ring-1 ring-gray-100 overflow-hidden">
        <div class="p-6 bg-white flex items-start justify-between">
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-primary/10 rounded-lg">
                        <i class="ki-filled ki-delivery-2 text-2xl text-primary"></i>
                    </div>
                    <div class="flex flex-col">
                        <h1 class="text-xl font-bold text-gray-900 leading-tight">{{ $request->name ?? 'Unnamed Request' }}</h1>
                        <span class="text-xs font-mono text-gray-500">ID: {{ $request->id }}</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-end gap-2">
                <span class="badge badge-lg {{ $request->status === 'completed' ? 'badge-success' : 'badge-warning' }} font-bold uppercase tracking-wider">
                    {{ ucfirst($request->status) }}
                </span>
                <span class="text-xs font-medium text-gray-500">
                    Created: {{ $request->created_at?->format('d M Y, H:i') }}
                </span>
            </div>
        </div>
    </div>

    {{-- DESTINATIONS SECTION --}}
    <div class="kt-card border-none shadow-xl shadow-red-100/50 rounded-2xl ring-1 ring-red-50">
        <div class="p-6 flex items-center justify-between border-b border-gray-50 bg-gradient-to-r from-red-600 to-orange-500 rounded-t-2xl">
            <div class="flex items-center gap-3">
                <i class="ki-filled ki-map text-white text-xl"></i>
                <h3 class="text-lg font-bold text-white">Destinations List</h3>
            </div>
            <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white rounded-lg text-sm font-bold">
                {{ $request->destinations->count() }} Locations
            </span>
        </div>

        <div class="p-4 space-y-4 bg-white rounded-b-2xl">
            @forelse($request->destinations as $index => $destination)
                <div class="border border-gray-100 rounded-2xl overflow-hidden transition-all hover:shadow-md" x-data="{ open: true }">
                    {{-- HEADER --}}
                    <div class="p-4 flex items-center justify-between cursor-pointer bg-gray-50/50 hover:bg-gray-50 transition-colors" @click="open = !open">
                        <div class="flex items-center gap-4">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600 text-xs font-bold">#{{ $index + 1 }}</span>
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-800">{{ $destination->receipt_name ?? 'No Recipient Name' }}</span>
                                <span class="text-xs text-gray-500 italic line-clamp-1">{{ $destination->receipt_address ?? 'No Address Provided' }}</span>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-600 text-[10px] font-bold">
                                        {{ $destination->packages->count() }} Items
                                    </span>
                                </div>
                            </div>
                        </div>
                        <i class="ki-filled ki-arrow-down text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                    </div>

                    {{-- CONTENT --}}
                    <div x-show="open" x-collapse class="p-6 bg-white border-t border-gray-100">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-6">
                            {{-- LEFT COLUMN: INFO --}}
                            <div class="space-y-5">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Recipient Name</label>
                                    <div class="kt-input-static p-3 bg-gray-50 rounded-xl text-sm font-semibold text-gray-700">
                                        {{ $destination->receipt_name ?? '-' }}
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Address</label>
                                    <div class="kt-input-static p-3 bg-gray-50 rounded-xl text-sm text-gray-600 min-h-[60px]">
                                        {{ $destination->receipt_address ?? '-' }}
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Note</label>
                                    <div class="kt-input-static p-3 bg-gray-50 rounded-xl text-sm text-gray-500 italic min-h-[80px]">
                                        {{ $destination->description ?? 'No notes' }}
                                    </div>
                                </div>
                            </div>

                            {{-- RIGHT COLUMN: COORDINATES --}}
                            <div class="bg-gray-50/50 p-2 rounded-xl border border-dashed border-gray-200 h-full flex flex-col">
                                 <div id="map-{{ $index }}"
                                     class="destination-map-verify w-full flex-grow min-h-[250px] rounded-lg shadow-inner"
                                     data-index="{{ $index }}"
                                     data-lat="{{ $destination->coordinate_latitude ?? -6.2088 }}"
                                     data-lng="{{ $destination->coordinate_longitude ?? 106.8456 }}">
                                </div>

                                <div class="flex items-center justify-between mt-3 px-1">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">LAT:</span>
                                        <span class="text-[10px] font-mono text-gray-600 bg-white px-2 py-0.5 rounded border border-gray-200">
                                            {{ $destination->coordinate_latitude ?? '-' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">LNG:</span>
                                        <span class="text-[10px] font-mono text-gray-600 bg-white px-2 py-0.5 rounded border border-gray-200">
                                            {{ $destination->coordinate_longitude ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PACKAGES SECTION --}}
                        <div class="pt-4 border-t border-gray-50">
                            <div class="kt-card border-none bg-blue-50/30 rounded-2xl ring-1 ring-blue-100">
                                <div class="p-5 flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-blue-600"></div>
                                    <h3 class="font-bold text-blue-900">Packages / Items</h3>
                                </div>

                                <div class="px-4 pb-4 space-y-3">
                                    @forelse($destination->packages as $pkgIndex => $package)
                                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ pkgOpen: false }">
                                            {{-- HEADER --}}
                                            <div class="px-4 py-3 flex items-center justify-between cursor-pointer bg-gradient-to-r from-blue-50 to-transparent" @click="pkgOpen = !pkgOpen">
                                                <span class="text-sm font-semibold text-gray-700">
                                                     #{{ $pkgIndex + 1 }} - <span class="text-blue-600">{{ $package->name ?? 'Unnamed Item' }}</span>
                                                     @if($package->qty) 
                                                        <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-700 text-[10px] rounded-full">{{ $package->qty }} Pcs</span> 
                                                     @endif
                                                </span>
                                                <i class="ki-filled ki-arrow-down text-gray-400 text-xs transition-transform" :class="{ 'rotate-180': pkgOpen }"></i>
                                            </div>

                                            {{-- DETAILS --}}
                                            <div x-show="pkgOpen" x-collapse class="p-5 bg-gray-50/30 border-t border-gray-50">
                                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                                    <div class="space-y-1">
                                                        <label class="text-[10px] font-medium text-gray-500">Width</label>
                                                        <div class="text-xs font-bold text-gray-800">{{ $package->dimension_width }} cm</div>
                                                    </div>
                                                    <div class="space-y-1">
                                                        <label class="text-[10px] font-medium text-gray-500">Length</label>
                                                        <div class="text-xs font-bold text-gray-800">{{ $package->dimension_weight }} cm</div> {{-- Assuming 'dimension_weight' maps to Length based on UI label --}}
                                                    </div>
                                                    <div class="space-y-1">
                                                        <label class="text-[10px] font-medium text-gray-500">Height</label>
                                                        <div class="text-xs font-bold text-gray-800">{{ $package->dimension_height }} cm</div>
                                                    </div>
                                                    <div class="space-y-1">
                                                        <label class="text-[10px] font-medium text-gray-500">Weight</label>
                                                        <div class="text-xs font-bold text-gray-800">{{ $package->heavy }} kg</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-4 text-gray-400 text-sm italic">
                                            No packages listed.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-gray-400">
                    <i class="ki-filled ki-map text-3xl mb-2 opacity-50"></i>
                    <p>No destinations found for this request.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
