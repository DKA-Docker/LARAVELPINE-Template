import $ from "jquery";
import "moment/locale/id.js";
import { KTAccordion } from "@keenthemes/ktui/src";
import mapboxgl from "mapbox-gl";

const elementExists = $("div.dashboards-apps-deliveries-requests-create");

const MAPBOX_TOKEN =
    "pk.eyJ1IjoieW92YW5nZ2EiLCJhIjoiY2tmNXZ3bG0wMHFzMzJxbnkwbmNybXVpaiJ9.cfXmJlhcnmnc-PFtWyFnzA";
mapboxgl.accessToken = MAPBOX_TOKEN;

// simpan instance biar nggak double init
const mapInstances = {};

/**
 * Bersihkan semua map lama (dipanggil setiap Livewire update).
 * Biar nggak nyangkut ke DOM lama yang sudah dibuang.
 */
function resetMapsRegistry() {
    Object.keys(mapInstances).forEach((id) => {
        const map = mapInstances[id];
        if (map && typeof map.remove === "function") {
            map.remove();
        }
        delete mapInstances[id];
    });
}

/**
 * Init map untuk semua elemen yang punya data-map-index
 * tapi belum pernah di-init di registry.
 */
function initAllItemMaps() {
    // kalau container dashboard-nya aja nggak ada, ya udah
    if (!elementExists.length) return;

    $("[data-map-index]").each(function () {
        const el = this as HTMLElement;
        const id = el.id; // contoh: "map-0"
        if (!id) return;

        // kalau sudah pernah dibuat untuk id ini (setelah reset), skip
        if (mapInstances[id]) return;

        const index = $(el).data("map-index"); // 0, 1, 2, ...

        // ambil input yang sesuai index-nya pakai jQuery
        const $addressInput = $(`#address-${index}`);
        const $latInput = $(`#lat-${index}`);
        const $lngInput = $(`#lng-${index}`);

        if (!$addressInput.length || !$latInput.length || !$lngInput.length) {
            console.warn("Input address/lat/lng belum ketemu untuk index", index);
        }

        // 🔥 BACA KOORDINAT YANG SUDAH ADA DARI INPUT
        const rawLat = ($latInput.val() as string) ?? "";
        const rawLng = ($lngInput.val() as string) ?? "";

        const existingLat = parseFloat(rawLat);
        const existingLng = parseFloat(rawLng);

        let center: [number, number] = [119.4365, -5.1477]; // default Makassar
        let zoom = 12;
        let hasExisting = false;

        if (!Number.isNaN(existingLat) && !Number.isNaN(existingLng)) {
            center = [existingLng, existingLat]; // mapbox = [lng, lat]
            zoom = 15;
            hasExisting = true;
        }

        // buat map baru
        const map = new mapboxgl.Map({
            container: el,
            style: "mapbox://styles/mapbox/standard",
            projection: "globe",
            zoom,
            center,
        });

        // simpan di registry
        mapInstances[id] = map;

        // kontrol dasar
        map.addControl(new mapboxgl.NavigationControl(), "top-right");
        const geolocate = new mapboxgl.GeolocateControl({
            positionOptions: { enableHighAccuracy: true },
            trackUserLocation: true,
            showUserHeading: true,
        });
        map.addControl(geolocate, "top-right");

        let currentMarker: mapboxgl.Marker | null = null;

        // 🔥 KALAU SUDAH ADA KOORDINAT → PASANG MARKER DARI AWAL
        if (hasExisting) {
            currentMarker = new mapboxgl.Marker().setLngLat(center).addTo(map);
        }

        // penting buat container yang pakai grid/accordion
        map.on("load", () => {
            map.resize();
        });

        // click: update marker + input + reverse geocode
        map.on("click", function (e) {
            const lng = e.lngLat.lng;
            const lat = e.lngLat.lat;

            if (currentMarker) {
                currentMarker.remove();
            }

            currentMarker = new mapboxgl.Marker().setLngLat([lng, lat]).addTo(map);

            // pakai jQuery.val() + trigger('input') biar Livewire kebaca
            if ($latInput.length) {
                $latInput.val(lat).trigger("input");
            }
            if ($lngInput.length) {
                $lngInput.val(lng).trigger("input");
            }

            // reverse geocoding
            const endpoint = `https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json`;
            const params = $.param({
                access_token: MAPBOX_TOKEN,
                language: "id",
                limit: 1,
            });

            fetch(`${endpoint}?${params}`)
                .then((res) => res.json())
                .then((data) => {
                    const feature =
                        data && data.features && data.features[0] ? data.features[0] : null;
                    const address = feature ? feature.place_name : "";

                    console.log(`Index ${index} alamat:`, address);

                    if ($addressInput.length) {
                        $addressInput.val(address).trigger("input");
                    }
                })
                .catch((err) => {
                    console.error("Gagal reverse geocode:", err);
                });
        });
    });
}


function resizeMapsInContent(contentEl: HTMLElement) {
    $(contentEl)
        .find("[data-map-index]")
        .each(function () {
            const id = (this as HTMLElement).id;
            if (!id) return;
            const map = mapInstances[id];
            if (map && typeof map.resize === "function") {
                map.resize();
            }
        });
}

/** Menunggu Semua Assets Load **/
$(window).on("load", function () {
    if (!elementExists.length) return;
    KTAccordion.init();
    // init pertama kali (item index 0)
    initAllItemMaps();
});

$(document).on("click", ".kt-accordion-toggle", function () {
    const $toggle = $(this);
    const targetSelector = $toggle.data("kt-accordion-toggle"); // contoh: "#accordion-content-0"
    if (!targetSelector) return;

    const contentEl = document.querySelector(targetSelector as string) as HTMLElement | null;
    if (!contentEl) return;

    // kasih delay kecil biar transition show/hide selesai dulu
    setTimeout(() => {
        resizeMapsInContent(contentEl);
    }, 250);
});

// Listen browser event dari Livewire (v2/v3) -> "packages-items-updated"
window.addEventListener("packages-items-updated", () => {
    // kasih sedikit delay biar DOM hasil morph Livewire sudah siap
    setTimeout(() => {
        // hapus map lama & re-init berdasarkan DOM baru
        resetMapsRegistry();
        initAllItemMaps();
        KTAccordion.init(); // kalau accordion perlu re-init juga
    }, 50);
});
