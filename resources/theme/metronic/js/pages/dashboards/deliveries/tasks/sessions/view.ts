import mapboxgl from "mapbox-gl";
import $ from "jquery";

let map: mapboxgl.Map | null = null;
let currentMarker: mapboxgl.Marker | null = null;
let destinationMarker: mapboxgl.Marker | null = null;
let hoverPopup: mapboxgl.Popup | null = null;

const formatTimeWithSeconds = (ts: string) => {
    const d = new Date(ts);
    return d.getHours().toString().padStart(2, '0') + ':' +
        d.getMinutes().toString().padStart(2, '0') + ':' +
        d.getSeconds().toString().padStart(2, '0');
};

const fetchRoadRoute = async (start: [number, number], end: [number, number], token: string) => {
    const response = await fetch(`https://api.mapbox.com/directions/v5/mapbox/driving/${start[0]},${start[1]};${end[0]},${end[1]}?geometries=geojson&access_token=${token}`);
    const data = await response.json();
    return data.routes[0]?.geometry;
};

const updateLogList = (coords: any[], times: any[], speeds: any[]) => {
    const $container = $('#log-container');
    $container.empty();
    const startIdx = Math.max(0, coords.length - 50);
    for (let i = coords.length - 1; i >= startIdx; i--) {
        $container.append(`
            <div class="log-item p-3 rounded-xl bg-gray-50 border border-gray-100" id="log-item-${i}">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-[11px] font-black text-indigo-600">${formatTimeWithSeconds(times[i])}</span>
                    <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-[9px] font-bold">${speeds[i]} KM/H</span>
                </div>
                <div class="text-[9px] text-gray-400 font-mono">COORD: ${coords[i][1].toFixed(5)}, ${coords[i][0].toFixed(5)}</div>
            </div>
        `);
    }
};

const updateMapData = async () => {
    const $el = $('#session-map-data');
    if (!$el.length || !map) return;

    const token = $('meta[name="mapbox-token"]').attr('content') as string;
    const geoJson = JSON.parse($el.attr('data-geojson') || '{}');
    const destData = JSON.parse($el.attr('data-destination') || '{}');

    // Cek ketersediaan Data Driver
    const coords = geoJson.geometry?.coordinates || [];
    const hasDriver = coords.length > 0;

    // 1. Update Jalur Hijau & List Log (Jika ada data driver)
    if (hasDriver) {
        (map.getSource('route') as mapboxgl.GeoJSONSource).setData(geoJson);
        updateLogList(coords, geoJson.properties.times, geoJson.properties.speeds);

        const lastCoord: [number, number] = coords[coords.length - 1];
        if (currentMarker) currentMarker.setLngLat(lastCoord);
    }

    // 2. LOGIKA JALUR MERAH & MARKER TUJUAN
    if (destData.lat && destData.lng) {
        const destCoord: [number, number] = [parseFloat(destData.lng), parseFloat(destData.lat)];

        // Update atau Buat Marker Tujuan
        if (!destinationMarker) {
            const div = document.createElement('div');
            div.innerHTML = `<div class="flex flex-col items-center">
                <div class="tracking-marker-label bg-red-500 text-white px-2 py-1 rounded text-[10px] font-bold mb-1 shadow">${destData.name}</div>
                <div class="w-3 h-3 bg-red-500 border-2 border-white rounded-full"></div>
            </div>`;
            destinationMarker = new mapboxgl.Marker({ element: div, anchor: 'bottom' }).setLngLat(destCoord).addTo(map);
        } else {
            destinationMarker.setLngLat(destCoord);
            // Update Label jika berubah
            const labelEl = destinationMarker.getElement().querySelector('.tracking-marker-label');
            if (labelEl) labelEl.textContent = destData.name;
        }

        // Jalur Merah (Hanya jika ada driver & tujuan)
        if (hasDriver) {
            const lastCoord: [number, number] = coords[coords.length - 1];
            try {
                const roadGeo = await fetchRoadRoute(lastCoord, destCoord, token);
                if (roadGeo) {
                    (map.getSource('to-destination') as mapboxgl.GeoJSONSource).setData({
                        type: 'Feature',
                        geometry: roadGeo,
                        properties: {}
                    });
                }
            } catch (error) {
                console.error("Gagal mengambil rute merah:", error);
            }
        }
    }
};

const initMap = () => {
    const $data = $('#session-map-data');
    if (!$("#session-tracking-map").length || !$data.length || map) return;

    mapboxgl.accessToken = $('meta[name="mapbox-token"]').attr('content') || '';
    const initialGeo = JSON.parse($data.attr('data-geojson') || '{"geometry":{"coordinates":[[0,0]]}}');
    const center = initialGeo.geometry.coordinates[initialGeo.geometry.coordinates.length - 1] || [0, 0];

    map = new mapboxgl.Map({
        container: 'session-tracking-map',
        style: 'mapbox://styles/mapbox/streets-v12',
        center: center,
        zoom: 15,
        attributionControl: false
    });

    hoverPopup = new mapboxgl.Popup({ closeButton: false, closeOnClick: false, offset: 15 });

    map.on('load', () => {
        if (!map) return;
        map.addSource('route', { type: 'geojson', data: initialGeo });
        map.addSource('to-destination', { type: 'geojson', data: { type: 'Feature', geometry: { type: 'LineString', coordinates: [] } } });

        map.addLayer({ id: 'route-line', type: 'line', source: 'route', paint: { 'line-color': '#10b981', 'line-width': 6, 'line-cap': 'round' } });
        map.addLayer({ id: 'to-dest-line', type: 'line', source: 'to-destination', paint: { 'line-color': '#ef4444', 'line-width': 4, 'line-dasharray': [2, 1] } });
        map.addLayer({ id: 'route-sensor', type: 'line', source: 'route', paint: { 'line-color': 'rgba(0,0,0,0)', 'line-width': 30 } });

        map.on('mousemove', 'route-sensor', (e) => {
            if (!e.features?.length) return;
            const props = e.features[0].properties;
            const times = JSON.parse(props.times);
            const activeIdx = times.length - 1;

            hoverPopup?.setLngLat(e.lngLat).setHTML(`<div class="text-center font-bold text-indigo-600">${formatTimeWithSeconds(times[activeIdx])}</div>`).addTo(map!);

            $('.log-item').removeClass('active');
            $(`#log-item-${activeIdx}`).addClass('active')[0]?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });

        map.on('mouseleave', 'route-sensor', () => { hoverPopup?.remove(); $('.log-item').removeClass('active'); });

        const el = document.createElement('div');
        el.className = 'w-4 h-4 bg-blue-600 border-2 border-white rounded-full shadow-lg';
        currentMarker = new mapboxgl.Marker({ element: el }).setLngLat(center).addTo(map);

        updateMapData();
    });
};

$(document).on('livewire:navigated', () => { if (map) { map.remove(); map = null; } initMap(); });
$(window).on('update-session-map', () => map ? updateMapData() : initMap());
