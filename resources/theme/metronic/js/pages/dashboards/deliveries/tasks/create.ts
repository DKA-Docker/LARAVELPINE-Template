/**
 * MODUL: TaskCreateModule
 * Deskripsi: Handler peta interaktif dengan Triple-Provider Geocoding.
 * Logika: Jika Google API Key tidak ada, sistem tetap berjalan menggunakan Mapbox & OSM.
 */

import $ from "jquery";
import mapboxgl from "mapbox-gl";
// @ts-ignore
import { Livewire } from '../../../../../../../../vendor/livewire/livewire/dist/livewire.esm'

interface TaskCreateModuleInterface {
    map: mapboxgl.Map | null;
    marker: mapboxgl.Marker | null;
    accessToken: string;
    googleApiKey: string;
    isAutoFilling: boolean;
    init(): void;
    getThemeMode(): string;
    getMapStyle(): string;
    setupAutocomplete(): void;
    setupThemeObserver(): void;
    fetchSuggestions(query: string, $container: JQuery<HTMLElement>): void;
    renderSuggestionItem($container: JQuery<HTMLElement>, data: any): void;
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
    googleApiKey: getCfg('google-maps-key'), // Akan kosong jika tidak diset di meta
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

        let initialLng = parseFloat($mapElement.attr('data-lng') || '119.4173');
        let initialLat = parseFloat($mapElement.attr('data-lat') || '-5.1476');

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

            Livewire.on('search-location', (event: any) => {
                if (event.address) self.geocodeAddress(event.address);
            });

            self.marker.on('dragend', () => {
                const lngLat = self.marker!.getLngLat();
                self.reverseGeocoding(lngLat.lng, lngLat.lat);
                self.syncToLivewire(lngLat.lng, lngLat.lat);
            });
        };

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
        const center = self.map ? self.map.getCenter() : { lng: 119.4173, lat: -5.1476 };

        // 1. Google (Hanya jika API Key ada)
        const googlePromise = self.googleApiKey
            ? $.getJSON(`https://maps.googleapis.com/maps/api/place/autocomplete/json?input=${encodeURIComponent(query)}&key=${self.googleApiKey}&location=${center.lat},${center.lng}&radius=20000&language=id&components=country:id`)
            : Promise.resolve({ predictions: [] });

        // 2. Mapbox
        const mapboxUrl = `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(query)}.json?access_token=${self.accessToken}&limit=4&country=ID&language=id&types=address,poi&proximity=${center.lng},${center.lat}`;

        // 3. OpenStreetMap
        const osmUrl = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&addressdetails=1&limit=4&countrycodes=id`;

        $container.empty().removeClass('hidden');

        Promise.all([
            // @ts-ignore
            googlePromise.catch(() => ({ predictions: [] })),
            $.getJSON(mapboxUrl).catch(() => ({ features: [] })),
            $.getJSON(osmUrl).catch(() => [])
        ]).then(([googleData, mapboxData, osmData]) => {

            // Render Google
            if (googleData && googleData.predictions) {
                googleData.predictions.forEach((p: any) => {
                    self.renderSuggestionItem($container, {
                        title: p.structured_formatting.main_text,
                        subtitle: p.description,
                        placeId: p.place_id,
                        source: 'Google'
                    });
                });
            }

            // Render Mapbox
            if (mapboxData.features) {
                mapboxData.features.forEach((f: any) => {
                    self.renderSuggestionItem($container, {
                        title: f.text,
                        subtitle: f.place_name,
                        lng: f.center[0],
                        lat: f.center[1],
                        source: 'Mapbox'
                    });
                });
            }

            // Render OSM
            if (Array.isArray(osmData)) {
                osmData.forEach((p: any) => {
                    self.renderSuggestionItem($container, {
                        title: p.address.road || p.display_name.split(',')[0],
                        subtitle: p.display_name,
                        lng: parseFloat(p.lon),
                        lat: parseFloat(p.lat),
                        source: 'OSM'
                    });
                });
            }

            if ($container.is(':empty')) {
                $container.append('<div class="px-4 py-3 text-[10px] text-gray-400 italic text-center">Lokasi tidak ditemukan...</div>');
            }
        });
    },

    renderSuggestionItem($container, data) {
        const self = this;
        const sourceColor = data.source === 'Google' ? 'text-green-600 bg-green-50' : (data.source === 'Mapbox' ? 'text-blue-600 bg-blue-50' : 'text-gray-500 bg-gray-50');

        const $item = $(`
            <div class="px-4 py-3 hover:bg-blue-50 dark:hover:bg-neutral-800 cursor-pointer transition-colors border-b border-gray-100 dark:border-neutral-800 last:border-0">
                <div class="flex items-start justify-between gap-3 pointer-events-none">
                    <div class="flex flex-col flex-1">
                        <span class="text-[11px] font-bold text-gray-800 dark:text-neutral-100 leading-tight mb-1">${data.subtitle}</span>
                        <div class="flex items-center gap-1.5 text-gray-400">
                             <i class="ki-outline ki-geolocation text-[10px]"></i>
                             <span class="text-[9px] line-clamp-1">${data.title}</span>
                        </div>
                    </div>
                    <span class="text-[8px] font-bold px-1.5 py-0.5 rounded ${sourceColor} dark:bg-neutral-700 dark:text-gray-300 uppercase shrink-0">${data.source}</span>
                </div>
            </div>
        `);

        $item.on('mousedown', (e) => {
            e.preventDefault();
            self.isAutoFilling = true;
            $('#map-search-input').val(data.subtitle).trigger('input');
            $container.addClass('hidden');

            if (data.source === 'Google' && data.placeId) {
                const detailsUrl = `https://maps.googleapis.com/maps/api/place/details/json?place_id=${data.placeId}&key=${self.googleApiKey}&fields=geometry`;
                $.getJSON(detailsUrl, (res) => {
                    if (res.result?.geometry?.location) {
                        const loc = res.result.geometry.location;
                        self.moveToLocation(loc.lng, loc.lat, false);
                    }
                });
            } else {
                self.moveToLocation(data.lng, data.lat, false);
            }

            setTimeout(() => { self.isAutoFilling = false; }, 300);
        });

        $container.append($item);
    },

    geocodeAddress(address) {
        const self = this;
        const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(address)}.json?access_token=${self.accessToken}&limit=1&country=ID&language=id&types=address,poi`;

        $.getJSON(url, (data) => {
            if (data.features && data.features.length > 0) {
                const [lng, lat] = data.features[0].center;
                self.isAutoFilling = true;
                $('#map-search-input').val(data.features[0].place_name).trigger('input');
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
        this.map.flyTo({ center: [lng, lat], zoom: 17, essential: true, speed: 1.2 });
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
