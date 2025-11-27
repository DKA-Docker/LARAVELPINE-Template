import $ from "jquery";
import "moment/locale/id.js"
import { KTAccordion } from "@keenthemes/ktui/src"
import mapboxgl from "mapbox-gl"

const elementExists = $("div.dashboards-apps-deliveries-requests-create");

/** Menunggu Semua Assets Load **/
$(window).on('load', function () {
    if (elementExists.length > 0) {
        KTAccordion.init();

        if ($('#map').length > 0) {
            const MAPBOX_TOKEN = 'pk.eyJ1IjoieW92YW5nZ2EiLCJhIjoiY2tmNXZ3bG0wMHFzMzJxbnkwbmNybXVpaiJ9.cfXmJlhcnmnc-PFtWyFnzA';

            mapboxgl.accessToken = MAPBOX_TOKEN;

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

            // ====== CLICK HANDLER UNTUK AMBIL KOORDINAT + ALAMAT ======
            let currentMarker = null;

            map.on('click', function (e) {
                const lng = e.lngLat.lng;
                const lat = e.lngLat.lat;

                // Debug di console
                console.log('Clicked at:', lng, lat);

                // Hapus marker lama kalau ada
                if (currentMarker) {
                    currentMarker.remove();
                }

                // Pasang marker baru di titik yang diklik
                currentMarker = new mapboxgl.Marker()
                    .setLngLat([lng, lat])
                    .addTo(map);

                // Simpan ke input koordinat
                $('#lat').val(lat);
                $('#lng').val(lng);

                // ====== REVERSE GEOCODING → ALAMAT ======
                const endpoint = `https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json`;
                const params = $.param({
                    access_token: MAPBOX_TOKEN,
                    language: 'id', // biar bahasa Indonesia
                    limit: 1
                });

                fetch(`${endpoint}?${params}`)
                    .then(res => res.json())
                    .then(data => {
                        const feature = data && data.features && data.features[0] ? data.features[0] : null;
                        const address = feature ? feature.place_name : '';

                        console.log('Alamat:', address);

                        // Isi ke input alamat (SESUIKAN selector kalau beda)
                        $('#address').val(address);
                        // atau:
                        // $('textarea[name="address"]').val(address);
                    })
                    .catch(err => {
                        console.error('Gagal reverse geocode:', err);
                    });
            });
        }
    }

});
