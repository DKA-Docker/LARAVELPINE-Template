/**
 * MODUL: RequestCreateModule
 * Deskripsi: Multi-instance Mapbox implementation for Dynamic Destination List
 */

import $ from "jquery";
import mapboxgl from "mapbox-gl";
import URI from "urijs";

declare var Livewire: any;

const getCfg = (name: string): string => {
    const $meta = $(`meta[name="${name}"]`);
    return $meta.length ? ($meta.attr('content') as string) : '';
};

const MAP_STYLES = {
    standard: 'mapbox://styles/mapbox/streets-v12',
    dark: 'mapbox://styles/mapbox/dark-v11'
};

class DestinationMap {
    index: number;
    containerId: string;
    map: mapboxgl.Map | null = null;
    marker: mapboxgl.Marker | null = null;
    accessToken: string;
    isAutoFilling: boolean = false;
    searchTimeout: any = null;

    constructor(index: number, accessToken: string) {
        this.index = index;
        this.accessToken = accessToken;
        this.containerId = `map-${index}`;
    }

    getThemeMode() {
        return document.documentElement.classList.contains('dark') ? 'dark' : 'light';
    }

    getMapStyle() {
        return this.getThemeMode() === 'dark' ? MAP_STYLES.dark : MAP_STYLES.standard;
    }

