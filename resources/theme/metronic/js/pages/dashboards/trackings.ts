import mapboxgl from "mapbox-gl";
import $ from "jquery";

$(window).on('load', function () {

    if ($('#map').length > 0) {
        mapboxgl.accessToken = 'pk.eyJ1IjoieW92YW5nZ2EiLCJhIjoiY2tmNXZ3bG0wMHFzMzJxbnkwbmNybXVpaiJ9.cfXmJlhcnmnc-PFtWyFnzA';
        const map = new mapboxgl.Map({
            container: "map",
            style: 'mapbox://styles/mapbox/standard',
            projection: 'globe',
            zoom: 12,
            center: [119.4365, -5.1477], // Makassar center
        });
        // Kontrol dasar
        map.addControl(new mapboxgl.NavigationControl(), 'top-right');
        const geolocate = new mapboxgl.GeolocateControl({
            positionOptions: { enableHighAccuracy: true },
            trackUserLocation: true,
            showUserHeading: true,
        });
        map.addControl(geolocate, 'top-right');
        // =======================
        // DEMO CONFIG
        // =======================
        const DEMO_CONFIG = {
            enabled: true,          // set false kalau mau matikan semua demo
            withTracking: true,     // set false kalau mau mobil diam di posisi awal
            intervalMs: 2000,       // perpindahan tiap 2 detik
        };
        // =======================
        // DEMO ROUTES (Makassar)
        // =======================
        // Ini rough route yang kira-kira ngikut jalan utama di Makassar.
        // Bukan 100% akurat, tapi cukup kelihatan "nyusur jalan".
        const demoRoutes = [
            {
                id: 'DRV-001',
                name: 'Driver A',
                status: 'On Duty',
                route: [
                    // Sekitar Pantai Losari → Jl Penghibur → Jl Riburane
                    [119.4085, -5.1415],
                    [119.4105, -5.1420],
                    [119.4130, -5.1425],
                    [119.4160, -5.1430],
                    [119.4185, -5.1435],
                    [119.4210, -5.1440],
                    [119.4235, -5.1445],
                    [119.4260, -5.1450],
                ],
            },
            {
                id: 'DRV-002',
                name: 'Driver B',
                status: 'Delivering',
                route: [
                    // Panakkukang Mall area keliling sedikit
                    [119.4480, -5.1530],
                    [119.4495, -5.1515],
                    [119.4510, -5.1505],
                    [119.4525, -5.1495],
                    [119.4540, -5.1490],
                    [119.4525, -5.1505],
                    [119.4510, -5.1520],
                    [119.4495, -5.1530],
                ],
            },
            {
                id: 'DRV-003',
                name: 'Driver C',
                status: 'Idle',
                route: [
                    // Rappocini area
                    [119.4240, -5.1780],
                    [119.4255, -5.1770],
                    [119.4270, -5.1760],
                    [119.4285, -5.1750],
                    [119.4300, -5.1745],
                    [119.4285, -5.1755],
                    [119.4270, -5.1765],
                    [119.4255, -5.1775],
                ],
            },
            {
                id: 'DRV-004',
                name: 'Driver D',
                status: 'On Duty',
                route: [
                    // Tamalanrea / Biringkanaya arah bandara
                    [119.4920, -5.1340],
                    [119.4940, -5.1285],
                    [119.4960, -5.1230],
                    [119.4980, -5.1175],
                    [119.5000, -5.1120],
                    [119.5020, -5.1070],
                    [119.5040, -5.1030],
                    [119.5060, -5.0995],
                ],
            },
        ];
        let demoDriverState = [];   // [{ meta, marker, routeIndex }]
        let demoTrackingTimer = null;
        // =======================
        // MAP LOAD
        // =======================
        map.on('load', () => {
            map.setFog({});

            // Fit ke semua titik dari semua route
            const allCoords = demoRoutes.flatMap(d => d.route);
            const [minX, minY, maxX, maxY] = allCoords.reduce(
                (acc, [lng, lat]) => [
                    Math.min(acc[0], lng),
                    Math.min(acc[1], lat),
                    Math.max(acc[2], lng),
                    Math.max(acc[3], lat),
                ],
                [Infinity, Infinity, -Infinity, -Infinity],
            );

            map.fitBounds(
                [
                    [minX, minY],
                    [maxX, maxY],
                ],
                { padding: 80 },
            );

            // Init demo (bisa diatur via DEMO_CONFIG)
            initDemoDrivers({
                enabled: DEMO_CONFIG.enabled,
                withTracking: DEMO_CONFIG.withTracking,
            });
        });

        window.addEventListener('resize', () => map.resize());
        // =======================
        // DEMO DRIVER FUNCTION
        // =======================
        function initDemoDrivers(options = { enabled : false, withTracking: false }) {
            const enabled = options.enabled ?? true;
            const withTracking = options.withTracking ?? true;

            // Bersihkan tracking interval lama
            if (demoTrackingTimer) {
                clearInterval(demoTrackingTimer);
                demoTrackingTimer = null;
            }

            // Hapus semua marker lama
            if (demoDriverState.length) {
                demoDriverState.forEach(d => d.marker.remove());
                demoDriverState = [];
            }

            // Kalau disabled, cukup berhenti di sini
            if (!enabled) return;

            // Buat marker baru dari route[0] tiap driver
            demoDriverState = demoRoutes.map((driver : any) => {
                const startCoord = driver.route[0];

                const el = document.createElement('div');
                el.className = 'driver-marker';
                el.style.display = 'flex';
                el.style.alignItems = 'center';
                el.style.justifyContent = 'center';
                el.style.fontSize = '40px';
                el.style.cursor = 'pointer';
                el.style.transform = 'translate(-50%, -50%)';
                el.textContent = '🚗';

                const marker = new mapboxgl.Marker(el)
                    .setLngLat(startCoord)
                    .setPopup(
                        new mapboxgl.Popup({ offset: 25 }).setHTML(makePopupHtml(driver, startCoord)),
                    )
                    .addTo(map);

                return {
                    meta: { ...driver },
                    marker,
                    routeIndex: 0,
                };
            });

            if (!withTracking) return;

            // =============== FAKE TRACKING SESUAI ROUTE ===============
            demoTrackingTimer = window.setInterval(() => {
                demoDriverState = demoDriverState.map((state) => {
                    const route = state.meta.route;
                    if (!route || route.length === 0) return state;

                    // next index (loop)
                    const nextIndex = (state.routeIndex + 1) % route.length;
                    const nextCoord = route[nextIndex];

                    state.routeIndex = nextIndex;
                    state.marker.setLngLat(nextCoord);

                    // update popup content biar lon/lat ikut berubah
                    state.marker.getPopup()?.setHTML(
                        makePopupHtml(state.meta, nextCoord),
                    );

                    return state;
                });
            }, DEMO_CONFIG.intervalMs);
        }
        // Helper popup html
        function makePopupHtml(driver, coord) {
            const [lng, lat] = coord;
            return `
        <div style="font-size:12px;">
            <div><strong>${driver.name}</strong> (${driver.id})</div>
            <div>Status: ${driver.status}</div>
            <div>Lon: ${lng.toFixed(4)}, Lat: ${lat.toFixed(4)}</div>
        </div>
    `;
        }
    }
})
