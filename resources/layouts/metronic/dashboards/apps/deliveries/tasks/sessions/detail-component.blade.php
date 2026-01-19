<div class="kt-container-fixed h-screen flex flex-col pb-5" wire:poll.2s="refreshData">


    {{-- Layout 70:30 --}}
    <div class="flex flex-row flex-grow gap-5 min-h-0">
        {{-- MAP (70%) --}}
        <div class="w-[70%] bg-white rounded-2xl shadow-sm overflow-hidden relative border border-gray-100">
            <div wire:ignore class="w-full h-full">
                <div id="session-tracking-map" class="w-full h-full"></div>
            </div>
            <div id="session-map-data" class="hidden"
                 data-geojson="{{ $routeGeoJson }}"
                 data-destination="{{ $destinationCoords }}">
            </div>
        </div>

        {{-- SIDEBAR LIST (30%) --}}
        <div class="w-[30%] bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col min-h-0">
            <div class="p-4 border-b border-gray-100">
                <h4 class="font-bold text-gray-800">Activity Logs</h4>
                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Waktu & Kecepatan</p>
            </div>
            <div id="log-container" class="flex-grow overflow-y-auto p-4 space-y-2 custom-scrollbar">
                {{-- Diisi via JS --}}
            </div>
        </div>
    </div>

    <style>
        .log-item { transition: all 0.2s; cursor: pointer; border: 1px solid transparent; }
        .log-item.active {
            background: #f0fdf4 !important;
            border-color: #10b981 !important;
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
        }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .mapboxgl-popup { pointer-events: none !important; z-index: 1000; }
        .mapboxgl-popup-content {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(8px);
            border-radius: 12px !important;
            padding: 10px 15px !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
            border: 1px solid #e5e7eb !important;
        }
    </style>
</div>
