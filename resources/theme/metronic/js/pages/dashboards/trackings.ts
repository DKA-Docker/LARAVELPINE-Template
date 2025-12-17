import mapboxgl from "mapbox-gl";
import $ from "jquery";
import axios from "axios";
import URI from "urijs";
import moment from "moment";
import { initializeApp } from "firebase/app";
import PerfectScrollbar from "perfect-scrollbar";
import "perfect-scrollbar/css/perfect-scrollbar.css";

// ==========================================
// 1. KONFIGURASI & INISIALISASI DASAR
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

// State Global
let mapInstance: mapboxgl.Map | null = null;
const markers: Record<string, {
    marker: mapboxgl.Marker;
    popup: mapboxgl.Popup;
    contentElement?: HTMLElement;
}> = {};

// ==========================================
// 2. FUNGSI LOGIKA DATA (API & TRACKING)
// ==========================================

/**
 * Mengambil data koordinat terbaru dari server dan memperbarui marker di peta
 */
async function fetchTracking() {
    try {
        const fullUri = URI(window.location);
        const fetchUrl = fullUri.segment([...fullUri.segment(), 'monitors']).toString();
        const res = await axios.get(fetchUrl);
        const drivers = res.data.data;

        // Filter: Hanya ambil data terbaru per UUID
        const latestPerUuid: Record<string, any> = {};
        drivers.forEach((d: any) => {
            if (!latestPerUuid[d.uuid] || new Date(d.created_at) > new Date(latestPerUuid[d.uuid].created_at)) {
                latestPerUuid[d.uuid] = d;
            }
        });

        updateMarkersOnMap(latestPerUuid);
    } catch (error) {
        console.error("Gagal update tracking:", error);
    }
}

/**
 * Mengirim perintah ke Laravel untuk memicu driver melakukan update lokasi (FCM)
 */
async function sendReloadNotification(fcmToken: string, driverName: string, uuid: string) {
    if (!fcmToken) {
        alert(`Driver ${driverName} tidak memiliki token FCM.`);
        return;
    }
    try {
        const fullUri = URI(window.location);
        const fetchUrl = fullUri.segment([...fullUri.segment(), 'monitors', 'token']).toString();
        const response = await axios.post(fetchUrl, {
            token: fcmToken,
            driver_name: driverName
        });

        if (response.data.status === 'success') {
            alert(`Perintah pembaruan lokasi berhasil dikirim ke ${driverName}`);

            // Animasi Kamera: Fokus ke target setelah reload berhasil
            if (markers[uuid] && mapInstance) {
                mapInstance.flyTo({
                    center: markers[uuid].marker.getLngLat(),
                    zoom: 16,
                    speed: 1.2,
                    essential: true
                });
            }
        }
    } catch (error: any) {
        console.error("FCM Error via Laravel:", error);
        alert("Gagal mengirim perintah reload.");
    }
}

// ==========================================
// 3. FUNGSI UI & MARKER (TAMPILAN)
// ==========================================

/**
 * Template untuk konten di dalam popup marker
 */
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

/**
 * Merender atau memperbarui posisi marker di Mapbox
 */
function updateMarkersOnMap(latestPerUuid: Record<string, any>) {
    const isDark = document.documentElement.classList.contains('dark');
    const colors = isDark ?
        { bg: '#2b2b2b', text: '#ffffff', divider: '#444' } :
        { bg: '#ffffff', text: '#333333', divider: '#eee' };

    Object.values(latestPerUuid).forEach((driver: any) => {
        const coord: [number, number] = [driver.longitude, driver.latitude];
        const fullName = `${driver.account.information.first_name} ${driver.account.information.last_name}`;
        const fcmToken = driver.account?.firebase?.token;

        if (!markers[driver.uuid]) {
            // Pembuatan Marker Baru
            const popupContainer = createPopupContainer(driver, fullName, fcmToken, colors);

            const popup = new mapboxgl.Popup({ offset: 25, closeButton: false, className: 'custom-tracking-popup' })
                .setDOMContent(popupContainer.container);

            const el = document.createElement('div');
            el.innerHTML = '🚗'; el.style.fontSize = '28px'; el.style.cursor = 'pointer';

            markers[driver.uuid] = {
                marker: new mapboxgl.Marker(el).setLngLat(coord).setPopup(popup).addTo(mapInstance!),
                popup,
                contentElement: popupContainer.contentElement
            };
        } else {
            // Update Marker yang sudah ada
            const target = markers[driver.uuid];
            target.marker.setLngLat(coord);
            if (target.contentElement) {
                target.contentElement.innerHTML = generatePopupHTML(driver, fullName, colors);
            }
        }
    });
}

/**
 * Helper untuk membuat elemen DOM Popup (Tombol Reload, Close, & Konten)
 */
function createPopupContainer(driver: any, fullName: string, fcmToken: string, colors: any) {
    const container = document.createElement('div');
    Object.assign(container.style, {
        padding: '12px', background: colors.bg, color: colors.text,
        borderRadius: '8px', position: 'relative', minWidth: '260px',
        boxShadow: '0 4px 15px rgba(0,0,0,0.2)', fontFamily: 'sans-serif'
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

// ==========================================
// 4. MAIN ENTRY POINT (WINDOW LOAD)
// ==========================================

$(window).on('load', async function () {
    const elementExists = $("div.dashboards-apps-trackings");
    if (elementExists.length === 0 || $('#map').length === 0) return;

    // A. Init Firebase
    initializeApp(FIREBASE_CONFIG);

    // B. Init Mapbox
    mapboxgl.accessToken = 'pk.eyJ1IjoieW92YW5nZ2EiLCJhIjoiY2tmNXZ3bG0wMHFzMzJxbnkwbmNybXVpaiJ9.cfXmJlhcnmnc-PFtWyFnzA';

    let currentStyleKey = document.documentElement.classList.contains('dark') ? 'dark' : 'standard';

    mapInstance = new mapboxgl.Map({
        container: "map",
        style: MAP_STYLES[currentStyleKey as keyof typeof MAP_STYLES],
        center: [119.4365, -5.1477],
        zoom: 12,
        projection: 'globe'
    });

    // C. Pindah Tema Otomatis (Dark/Light)
    const themeObserver = new MutationObserver(() => {
        const isDark = document.documentElement.classList.contains('dark');
        const newKey = isDark ? 'dark' : 'standard';
        if (newKey !== currentStyleKey) {
            currentStyleKey = newKey;
            mapInstance?.setStyle(MAP_STYLES[currentStyleKey as keyof typeof MAP_STYLES]);
        }
    });
    themeObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

    // D. Event Map Load & Loop Interval
    mapInstance.on('style.load', () => {
        fetchTracking();
    });

    // @ts-ignore
    window.Echo.channel('dashboards.apps.trackings.monitors')
        .listen('.dashboards/apps/trackings/monitors', (response: { data: any; }) => {
            console.log("Data Monitoring Baru:", response.data);

            // Contoh aksi: Tampilkan notifikasi toast
            alert("Ada data monitor baru masuk!");

            // Contoh aksi: Update table secara real-time
            // updateTableData(response.data);
        });

    setInterval(fetchTracking, 2000);

    // E. Inject Custom CSS
    $('<style>').text(`
        .custom-tracking-popup .mapboxgl-popup-content { padding: 0; background: none; box-shadow: none; border: none; }
        .custom-tracking-popup .mapboxgl-popup-tip { display: none; }
    `).appendTo('head');

    window.addEventListener('resize', () => mapInstance?.resize());
});
