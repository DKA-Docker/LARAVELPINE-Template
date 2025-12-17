import $ from "jquery";
import "moment/locale/id.js";
import { KTAccordion } from "@keenthemes/ktui/src";
import mapboxgl from "mapbox-gl";
import moment from "moment-timezone";
import URI from "urijs";
import axios from "axios";
import jQuery from "jquery";

const elementExists = $("div.dashboards-apps-deliveries-tasks-create");

if(elementExists.length > 0 ){
    // ubah local menjadi indo
    moment.locale('id');

    // ambil url dimana saja url ini di muat
    const FullUriCurrentUrl =  URI(window.location);
    /**
     * Ubah URL Menjadi Array Segment
     * misal /dashboards/apps/deliveries menjadi
     * ['dashboards','apps','deliveries'];
     * **/
    const segs = FullUriCurrentUrl.segment();
    /**
     * Tambahkan Data Di Dalam Array
     * ['api','dashboards','apps','deliveries'];
     * **/
    segs.unshift('api');
    /**
     * ['api','dashboards','apps','deliveries'];
     * Ambil Kembali Semua Segment dan ubah menjadi URL Kembali
     * /api/dashboards/apps/deliveries
     * **/
    FullUriCurrentUrl.segment(segs);

    // ambil data simpan di dalam array/cache
    let requestDataCache: object[] = [];
    let requestDestinatCache: object[] = [];
    let requestDriverCache: object[] = [];

    // Tampilkan data di select - option
    const apiUrl = FullUriCurrentUrl.toString();

    // MEMBUAT URL KEDUA (Accounts) ---
    // Gunakan .clone() agar FullUriCurrentUrl yang asli tidak terganggu
    const accountsUrl = FullUriCurrentUrl.clone()
        .path('/api/base/accounts') //Langsung timpa path-nya
        .toString();

    // panggil data appDeliveryRequest
    async function fetchRequestsDestinations(apiUrl: string){
        try{
            const res = await fetch(apiUrl);
            const json = await res.json();
            if(!json.status || !json.data){
                requestDestinatCache = [];
            }else{
                requestDestinatCache = json.data;
            }

            return requestDestinatCache;
        }catch (e) {
            console.error("fetch error", e);
            return [];
        }
    }

    async function fetchDrivers(accountsUrl: string){
        try{
            const res = await fetch(accountsUrl);
            const json = await res.json();
            if(!json.status || !json.data){
                requestDriverCache = [];
            }else{
                requestDriverCache = json.data;
            }

            return requestDriverCache;
        }catch (e) {
            console.error("fetch error", e);
            return [];
        }
    }

    (async() => {
    // tampilkan semua data destination
        const $dataDestinats = $("#destination");
        const dataDestinations = await fetchRequestsDestinations(apiUrl);

        $dataDestinats.empty();
        $dataDestinats.append(`<option value="">Pilih Destinasi</option>`)

        dataDestinations.forEach(request => {
            // @ts-ignore
            $dataDestinats.append(`<option value="${request.id}">${request.receipt_name} - ${request.receipt_address}</option>`)
        })

        // tampilkan semua data driver
        // const $datDrivs = $("#account");
        const dataDrivers = await fetchDrivers(accountsUrl);
        requestDriverCache = dataDrivers;

        // State untuk menampung driver yang dipilih
        let selectedDrivers: any[] = [];

        const $driverInput = $("#driver_search_input");
        const $suggestionsBox = $("#driver_suggestions");
        const $selectedContainer = $("#selected_drivers_container");
        const $hiddenContainer = $("#hidden_inputs_container");

        // Fungsi 1: Update Tampilan Chips & Input Hidden
        function updateSelectedUI(){
            $selectedContainer.empty();
            $hiddenContainer.empty();

            selectedDrivers.forEach((driver, index) =>{
                const username = driver.credential?.username || "Tanpa nama";

                // A. Buat Visual Chip (Tag)
                const $chip = $(`
                       <div class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-green-500 text-sm font-medium border border-green-400">
                            ${username}
                            <span class="cursor-pointer text-gray-500 hover:text-red-500 ml-1 remove-driver" data-id="${driver.id}">
                            &times;</span>
                       </div>
                `);

                // B. Buat Input Hidden (account[])
                // Ini penting agar Laravel membacanya sebagai array
                const $hiddenInput = $(`<input type="hidden" name="account[]" value="${driver.id}">`);

                $selectedContainer.append($chip);
                $hiddenContainer.append($hiddenInput);
            })
        }

        // Fungsi 2: Render List Dropdown (Filter yang sudah dipilih)
        function renderDriverList(drivers: any[]){
            $suggestionsBox.empty();

            // Filter: jangan tampilkan driver yang sudah dipilih
            // @ts-ignore
            const availableDrivers = drivers.filter(d => !selectedDrivers.some(selected => selected.id === d.id));

            if(availableDrivers.length === 0){
                $suggestionsBox.append(`<div class="px-4 py-3 text-gray-500 text-sm">Tidak ada driver lain</div>`);
                $suggestionsBox.removeClass("hidden");
                return;
            }

            availableDrivers.forEach(driver => {
                const username =  driver.credential?.username || "Tanpa nama";
                const email = driver.contact?.email || "";

                const $item = $(`
                    <div class="px-4 py-3 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-0">
                        <div class="text-sm font-semibold text-gray-800">${username}</div>
                        <div class="text-xs text-gray-500">${email}</div>
                    </div>
                `);

                // Klik Item -> Tambahkan ke Selection
                $item.on('click', function(){
                    selectedDrivers.push(driver); // Masukkan ke array
                    updateSelectedUI(); // Update tampilan chip

                    $driverInput.val(""); // Kosongkan search box
                    $suggestionsBox.addClass("hidden"); // Tutup dropdown
                    $driverInput.focus(); // Balikin fokus biar bisa ngetik lagi
                });

                $suggestionsBox.append($item);
            });

            $suggestionsBox.removeClass("hidden");
        }

        // Event: Remove Driver (Klik tanda silang di chip)
        $(document).on("click", ".remove-driver", function (){
            const idToRemove = $(this).data("id");
            // Hapus dari array
            // @ts-ignore
            selectedDrivers = selectedDrivers.filter(d => d.id !== idToRemove);
            updateSelectedUI();
        });

        // Event: Typing Search
        $driverInput.on("input", function(){
            const query = ($(this).val() as string).toLowerCase();
            if(query == ""){
                $suggestionsBox.addClass("hidden");
                return;
            }

            // @ts-ignore
            const filteredDrivers = requestDriverCache.filter(driver => {
            // @ts-ignore
                const name = driver.credential?.username?.toLowerCase() || "";
                return name.includes(query);
            });

            renderDriverList(filteredDrivers);
        });

        // Events: focus (Show suggestions)
        $driverInput.on("focus", function(){
            const query = ($(this).val() as string).toLowerCase();
            if(query === "" && requestDriverCache.length > 0){
                //@ts-ignore
                renderDriverList(requestDriverCache);// Tampilkan list sisa
            }
        });

        // Event: Close dropdown click outside
        $(document).on("click", function(e) {
            // @ts-ignore
            if (!$(e.target).closest("#driver-wrapper").length) {
                $suggestionsBox.addClass("hidden");
            }
        });

        // Fungsi Helper: Tampilkan sisa data (Reusable)
        function showRemainingData(){
            // Cek apakah data sudah dimuat
            // @ts-ignore
            if(requestDriverCache.length > 0){
                // Panggil render dengan semua data cache
                // (renderDriverList sudah otomatis memfilter yang sudah dipilih)
                // @ts-ignore
                renderDriverList(requestDriverCache);
            }
        }

        // 1. EVENT KLIK 2 KALI (DOUBLE KLIK) - Sesuai Request
        $driverInput.on('dblclick', function(){
            showRemainingData();
        })

        // 2. EVENT KLIK BIASA (SINGLE CLICK) - Solusi Tambahan
        // Ini mengatasi masalah "harus klik di luar dulu".
        // Dengan ini, meski sudah fokus, kalau diklik lagi dropdown akan muncul.
        $driverInput.on('click', function(){
            const query = ($(this).val() as string);

            // Hanya munculkan jika dropdown sedang tertutup
            if($suggestionsBox.hasClass("hidden")){
                // Jika input kosong, tampilkan semua sisa data
                if(query === ""){
                    showRemainingData();
                }else{
                    // Jika ada teks, trigger pencarian ulang (opsional)
                    $(this).trigger("input");
                }
            }
        });

        // Update event Focus yang lama agar menggunakan fungsi helper yang sama
        $driverInput.on("focus", function() {
            const query = ($(this).val() as string);
            if(query === ""){
                showRemainingData();
            }
        });

        // $datDrivs.empty();
        // $datDrivs.append(`<option value="">Pilih Driver</option>`)
        //
        // dataDrivers.forEach(request => {
        //     // @ts-ignore
        //     $datDrivs.append(`<option value="${request.id}">${request.credential.username}</option>`)
        // })


    })()

    // destination ketika di klik
    $("#destination").on("change", function(){
        const selectedId = $(this).val();

    })

    // sisipkan URL dan panggil data api Request
    function fetchRequestOptions(FullUriCurrentUrl: string){
        return fetch(FullUriCurrentUrl)
            .then(res => res.json())
            .then(json => {
                if( !json.status || !json.data) return [];

                // simpan semua data di cache
                requestDataCache = json.data;

                return json.data.map((item: any)=> {
                    const id  = item.id;
                    const title = item.name ?? "(Tanpa Nama)";
                    const firstName = item.account?.information?.first_name ?? "";
                    const destinations = item.destinations?.length ?? "0";
                    const label = `${title} - Destinasi : ${destinations}` ;
                    return  {id, label};
                } );

            });

    }

    fetchRequestOptions(apiUrl)
        .then(axios => {
            const $select = jQuery("#request");

            axios.forEach( opt => {
                $select.append(
                    `<option value="${opt.id}">${opt.label}</option>`
                );
            });
        });

    // cache - tampilkan console log data yang di pilih
    $("#request").on('change', function(){
        const selectedId = $(this).val();

        // cari object data sesuai ID
        // @ts-ignore
        let selectedItem = requestDataCache.find(item => item.id === selectedId);

        // kalau nggak ketemu atau nggak ada destinasi -> KOSONGKAN SEMUA & STOP
        // @ts-ignore
        if(
            !selectedItem ||
            // @ts-ignore
            !Array.isArray(selectedItem.destinations) ||
            // @ts-ignore
            selectedItem.destinations.length === 0
        ){
            // kosongkan teks & input
            $('#title').val("-");
            $('#receipt_address').text("-");
            $('#address_destination').text("-");
            $('#date_destination').text("-");
            $('#receipt_name').text("-");
            $('#first_name').val("");
            $('#name').val("");

            // kosongkan card order
            $('#card-order').empty();

            return; // jgn lanjut
        }

        // @ts-ignore
        const destination = selectedItem.destinations[0];

        // @ts-ignore
        $('#title').val(selectedItem ? selectedItem?.account?.contact?.email : "-")
        // @ts-ignore
        $('#receipt_address').text(selectedItem ?  ` ${destination?.receipt_name} - ${destination.receipt_address}` : "-");
        // @ts-ignore
        $('#address_destination').text(selectedItem ?  ` ${destination.receipt_address}` : "-");
        // @ts-ignore
        let dataDestination = moment(destination?.created_at).toDate();
        // @ts-ignore
        $('#date_destination').text(selectedItem ? dataDestination : "-");
        // @ts-ignore
        $('#receipt_name').text(selectedItem ?  ` ${destination?.receipt_name}` : "-");
        // @ts-ignore
        $('#first_name').val(selectedItem ?  ` ${selectedItem?.account?.information.first_name}` : "-");
        // @ts-ignore
        $('#name').val(selectedItem ?  `${selectedItem?.name}` : "-");

        $('#card-order').empty();

        // isi data dari pilihan select untuk card box - confirmation
        // @ts-ignore
        selectedItem.destinations[0].packages.forEach((item: any) => {
            const label = `${item?.name}`;
            console.log("Data Terpilih: ", item);

            $('#card-order').append(
                `
                 <div class="flex items-start justify-between border-b border-border py-2">
                    <div class="flex items-center gap-3.5">
                       <div class="kt-card flex items-center justify-center bg-accent/50 h-[70px] w-[90px] shadow-none">
                            <!-- <img alt="img" class="cursor-pointer h-[70px]" data-kt-drawer-toggle="#drawers_shop_product_details" src="assets/media/store/client/600x600/11.png"/>-->
                       </div>
                       <div class="flex flex-col gap-1">
                            <span class="hover:text-primary text-sm font-medium text-mono leading-5.5" data-kt-drawer-toggle="#drawers_shop_product_details" >
                                ${label}
                            </span>
                            <div class="flex items-center gap-1.5">
                                <span class="text-xs font-normal text-secondary-foreground uppercase">

                                    <span class="text-xs font-medium text-foreground">
                                          ${item.qty}
                                    </span>
                                </span>
                            </div>
                       </div>
                  </div>
                  <div class="flex flex-col gap-1.5">
                       <span class="text-xs font-normal text-secondary-foreground text-end">
                                                                   
                                                                 </span>
                             <div class="flex items-center flex-wrap gap-1.5">
                                     <span class="text-sm font-normal text-secondary-foreground line-through">
                                     </span>
                                          <span class="text-sm font-semibold text-mono">
                                                ${item.qty}
                                          </span>
                             </div>
                  </div>
                </div>`
            );
        })
    })


}

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
