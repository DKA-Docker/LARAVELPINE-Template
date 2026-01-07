import $ from "jquery";
import mapboxgl from "mapbox-gl";

declare var Livewire: any;

interface TaskDetailModuleInterface {
    map: mapboxgl.Map | null;
    init(): void;
    initMap(lat: number, lng: number): void;
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

const TaskDetailModule: TaskDetailModuleInterface = {
    map: null,

    getThemeMode() {
        return document.documentElement.classList.contains('dark') ? 'dark' : 'light';
    },

    getMapStyle() {
        return this.getThemeMode() === 'dark' ? MAP_STYLES.dark : MAP_STYLES.standard;
    },

    init() {
        // Listen for Livewire updates or DOM availability
        const checkAndInitMap = () => {
            const $mapContainer = document.getElementById('map-detail');

            if ($mapContainer) {
                // Check if map is already initialized on THIS specific element
                // Mapbox adds 'mapboxgl-map' class to the container upon initialization
                if ($mapContainer.classList.contains('mapboxgl-map')) {
                    // Map is already active on this element, ensure size is correct
                    this.map?.resize();
                    return;
                }

                // If we have an old map instance stored but the DOM element is fresh (no class),
                // it means the old container was destroyed (tab switch). Clean up.
                if (this.map) {
                    this.map.remove();
                    this.map = null;
                }

                const lat = parseFloat($mapContainer.dataset.lat || '-6.200000');
                const lng = parseFloat($mapContainer.dataset.lng || '106.816666');
                this.initMap(lat, lng);
            }
        };

        // Check on load
        checkAndInitMap();

        // Check when Livewire updates (e.g. switching tabs)
        document.addEventListener('livewire:navigated', checkAndInitMap);
        document.addEventListener('livewire:initialized', () => {
            Livewire.hook('morph.updated', () => {
                checkAndInitMap();
            });
        });

        // Also listen for a specific event dispatched from the component
        window.addEventListener('init-detail-map', (e: any) => {
            checkAndInitMap();
        });
    },

    initMap(lat: number, lng: number) {
        const token = getCfg('mapbox-token');
        if (!token) {
            console.error("Mapbox token not found");
            return;
        }

        mapboxgl.accessToken = token;

        this.map = new mapboxgl.Map({
            container: 'map-detail',
            style: this.getMapStyle(),
            center: [lng, lat],
            zoom: 17
        });

        new mapboxgl.Marker()
            .setLngLat([lng, lat])
            .addTo(this.map);

        // Resize map after load to prevent gray box
        this.map.on('load', () => {
            this.map?.resize();
        });

        // Handle Theme Switch
        const themeElement = document.documentElement;
        const observer = new MutationObserver(() => {
            if (this.map) {
                this.map.setStyle(this.getMapStyle());
            }
        });
        observer.observe(themeElement, { attributes: true, attributeFilter: ['class', 'data-theme'] });
    }
};

// On document ready
$(document).ready(() => {
    TaskDetailModule.init();
});

export default TaskDetailModule;
