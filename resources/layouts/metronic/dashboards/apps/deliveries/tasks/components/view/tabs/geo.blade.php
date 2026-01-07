<div class="flex flex-col gap-6">
    <div class="flex items-center justify-between mb-2">
        <h3 class="text-lg font-bold text-gray-900">Lokasi & Peta</h3>
    </div>

    {{-- Grid Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6"
         x-data="{ init() { window.dispatchEvent(new CustomEvent('init-detail-map')); } }"
         x-init="init()"
    >
        {{-- Col 1: Details --}}
        <div class="lg:col-span-1 flex flex-col gap-6">
            <div class="flex flex-col gap-1.5">
                 <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Koordinat</span>
                 <span class="text-sm font-mono font-bold text-gray-800 bg-gray-100 px-3 py-2 rounded-lg w-fit">
                    {{ number_format(data_get($task, 'geos.latitude', 0), 6) }}, {{ number_format(data_get($task, 'geos.longitude', 0), 6) }}
                 </span>
            </div>
             <div class="flex flex-col gap-1.5">
                 <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kode Pos</span>
                 <span class="text-sm font-bold text-gray-800">
                    {{ data_get($task, 'geos.postal_code', '-') }}
                 </span>
            </div>
        </div>

        {{-- Col 2: Map --}}
        <div class="lg:col-span-2">
            <div id="map-detail" 
                 class="w-full h-[400px] rounded-xl border border-gray-100 shadow-sm bg-gray-50"
                 data-lat="{{ data_get($task, 'geos.latitude', -6.200000) }}"
                 data-lng="{{ data_get($task, 'geos.longitude', 106.816666) }}"
            ></div>
        </div>
    </div>
</div>