    init() {
        const $el = $(`#${this.containerId}`);
        if (!$el.length) return;

        // Default Makassar Coordinates
        const defaultLat = -5.147665;
        const defaultLng = 119.432731;

        const initialLat = parseFloat($el.attr('data-lat') || defaultLat.toString());
        const initialLng = parseFloat($el.attr('data-lng') || defaultLng.toString());

        // Check if data matches default (allowing small float diffs)
        // Matches -6.2088 (Jakarta/Blade default) OR Makassar default
        const isDefault = (Math.abs(initialLat - (-6.2088)) < 0.0001 && Math.abs(initialLng - 106.8456) < 0.0001) ||
            (Math.abs(initialLat - defaultLat) < 0.0001 && Math.abs(initialLng - defaultLng) < 0.0001);

        if (isDefault) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        this.renderMap(pos.coords.longitude, pos.coords.latitude, true);
                    },
                    (err) => {
                        // Permission denied or error: Show Error & Hide Map
                        this.showLocationError($el);
                        // Still enable autocomplete/search so user can type address manually
                        this.setupAutocomplete();
                    }
                );
            } else {
                // Fallback to Makassar if Geolocation not supported
                this.renderMap(defaultLng, defaultLat);
            }
        } else {
            // Use saved coordinates
            this.renderMap(initialLng, initialLat);
        }
    }

    renderMap(lng: number, lat: number, reverseGeocodeInit: boolean = false) {
        mapboxgl.accessToken = this.accessToken;

        this.map = new mapboxgl.Map({
            container: this.containerId,
            style: this.getMapStyle(),
            center: [lng, lat],
            zoom: 13,
        });

        this.map.addControl(new mapboxgl.NavigationControl(), 'top-right');

        const geolocate = new mapboxgl.GeolocateControl({
            positionOptions: { enableHighAccuracy: true },
            trackUserLocation: true,
            showUserHeading: true
        });
        this.map.addControl(geolocate, 'top-right');

        geolocate.on('geolocate', (e: any) => {
            this.moveTo(e.coords.longitude, e.coords.latitude, undefined, true);
        });

        this.marker = new mapboxgl.Marker({ draggable: true, color: "#dc2626" })
            .setLngLat([lng, lat])
            .addTo(this.map);

        this.marker.on('dragend', () => {
            const lngLat = this.marker!.getLngLat();
            this.reverseGeocoding(lngLat.lng, lngLat.lat);
            this.syncToLivewire(lngLat.lng, lngLat.lat);
        });

        this.map.on('click', (e) => {
            this.marker!.setLngLat(e.lngLat);
            this.reverseGeocoding(e.lngLat.lng, e.lngLat.lat);
            this.syncToLivewire(e.lngLat.lng, e.lngLat.lat);
        });

        this.setupAutocomplete();
        this.setupThemeObserver();

        if (reverseGeocodeInit) {
            this.reverseGeocoding(lng, lat);
        }

        this.syncToLivewire(lng, lat);
    }

    showLocationError($el: JQuery<HTMLElement>) {
        $el.addClass('flex items-center justify-center bg-gray-50 border border-gray-200 rounded-lg');
        $el.html(`
            <div class="text-center p-6">
                <i class="ki-filled ki-geolocation text-3xl text-gray-400 mb-3"></i>
                <p class="text-gray-600 font-bold text-sm">Membutuhkan akses lokasi</p>
                <p class="text-gray-400 text-xs mt-1 max-w-[200px] mx-auto">Izinkan akses lokasi browser untuk menampilkan peta.</p>
            </div>
        `);
    }

    syncToLivewire(lng: number, lat: number) {
        // Update Display
        $(`#lat-display-${this.index}`).text(lat.toFixed(6));
        $(`#lng-display-${this.index}`).text(lng.toFixed(6));

        // Update Livewire
        const wrapper = $(`#${this.containerId}`).closest('[wire\\:id]');
        const componentId = wrapper.attr('wire:id');
        if (componentId && Livewire) {
            const component = Livewire.find(componentId);
            if (component) {
                // Assuming the structure is destinations[index]['coordinate_...']
                component.set(`destinations.${this.index}.coordinate_latitude`, lat.toFixed(6));
                component.set(`destinations.${this.index}.coordinate_longitude`, lng.toFixed(6));
            }
        }
    }

    setupThemeObserver() {
        let currentStyleKey = this.getThemeMode();
        const observer = new MutationObserver(() => {
            const newKey = this.getThemeMode();
            if (newKey !== currentStyleKey && this.map) {
                currentStyleKey = newKey;
                this.map.setStyle(this.getMapStyle());
                this.map.once('style.load', () => this.marker?.addTo(this.map!));
            }
        });
        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
    }

    setupAutocomplete() {
        const $input = $(`#map-search-${this.index}`);
        const $results = $(`#map-results-${this.index}`);

        $input.on('input', () => {
            if (this.isAutoFilling) return;
            const query = $input.val() as string;

            if (this.searchTimeout) clearTimeout(this.searchTimeout);

            if (query.length < 3) {
                $results.addClass('hidden');
                return;
            }

            this.searchTimeout = setTimeout(() => {
                this.fetchSuggestions(query, $results);
            }, 500);
        });

        // Hide results on click outside
        $(document).on('click', (e) => {
            if (!$(e.target).closest(`#map-search-${this.index}, #map-results-${this.index}`).length) {
                $results.addClass('hidden');
            }
        });
    }

    fetchSuggestions(query: string, $container: JQuery<HTMLElement>) {
        const mapboxUrl = `https://api.mapbox.com/search/geocode/v6/forward?q=${encodeURIComponent(query)}` +
            `&access_token=${this.accessToken}&limit=5&country=ID&language=id&types=address,street,place,locality`;

        // Use Proxy URI
        const FullUriCurrentURL = URI(window.location);
        const segs = FullUriCurrentURL.segment();
        segs.push('geocoding-proxy');
        const proxyUri = new URI().segment(segs).query({ q: query });

        Promise.allSettled([
            $.getJSON(mapboxUrl),
            $.getJSON(`${proxyUri}`)
        ]).then((results) => {
            $container.empty().removeClass('hidden');
            let combinedResults: any[] = [];

            // 1. PARSE MAPBOX (V6 Response Structure)
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

            // 2. PARSE OSM
            if (results[1].status === 'fulfilled') {
                const data = results[1].value;
                if (Array.isArray(data)) {
                    data.forEach((item: any) => {
                        combinedResults.push({
                            source: 'OPEN STREET MAP',
                            name: (item.display_name || '').split(',')[0],
                            full: item.display_name,
                            lng: parseFloat(item.lon),
                            lat: parseFloat(item.lat),
                            type: item.type,
                            region: item.address?.city || item.address?.town || item.address?.state || ''
                        });
                    });
                }
            }

            if (combinedResults.length === 0) {
                $container.append('<div class="p-3 text-sm text-gray-500">Tidak ditemukan</div>');
                return;
            }

            // Render ke UI
            combinedResults.forEach(res => {
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

                            ${res.region ? `
                                <div class="flex items-center mt-2 pl-6">
                                    <span class="text-[10px] bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 px-2 py-0.5 rounded font-bold uppercase tracking-wider">
                                        ${res.region}
                                    </span>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                 `);

                $item.on('mousedown', (e) => {
                    e.preventDefault(); // Prevent blur
                    this.moveTo(res.lng, res.lat, res.full);
                    $container.addClass('hidden');
                });

                $container.append($item);
            });
        });
    }

    reverseGeocoding(lng: number, lat: number) {
        const mapboxRevUrl = `https://api.mapbox.com/search/geocode/v6/reverse?longitude=${lng}&latitude=${lat}&access_token=${this.accessToken}&limit=1&language=id`;
        const osmRevUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`;

        $.getJSON(mapboxRevUrl, (data) => {
            if (data.features && data.features.length > 0) {
                const address = data.features[0].properties.full_address || data.features[0].properties.name;
                this.isAutoFilling = true;
                const $input = $(`#map-search-${this.index}`);
                $input.val(address);
                if ($input[0]) {
                    $input[0].dispatchEvent(new Event('input', { bubbles: true }));
                    $input[0].dispatchEvent(new Event('change', { bubbles: true })); // safety
                }
                setTimeout(() => { this.isAutoFilling = false; }, 300);
            } else {
                // Fallback to OSM
                $.getJSON(osmRevUrl, (osmData) => {
                    if (osmData.display_name) {
                        this.isAutoFilling = true;
                        const $input = $(`#map-search-${this.index}`);
                        $input.val(osmData.display_name);
                        if ($input[0]) {
                            $input[0].dispatchEvent(new Event('input', { bubbles: true }));
                            $input[0].dispatchEvent(new Event('change', { bubbles: true }));
                        }
                        setTimeout(() => { this.isAutoFilling = false; }, 300);
                    }
                });
            }
        });
    }

    moveTo(lng: number, lat: number, address?: string, updateAddress: boolean = false) {
        if (this.map && this.marker) {
            this.map.flyTo({ center: [lng, lat], zoom: 16, essential: true, speed: 1.2 });
            this.marker.setLngLat([lng, lat]);
        }

        this.syncToLivewire(lng, lat);

        if (address) {
            this.isAutoFilling = true;
            const $input = $(`#map-search-${this.index}`);
            $input.val(address);
            if ($input[0]) {
                $input[0].dispatchEvent(new Event('input', { bubbles: true }));
                $input[0].dispatchEvent(new Event('change', { bubbles: true }));
            }
            setTimeout(() => { this.isAutoFilling = false; }, 300);
        } else if (updateAddress) {
            this.reverseGeocoding(lng, lat);
        }
    }
}

// Manager to handle dynamic maps
const DestinationMapManager = {
    instances: {} as Record<number, DestinationMap>,

    init() {
        const accessToken = getCfg('mapbox-token');
        if (!accessToken) return;

        const scan = () => {
            $('.destination-map').each((_, el) => {
                const index = $(el).data('index');
                // Check if already initialized and if element is still connected
                if (typeof index !== 'undefined' && !this.instances[index]) {
                    const mapInstance = new DestinationMap(index, accessToken);
                    mapInstance.init();
                    this.instances[index] = mapInstance;
                }
            });
        };

        scan();

        // Watch for DOM changes (Livewire updates)
        const observer = new MutationObserver((mutations) => {
            let shouldScan = false;
            for (const mutation of mutations) {
                if (mutation.addedNodes.length) {
                    shouldScan = true;
                    break;
                }
            }
            if (shouldScan) scan();
        });

        const container = document.querySelector('main') || document.body;
        observer.observe(container, { childList: true, subtree: true });
    }
};

$(() => {
    // Run on initial load
    DestinationMapManager.init();

    // Run on Livewire navigation
    $(document).on('livewire:navigated', () => {
        DestinationMapManager.instances = {}; // Reset instances on navigation
        DestinationMapManager.init();
    });
});
