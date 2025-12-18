import mapboxgl from "mapbox-gl";
import $ from "jquery";
import axios from "axios";
import URI from "urijs";
import moment from "moment";
import { initializeApp } from "firebase/app";
import PerfectScrollbar from "perfect-scrollbar";
import "perfect-scrollbar/css/perfect-scrollbar.css";
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

/**
 * Helper untuk mengambil nilai dari Meta Tag agar kebal Obfuscation
 */
const getCfg = (name: string): string => {
    const meta = document.querySelector(`meta[name="${name}"]`) as HTMLMetaElement;
    return meta ? meta.content : '';
};

window.Pusher = Pusher;

// Inisialisasi Echo menggunakan Meta Tags dari Config Laravel
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: getCfg('reverb-key'),
    wsHost: getCfg('reverb-host'),
    wsPort: parseInt(getCfg('reverb-port')) || 80,
    forceTLS: getCfg('reverb-scheme') === 'https',
    enabledTransports: ['ws', 'wss'],
});

// ==========================================
// 1. KONFIGURASI & STATE
// ==========================================
const FIREBASE_CONFIG = {
    apiKey: "AIzaSyBy_jmKX6mIQOVSUSxra5DnVfFSAel3RIE",
    authDomain: "hndgs-65ce6.firebaseapp.com",
    projectId: "hndgs-65ce6",
    storageBucket: "hndgs-65ce6.firebasestorage.app",
    messagingSenderId: "1078964933148",
    appId: "1:1078964933148:web:6f733f7f2264c0f8f245d9",
    measurementId: "G-W472DNVMSB"
};

const MAP_STYLES = {
    standard: 'mapbox://styles/mapbox/standard',
    streets: 'mapbox://styles/mapbox/streets-v12',
    satellite: 'mapbox://styles/mapbox/satellite-v9',
    dark: 'mapbox://styles/mapbox/dark-v11',
};

let mapInstance: mapboxgl.Map | null = null;
const markers: Record<string, {
    marker: mapboxgl.Marker;
    popup: mapboxgl.Popup;
    contentElement?: HTMLElement;
    containerElement?: HTMLElement;
}> = {};

// ==========================================
// 2. LOGIKA DATA & ANIMASI
// ==========================================

async function fetchTracking(highlightUuid: string | null = null) {
    try {
        const fullUri = URI(window.location);
        const fetchUrl = fullUri.segment([...fullUri.segment(), 'monitors']).toString();
        const res = await axios.get(fetchUrl);
        const drivers = res.data.data;

        const latestPerUuid: Record<string, any> = {};
        drivers.forEach((d: any) => {
            if (!latestPerUuid[d.uuid] || new Date(d.created_at) > new Date(latestPerUuid[d.uuid].created_at)) {
                latestPerUuid[d.uuid] = d;
            }
        });

        updateMarkersOnMap(latestPerUuid, highlightUuid);
    } catch (error) {
        console.error("Gagal update tracking:", error);
    }
}

function updateMarkersOnMap(latestPerUuid: Record<string, any>, highlightUuid: string | null = null) {
    const isDark = document.documentElement.classList.contains('dark');
    const colors = isDark ?
        { bg: '#2b2b2b', text: '#ffffff', divider: '#444' } :
        { bg: '#ffffff', text: '#333333', divider: '#eee' };

    Object.values(latestPerUuid).forEach((driver: any) => {
        const coord: [number, number] = [driver.longitude, driver.latitude];
        const fullName = `${driver.account.information.first_name} ${driver.account.information.last_name}`;
        const fcmToken = driver.account?.firebase?.token;

        if (!markers[driver.uuid]) {
            const popupData = createPopupContainer(driver, fullName, fcmToken, colors);
            const popup = new mapboxgl.Popup({ offset: 25, closeButton: false, className: 'custom-tracking-popup' })
                .setDOMContent(popupData.container);

            const el = document.createElement('div');
            el.innerHTML = '🚗';
            el.style.fontSize = '28px';
            el.style.cursor = 'pointer';

            markers[driver.uuid] = {
                marker: new mapboxgl.Marker(el).setLngLat(coord).setPopup(popup).addTo(mapInstance!),
                popup,
                contentElement: popupData.contentElement,
                containerElement: popupData.container
            };
        } else {
            const target = markers[driver.uuid];
            target.marker.setLngLat(coord);

            if (target.contentElement) {
                target.contentElement.innerHTML = generatePopupHTML(driver, fullName, colors);
            }

            // TRIGGER ANIMASI JIKA ADA UPDATE DARI ECHO
            if (driver.uuid === highlightUuid) {
                const el = target.marker.getElement();
                el.classList.remove('animate-marker-ping');
                void el.offsetWidth;
                el.classList.add('animate-marker-ping');

                if (target.containerElement) {
                    target.containerElement.classList.remove('animate-popup-glow');
                    void target.containerElement.offsetWidth;
                    target.containerElement.classList.add('animate-popup-glow');
                }
            }
        }
    });
}

// ==========================================
// 3. UI GENERATORS (ISI DATA TETAP SAMA)
// ==========================================

