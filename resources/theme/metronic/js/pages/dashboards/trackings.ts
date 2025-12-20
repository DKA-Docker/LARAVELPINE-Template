import mapboxgl from "mapbox-gl";
import $ from "jquery";
import axios from "axios";
import URI from "urijs";
import moment from "moment";
import { initializeApp } from "firebase/app";
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

declare global {
    interface Window {
        $: typeof jQuery;
        jQuery: typeof jQuery;
        axios: typeof axios;
        Pusher: typeof Pusher;
        Echo: Echo<"reverb">;
    }
}

$(window).on('load', async function () {
    const elementExists = $("div.dashboards-apps-trackings");
    if (elementExists.length === 0 || $('#map').length === 0) return;

    const getCfg = (name: string): string => {
        const meta = document.querySelector(`meta[name="${name}"]`) as HTMLMetaElement;
        return meta ? meta.content : '';
    };

    // --- REVERB & FIREBASE CONFIG ---
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: getCfg('reverb-key'),
        wsHost: getCfg('reverb-host'),
        wsPort: parseInt(getCfg('reverb-port')) || 80,
        wssPort: parseInt(getCfg('reverb-port')) || 443,
        forceTLS: getCfg('reverb-scheme') === 'https',
        enabledTransports: ['ws', 'wss'],
    });

    const FIREBASE_CONFIG = {
        apiKey: "AIzaSyBy_jmKX6mIQOVSUSxra5DnVfFSAel3RIE",
        authDomain: "hndgs-65ce6.firebaseapp.com",
        projectId: "hndgs-65ce6",
        storageBucket: "hndgs-65ce6.firebasestorage.app",
        messagingSenderId: "1078964933148",
        appId: "1:1078964933148:web:6f733f7f2264c0f8f245d9",
    };

    let mapInstance: mapboxgl.Map | null = null;
    let selectedUuid: string | null = null;
    const markers: Record<string, { marker: mapboxgl.Marker }> = {};

    // ==========================================
    // 1. TELEMETRY & UI LOGIC
    // ==========================================

    function addTelemetryLog(message: string, type: 'info' | 'alert' = 'info') {
        const $container = $('#log-container');
        const colorClass = type === 'alert' ? 'text-primary' : 'text-foreground/40';
        const logHtml = `
            <div class="log-item flex gap-3 items-start border-l border-white/5 pl-3 py-1 mb-1">
                <span class="text-[8px] font-mono opacity-20 mt-0.5">${moment().format('HH:mm:ss')}</span>
                <p class="text-[10px] font-bold tracking-tight ${colorClass}">>> ${message}</p>
            </div>`;
        $container.prepend(logHtml);
        if ($container.children().length > 6) $container.children().last().remove();
    }

    function resetControlHub() {
        selectedUuid = null;
        $('#unit-name').text('System Ready');
        $('#btn-ping-driver, #energy-widget, #log-widget, #security-alert-box').addClass('hidden');
        $('#control-sidebar').removeClass('is-updating is-commanding');
        $('#unit-card').removeClass('animate-panel-scan');
    }

    function updateControlHub(driver: any, isEchoUpdate: boolean = false) {
        const info = driver.account?.information;
        const fullName = info ? `${info.first_name} ${info.last_name}` : 'Unknown';
        const fcmToken = driver.account?.firebase?.token;

        $('#unit-name').text(fullName);
        $('#unit-id').text(`ID: ${driver.uuid.substring(0, 8).toUpperCase()}`);
        $('#unit-speed').html(`${parseFloat(driver.speed).toFixed(2)} <span class="text-[10px]">KM/H</span>`);
        $('#unit-time').text(moment(driver.created_at).format('HH:mm:ss'));
        if (info?.avatar) $('#unit-avatar').attr('src', `/storage/${info.avatar}`);

        $('#btn-ping-driver, #energy-widget, #log-widget').removeClass('hidden');

        const $sidebar = $('#control-sidebar');
        const $card = $('#unit-card');

        // --- THE CYBERPUNK SCAN GIF EFFECT ---
        if (isEchoUpdate) {
            // Trigger Scanline & Overlay
            $sidebar.addClass('is-updating');

            // Trigger Glow pada Card dengan Reflow
            $card.removeClass('animate-panel-scan');
            void $card[0].offsetWidth;
            $card.addClass('animate-panel-scan');

            // Alert Box logic
            $('#security-alert-box').stop(true, true).hide().removeClass('hidden').fadeIn(200);
            $('#alert-message').text(`${fullName} signal acquired.`);
            addTelemetryLog(`LIVE SYNC: ${fullName}`, 'alert');

            // Matikan efek setelah 2 detik (durasi scanning)
            setTimeout(() => {
                $sidebar.removeClass('is-updating');
                $('#security-alert-box').fadeOut(1000);
            }, 2000);
        }

        // --- REQUEST COMMAND OVERRIDE ---
        $('#btn-ping-driver').off('click').on('click', async function(e) {
            e.stopPropagation();
            const $this = $(this);
            if ($this.hasClass('is-loading')) return;

            $this.addClass('is-loading');
            $sidebar.addClass('is-commanding'); // Mode Merah (Override)
            addTelemetryLog(`OVERRIDE: REQUESTING LOCATION...`, 'alert');

            try {
                const fullUri = URI(window.location);
                const fetchUrl = fullUri.segment([...fullUri.segment(), 'monitors', 'token']).toString();
                await axios.post(fetchUrl, { token: fcmToken, driver_name: fullName });

                setTimeout(() => {
                    $this.removeClass('is-loading');
                    $sidebar.removeClass('is-commanding');
                    addTelemetryLog(`COMMAND CONFIRMED BY UNIT`, 'info');
                }, 2500);
            } catch (err) {
                $this.removeClass('is-loading');
                $sidebar.removeClass('is-commanding');
                addTelemetryLog(`DISPATCH FAILED: UNIT OFFLINE`, 'alert');
            }
        });
    }

    // ==========================================
    // 2. THEME OBSERVER (MUTATE OBSERVER)
    // ==========================================
    const themeObserver = new MutationObserver(() => {
        const isDark = document.documentElement.classList.contains('dark');
        const newStyle = isDark ? 'mapbox://styles/mapbox/dark-v11' : 'mapbox://styles/mapbox/standard';
        if (mapInstance) mapInstance.setStyle(newStyle);
    });
    themeObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

    // ==========================================
    // 3. MARKER ENGINE
    // ==========================================
    function updateMarkersOnMap(latestPerUuid: Record<string, any>, highlightUuid: string | null = null) {
        Object.values(latestPerUuid).forEach((driver: any) => {
            const coord: [number, number] = [driver.longitude, driver.latitude];
            if (!markers[driver.uuid]) {
                const el = document.createElement('div');
                el.className = 'marker-car'; el.innerHTML = '🚗';
                el.addEventListener('click', (e) => {
                    e.stopPropagation(); selectedUuid = driver.uuid;
                    updateControlHub(driver, false);
                    mapInstance?.flyTo({ center: coord, zoom: 16 });
                });
                markers[driver.uuid] = { marker: new mapboxgl.Marker(el).setLngLat(coord).addTo(mapInstance!) };
            } else {
                markers[driver.uuid].marker.setLngLat(coord);
                if (driver.uuid === selectedUuid) updateControlHub(driver, driver.uuid === highlightUuid);
            }
        });
    }

    async function fetchTracking(highlightUuid: string | null = null) {
        try {
            const res = await axios.get(URI(window.location).segment([...URI(window.location).segment(), 'monitors']).toString());
            const latest: Record<string, any> = {};
            res.data.data.forEach((d: any) => {
                if (!latest[d.uuid] || new Date(d.created_at) > new Date(latest[d.uuid].created_at)) latest[d.uuid] = d;
            });
            updateMarkersOnMap(latest, highlightUuid);
        } catch (e) { console.error(e); }
    }

    // --- INITIALIZE ---
    initializeApp(FIREBASE_CONFIG);
    mapboxgl.accessToken = getCfg('mapbox-token');
    mapInstance = new mapboxgl.Map({
        container: "map",
        style: document.documentElement.classList.contains('dark') ? 'mapbox://styles/mapbox/dark-v11' : 'mapbox://styles/mapbox/standard',
        center: [119.4365, -5.1477], zoom: 12
    });

    mapInstance.on('click', (e) => { if (!(e.originalEvent.target as HTMLElement).closest('.marker-car')) resetControlHub(); });

    // --- REALTIME LISTEN ---
    window.Echo.channel('dashboards.apps.trackings.monitors')
        .listen('.dashboards.apps.trackings.monitors', (response: any) => {
            const incoming = response.data;
            if (markers[incoming.uuid]) markers[incoming.uuid].marker.setLngLat([incoming.longitude, incoming.latitude]);
            if (!selectedUuid || selectedUuid === incoming.uuid) {
                selectedUuid = incoming.uuid;
                updateControlHub(incoming, true); // <--- INI PEMICU ANIMASI CYBER
                mapInstance?.flyTo({ center: [incoming.longitude, incoming.latitude], zoom: 17 });
            }
            fetchTracking(incoming.uuid);
        });

    mapInstance.on('style.load', () => fetchTracking());
});
