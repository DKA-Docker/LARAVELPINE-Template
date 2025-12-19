import $ from "jquery";
import mapboxgl from "mapbox-gl";
import moment from "moment-timezone";
// @ts-ignore
import { Livewire } from '../../../../vendor/livewire/livewire/dist/livewire.esm'
import "moment/locale/id.js";

interface TaskCreateModuleInterface {
    map: mapboxgl.Map | null;
    marker: mapboxgl.Marker | null;
    accessToken: string;
    init(): void;
    addSearchAutocomplete(): void;
    fetchSuggestions(query: string, $container: JQuery<HTMLElement>): void;
    moveToLocation(lng: number, lat: number): void;
    performGeocoding(address: string): void;
    syncToLivewire(lng: number, lat: number): void;
}

const getCfg = (name: string): string => {
    const $meta = $(`meta[name="${name}"]`);
    return $meta.length ? ($meta.attr('content') as string) : '';
};

const TaskCreateModule: TaskCreateModuleInterface = {
    map: null,
    marker: null,
    accessToken: getCfg('mapbox-token'),

    init() {
        const self = this;
        const $mapElement = $('#map');

        if (!$mapElement.length || !self.accessToken) return;

        moment.locale('id');
        mapboxgl.accessToken = self.accessToken;

        const initialLng = parseFloat($mapElement.data('lng') || '106.8456');
        const initialLat = parseFloat($mapElement.data('lat') || '-6.2088');

        // 1. Setup Map dengan Style Kontras & Pitch 3D
        self.map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/navigation-guidance-day-v4',
            center: [initialLng, initialLat],
            zoom: 14,
            pitch: 45,
            antialias: true
        });

        self.map.addControl(new mapboxgl.NavigationControl(), 'bottom-right');

        // 2. Setup Marker Draggable
        self.marker = new mapboxgl.Marker({
            draggable: true,
            scale: 1.2,
            color: "#2563eb"
        })
            .setLngLat([initialLng, initialLat])
            .addTo(self.map);

        // 3. Tambahkan UI Autocomplete Search di Atas Map
        self.addSearchAutocomplete();

        // 4. Event: Marker Drag
        self.marker.on('dragend', () => {
            if (self.marker) {
                const lngLat = self.marker.getLngLat();
                self.syncToLivewire(lngLat.lng, lngLat.lat);
            }
        });

        // 5. Event: Listener dari Dropdown Destinasi Livewire
        $(window).on('search-location', (event: any) => {
            const address = event.detail?.address;
            if (address) self.performGeocoding(address);
        });
    },

    /**
     * Membuat Search Bar Floating dengan Autocomplete
     */
    addSearchAutocomplete() {
        const self = this;
        const $searchContainer = $('<div class="absolute top-4 left-4 z-20 w-80 md:w-96"></div>');

        $searchContainer.html(`
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600">
                    <i class="ki-outline ki-magnifier text-lg"></i>
                </div>
                <input type="text" id="map-search-input"
                    class="block w-full pl-10 pr-3 py-2.5 bg-white/95 backdrop-blur-md border border-gray-200 rounded-xl shadow-xl text-xs font-bold placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all"
                    placeholder="Cari jalan atau nama tempat..." autocomplete="off">

                <div id="autocomplete-results" class="hidden absolute left-0 right-0 mt-2 bg-white border border-gray-100 rounded-xl shadow-2xl overflow-hidden z-30">
                </div>
            </div>
        `);

        $('#map').append($searchContainer);

        const $input = $('#map-search-input');
        const $resultsContainer = $('#autocomplete-results');

        $input.on('input', (e: JQuery.TriggeredEvent) => {
            const query = $(e.target).val() as string;
            if (query.length < 3) {
                $resultsContainer.addClass('hidden');
                return;
            }
            self.fetchSuggestions(query, $resultsContainer);
        });

        $(document).on('click', (e: JQuery.ClickEvent) => {
            if (!$searchContainer.is(e.target) && $searchContainer.has(e.target).length === 0) {
                $resultsContainer.addClass('hidden');
            }
        });
    },

    /**
     * API Suggestion: Mencari Alamat, Jalan, dan Nama Tempat (POI)
     */
    fetchSuggestions(query: string, $container: JQuery<HTMLElement>) {
        const self = this;
        // Penambahan 'address,poi' memastikan hasil pencarian spesifik ke jalan & gedung
        const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(query)}.json?access_token=${self.accessToken}&limit=5&country=ID&types=address,poi,place&language=id`;

        $.getJSON(url, (data) => {
            $container.empty();
            if (data.features && data.features.length > 0) {
                $container.removeClass('hidden');
                data.features.forEach((feature: any) => {
                    const placeName = feature.text; // Nama Gedung/Jalan
                    const fullAddress = feature.place_name; // Alamat Lengkap

                    const $item = $(`
                        <div class="px-4 py-3 hover:bg-blue-50 cursor-pointer border-b border-gray-50 last:border-0 transition-colors">
                            <div class="flex items-start gap-3">
                                <i class="ki-outline ki-geolocation text-blue-500 mt-1"></i>
                                <div class="flex flex-col">
                                    <span class="text-[11px] font-bold text-gray-800 line-clamp-1">${placeName}</span>
                                    <span class="text-[9px] text-gray-400 line-clamp-2 leading-relaxed">${fullAddress}</span>
                                </div>
                            </div>
                        </div>
                    `);

                    $item.on('click', () => {
                        $('#map-search-input').val(fullAddress);
                        $container.addClass('hidden');
                        self.moveToLocation(feature.center[0], feature.center[1]);
                    });

                    $container.append($item);
                });
            } else {
                $container.addClass('hidden');
            }
        });
    },

    /**
     * Pindah Kamera & Sinkronisasi
     */
    moveToLocation(lng: number, lat: number) {
        const self = this;
        self.map?.flyTo({
            center: [lng, lat],
            zoom: 17, // Zoom lebih dekat untuk akurasi jalan
            speed: 1.5,
            essential: true
        });
        self.marker?.setLngLat([lng, lat]);
        self.syncToLivewire(lng, lat);
    },

    /**
     * Geocoding untuk Address dari Dropdown Livewire
     */
    performGeocoding(address: string) {
        const self = this;
        const query = encodeURIComponent(address);
        // Memastikan pencarian otomatis tetap mencakup detail spesifik
        const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${query}.json?access_token=${self.accessToken}&limit=1&country=ID&types=address,poi,place`;

        $.getJSON(url, (data) => {
            if (data.features && data.features.length > 0) {
                const [lng, lat] = data.features[0].center;
                self.moveToLocation(lng, lat);
            }
        });
    },

    /**
     * Mengirim Koordinat ke Livewire Component
     */
    syncToLivewire(lng: number, lat: number) {
        const $mapElement = $('#map');
        const componentId = $mapElement.closest('[wire\\:id]').attr('wire:id');

        // @ts-ignore
        const lwComponent = window.Livewire.find(componentId);

        if (lwComponent) {
            lwComponent.set('formData.longitude', lng.toFixed(6), true);
            lwComponent.set('formData.latitude', lat.toFixed(6), true);
        }
    }
};

$(function() {
    const selector = "div.dashboards-apps-deliveries-tasks-create";

    const runInit = () => {
        if ($(selector).length > 0) {
            TaskCreateModule.init();
        }
    };

    runInit();

    $(document).on('livewire:navigated', () => {
        runInit();
    });
});
