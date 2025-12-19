import $ from "jquery";
import mapboxgl from "mapbox-gl";
// @ts-ignore
import { Livewire } from '../../../../../../../../vendor/livewire/livewire/dist/livewire.esm'

interface TaskCreateModuleInterface {
    map: mapboxgl.Map | null;
    marker: mapboxgl.Marker | null;
    accessToken: string;
    isAutoFilling: boolean;
    init(): void;
    getThemeMode(): string;
    getMapStyle(): string;
    setupAutocomplete(): void;
    setupThemeObserver(): void;
    fetchSuggestions(query: string, $container: JQuery<HTMLElement>): void;
    geocodeAddress(address: string): void;
    reverseGeocoding(lng: number, lat: number): void;
    moveToLocation(lng: number, lat: number, updateAddress?: boolean): void;
    syncToLivewire(lng: number, lat: number): void;
}

const getCfg = (name: string): string => {
    const $meta = $(`meta[name="${name}"]`);
    return $meta.length ? ($meta.attr('content') as string) : '';
};

const MAP_STYLES = {
    standard: 'mapbox://styles/mapbox/streets-v12',
    dark: 'mapbox://styles/mapbox/dark-v11'
};

const TaskCreateModule: TaskCreateModuleInterface = {
    map: null,
    marker: null,
    accessToken: getCfg('mapbox-token'),
    isAutoFilling: false,

    getThemeMode() {
        return document.documentElement.classList.contains('dark') ? 'dark' : 'light';
    },

    getMapStyle() {
        return this.getThemeMode() === 'dark' ? MAP_STYLES.dark : MAP_STYLES.standard;
    },

    init() {
        const self = this;
        const $mapElement = $('#map');
        if (!$mapElement.length || !self.accessToken) return;

        mapboxgl.accessToken = self.accessToken;

        // Default Jakarta
        let initialLng = parseFloat($mapElement.attr('data-lng') || '106.8456');
        let initialLat = parseFloat($mapElement.attr('data-lat') || '-6.2088');

        const renderMap = (lng: number, lat: number) => {
            self.map = new mapboxgl.Map({
                container: 'map',
                style: self.getMapStyle(),
                center: [lng, lat],
                zoom: 14,
            });

            self.map.addControl(new mapboxgl.NavigationControl(), 'top-right');

            const geolocate = new mapboxgl.GeolocateControl({
                positionOptions: { enableHighAccuracy: true },
                trackUserLocation: true,
                showUserHeading: true
            });
            self.map.addControl(geolocate, 'top-right');

            geolocate.on('geolocate', (e: any) => {
                self.moveToLocation(e.coords.longitude, e.coords.latitude, true);
            });

            self.marker = new mapboxgl.Marker({ draggable: true, color: "#2563eb" })
                .setLngLat([lng, lat])
                .addTo(self.map);

            self.setupAutocomplete();
            self.setupThemeObserver();

            // SINKRONISASI DARI LIVEWIRE (EVENT 'search-location')
            // Dipicu saat updatedFormDataDestination di PHP berjalan
            Livewire.on('search-location', (event: any) => {
                const address = event.address;
                if (address) {
                    self.geocodeAddress(address);
                }
            });

            self.marker.on('dragend', () => {
                const lngLat = self.marker!.getLngLat();
                self.reverseGeocoding(lngLat.lng, lngLat.lat);
                self.syncToLivewire(lngLat.lng, lngLat.lat);
            });
        };

        // Get Initial Position (My Location)
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (pos) => renderMap(pos.coords.longitude, pos.coords.latitude),
                () => renderMap(initialLng, initialLat),
                { timeout: 5000 }
            );
        } else {
            renderMap(initialLng, initialLat);
        }
    },

    setupThemeObserver() {
        const self = this;
        let currentStyleKey = self.getThemeMode();
        const themeObserver = new MutationObserver(() => {
            const newKey = self.getThemeMode();
            if (newKey !== currentStyleKey) {
                currentStyleKey = newKey;
                if (self.map) {
                    self.map.setStyle(self.getMapStyle());
                    self.map.once('style.load', () => self.marker?.addTo(self.map!));
                }
            }
        });
        themeObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
    },

    setupAutocomplete() {
        const self = this;
        const $input = $('#map-search-input');
        const $resultsContainer = $('#autocomplete-results');

        $input.on('input', function() {
            if (self.isAutoFilling) return;
            const query = $(this).val() as string;
            if (query.length < 3) {
                $resultsContainer.addClass('hidden');
                return;
            }
            self.fetchSuggestions(query, $resultsContainer);
        });

        $(document).on('click', (e: any) => {
            if (!$(e.target).closest('#map-search-container').length) $resultsContainer.addClass('hidden');
        });
    },

    fetchSuggestions(query, $container) {
        const self = this;
        const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(query)}.json?access_token=${self.accessToken}&limit=5&country=ID&language=id`;

        $.getJSON(url, (data) => {
            $container.empty().removeClass('hidden');
            data.features.forEach((feature: any) => {
                const $item = $(`
                    <div class="px-4 py-3 hover:bg-blue-50 dark:hover:bg-neutral-800 cursor-pointer border-b border-gray-100 dark:border-neutral-800 last:border-0 transition-colors">
                        <div class="flex flex-col pointer-events-none">
                            <span class="text-[11px] font-bold text-gray-800 dark:text-neutral-100">${feature.text}</span>
                            <span class="text-[9px] text-gray-400 line-clamp-1">${feature.place_name}</span>
                        </div>
                    </div>
                `);

                $item.on('mousedown', (e) => {
                    e.preventDefault();
                    self.isAutoFilling = true;
                    $('#map-search-input').val(feature.place_name).trigger('input');
                    $container.addClass('hidden');
                    self.moveToLocation(feature.center[0], feature.center[1], false);
                    setTimeout(() => { self.isAutoFilling = false; }, 300);
                });

                $container.append($item);
            });
        });
    },

    /**
     * Mengonversi Teks Alamat menjadi Koordinat (Digunakan saat pilih destinasi)
     */
    geocodeAddress(address) {
        const self = this;
        const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(address)}.json?access_token=${self.accessToken}&limit=1&country=ID&language=id`;

        $.getJSON(url, (data) => {
            if (data.features && data.features.length > 0) {
                const [lng, lat] = data.features[0].center;

                // Set flag agar input address tidak memunculkan suggest saat terisi otomatis
                self.isAutoFilling = true;
                $('#map-search-input').val(data.features[0].place_name).trigger('input');

                // Terbang ke lokasi
                self.moveToLocation(lng, lat, false);

                setTimeout(() => { self.isAutoFilling = false; }, 500);
            }
        });
    },

    reverseGeocoding(lng, lat) {
        const self = this;
        const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${this.accessToken}&limit=1&language=id`;
        $.getJSON(url, (data) => {
            if (data.features && data.features.length > 0) {
                const address = data.features[0].place_name;
                self.isAutoFilling = true;
                $('#map-search-input').val(address).trigger('input');
                setTimeout(() => { self.isAutoFilling = false; }, 300);
            }
        });
    },

    moveToLocation(lng, lat, updateAddress = false) {
        if (!this.map) return;

        this.map.flyTo({
            center: [lng, lat],
            zoom: 16,
            essential: true,
            speed: 1.2
        });

        if (this.marker) this.marker.setLngLat([lng, lat]);

        this.syncToLivewire(lng, lat);
        if (updateAddress) this.reverseGeocoding(lng, lat);
    },

    syncToLivewire(lng, lat) {
        // Update visual input agar user tahu angka berubah
        $('#lat-display').val(lat.toFixed(6));
        $('#lng-display').val(lng.toFixed(6));

        const componentId = $('#map').closest('[wire\\:id]').attr('wire:id');
        const lw = Livewire.find(componentId);

        if (lw) {
            // DISESUAIKAN: Mengarah ke properti 'geos' sesuai revisi model terbaru
            lw.set('formData.geos.longitude', lng.toFixed(6));
            lw.set('formData.geos.latitude', lat.toFixed(6));
        }
    }
};

$(() => {
    const run = () => { if ($("#map").length > 0) TaskCreateModule.init(); };
    run();
    $(document).on('livewire:navigated', run);
});
