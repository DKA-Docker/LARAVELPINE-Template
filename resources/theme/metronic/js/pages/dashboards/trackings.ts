import mapboxgl from "mapbox-gl";
import $ from "jquery";
import axios from "axios";
import URI from "urijs";
import moment from "moment";
import PerfectScrollbar from "perfect-scrollbar";
import "perfect-scrollbar/css/perfect-scrollbar.css";

const elementExists = $("div.dashboards-apps-trackings");

$(window).on('load', async function () {
    if (elementExists.length === 0 || $('#map').length === 0) return;

    // --- CSS Injector untuk memastikan hanya 1 container putih dan menambahkan panah ---
    const style = document.createElement('style');
    style.textContent = `
        /* Menghapus container default Mapbox (agar tidak ada kotak putih ganda) */
        .driver-info-popup.mapboxgl-popup .mapboxgl-popup-content {
            padding: 0;
            background: none; /* Transparan */
            box-shadow: none; /* Bayangan dikontrol oleh popupContainer kustom */
            border-radius: 0;
        }
        /* Mengembalikan Panah (Tip) Mapbox bawaan */
        /* Kita hanya perlu menargetkan warna latar belakang (border-top-color) */
        .driver-info-popup.mapboxgl-popup .mapboxgl-popup-tip {
            /* Hapus "border: none;" yang sebelumnya ada di sini */
            /* Kita ingin panah muncul, jadi kita set warna panah menjadi putih */
            border-top-color: #fff !important;
        }
    `;
    document.head.appendChild(style);
    // ----------------------------------------------------------------------

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
            const FullUriCurrentURL = URI(window.location);
            const segs = FullUriCurrentURL.segment();
            segs.unshift('api');
            FullUriCurrentURL.segment([...segs, 'monitors']);
            const res = await axios.get(FullUriCurrentURL.toString());
            const drivers = res.data.data;

            const latestPerUuid: Record<string, any> = {};
            drivers.forEach(d => {
                if (!latestPerUuid[d.uuid] || new Date(d.created_at) > new Date(latestPerUuid[d.uuid].created_at)) {
                    latestPerUuid[d.uuid] = d;
                }
            });

            const BUTTON_SIZE = 30;

            Object.values(latestPerUuid).forEach((driver: any) => {
                const coord = [driver.longitude, driver.latitude];
                const lastUpdate = moment(driver.created_at).format('HH:mm:ss DD MMMM YYYY');

                // --- LOGIKA KECEPATAN ---
                let speedDisplay;
                const speedKmH = parseFloat(driver.speed);

                if (speedKmH >= 1) {
                    speedDisplay = `${speedKmH.toFixed(2)} km/h`;
                } else {
                    const speedMH = speedKmH * 1000;
                    speedDisplay = `${speedMH.toFixed(0)} m/h`;
                }
                // -----------------------------

                // Container popup KUSTOM
                const popupContainer = document.createElement('div');
                popupContainer.style.fontSize = '13px';
                popupContainer.style.minWidth = '280px';
                popupContainer.style.padding = '10px';
                popupContainer.style.background = '#fff';
                popupContainer.style.borderRadius = '8px';
                popupContainer.style.boxShadow = '0 2px 8px rgba(0,0,0,0.2)';
                popupContainer.style.position = 'relative';
                popupContainer.style.overflow = 'visible';

                // Tombol close custom (BULAT dan DI LUAR KOTAK)
                const closeBtn = document.createElement('button');
                closeBtn.innerHTML = '<span style="font-size: 16px; line-height: 1;">&times;</span>';

                closeBtn.style.position = 'absolute';
                closeBtn.style.top = `${-BUTTON_SIZE / 2}px`;
                closeBtn.style.right = `${-BUTTON_SIZE / 2}px`;

                closeBtn.style.background = 'red';
                closeBtn.style.color = 'white';
                closeBtn.style.border = 'none';
                closeBtn.style.borderRadius = '50%';
                closeBtn.style.width = `${BUTTON_SIZE}px`;
                closeBtn.style.height = `${BUTTON_SIZE}px`;
                closeBtn.style.cursor = 'pointer';
                closeBtn.style.padding = '0';
                closeBtn.style.display = 'flex';
                closeBtn.style.alignItems = 'center';
                closeBtn.style.justifyContent = 'center';
                closeBtn.style.boxShadow = '0 2px 4px rgba(0,0,0,0.3)';

                closeBtn.addEventListener('click', () => {
                    if (markers[driver.uuid] && markers[driver.uuid].popup.isOpen()) {
                        markers[driver.uuid].popup.remove();
                    }
                });

                // Konten 2 kolom
                const content = document.createElement('div');
                content.style.display = 'flex';
                content.style.flexDirection = 'column';
                content.style.gap = '4px';
                content.style.maxHeight = '160px';
                content.style.overflowY = 'auto';
                content.style.paddingTop = '5px';
                content.style.paddingRight = '5px';

                const fields = [
                    { label: 'Driver', value: driver.uuid },
                    { label: 'Longitude', value: driver.longitude.toFixed(4) },
                    { label: 'Latitude', value: driver.latitude.toFixed(4) },
                    { label: 'Speed', value: speedDisplay },
                    { label: 'Last Update', value: lastUpdate },
                ];

                fields.forEach(f => {
                    const row = document.createElement('div');
                    row.style.display = 'flex';
                    row.style.justifyContent = 'space-between';
                    row.style.padding = '2px 0';
                    row.style.borderBottom = '1px solid #eee';

                    const label = document.createElement('span');
                    label.style.fontWeight = 'bold';
                    label.textContent = f.label;

                    const value = document.createElement('span');
                    value.textContent = f.value;
                    value.style.textAlign = 'right';
                    value.style.flex = '1';
                    value.style.marginLeft = '8px';
                    value.style.wordBreak = 'break-all';

                    row.appendChild(label);
                    row.appendChild(value);
                    content.appendChild(row);
                });

                popupContainer.appendChild(closeBtn);
                popupContainer.appendChild(content);

                new PerfectScrollbar(content, { wheelPropagation: false });

                // Inisialisasi Popup Mapbox
                let popup = new mapboxgl.Popup({
                    offset: 25,
                    closeButton: false,
                    closeOnClick: false,
                    className: 'driver-info-popup'
                }).setDOMContent(popupContainer);


                if (!markers[driver.uuid]) {
                    const el = document.createElement('div');
                    el.className = 'driver-marker';
                    el.style.display = 'flex';
                    el.style.alignItems = 'center';
                    el.style.justifyContent = 'center';
                    el.style.fontSize = '32px';
                    el.style.cursor = 'pointer';
                    el.style.transform = 'translate(-50%, -50%)';
                    el.innerHTML = '🚗';

                    const marker = new mapboxgl.Marker(el)
                        .setLngLat(coord as any)
                        .setPopup(popup)
                        .addTo(map);

                    markers[driver.uuid] = { marker, popup };
                } else {
                    markers[driver.uuid].marker.setLngLat(coord as any);
                    markers[driver.uuid].popup.setDOMContent(popupContainer);
                }
            });

            // Hapus marker yang tidak ada
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

    await fetchTracking();
    setInterval(fetchTracking, 1000);
    window.addEventListener('resize', () => map.resize());
});
