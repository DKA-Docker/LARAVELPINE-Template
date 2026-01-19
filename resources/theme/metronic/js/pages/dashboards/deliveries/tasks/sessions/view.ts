import mapboxgl from "mapbox-gl";

const fetchRoadRoute = async (start: [number, number], end: [number, number], token: string) => {
    try {
        const query = await fetch(
            `https://api.mapbox.com/directions/v5/mapbox/driving/${start[0]},${start[1]};${end[0]},${end[1]}?geometries=geojson&access_token=${token}`,
            { method: 'GET' }
        );
        const json = await query.json();
        const data = json.routes[0];
        return data.geometry;
    } catch (e) {
        console.error('[Mapbox] Directions API Error:', e);
        return null;
    }
};

const initSessionMap = async (attempt = 1) => {
    const containerId = 'session-tracking-map';
    const container = document.getElementById(containerId);
    const dataContainer = document.getElementById('session-map-data');

    if (!container || !dataContainer) {
        if (attempt < 20) {
            setTimeout(() => initSessionMap(attempt + 1), 300);
        }
        return;
    }

    // Token & Data Extraction
    const meta = document.querySelector('meta[name="mapbox-token"]') as HTMLMetaElement;
    const token = meta?.content;
    const geoJsonRaw = dataContainer.getAttribute('data-geojson');
    const destinationRaw = dataContainer.getAttribute('data-destination');

    if (!token) return;

    // IF MAP EXISTS, UPDATE DATA INSTEAD OF RE-INITIALIZING
    if (container.classList.contains('mapboxgl-map')) {
        const map = (window as any).sessionMap as mapboxgl.Map;
        if (map && map.isStyleLoaded()) {
            try {
                if (geoJsonRaw) {
                    const geoJson = JSON.parse(geoJsonRaw);
                    const source = map.getSource('route') as mapboxgl.GeoJSONSource;
                    if (source && geoJson.coordinates && geoJson.coordinates.length > 0) {
                        source.setData(geoJson);

                        const lastCoord = geoJson.coordinates[geoJson.coordinates.length - 1];
                        if ((window as any).currentLocationMarker) {
                            (window as any).currentLocationMarker.setLngLat(lastCoord);
                        }

                        // Update destination line (Road Following)
                        if (destinationRaw) {
                            const destData = JSON.parse(destinationRaw);
                            if (destData.lat && destData.lng) {
                                const destCoord: [number, number] = [parseFloat(destData.lng), parseFloat(destData.lat)];
                                const roadGeoJson = await fetchRoadRoute(lastCoord, destCoord, token);
                                if (roadGeoJson) {
                                    const toDestSource = map.getSource('to-destination') as mapboxgl.GeoJSONSource;
                                    if (toDestSource) {
                                        toDestSource.setData({
                                            type: 'Feature',
                                            properties: {},
                                            geometry: roadGeoJson
                                        });
                                    }
                                }
                            }
                        }
                    }
                }
            } catch (e) {
                console.error('[Mapbox] Live Update Error:', e);
            }
        }
        return;
    }

    mapboxgl.accessToken = token;

    let routeData: any = null;
    try {
        if (geoJsonRaw) routeData = JSON.parse(geoJsonRaw);
    } catch (e) {
        console.error('[Mapbox] Invalid GeoJSON');
    }

    let destinationData: any = null;
    try {
        if (destinationRaw) destinationData = JSON.parse(destinationRaw);
    } catch (e) {
        console.error('[Mapbox] Invalid Destination JSON');
    }

    // Center calculation
    let center: [number, number] = [106.827153, -6.175392];
    if (routeData?.coordinates?.length) {
        const last = routeData.coordinates[routeData.coordinates.length - 1];
        center = [last[0], last[1]];
    }

    // Determine Style
    const isDark = document.documentElement.classList.contains('dark');
    const style = isDark ? 'mapbox://styles/mapbox/dark-v11' : 'mapbox://styles/mapbox/streets-v12';

    if (!mapboxgl.supported()) return;

    try {
        const map = new mapboxgl.Map({
            container: container,
            style: style,
            center: center,
            zoom: 16,
            attributionControl: false,
            pitch: 45
        });

        map.addControl(new mapboxgl.NavigationControl(), 'top-right');
        (window as any).sessionMap = map;

        map.on('load', async () => {
            map.resize();

            // 1. ADD ARROW ICON
            const arrowImg = new Image(24, 24);
            arrowImg.onload = () => map.addImage('arrow-icon', arrowImg);
            arrowImg.src = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent('<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L4.5 20.29L5.21 21L12 18L18.79 21L19.5 20.29L12 2Z" fill="#ffffff" stroke="#10b981" stroke-width="2" stroke-linejoin="round"/></svg>');

            if (routeData) {
                // TRAVELED ROUTE (THICK GREEN LINE)
                map.addSource('route', { type: 'geojson', data: routeData });

                map.addLayer({
                    id: 'route-line-case',
                    type: 'line',
                    source: 'route',
                    layout: { 'line-join': 'round', 'line-cap': 'round' },
                    paint: { 'line-color': '#064e3b', 'line-width': 12, 'line-opacity': 0.3 }
                });

                map.addLayer({
                    id: 'route-line',
                    type: 'line',
                    source: 'route',
                    layout: { 'line-join': 'round', 'line-cap': 'round' },
                    paint: { 'line-color': '#10b981', 'line-width': 8 }
                });

                // DIRECTIONAL ARROWS
                map.addLayer({
                    id: 'route-arrows',
                    type: 'symbol',
                    source: 'route',
                    layout: {
                        'symbol-placement': 'line',
                        'symbol-spacing': 80,
                        'icon-image': 'arrow-icon',
                        'icon-size': 0.5,
                        'icon-rotation-alignment': 'map',
                        'icon-allow-overlap': true,
                        'icon-ignore-placement': true
                    },
                    paint: { 'icon-opacity': 0.8 }
                });

                if (routeData.coordinates && routeData.coordinates.length > 0) {
                    const lastCoord = routeData.coordinates[routeData.coordinates.length - 1];
                    const el = document.createElement('div');
                    el.className = 'navigation-marker';
                    el.style.width = '40px';
                    el.style.height = '40px';
                    el.innerHTML = `
                        <div class="relative flex items-center justify-center">
                            <div class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></div>
                            <div class="relative inline-flex rounded-full h-8 w-8 bg-blue-600 border-4 border-white shadow-lg flex items-center justify-center">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M12 2L4.5 20.29L5.21 21L12 18L18.79 21L19.5 20.29L12 2Z"/></svg>
                            </div>
                        </div>
                    `;

                    (window as any).currentLocationMarker = new mapboxgl.Marker({ element: el })
                        .setLngLat(lastCoord)
                        .addTo(map);

                    // DESTINATION (ROAD FOLLOWING)
                    if (destinationData?.lat && destinationData?.lng) {
                        const destCoord: [number, number] = [parseFloat(destinationData.lng), parseFloat(destinationData.lat)];

                        // Initial fetch for road route
                        const roadGeoJson = await fetchRoadRoute(lastCoord, destCoord, token);

                        map.addSource('to-destination', {
                            type: 'geojson',
                            data: {
                                type: 'Feature',
                                properties: {},
                                geometry: roadGeoJson || { type: 'LineString', coordinates: [lastCoord, destCoord] }
                            }
                        });

                        map.addLayer({
                            id: 'to-destination-line',
                            type: 'line',
                            source: 'to-destination',
                            paint: {
                                'line-color': '#ef4444',
                                'line-width': 6,
                                'line-dasharray': [2, 1]
                            }
                        });

                        const destEl = document.createElement('div');
                        destEl.innerHTML = `
                            <div class="flex flex-col items-center">
                                <div class="bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md mb-1 uppercase whitespace-nowrap">${destinationData.name}</div>
                                <div class="w-6 h-6 bg-red-600 border-4 border-white rounded-full shadow-lg"></div>
                            </div>
                        `;
                        new mapboxgl.Marker({ element: destEl })
                            .setLngLat(destCoord)
                            .addTo(map);
                    }

                    const bounds = new mapboxgl.LngLatBounds();
                    routeData.coordinates.forEach((x: any) => bounds.extend(x));
                    if (destinationData?.lat) bounds.extend([destinationData.lng, destinationData.lat]);
                    map.fitBounds(bounds, { padding: 100 });
                }
            }
        });

        const resizeObserver = new ResizeObserver(() => map.resize());
        resizeObserver.observe(container);

    } catch (e: any) {
        console.error('[Mapbox] Crash:', e);
    }
};

// Event Listeners
document.addEventListener('livewire:navigated', () => initSessionMap(1));
document.addEventListener('init-session-map', () => initSessionMap(1));
document.addEventListener('update-session-map', () => initSessionMap(1));

// Start checking immediately
initSessionMap(1);
