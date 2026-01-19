<div class="kt-container-fixed h-full flex flex-col" wire:poll.5s="refreshData">
    <div class="bg-white rounded-2xl shadow-sm px-6 py-4 mb-5 flex items-center justify-between">
         <div class="flex items-center gap-4">
            <a href="{{ route('dashboards.apps.deliveries.tasks.sessions.index') }}" class="btn btn-sm btn-light">
                <i class="ki-filled ki-arrow-left"></i> Back
            </a>
            <h3 class="text-lg font-bold text-gray-800">
                Session Tracking: {{ $sessionData->accountDetail->information->first_name ?? 'Driver' }}
                <span class="text-sm font-normal text-gray-500">({{ $sessionData->taskDetail->name ?? '-' }})</span>
            </h3>
        </div>
    </div>

    <div class="flex-1 bg-white rounded-2xl shadow-sm overflow-hidden relative min-h-[600px]">
        {{-- STATUS INDICATOR --}}
        <div class="absolute top-4 left-4 z-50 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-lg shadow-sm border border-gray-200 flex items-center gap-3">
             <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
             </span>
             <div class="flex flex-col">
                 <span class="text-xs font-bold text-gray-800 uppercase tracking-wider">Live Monitor</span>
                 <span class="text-[10px] text-gray-500 font-medium">Driver Ready (Active)</span>
             </div>
        </div>

        {{-- HIDDEN DATA CONTAINER (UPDATED BY LIVEWIRE) --}}
        <div id="session-map-data" 
             class="hidden" 
             data-geojson="{{ $routeGeoJson }}" 
             data-destination="{{ $destinationCoords ?? '{}' }}">
        </div>

        {{-- MAP BOX CONTAINER (STABLE) --}}
        <div
            id="session-tracking-map"
            class="w-full h-[800px] bg-gray-100"
            wire:ignore
            x-data
            x-init="$nextTick(() => { window.dispatchEvent(new CustomEvent('init-session-map')); })"
        ></div>
    </div>
</div>
