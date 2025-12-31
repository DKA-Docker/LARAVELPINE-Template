/**
 * MODUL: TaskEditModule
 * Deskripsi: Hybrid Geocoding (Mapbox V6 + OSM Nominatim) dengan Debounce Logic.
 * Adaptasi dari Create Module untuk Edit Page.
 */

import $ from "jquery";
import mapboxgl from "mapbox-gl";
import URI from "urijs";

interface TaskEditModuleInterface {
    map: mapboxgl.Map | null;
    marker: mapboxgl.Marker | null;
    accessToken: string;
    isAutoFilling: boolean;
    searchTimeout: any; // Untuk Debounce
    init(): void;
    getThemeMode(): string;
    getMapStyle(): string;
    setupAutocomplete(): void;
    setupThemeObserver(): void;
    fetchSuggestions(query: string, $container: JQuery<HTMLElement>): void;
    geocodeAddress(address: string, updateInput?: boolean): void;
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

const TaskEditModule: TaskEditModuleInterface = {
    map: null,
    marker: null,
    accessToken: getCfg('mapbox-token'),
    isAutoFilling: false,
    searchTimeout: null,

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

        // Ambil koordinat awal dari atribut data (ini akan diisi nilai dari DB oleh Livewire/Blade)
        let initialLng = parseFloat($mapElement.attr('data-lng') || '106.8456');
        let initialLat = parseFloat($mapElement.attr('data-lat') || '-6.2088');

        // Render Map
        const renderMap = (lng: number, lat: number) => {
            self.map = new mapboxgl.Map({
                container: 'map',
                style: self.getMapStyle(),
                center: [lng, lat],
                zoom: 15, // Zoom lebih dekat untuk edit
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

            // Lakukan Reverse Geo untuk mengisi input search-box dengan alamat saat ini
            if (lng !== 106.8456 && lat !== -6.2088) { // Jika bukan koordinat default
                 self.reverseGeocoding(lng, lat);
            }

            // data ada search-location
            Livewire.on('search-location', (event: any) => {
                const data = Array.isArray(event) ? event[0] : event;
                if (data.address) self.geocodeAddress(data.address, true);
            });

            Livewire.on('destination-updated', (event: any) => {
                const data = Array.isArray(event) ? event[0] : event;
                if (data.address) self.geocodeAddress(data.address, true);
            });

            self.marker.on('dragend', () => {
                const lngLat = self.marker!.getLngLat();
                self.reverseGeocoding(lngLat.lng, lngLat.lat);
                self.syncToLivewire(lngLat.lng, lngLat.lat);
            });
        };

        renderMap(initialLng, initialLat);
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

        $input.on('input', function () {
            if (self.isAutoFilling) return;
            const query = $(this).val() as string;

            if (self.searchTimeout) clearTimeout(self.searchTimeout);

            if (query.length < 3) {
                $resultsContainer.addClass('hidden');
                return;
            }

            self.searchTimeout = setTimeout(() => {
                self.fetchSuggestions(query, $resultsContainer);
            }, 500);
        });

        $(document).on('click', (e: any) => {
            if (!$(e.target).closest('#map-search-container').length) $resultsContainer.addClass('hidden');
        });
    },

    fetchSuggestions(query, $container) {
        const self = this;
        const FullUriCurrentURL = URI(window.location);
        const segs = FullUriCurrentURL.segment();

        // Adjust proxy URL construction for Edit route structure
        // Edit route is likely .../tasks/{id}/edit
        // Create was .../tasks/create
        // Proxy logic needs to point to a valid controller method.
        // We registered 'geocodingProxy' in Create route group, but not Edit.
        // Let's assume we can reuse the create proxy or point to a new one if we register it.
        // For now, let's try to hit the same proxy endpoint if accessible, OR
        // Point to the create route's proxy explicitly if possible?
        // Or simpler: Reuse the logic but fix segment construction.

        // Actually, in web.php, the proxy is under `dashboards.apps.deliveries.tasks.create.geocodingProxy`
        // Url: dashboards/apps/deliveries/tasks/create/geocoding-proxy

        // We are at dashboards/apps/deliveries/tasks/{id}/edit
        // So we need to traverse up and over.

        const proxyUrl = "/dashboards/apps/deliveries/tasks/create/geocoding-proxy";

        const mapboxUrl = `https://api.mapbox.com/search/geocode/v6/forward?q=${encodeURIComponent(query)}` +
            `&access_token=${self.accessToken}` +
            `&limit=5` +
            `&country=ID` +
            `&language=id` +
            `&types=address,street,place,locality`;

        Promise.allSettled([
            $.getJSON(mapboxUrl),
            $.getJSON(proxyUrl, { q: query })
        ]).then((results) => {
            $container.empty().removeClass('hidden');
            let combinedResults: any[] = [];

            if (results[0].status === 'fulfilled') {
                const data = results[0].value;
                if (data.features) {
                    data.features.forEach((f: any) => {
                        const p = f.properties;
                        combinedResults.push({
                            source: 'MAPBOX',
                            name: p.name || '',
                            full: p.full_address || p.place_formatted || '',
                            lng: f.geometry.coordinates[0],
                            lat: f.geometry.coordinates[1],
                            type: p.feature_type,
                            region: [p.context?.locality?.name, p.context?.place?.name].filter(Boolean).join(', ')
                        });
                    });
                }
            }

            if (results[1].status === 'fulfilled') {
                const data = results[1].value;
                data.forEach((item: any) => {
                    combinedResults.push({
                        source: 'OPEN STREET MAP',
                        name: item.display_name.split(',')[0],
                        full: item.display_name,
                        lng: parseFloat(item.lon),
                        lat: parseFloat(item.lat),
                        type: item.type,
                        region: item.address.city || item.address.town || item.address.state || ''
                    });
                });
            }

            if (combinedResults.length === 0) {
                $container.addClass('hidden');
                return;
            }

            combinedResults.forEach((res) => {
                const isMapbox = res.source === 'MAPBOX';
                const $item = $(`
                    <div class="px-5 py-4 hover:bg-blue-50 dark:hover:bg-neutral-800 cursor-pointer transition-colors group">
                        <div class="flex flex-col pointer-events-none">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <div class="flex items-center gap-2">
                                    <i class="ki-filled ${res.type === 'poi' ? 'ki-shop' : 'ki-geolocation'} ${isMapbox ? 'text-blue-500' : 'text-gray-400'} group-hover:text-blue-600 text-[14px]"></i>
                                    <span class="text-[15px] font-bold text-gray-900 dark:text-neutral-50 line-clamp-1">${res.name}</span>
                                </div>
                                <span class="text-[9px] font-black px-1.5 py-0.5 rounded ${isMapbox ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-500'} uppercase tracking-tighter">
                                    ${res.source}
                                </span>
                            </div>
                            <span class="text-[13px] text-gray-500 dark:text-neutral-400 line-clamp-2 leading-relaxed pl-6">
                                ${res.full}
                            </span>
                        </div>
                    </div>
                `);

                $item.on('mousedown', (e) => {
                    e.preventDefault();
                    self.isAutoFilling = true;
                    $('#map-search-input').val(res.full).trigger('input');
                    $container.addClass('hidden');
                    self.moveToLocation(res.lng, res.lat, false);
                    setTimeout(() => { self.isAutoFilling = false; }, 300);
                });

                $container.append($item);
            });
        });
    },

    geocodeAddress(address, updateInput = true) {
        const self = this;
        const url = `https://api.mapbox.com/search/geocode/v6/forward?q=${encodeURIComponent(address)}&access_token=${self.accessToken}&limit=1&country=ID&language=id`;

        $.getJSON(url, (data) => {
            if (data.features && data.features.length > 0) {
                const feature = data.features[0];
                const [lng, lat] = feature.geometry.coordinates;
                self.isAutoFilling = true;
                if (updateInput) {
                    $('#map-search-input').val(feature.properties.full_address || feature.properties.name).trigger('input');
                }
                self.moveToLocation(lng, lat, false);
                setTimeout(() => { self.isAutoFilling = false; }, 500);
            }
        });
    },

    reverseGeocoding(lng, lat) {
        const self = this;
        const mapboxRevUrl = `https://api.mapbox.com/search/geocode/v6/reverse?longitude=${lng}&latitude=${lat}&access_token=${this.accessToken}&limit=1&language=id`;
        const osmRevUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`;

        $.getJSON(mapboxRevUrl, (data) => {
            if (data.features && data.features.length > 0) {
                const address = data.features[0].properties.full_address || data.features[0].properties.name;
                self.isAutoFilling = true;
                $('#map-search-input').val(address).trigger('input');
                setTimeout(() => { self.isAutoFilling = false; }, 300);
            } else {
                $.getJSON(osmRevUrl, (osmData) => {
                    if (osmData.display_name) {
                        self.isAutoFilling = true;
                        $('#map-search-input').val(osmData.display_name).trigger('input');
                        setTimeout(() => { self.isAutoFilling = false; }, 300);
                    }
                });
            }
        });
    },

    moveToLocation(lng, lat, updateAddress = false) {
        if (!this.map) return;
        this.map.flyTo({ center: [lng, lat], zoom: 16, essential: true, speed: 1.2 });
        if (this.marker) this.marker.setLngLat([lng, lat]);
        this.syncToLivewire(lng, lat);
        if (updateAddress) this.reverseGeocoding(lng, lat);
    },

    syncToLivewire(lng, lat) {
        $('#lat-display').val(lat.toFixed(6));
        $('#lng-display').val(lng.toFixed(6));
        const componentId = $('#map').closest('[wire\\:id]').attr('wire:id');
        const lw = Livewire.find(componentId);
        if (lw) {
            lw.set('formData.geos.longitude', lng.toFixed(6), false);
            lw.set('formData.geos.latitude', lat.toFixed(6), false);
        }
    }
};

$(() => {
    // Target the Edit page container specifically
    const elementExists = $("div.dashboards-apps-deliveries-tasks-edit");
    if (elementExists.length === 0) return;

    const run = () => {
        if ($("#map").length > 0) {
            TaskEditModule.init();
        }
    };

    run();
    $(document).on('livewire:navigated', run);
    document.addEventListener('init-map', run);
});
