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

    // --- SIDEBAR & TAB LOGIC ---
    $('#sidebar-toggle').on('click', function() {
        $('#control-sidebar').toggleClass('is-minimized');
        $(this).toggleClass('rotate-180');
        setTimeout(() => { if (mapInstance) mapInstance.resize(); }, 500);
    });

    $('.tab-btn[data-tab="list"]').addClass('is-active');
    $('#tab-list').removeClass('hidden');

    $('.tab-btn').on('click', function() {
        const target = $(this).data('tab');
        $('.tab-btn').removeClass('is-active');
        $(this).addClass('is-active');
        $('.tab-content').addClass('hidden');
        $(`#tab-${target}`).removeClass('hidden').addClass('animate-in fade-in duration-500');
    });

    $('#unit-search').on('input', function() {
        const val = ($(this).val() as string).toLowerCase();
        $('.unit-item').each(function() {
            const name = $(this).find('.unit-item-name').text().toLowerCase();
            $(this).toggle(name.includes(val));
        });
    });

    /**
     * TACTICAL LOGGING SYSTEM
     */
    function addLog(msg: string, type: 'info' | 'alert' | 'danger' | 'success' = 'info', details?: any) {
        let colorClass = 'text-foreground/40';
        let icon = '>>';

        if (type === 'alert') { colorClass = 'text-primary'; icon = 'SYNC'; }
        if (type === 'danger') { colorClass = 'text-red-500'; icon = 'WARN'; }
        if (type === 'success') { colorClass = 'text-green-500'; icon = 'EXEC'; }

        let detailHtml = '';
        if (details) {
            detailHtml = `
                <div class="mt-1 flex flex-wrap gap-2 opacity-60 font-mono text-[9px]">
                    ${details.speed ? `<span class="bg-white/5 px-1 border border-white/5 rounded">SPD: ${details.speed} KM/H</span>` : ''}
                    ${details.lat ? `<span class="bg-white/5 px-1 border border-white/5 rounded">POS: ${parseFloat(details.lat).toFixed(4)}, ${parseFloat(details.lng).toFixed(4)}</span>` : ''}
                    ${details.event ? `<span class="bg-primary/20 text-primary px-1 font-bold rounded">${details.event}</span>` : ''}
                </div>
            `;
        }

        const html = `
            <div class="flex flex-col border-l-2 border-white/5 pl-4 py-2 mb-2 animate-in slide-in-from-left duration-300 hover:bg-white/[0.02] rounded-r-lg transition-colors">
                <div class="flex gap-3 items-center">
                    <span class="text-[8px] font-mono font-bold opacity-20 bg-white/5 px-1 rounded">${moment().format('HH:mm:ss')}</span>
                    <p class="text-[10px] font-black tracking-tight ${colorClass}">${icon} ${msg}</p>
                </div>
                ${detailHtml}
            </div>`;

        $('#log-container').prepend(html);
        if ($('#log-container').children().length > 15) $('#log-container').children().last().remove();
    }

    const updateMapStyle = () => {
        const isDark = document.documentElement.classList.contains('dark');
        const style = isDark ? 'mapbox://styles/mapbox/dark-v11' : 'mapbox://styles/mapbox/light-v11';
        if (mapInstance) mapInstance.setStyle(style);
    };
    const themeObserver = new MutationObserver(updateMapStyle);
    themeObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

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
        const fullName = info ? `${info.first_name} ${info.last_name}` : 'Unknown Unit';

        if($('#control-sidebar').hasClass('is-minimized')) {
            $('#control-sidebar').removeClass('is-minimized');
            $('#sidebar-toggle').removeClass('rotate-180');
        }

        $('.tab-btn[data-tab="detail"]').click();
        $('.marker-car').removeClass('is-active');
        if (markers[id]) $(markers[id].element).addClass('is-active');

        $('.unit-item').removeClass('bg-primary/10 border-primary/30');
        $(`.unit-item[data-id="${id}"]`).addClass('bg-primary/10 border-primary/30');

        $('#unit-name').text(fullName);
        $('#unit-id').text(`${isLive ? 'LIVE' : 'CACHE'}: NODE-${id.toString().substring(0,8).toUpperCase()}`).toggleClass('text-primary', isLive);
        $('#unit-speed').html(`${parseFloat(driver.speed || 0).toFixed(2)} <small class="text-xs opacity-30 font-bold not-italic font-black">KM/H</small>`);
        $('#unit-time').text(moment(driver.created_at).format('HH:mm:ss'));

        const displayLat = parseFloat(driver.latitude).toFixed(5);
        const displayLng = parseFloat(driver.longitude).toFixed(5);
        $('#unit-coords').text(`${displayLat}, ${displayLng}`);
        $('#unit-accuracy').text(driver.accuracy ? `${driver.accuracy} m` : 'N/A');

        if (info?.avatar) $('#unit-avatar').attr('src', `/storage/${info.avatar}`);
        $('#btn-ping-driver, #btn-alarm-driver, #log-widget').removeClass('hidden');

        if (isLive) {
            $('#control-sidebar').addClass('is-updating');
            triggerPulse(acc.id);
            addLog(`INCOMING DATA: ${fullName}`, 'alert', {
                speed: parseFloat(driver.speed).toFixed(1),
                lat: driver.latitude,
                lng: driver.longitude,
                event: 'PULSE_UPDATE'
            });
            setTimeout(() => $('#control-sidebar').removeClass('is-updating'), 3000);
        }

        // --- BUTTON HANDLERS ---
        $('#btn-ping-driver').off('click').on('click', async function() {
            const $b = $(this).addClass('is-loading');
            $('#control-sidebar').addClass('is-updating');
            addLog(`CMD: REQUESTING LOCATION [${fullName.toUpperCase()}]`, 'info');

            try {
                const url = URI(window.location).segment([...URI(window.location).segment(), 'monitors', 'request-location-update']).toString();
                await axios.post(url, { token: fcm, driver_name: info?.first_name });
                addLog(`PROTOCOL: COMMAND DISPATCHED`, 'success', { event: 'CMD_SENT' });
            } catch (e) {
                addLog(`ERROR: DISPATCH FAILED`, 'danger');
            } finally {
                setTimeout(() => { $b.removeClass('is-loading'); $('#control-sidebar').removeClass('is-updating'); }, 2000);
            }
        });

        $('#btn-alarm-driver').off('click').on('click', async function() {
            const $b = $(this).addClass('is-loading');
            $('#control-sidebar').addClass('is-updating is-commanding');
            addLog(`CMD: INITIATING ALARM [${fullName.toUpperCase()}]`, 'danger');

            try {
                const url = URI(window.location).segment([...URI(window.location).segment(), 'monitors', 'request-alarm']).toString();
                await axios.post(url, { token: fcm, driver_name: info?.first_name });
                addLog(`PROTOCOL: ALARM BROADCASTED`, 'success', { event: 'ALARM_SIG' });
            } catch (e) {
                addLog(`ERROR: ALARM FAILED`, 'danger');
            } finally {
                setTimeout(() => {
                    $b.removeClass('is-loading');
                    $('#control-sidebar').removeClass('is-updating is-commanding');
                }, 4000);
            }
        });
    }

    function updateUnitList(drivers: any[]) {
        const container = $('#unit-list-container');
        container.empty();
        drivers.forEach(d => {
            const info = d.account?.information;
            const id = d.account.id;
            const html = `
                <div class="unit-item group p-4 rounded-2xl border border-white/5 bg-white/[0.02] flex items-center gap-4 cursor-pointer hover:bg-white/10 hover:border-white/20 transition-all active:scale-[0.98]" data-id="${id}">
                    <div class="relative">
                        <img src="${info?.avatar ? '/storage/'+info.avatar : '/storage/media/avatars/blank.png'}" class="size-11 rounded-xl border border-white/10 object-cover">
                        <div class="absolute -bottom-1 -right-1 size-3 bg-green-500 border-2 border-background rounded-full"></div>
                    </div>
                    <div class="flex-1">
                        <div class="unit-item-name text-xs font-black uppercase tracking-tight text-foreground/80 group-hover:text-primary transition-colors">${info?.first_name || 'Unit'} ${info?.last_name || ''}</div>
                        <div class="text-[9px] font-mono opacity-30 uppercase">NODE-${id.toString().substring(0,8)}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-[10px] font-black text-primary italic">${parseFloat(d.speed || 0).toFixed(0)} <span class="text-[8px] opacity-50 not-italic">KM/H</span></div>
                        <div class="text-[8px] font-bold opacity-20 uppercase tracking-tighter mt-1">ACTIVE</div>
                    </div>
                </div>`;
            container.append(html);
        });

        $('.unit-item').on('click', function() {
            const id = $(this).data('id');
            const data = markers[id].lastData;
            selectedAccountId = id;
            updateUI(data, false);
            mapInstance?.flyTo({ center: markers[id].lastCoord, zoom: 16, essential: true });
        });
    }

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
        el.innerHTML = `<div class="pulse-ring"></div><div class="pulse-danger"></div><div class="marker-icon-wrapper"><span class="car-icon">🚗</span></div>`;

        el.onclick = (e) => {
            e.stopPropagation();
            selectedAccountId = id;
            updateUI(markers[id].lastData, false);
            mapInstance?.flyTo({ center: markers[id].lastCoord, zoom: 16, essential: true });
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
        } catch (e) {}
    }

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

            // AUTO-SELECT ON ECHO
            selectedAccountId = id;
            updateUI(d, true);
            mapInstance?.flyTo({ center: newPos, zoom: 17, essential: true });

            const existingInList = $(`.unit-item[data-id="${id}"]`);
            if(existingInList.length > 0) {
                existingInList.find('.text-primary').html(`${parseFloat(d.speed || 0).toFixed(0)} <span class="text-[8px] opacity-50 not-italic">KM/H</span>`);
            }
        });

    window.Echo.channel('dashboards.apps.trackings.alarms')
        .listen('.dashboards.apps.trackings.alarms', (res: any) => {
            const accId = res.data.account.id;
            const name = res.data.account.information?.first_name || 'Unit';
            addLog(`ALERT: EMERGENCY ALARM TRIGGERED BY ${name.toUpperCase()}`, 'danger', { event: 'ALARM_RCV' });
            triggerAlarmPulse(accId);
        });

    mapInstance.on('load', fetchAll);
    mapInstance.on('click', (e) => {
        if (!$(e.originalEvent.target as any).closest('.marker-car').length) {
            selectedAccountId = null;
            $('.marker-car').removeClass('is-active');
            $('.unit-item').removeClass('bg-primary/10 border-primary/30');
            $('#unit-name').text('System Ready');
            $('#btn-ping-driver, #btn-alarm-driver, #log-widget').addClass('hidden');
        }
    });
});
