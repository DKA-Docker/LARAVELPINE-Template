import $ from "jquery";
import "moment/locale/id.js";
import { KTAccordion } from "@keenthemes/ktui/src";
import mapboxgl from "mapbox-gl";

const elementExists = $("div.dashboards-apps-deliveries-tasks-create");

const MAPBOX_TOKEN =
"pk.eyJ1IjoieW92YW5nZ2EiLCJhIjoiY2tmNXZ3bG0wMHFzMzJxbnkwbmNybXVpaiJ9.cfXmJlhcnmnc-PFtWyFnzA";
mapboxgl.accessToken = MAPBOX_TOKEN;

/**
* mapInstances
* - map instance per ID container (misal: map-0, map-1)
* - marker sekarang
* - index item
* - reference ke input address/lat/lng
*/
const mapInstances: {
[id: string]: {
map: mapboxgl.Map;
marker: mapboxgl.Marker | null;
index: number;
$address: JQuery<HTMLElement>;
    $lat: JQuery<HTMLElement>;
        $lng: JQuery<HTMLElement>;
            };
            } = {};

            /**
            * Bersihkan semua map lama (dipanggil setiap Livewire update).
            * Biar nggak nyangkut ke DOM lama yang sudah dibuang.
            */
            function resetMapsRegistry() {
            Object.keys(mapInstances).forEach((id) => {
            const ctx = mapInstances[id];
            if (ctx && ctx.map && typeof ctx.map.remove === "function") {
            ctx.map.remove();
            }
            delete mapInstances[id];
            });
            }

            /**
            * Helper: bikin / dapetin container dropdown autocomplete
            * di bawah input address-{index}.
            */
            function getAddressDropdown(index: number, $addressInput: JQuery<HTMLElement>) {
                let $dropdown = $(`#address-suggest-${index}`);
                if (!$dropdown.length) {
                $dropdown = $("<div/>", {
                id: `address-suggest-${index}`,
                class:
                "absolute z-50 mt-1 bg-white border border-gray-200 rounded shadow max-h-60 overflow-y-auto text-sm w-full",
                });

                const parent = $addressInput.parent();
                if (!parent.hasClass("relative")) {
                parent.css("position", "relative");
                }

                $addressInput.after($dropdown);

                // blokir bubbling ke header accordion dari area dropdown
                $dropdown.on("mousedown click", (e) => {
                e.preventDefault();
                e.stopPropagation();
                });
                }
                return $dropdown;
                }

                /**
                * Helper: sembunyikan dropdown autocomplete
                */
                function hideAddressDropdown(index: number) {
                const $dropdown = $(`#address-suggest-${index}`);
                if ($dropdown.length) {
                $dropdown.empty().hide();
                }
                }

                /**
                * Setup autocomplete Mapbox untuk satu item (per index).
                * - Listen input di address-{index}
                * - Call forward geocoding Mapbox
                * - Tampilkan suggestion di dropdown
                * - Klik suggestion -> set marker + lat/lng + map.flyTo
                */
                function setupAddressAutocomplete(
                id: string,
                ctx: {
                map: mapboxgl.Map;
                marker: mapboxgl.Marker | null;
                index: number;
                $address: JQuery<HTMLElement>;
                    $lat: JQuery<HTMLElement>;
                        $lng: JQuery<HTMLElement>;
                            }
                            ) {
                            const { map, index, $address, $lat, $lng } = ctx;

                            // matikan autocomplete browser biar nggak bentrok
                            $address.attr("autocomplete", "off");

                            // klik di input jangan dianggap klik accordion header
                            $address.on("mousedown", (e) => {
                            e.stopPropagation();
                            });

                            let typingTimer: number | undefined;

                            $address.off("input.map-autocomplete").on("input.map-autocomplete", function () {
                            const query = ($(this).val() as string) ?? "";

                            if (typingTimer) {
                            window.clearTimeout(typingTimer);
                            }

                            if (!query || query.trim().length < 3) {
                            hideAddressDropdown(index);
                            return;
                            }

                            typingTimer = window.setTimeout(() => {
                            const endpoint = `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(
                            query
                            )}.json`;

                            const params = $.param({
                            access_token: MAPBOX_TOKEN,
                            autocomplete: true,
                            language: "id",
                            limit: 5,
                            });

                            fetch(`${endpoint}?${params}`)
                            .then((res) => res.json())
                            .then((data) => {
                            const features = data && data.features ? data.features : [];

                            if (!features.length) {
                            hideAddressDropdown(index);
                            return;
                            }

                            const $dropdown = getAddressDropdown(index, $address);
                            $dropdown.empty().show();

                            features.forEach((feature: any) => {
                            const placeName = feature.place_name || "";
                            const center = feature.center || []; // [lng, lat]

                            const $item = $("<div/>", {
                            class:
                            "px-3 py-2 hover:bg-gray-100 cursor-pointer text-gray-800 text-xs lg:text-sm",
                            text: placeName,
                            });

                            // klik suggestion: jangan bubble ke header
                            $item.on("mousedown click", (e) => {
                            e.preventDefault();
                            e.stopPropagation();

                            const lng = center[0];
                            const lat = center[1];

                            if (typeof lng === "number" && typeof lat === "number") {
                            // update input
                            $lat.val(lat).trigger("input");
                            $lng.val(lng).trigger("input");
                            $address.val(placeName).trigger("input");

                            const currentCtx = mapInstances[id];
                            const currentMarker = currentCtx ? currentCtx.marker : null;

                            if (currentMarker) {
                            currentMarker.remove();
                            }

                            const newMarker = new mapboxgl.Marker()
                            .setLngLat([lng, lat])
                            .addTo(map);

                            if (currentCtx) {
                            currentCtx.marker = newMarker;
                            }

                            map.flyTo({
                            center: [lng, lat],
                            zoom: 15,
                            });
                            }

                            hideAddressDropdown(index);
                            });

                            $dropdown.append($item);
                            });
                            })
                            .catch((err) => {
                            console.error("Gagal forward geocode (autocomplete):", err);
                            hideAddressDropdown(index);
                            });
                            }, 400); // debounce ~400ms
                            });

                            // klik di luar (dimanapun di dokumen) -> tutup dropdown
                            $(document)
                            .off(`click.map-autocomplete-${index}`)
                            .on(`click.map-autocomplete-${index}`, function (e) {
                            const target = e.target as unknown as HTMLElement;
                            const dropdown = $(`#address-suggest-${index}`);
                            const isInsideDropdown =
                            dropdown.length && ($(target).is(dropdown) || $.contains(dropdown[0], target));
                            const isInsideInput =
                            $(target).is($address) || $.contains($address.parent()[0], target);

                            if (!isInsideDropdown && !isInsideInput) {
                            hideAddressDropdown(index);
                            }
                            });

                            // ESC buat nutup dropdown juga (optional nice UX)
                            $(document)
                            .off(`keydown.map-autocomplete-${index}`)
                            .on(`keydown.map-autocomplete-${index}`, function (e) {
                            if ((e).key === "Escape") {
                            hideAddressDropdown(index);
                            }
                            });
                            }

                            /**
                            * Init map untuk semua elemen yang punya data-map-index
                            * tapi belum pernah di-init di registry.
                            */
                            function initAllItemMaps() {
                            if (!elementExists.length) return;

                            $("[data-map-index]").each(function () {
                            const el = this as HTMLElement;
                            const id = el.id; // contoh: "map-0"
                            if (!id) return;

                            // kalau sudah pernah dibuat untuk id ini (setelah reset), skip
                            if (mapInstances[id]) return;

                            const index = $(el).data("map-index") as number; // 0, 1, 2, ...

                            // ambil input yang sesuai index-nya pakai jQuery
                            const $addressInput = $(`#address-${index}`);
                            const $latInput = $(`#lat-${index}`);
                            const $lngInput = $(`#lng-${index}`);

                            if (!$addressInput.length || !$latInput.length || !$lngInput.length) {
                            console.warn("Input address/lat/lng belum ketemu untuk index", index);
                            }

                            // BACA KOORDINAT YANG SUDAH ADA DARI INPUT
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

                            let currentMarker: mapboxgl.Marker | null = null;

                            // KALAU SUDAH ADA KOORDINAT → PASANG MARKER DARI AWAL
                            if (hasExisting) {
                            currentMarker = new mapboxgl.Marker().setLngLat(center).addTo(map);
                            }

                            // simpan di registry
                            mapInstances[id] = {
                            map,
                            marker: currentMarker,
                            index,
                            $address: $addressInput,
                            $lat: $latInput,
                            $lng: $lngInput,
                            };

                            // kontrol dasar
                            map.addControl(new mapboxgl.NavigationControl(), "top-right");
                            const geolocate = new mapboxgl.GeolocateControl({
                            positionOptions: { enableHighAccuracy: true },
                            trackUserLocation: true,
                            showUserHeading: true,
                            });
                            map.addControl(geolocate, "top-right");

                            // penting buat container yang pakai grid/accordion
                            map.on("load", () => {
                            map.resize();
                            });

                            // click: update marker + input + reverse geocode
                            map.on("click", function (e) {
                            const lng = e.lngLat.lng;
                            const lat = e.lngLat.lat;

                            const ctx = mapInstances[id];
                            const marker = ctx ? ctx.marker : null;

                            if (marker) {
                            marker.remove();
                            }

                            const newMarker = new mapboxgl.Marker().setLngLat([lng, lat]).addTo(map);

                            if (ctx) {
                            ctx.marker = newMarker;
                            }

                            if ($latInput.length) {
                            $latInput.val(lat).trigger("input");
                            }
                            if ($lngInput.length) {
                            $lngInput.val(lng).trigger("input");
                            }

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

                            if ($addressInput.length) {
                            $addressInput.val(address).trigger("input");
                            }
                            })
                            .catch((err) => {
                            console.error("Gagal reverse geocode:", err);
                            });
                            });

                            // setup autocomplete address <-> map
                            setupAddressAutocomplete(id, mapInstances[id]);
                            });
                            }

                            function resizeMapsInContent(contentEl: HTMLElement) {
                            $(contentEl)
                            .find("[data-map-index]")
                            .each(function () {
                            const id = (this as HTMLElement).id;
                            if (!id) return;
                            const ctx = mapInstances[id];
                            const map = ctx ? ctx.map : null;
                            if (map && typeof map.resize === "function") {
                            map.resize();
                            }
                            });
                            }

                            /** Menunggu Semua Assets Load **/
                            $(window).on("load", function () {
                            if (!elementExists.length) return;
                            KTAccordion.init();
                            initItemTitleWatcher();
                            initAllItemMaps();
                            syncAllItemTitles();
                            });

                            $(document).on("click", ".kt-accordion-toggle", function () {
                            const $toggle = $(this);
                            const targetSelector = $toggle.data("kt-accordion-toggle"); // contoh: "#accordion-content-0"
                            if (!targetSelector) return;

                            const contentEl = document.querySelector(targetSelector as string) as HTMLElement | null;
                            if (!contentEl) return;

                            setTimeout(() => {
                            resizeMapsInContent(contentEl);
                            }, 250);
                            });

                            // Sinkronkan judul accordion dengan input nama paket
                            // Rebuild teks judul untuk satu item accordion
                            function recomputeItemTitle(index: number) {
                            const $titleText = $(`#item-title-${index} .item-title-text`);
                            if (!$titleText.length) return;

                            const name = String($(`#item-name-${index}`).val() ?? "").trim();
                            const address = String($(`#address-${index}`).val() ?? "").trim();

                            const $qtyInput = $(`input[data-item-index="${index}"][data-title-field="qty"]`);
                            const $unitInput = $(`input[data-item-index="${index}"][data-title-field="unit"]`);

                            const qty = String($qtyInput.val() ?? "").trim();
                            const unit = String($unitInput.val() ?? "").trim();

                            const parts: string[] = [];

                            // Nama (wajib, ada fallback)
                            parts.push(name.length ? name : "Tanpa Judul");

                            // Qty + Unit (opsional)
                            if (qty.length || unit.length) {
                            const label = `${qty || ""} ${unit || "unit"}`.trim();
                            if (label.length) {
                            parts.push(label);
                            }
                            }

                            // Address (opsional)
                            if (address.length) {
                            parts.push(`dikirim ke ${address}`);
                            }



                            // Gabung: "Nama - Alamat - 1 unit"
                            $titleText.text(parts.join(" - "));
                            }

                            // Listen semua input yang mempengaruhi judul
                            function initItemTitleWatcher() {
                            if (!elementExists.length) return;

                            // bersihin handler lama biar nggak dobel
                            $(document).off("input.item-title-sync");

                            $(document).on(
                            "input.item-title-sync",
                            'input[data-item-index][data-title-field]',
                            function () {
                            const $input = $(this);
                            const index = $input.data("item-index");

                            recomputeItemTitle(index);
                            }
                            );
                            }

                            // Sync semua judul item berdasarkan nilai input yang ada di DOM
                            function syncAllItemTitles() {
                            if (!elementExists.length) return;
                            // cari semua title yang ada id-nya item-title-{index}
                            $('[id^="item-title-"]').each(function () {
                            const id = $(this).attr("id"); // contoh: item-title-0
                            if (!id) return;

                            const match = id.match(/^item-title-(\d+)$/);
                            if (!match) return;

                            const index = parseInt(match[1], 10);
                            if (Number.isNaN(index)) return;

                            recomputeItemTitle(index);
                            });
                            }

                            // Listen browser event dari Livewire (v2/v3) -> "packages-items-updated"
                            window.addEventListener("packages-items-updated", () => {
                            setTimeout(() => {
                            resetMapsRegistry();
                            initAllItemMaps();
                            initItemTitleWatcher();
                            syncAllItemTitles();
                            KTAccordion.init();
                            }, 50);
                            });
