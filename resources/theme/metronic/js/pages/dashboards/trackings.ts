import mapboxgl from "mapbox-gl";
import $ from "jquery";
import axios from "axios";
import URI from "urijs";

const elementExists = $("div.dashboards-apps-trackings");

$(window).on('load', async function () {
    if (elementExists.length === 0 || $('#map').length === 0) return;

    mapboxgl.accessToken = 'pk.eyJ1IjoieW92YW5nZ2EiLCJhIjoiY2tmNXZ3bG0wMHFzMzJxbnkwbmNybXVpaiJ9.cfXmJlhcnmnc-PFtWyFnzA';

    const map = new mapboxgl.Map({
        container: "map",
        style: 'mapbox://styles/mapbox/standard',
        projection: 'globe',
        zoom: 12,
        center: [119.4365, -5.1477],
    });

    map.addControl(new mapboxgl.NavigationControl(), 'top-right');

    const geolocate = new mapboxgl.GeolocateControl({
        positionOptions: { enableHighAccuracy: true },
        trackUserLocation: true,
        showUserHeading: true,
    });
    map.addControl(geolocate, 'top-right');

    const markers: Record<string, { marker: mapboxgl.Marker; popup: mapboxgl.Popup }> = {};

    async function fetchTracking() {
        try {
            // Ambil URL JS ini dimuat
            const FullUriCurrentURL = URI(window.location);

            // Segment URL, tambah 'api' di depan
            const segs = FullUriCurrentURL.segment();
            segs.unshift('api');
            FullUriCurrentURL.segment([...segs, 'monitors']);

            const res = await axios.get(FullUriCurrentURL.toString());
            const drivers = res.data.data;

            // Ambil data terakhir per uuid
            const latestPerUuid: Record<string, any> = {};
            drivers.forEach(d => {
                if (!latestPerUuid[d.uuid] || new Date(d.created_at) > new Date(latestPerUuid[d.uuid].created_at)) {
                    latestPerUuid[d.uuid] = d;
                }
            });

            // Sync markers: tambah/update
            Object.values(latestPerUuid).forEach((driver: any) => {
                const coord = [driver.longitude, driver.latitude];

                if (!markers[driver.uuid]) {
                    // Buat marker baru
                    const el = document.createElement('div');
                    el.className = 'driver-marker';
                    el.style.display = 'flex';
                    el.style.alignItems = 'center';
                    el.style.justifyContent = 'center';
                    el.style.fontSize = '28px';
                    el.style.cursor = 'pointer';
                    el.style.transform = 'translate(-50%, -50%)';
                    el.textContent = '🧑';

                    const popup = new mapboxgl.Popup({ offset: 25 }).setHTML(`
                        <div style="font-size:12px;">
                            <div><strong>${driver.uuid}</strong></div>
                            <div>Lon: ${driver.longitude.toFixed(4)}, Lat: ${driver.latitude.toFixed(4)}</div>
                            <div>Speed: ${driver.speed} km/h</div>
                        </div>
                    `);

                    const marker = new mapboxgl.Marker(el).setLngLat(coord as any).setPopup(popup).addTo(map);

                    markers[driver.uuid] = { marker, popup };
                } else {
                    // Update posisi marker
                    markers[driver.uuid].marker.setLngLat(coord as any);
                    markers[driver.uuid].popup.setHTML(`
                        <div style="font-size:12px;">
                            <div><strong>${driver.uuid}</strong></div>
                            <div>Lon: ${driver.longitude.toFixed(4)}, Lat: ${driver.latitude.toFixed(4)}</div>
                            <div>Speed: ${driver.speed} km/h</div>
                        </div>
                    `);
                }
            });

            // Hapus marker yang tidak ada di data terbaru
            Object.keys(markers).forEach(uuid => {
                if (!latestPerUuid[uuid]) {
                    markers[uuid].marker.remove();
                    delete markers[uuid];
                }
            });

        } catch (error) {
            console.error("Gagal load tracking:", error);
        }
    }

    // Initial fetch
    await fetchTracking();

    // Update tiap 1 detik
    setInterval(fetchTracking, 1000);

    window.addEventListener('resize', () => map.resize());
});
