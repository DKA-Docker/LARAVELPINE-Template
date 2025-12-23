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

    // --- BROADCAST ENGINE ---
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

    let mapInstance: mapboxgl.Map | null = null;
    let selectedAccountId: string | number | null = null;
    const markers: Record<string, { marker: mapboxgl.Marker, element: HTMLElement, lastCoord: [number, number], lastData: any }> = {};

    function addLog(msg: string, type: 'info' | 'alert' | 'danger' = 'info') {
        let colorClass = 'text-foreground/40';
        if (type === 'alert') colorClass = 'text-primary';
        if (type === 'danger') colorClass = 'text-red-500';

        const html = `
            <div class="flex gap-4 border-l-2 border-white/5 pl-4 py-1 animate-in slide-in-from-left duration-300">
                <span class="text-[9px] font-mono font-bold opacity-20">${moment().format('HH:mm:ss')}</span>
                <p class="text-[11px] font-black tracking-tight ${colorClass}">>> ${msg}</p>
            </div>`;
        $('#log-container').prepend(html);
        if ($('#log-container').children().length > 8) $('#log-container').children().last().remove();
    }

    // --- THEME OBSERVER ---
    const updateMapStyle = () => {
        const isDark = document.documentElement.classList.contains('dark');
        const style = isDark ? 'mapbox://styles/mapbox/dark-v11' : 'mapbox://styles/mapbox/light-v11';
        if (mapInstance) mapInstance.setStyle(style);
    };
    const themeObserver = new MutationObserver(updateMapStyle);
    themeObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

    // --- PULSE TRIGGERS ---
    function triggerPulse(accId: any) {
        if (markers[accId]) {
            $(markers[accId].element).addClass('marker-pulse-active');
            setTimeout(() => $(markers[accId].element).removeClass('marker-pulse-active'), 5000);
        }
    }

    function triggerAlarmPulse(accId: any) {
        if (markers[accId]) {
            $(markers[accId].element).addClass('marker-alarm-active');
            setTimeout(() => $(markers[accId].element).removeClass('marker-alarm-active'), 10000);
        }
    }

    // --- UPDATE UI & HIGHLIGHT MARKER ---
    function updateUI(driver: any, isLive: boolean = false) {
        const acc = driver.account;
        const info = acc?.information;
        const fcm = acc?.firebase?.token;
        const id = acc?.id || "N/A";

        // Ganti Warna Marker Terpilih
        $('.marker-car').removeClass('is-active'); // Hapus semua highlight
        if (markers[id]) {
            $(markers[id].element).addClass('is-active'); // Tambah highlight ke yang diklik
        }

        $('#unit-name').text(info ? `${info.first_name} ${info.last_name}` : 'Unknown Unit');
        $('#unit-id').text(`${isLive ? 'LIVE' : 'CACHE'}: NODE-${id.toString().substring(0,8).toUpperCase()}`).toggleClass('text-primary', isLive);
        $('#unit-speed').html(`${parseFloat(driver.speed || 0).toFixed(2)} <small class="text-xs opacity-30 font-bold not-italic">KM/H</small>`);
        $('#unit-time').text(moment(driver.created_at).format('HH:mm:ss'));

        // REVISI POSISI: Pastikan urutan Lat, Lng benar untuk tampilan teks
        const displayLat = parseFloat(driver.latitude).toFixed(5);
        const displayLng = parseFloat(driver.longitude).toFixed(5);
        $('#unit-coords').text(`${displayLat}, ${displayLng}`);

        $('#unit-accuracy').text(driver.accuracy ? `${driver.accuracy} m` : 'N/A');

        if (info?.avatar) $('#unit-avatar').attr('src', `/storage/${info.avatar}`);
        $('#btn-ping-driver, #btn-alarm-driver, #log-widget').removeClass('hidden');

        if (isLive) {
            $('#control-sidebar').addClass('is-updating');
            triggerPulse(acc.id);
            addLog(`LIVE SYNC: ${info?.first_name || 'Unit'}`, 'alert');
            setTimeout(() => $('#control-sidebar').removeClass('is-updating'), 3000);
        }

        // --- BUTTON HANDLERS ---
        $('#btn-ping-driver').off('click').on('click', async function() {
            const $b = $(this).addClass('is-loading');
            $('#control-sidebar').addClass('is-updating');
            triggerPulse(acc.id);
            try {
                const url = URI(window.location).segment([...URI(window.location).segment(), 'monitors', 'request-location-update']).toString();
                await axios.post(url, { token: fcm, driver_name: info?.first_name });
                addLog(`PING REQUEST SENT`, 'info');
            } finally {
                setTimeout(() => { $b.removeClass('is-loading'); $('#control-sidebar').removeClass('is-updating'); }, 2000);
            }
        });

        $('#btn-alarm-driver').off('click').on('click', async function() {
            const $b = $(this).addClass('is-loading');
            $('#control-sidebar').addClass('is-updating is-commanding');
            triggerAlarmPulse(acc.id);
            try {
                const url = URI(window.location).segment([...URI(window.location).segment(), 'monitors', 'request-alarm']).toString();
                await axios.post(url, { token: fcm, driver_name: info?.first_name });
                addLog(`CRITICAL ALARM BROADCASTED`, 'danger');
            } finally {
                setTimeout(() => {
                    $b.removeClass('is-loading');
                    $('#control-sidebar').removeClass('is-updating is-commanding');
                }, 4000);
            }
        });
    }

    // --- MAP ENGINE ---
    mapboxgl.accessToken = getCfg('mapbox-token');
    mapInstance = new mapboxgl.Map({
        container: "map",
        style: document.documentElement.classList.contains('dark') ? 'mapbox://styles/mapbox/dark-v11' : 'mapbox://styles/mapbox/light-v11',
        center: [119.4365, -5.1477], zoom: 12
    });

    function createMarker(d: any) {
        const id = d.account.id;
        const pos: [number, number] = [parseFloat(d.longitude), parseFloat(d.latitude)];
        const el = document.createElement('div');
        el.className = 'marker-car';
        el.innerHTML = `
            <div class="pulse-ring"></div>
            <div class="pulse-danger"></div>
            <div class="marker-icon-wrapper">
                <span class="car-icon">🚗</span>
            </div>
        `;

        el.onclick = (e) => {
            e.stopPropagation(); // Mencegah map click event
            selectedAccountId = id;
            const currentData = markers[id].lastData;
            const currentPos = markers[id].lastCoord;

            updateUI(currentData, false);
            mapInstance?.flyTo({ center: currentPos, zoom: 16, essential: true });
        };

        markers[id] = {
            marker: new mapboxgl.Marker(el).setLngLat(pos).addTo(mapInstance!),
            element: el,
            lastCoord: pos,
            lastData: d
        };
    }

    async function fetchAll() {
        try {
            const res = await axios.get(URI(window.location).segment([...URI(window.location).segment(), 'monitors']).toString());
            res.data.data.forEach((d: any) => {
                const id = d.account.id;
                const pos: [number, number] = [parseFloat(d.longitude), parseFloat(d.latitude)];
                if (!markers[id]) {
                    createMarker(d);
                } else {
                    markers[id].marker.setLngLat(pos);
                    markers[id].lastCoord = pos;
                    markers[id].lastData = d;
                    if (id === selectedAccountId) updateUI(d, false);
                }
            });
        } catch (e) {}
    }

    // Tracking Channel
    window.Echo.channel('dashboards.apps.trackings.monitors')
        .listen('.dashboards.apps.trackings.monitors', (res: any) => {
            const d = res.data;
            const id = d.account.id;
            const newPos: [number, number] = [parseFloat(d.longitude), parseFloat(d.latitude)];

            if (markers[id]) {
                markers[id].marker.setLngLat(newPos);
                markers[id].lastCoord = newPos;
                markers[id].lastData = d;
            } else {
                createMarker(d);
            }

            if (selectedAccountId === id) {
                updateUI(d, true);
                mapInstance?.flyTo({ center: newPos, zoom: 17, essential: true });
            }
        });

    // Alarm Channel
    window.Echo.channel('dashboards.apps.trackings.alarms')
        .listen('.dashboards.apps.trackings.alarms', (res: any) => {
            const accId = res.data.account.id;
            addLog(`CRITICAL: Unit NODE-${accId.toString().substring(0,8)} Alarm Triggered!`, 'danger');
            triggerAlarmPulse(accId);
        });

    mapInstance.on('load', fetchAll);
    mapInstance.on('click', (e) => {
        if (!$(e.originalEvent.target as any).closest('.marker-car').length) {
            selectedAccountId = null;
            $('.marker-car').removeClass('is-active');
            $('#unit-name').text('System Ready');
            $('#btn-ping-driver, #btn-alarm-driver, #log-widget').addClass('hidden');
        }
    });
});