const generatePopupHTML = (driver: any, name: string, colors: any) => `
    <div style="border-bottom: 1px solid ${colors.divider}; margin-bottom: 8px; padding-bottom: 5px;">
        <strong style="font-size: 14px;">${name}</strong>
    </div>
    <div style="display: flex; flex-direction: column; gap: 4px; font-size: 11px;">
        <div style="display: flex; justify-content: space-between;">
            <span style="font-weight: bold;">Latitude:</span> <span>${driver.latitude}</span>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <span style="font-weight: bold;">Longitude:</span> <span>${driver.longitude}</span>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <span style="font-weight: bold;">Kecepatan:</span> <span>${parseFloat(driver.speed).toFixed(2)} km/h</span>
        </div>
        <div style="display: flex; flex-direction: column; margin-top: 6px; border-top: 1px dashed ${colors.divider}; padding-top: 6px;">
            <span style="font-weight: bold; color: #888; margin-bottom: 2px;">Last Updated:</span>
            <span>${moment(driver.created_at).format('DD MMM YYYY, HH:mm:ss')}</span>
        </div>
    </div>
`;

function createPopupContainer(driver: any, fullName: string, fcmToken: string, colors: any) {
    const container = document.createElement('div');
    Object.assign(container.style, {
        padding: '12px', background: colors.bg, color: colors.text,
        borderRadius: '8px', position: 'relative', minWidth: '260px',
        boxShadow: '0 4px 15px rgba(0,0,0,0.2)', fontFamily: 'sans-serif',
        border: '2px solid transparent'
    });

    const reloadBtn = document.createElement('button');
    reloadBtn.innerHTML = '↻';
    Object.assign(reloadBtn.style, {
        position: 'absolute', top: '-12px', left: '-12px', background: '#007bff',
        color: 'white', border: 'none', borderRadius: '50%', width: '28px', height: '28px',
        cursor: 'pointer', display: 'flex', alignItems: 'center', justifyContent: 'center', fontWeight: 'bold'
    });
    reloadBtn.onclick = () => sendReloadNotification(fcmToken, fullName, driver.uuid);

    const closeBtn = document.createElement('button');
    closeBtn.innerHTML = '&times;';
    Object.assign(closeBtn.style, {
        position: 'absolute', top: '-12px', right: '-12px', background: '#dc3545',
        color: 'white', border: 'none', borderRadius: '50%', width: '28px', height: '28px',
        cursor: 'pointer', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '18px'
    });
    closeBtn.onclick = () => markers[driver.uuid].popup.remove();

    const contentElement = document.createElement('div');
    contentElement.style.paddingTop = '5px';
    contentElement.innerHTML = generatePopupHTML(driver, fullName, colors);

    container.append(reloadBtn, closeBtn, contentElement);
    return { container, contentElement };
}

async function sendReloadNotification(fcmToken: string, driverName: string, uuid: string) {
    if (!fcmToken) return alert(`Driver ${driverName} tidak memiliki token FCM.`);
    try {
        const fullUri = URI(window.location);
        const fetchUrl = fullUri.segment([...fullUri.segment(), 'monitors', 'token']).toString();
        const response = await axios.post(fetchUrl, { token: fcmToken, driver_name: driverName });
        if (response.data.status === 'success') console.debug(`Perintah pembaruan lokasi berhasil dikirim ke ${driverName}`);
    } catch (error: any) {
        alert("Gagal mengirim perintah reload.");
    }
}

// ==========================================
// 4. MAIN ENTRY POINT
// ==========================================

$(window).on('load', async function () {
    const elementExists = $("div.dashboards-apps-trackings");
    if (elementExists.length === 0 || $('#map').length === 0) return;

    initializeApp(FIREBASE_CONFIG);

    // Ambil Access Token Mapbox dari Meta Tag
    mapboxgl.accessToken = getCfg('mapbox-token');

    let currentStyleKey = document.documentElement.classList.contains('dark') ? 'dark' : 'standard';

    mapInstance = new mapboxgl.Map({
        container: "map",
        style: MAP_STYLES[currentStyleKey as keyof typeof MAP_STYLES],
        center: [119.4365, -5.1477],
        zoom: 12,
        projection: 'globe'
    });

    $('<style>').text(`
        .custom-tracking-popup .mapboxgl-popup-content { padding: 0; background: none; box-shadow: none; border: none; }
        .custom-tracking-popup .mapboxgl-popup-tip { display: none; }

        @keyframes popup-glow {
            0% { border-color: transparent; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
            50% { border-color: #007bff; box-shadow: 0 0 25px rgba(0,123,255,0.6); }
            100% { border-color: transparent; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        }
        .animate-popup-glow { animation: popup-glow 1.2s ease-in-out; }
    `).appendTo('head');

    window.Echo.channel('dashboards.apps.trackings.monitors')
        .listen('.dashboards.apps.trackings.monitors', (response: any) => {
            const incomingUuid = response.data.uuid;

            mapInstance?.flyTo({
                center: [response.data.longitude, response.data.latitude],
                zoom: 19,
                speed: 3,
                essential: true
            });

            Object.values(markers).forEach(m => {
                if (m.popup.isOpen()) {
                    m.popup.remove();
                }
            });

            if (markers[incomingUuid]) {
                markers[incomingUuid].popup.addTo(mapInstance!);
            }

            fetchTracking(incomingUuid);
        });

    mapInstance.on('style.load', () => fetchTracking());

    const themeObserver = new MutationObserver(() => {
        const isDark = document.documentElement.classList.contains('dark');
        const newKey = isDark ? 'dark' : 'standard';
        if (newKey !== currentStyleKey) {
            currentStyleKey = newKey;
            mapInstance?.setStyle(MAP_STYLES[currentStyleKey as keyof typeof MAP_STYLES]);
        }
    });
    themeObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

    window.addEventListener('resize', () => mapInstance?.resize());
});
