import $ from "jquery";
import mapboxgl from "mapbox-gl";

declare var Livewire: any;

interface RequestDetailModuleInterface {
    maps: Map<string, mapboxgl.Map>;
    init(): void;
    initMap(id: string, lat: number, lng: number): void;
    getThemeMode(): string;
    getMapStyle(): string;
}

const getCfg = (name: string): string => {
    const $meta = $(`meta[name="${name}"]`);
    return $meta.length ? ($meta.attr('content') as string) : '';
};

const MAP_STYLES = {
    standard: 'mapbox://styles/mapbox/streets-v12',
    dark: 'mapbox://styles/mapbox/dark-v11'
};

const RequestDetailModule: RequestDetailModuleInterface = {
    maps: new Map(),

    getThemeMode() {
        return document.documentElement.classList.contains('dark') ? 'dark' : 'light';
    },

    getMapStyle() {
        return this.getThemeMode() === 'dark' ? MAP_STYLES.dark : MAP_STYLES.standard;
    },

    init() {
        // Listen for Livewire updates or DOM availability
        const checkAndInitMaps = () => {
            const mapElements = document.querySelectorAll('.destination-map-verify');

            mapElements.forEach((element) => {
                const $mapContainer = element as HTMLElement;
                const index = $mapContainer.dataset.index;

                if (!$mapContainer || !index) return;

                // Check if map is already initialized on this element
                if ($mapContainer.classList.contains('mapboxgl-map')) {
                    this.maps.get(index)?.resize();
                    return;
                }

                // Clean up old map instance for this index if exists but DOM is fresh
                if (this.maps.has(index)) {
                    this.maps.get(index)?.remove();
                    this.maps.delete(index);
                }

                const lat = parseFloat($mapContainer.dataset.lat || '-6.200000');
                const lng = parseFloat($mapContainer.dataset.lng || '106.816666');

                // Initialize map for this specific destination
                this.initMap(index, lat, lng);
            });
        };

        // Check on load
        checkAndInitMaps();

        // Check when Livewire updates
        document.addEventListener('livewire:navigated', checkAndInitMaps);
        document.addEventListener('livewire:initialized', () => {
            // Re-check after Livewire updates DOM (e.g. pagination or refresh)
            Livewire.hook('morph.updated', () => {
                checkAndInitMaps();
            });
        });

        // Listen for specific event if needed
        window.addEventListener('init-request-detail-maps', () => {
            checkAndInitMaps();
        });
    },

    initMap(index: string, lat: number, lng: number) {
        const token = getCfg('mapbox-token');
        if (!token) {
            console.error("Mapbox token not found");
            return;
        }

        mapboxgl.accessToken = token;
        const containerId = `map-${index}`;

        // Ensure element exists with this ID
        const container = document.getElementById(containerId);
        if (!container) return;

        const map = new mapboxgl.Map({
            container: containerId,
            style: this.getMapStyle(),
            center: [lng, lat],
            zoom: 15
        });

        new mapboxgl.Marker()
            .setLngLat([lng, lat])
            .addTo(map);

        map.on('load', () => {
            map.resize();
        });

        // Store map instance
        this.maps.set(index, map);

        // Handle Theme Switch for this map
        const themeElement = document.documentElement;
        const observer = new MutationObserver(() => {
            if (this.maps.has(index)) {
                this.maps.get(index)?.setStyle(this.getMapStyle());
            }
        });
        observer.observe(themeElement, { attributes: true, attributeFilter: ['class', 'data-theme'] });
    }
};

// On document ready
$(document).ready(() => {
    RequestDetailModule.init();
});

export default RequestDetailModule;
