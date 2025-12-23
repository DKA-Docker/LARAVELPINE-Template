import mapboxgl from "mapbox-gl";
import $ from "jquery";
import axios from "axios";
import URI from "urijs";
import moment from "moment";
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

    // --- JARVIS UI UTILITIES ---
    const typingQueue: { el: JQuery, text: string, speed: number }[] = [];
    let isTyping = false;

    function typeWriter(element: JQuery, text: string, speed: number = 30) {
        return new Promise<void>(resolve => {
            element.text('');
            let i = 0;
            function type() {
                if (i < text.length) {
                    element.text(element.text() + text.charAt(i));
                    i++;
                    setTimeout(type, speed);
                } else {
                    resolve();
                }
            }
            type();
        });
    }

    // --- SIDEBAR & TAB LOGIC (LAZY LOAD SUPPORT) ---
    // --- SIDEBAR & TAB LOGIC (DELEGATED EVENTS) ---
    // Handle Sidebar Toggle
    $(document).on('click', '#sidebar-toggle', function () {
        const $sidebar = $('#control-sidebar');
        const $btn = $(this);
        $sidebar.toggleClass('is-minimized');
        $btn.find('svg').toggleClass('rotate-180');

        // Use a longer timeout to match CSS transition (500ms) + buffer
        setTimeout(() => {
            mapInstance?.resize();
        }, 600);
    });

    // Handle Tab Switching
    $(document).on('click', '.tab-btn', function () {
        const target = $(this).data('tab');
        $('.tab-btn').removeClass('is-active');
        $(this).addClass('is-active');
        $('.tab-content').addClass('hidden');
        $(`#tab-${target}`).removeClass('hidden').addClass('animate-in fade-in duration-500');
    });

    // Handle Unit Search
    $(document).on('input', '#unit-search', function () {
        const val = ($(this).val() as string).toLowerCase();
        $('.unit-item').each(function () {
            const name = $(this).find('.unit-item-name').text().toLowerCase();
            $(this).toggle(name.includes(val));
        });
    });

    // Handle Unit Item Click
    $(document).on('click', '.unit-item', function () {
        const id = $(this).data('id');
        if (markers[id]) {
            const data = markers[id].lastData;
            selectedAccountId = id;
            updateUI(data, false);
            mapInstance?.flyTo({ center: markers[id].lastCoord, zoom: 16, essential: true, speed: 1.5, curve: 1 });
        }
    });

    function initSidebar() {
        if ($('#control-sidebar').length === 0) return;

        // Trigger initial data population if data exists
        if (mapInstance && Object.keys(markers).length > 0) {
            // Need to reconstruct unit list if sidebar came late
            const drivers = Object.values(markers).map(m => m.lastData);
            updateUnitList(drivers);
        }

        // Force Map Resize after layout shift
        setTimeout(() => {
            mapInstance?.resize();
        }, 300);
    }

    // Listen for Livewire/Alpine event
    document.addEventListener('intel-hub-ready', initSidebar);
    // Also check immediately in case it's already there
    initSidebar();

    function updateHudTime() {
        $('#hud-time').text(moment().format('HH:mm:ss'));
        requestAnimationFrame(updateHudTime);
    }
    updateHudTime();

    /** TACTICAL LOGGING SYSTEM (ENHANCED) */
    function addLog(msg: string, type: 'info' | 'alert' | 'danger' | 'success' = 'info', details?: any) {
        let colorClass = 'text-blue-200/60';
        let icon = '>>';
        if (type === 'alert') { colorClass = 'text-blue-400'; icon = 'SYNC'; }
        if (type === 'danger') { colorClass = 'text-red-400'; icon = 'WARN'; }
        if (type === 'success') { colorClass = 'text-emerald-400'; icon = 'EXEC'; }

        let detailHtml = '';
        if (details) {
            detailHtml = `<div class="mt-1 flex flex-wrap gap-2 text-[8px] font-mono opacity-60">
                ${details.speed ? `<span class="text-blue-300">SPD:${details.speed}</span>` : ''}
                ${details.lat ? `<span>POS:${parseFloat(details.lat).toFixed(4)},${parseFloat(details.lng).toFixed(4)}</span>` : ''}
            </div>`;
        }

        const html = `
            <div class="border-l border-white/10 pl-3 py-1 mb-1 animate-in slide-in-from-left-2 duration-200">
                <div class="flex gap-2 items-center">
                    <span class="text-[8px] font-mono opacity-30 text-blue-200">${moment().format('HH:mm:ss')}</span>
                    <p class="text-[9px] font-bold tracking-tight ${colorClass} uppercase">[${icon}] ${msg}</p>
                </div>
                ${detailHtml}
            </div>`;

        $('#log-container').prepend(html);
        if ($('#log-container').children().length > 10) $('#log-container').children().last().remove();
    }

    // --- THEME MUTATION OBSERVER ---
    const updateMapStyle = () => {
        const isDark = document.documentElement.classList.contains('dark');
        const style = isDark ? 'mapbox://styles/mapbox/dark-v11' : 'mapbox://styles/mapbox/light-v11';
        if (mapInstance) mapInstance.setStyle(style);
    };

    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                updateMapStyle();
            }
        });
    });

    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

    // --- MAP RESIZE OBSERVER (ROBUST) ---
    // Automatically resize map whenever the container size changes (e.g., sidebar toggle)
    const paddingObserver = new ResizeObserver(() => {
        mapInstance?.resize();
    });
    const mapContainer = document.getElementById('map');
    if (mapContainer) paddingObserver.observe(mapContainer.parentElement as HTMLElement);

    // --- MARKER CREATION ---
    function createMarker(d: any) {
        const id = d.account.id;
        const pos: [number, number] = [parseFloat(d.longitude), parseFloat(d.latitude)];
        const el = document.createElement('div');
        el.className = 'marker-car';
        el.innerHTML = `
            <div class="pulse-ring"></div>
            <div class="pulse-danger"></div>
            <div class="marker-icon-wrapper transition-transform duration-300">
                <span class="car-icon text-3xl filter drop-shadow-[0_0_8px_rgba(59,130,246,0.8)]">🚀</span>
            </div>
        `;

        el.onclick = (e) => {
            e.stopPropagation();
            selectedAccountId = id;
            updateUI(markers[id].lastData, false);
            mapInstance?.flyTo({ center: markers[id].lastCoord, zoom: 16, essential: true, speed: 1.5 });
        };

        markers[id] = {
            marker: new mapboxgl.Marker(el).setLngLat(pos).addTo(mapInstance!),
            element: el,
            lastCoord: pos,
            lastData: d
        };
    }
    async function updateUI(driver: any, isLive: boolean = false) {
        const acc = driver.account;
        const info = acc?.information;
        const fcm = acc?.firebase?.token;
        const id = acc?.id || "N/A";
        const fullName = info ? `${info.first_name} ${info.last_name}` : 'Unknown Unit';

        if ($('#control-sidebar').hasClass('is-minimized')) {
            $('#control-sidebar').removeClass('is-minimized');
            $('#sidebar-toggle').find('i').removeClass('rotate-180');
            setTimeout(() => mapInstance?.resize(), 510);
        }

        $('.tab-btn[data-tab="detail"]').click();
        $('.marker-car').removeClass('is-active');
        if (markers[id]) $(markers[id].element).addClass('is-active');

        $('.unit-item').removeClass('bg-blue-500/10 border-blue-500/30');
        $(`.unit-item[data-id="${id}"]`).addClass('bg-blue-500/10 border-blue-500/30');

        // Typing Animations for Detail View
        if (!isLive) { // Only animate text on explicit selection
            await Promise.all([
                typeWriter($('#unit-name'), fullName, 20),
                typeWriter($('#unit-id'), `${isLive ? 'LIVE' : 'CACHE'}: NODE-${id.toString().substring(0, 8).toUpperCase()}`, 10)
            ]);
        } else {
            $('#unit-name').text(fullName);
            $('#unit-id').text(`${isLive ? 'LIVE' : 'CACHE'}: NODE-${id.toString().substring(0, 8).toUpperCase()}`);
        }

        $('#unit-speed').html(`${parseFloat(driver.speed || 0).toFixed(2)} <small class="text-[9px] text-white/30">KM/H</small>`);
        $('#unit-time').text(moment(driver.created_at).format('HH:mm:ss'));

        if (info?.avatar) $('#unit-avatar').attr('src', `/storage/${info.avatar}`);
        $('#btn-ping-driver, #btn-alarm-driver, #log-widget').removeClass('hidden');

        if (isLive) {
            addLog(`INCOMING STREAM: ${fullName}`, 'alert', { speed: parseFloat(driver.speed).toFixed(1) });
        }

        // --- BUTTON HANDLERS ---
        $('#btn-ping-driver').off('click').on('click', async function () {
            const $b = $(this).addClass('is-loading');
            addLog(`CMD: LOC REQUEST [${fullName.toUpperCase()}]`, 'info');
            try {
                const url = URI(window.location).segment([...URI(window.location).segment(), 'monitors', 'request-location-update']).toString();
                await axios.post(url, { token: fcm, driver_name: info?.first_name });
                addLog(`ACK: COMMAND RECEIVED`, 'success');
            } catch (e) {
                addLog(`ERR: PACKET LOSS`, 'danger');
            } finally {
                setTimeout(() => $b.removeClass('is-loading'), 2000);
            }
        });

        $('#btn-alarm-driver').off('click').on('click', async function () {
            const $b = $(this).addClass('is-loading');
            addLog(`CMD: ALARM PROTOCOL [${fullName.toUpperCase()}]`, 'danger');
            try {
                const url = URI(window.location).segment([...URI(window.location).segment(), 'monitors', 'request-alarm']).toString();
                await axios.post(url, { token: fcm, driver_name: info?.first_name });
                addLog(`ACK: ALARM TRIGGERED`, 'success');
            } catch (e) {
                addLog(`ERR: SIGNAL BLOCKED`, 'danger');
            } finally {
                setTimeout(() => $b.removeClass('is-loading'), 4000);
            }
        });
    }

    function updateUnitList(drivers: any[]) {
        const container = $('#unit-list-container');
        container.empty();
        $('#hud-active-count').text(drivers.length.toString().padStart(2, '0'));

        drivers.forEach(d => {
            const info = d.account?.information;
            const id = d.account.id;
            const html = `
                <div class="unit-item group p-3 rounded-xl border border-blue-200 dark:border-white/5 bg-white/50 dark:bg-white/[0.02] flex items-center gap-3 cursor-pointer hover:bg-blue-50 dark:hover:bg-white/10 hover:border-blue-400/50 transition-all shadow-sm dark:shadow-none" data-id="${id}">
                    <div class="relative shrink-0">
                        <img src="${info?.avatar ? '/storage/' + info.avatar : '/storage/media/avatars/blank.png'}" class="size-9 rounded-lg border border-blue-100 dark:border-white/10 object-cover shadow-sm bg-white">
                        <div class="absolute -bottom-0.5 -right-0.5 size-2 bg-emerald-500 rounded-full shadow-[0_0_5px_#10b981] ring-2 ring-white dark:ring-black"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="unit-item-name text-[10px] font-black uppercase tracking-tight text-gray-800 dark:text-white group-hover:text-blue-700 dark:group-hover:text-blue-400 transition-colors truncate">${info?.first_name || 'Unit'} ${info?.last_name || ''}</div>
                        <div class="text-[8px] font-mono font-bold opacity-100 dark:opacity-30 uppercase truncate text-gray-600 dark:text-gray-400">NODE-${id.toString().substring(0, 6)}</div>
                    </div>
                    <div class="text-right shrink-0">
                        <div class="text-[9px] font-black text-blue-700 dark:text-blue-400 italic">${parseFloat(d.speed || 0).toFixed(0)} <span class="text-[7px] opacity-100 dark:opacity-50 not-italic text-gray-500 dark:text-white">KM</span></div>
                    </div>
                </div>`;
            container.append(html);
        });


    }

    mapboxgl.accessToken = getCfg('mapbox-token');
    mapInstance = new mapboxgl.Map({
        container: "map",
        style: document.documentElement.classList.contains('dark') ? 'mapbox://styles/mapbox/dark-v11' : 'mapbox://styles/mapbox/light-v11',
        center: [119.4365, -5.1477], zoom: 12,
        attributionControl: false
    });

    // --- MARKER CREATION ---


    async function fetchAll() {
        try {
            const res = await axios.get(URI(window.location).segment([...URI(window.location).segment(), 'monitors']).toString());
            const drivers = res.data.data;
            drivers.forEach((d: any) => {
                const id = d.account.id;
                const pos: [number, number] = [parseFloat(d.longitude), parseFloat(d.latitude)];
                if (!markers[id]) createMarker(d);
                else {
                    markers[id].marker.setLngLat(pos);
                    markers[id].lastCoord = pos;
                    markers[id].lastData = d;
                }
            });
            updateUnitList(drivers);
            addLog(`SYSTEM INITIALIZED: ${drivers.length} NODES ONLINE`, 'success');
        } catch (e) { }
    }

    // --- ECHO LISTENERS ---
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

            selectedAccountId = id;
            updateUI(d, true);
            mapInstance?.flyTo({ center: newPos, zoom: 17, essential: true, speed: 2 });

            // Pulse animation on map
            $(markers[id].element).find('.pulse-ring').css({ animation: 'none' });
            setTimeout(() => $(markers[id].element).find('.pulse-ring').css({ animation: 'dramatic-pulse 2s infinite ease-out' }), 10);
            setTimeout(() => $(markers[id].element).find('.pulse-ring').css({ animation: 'none' }), 3000);

            const existingInList = $(`.unit-item[data-id="${id}"]`);
            if (existingInList.length > 0) {
                existingInList.find('.text-blue-400').html(`${parseFloat(d.speed || 0).toFixed(0)} <span class="text-[7px] opacity-50 not-italic text-white">KM</span>`);
            }
        });

    window.Echo.channel('dashboards.apps.trackings.alarms')
        .listen('.dashboards.apps.trackings.alarms', (res: any) => {
            const accId = res.data.account.id;
            const name = res.data.account.information?.first_name || 'Unit';
            addLog(`WARNING: ALARM SIGNAL [${name.toUpperCase()}]`, 'danger', { event: 'ALARM' });
            if (markers[accId]) {
                $(markers[accId].element).find('.pulse-danger').css({ animation: 'dramatic-pulse 0.8s infinite ease-out' });
                setTimeout(() => $(markers[accId].element).find('.pulse-danger').css({ animation: 'none' }), 10000);
            }
        });

    mapInstance.on('load', fetchAll);
    mapInstance.on('click', (e) => {
        if (!$(e.originalEvent.target as any).closest('.marker-car').length) {
            selectedAccountId = null;
            $('.marker-car').removeClass('is-active');
            $('.unit-item').removeClass('bg-blue-500/10 border-blue-500/30');
            $('#unit-name').text('System Ready');
            $('#btn-ping-driver, #btn-alarm-driver, #log-widget').addClass('hidden');
        }
    });
});
