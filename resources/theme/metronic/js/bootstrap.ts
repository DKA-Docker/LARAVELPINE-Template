// resources/ts/bootstrap.ts

import axios from 'axios';
import ApexCharts from 'apexcharts';
import jQuery from 'jquery';
import moment from "moment-timezone";
import { Livewire } from '../../../../vendor/livewire/livewire/dist/livewire.esm'
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
// Biar TypeScript nggak ngamuk kalau kita tempel ke window
declare global {
    interface Window {
        $: typeof jQuery;
        jQuery: typeof jQuery;
        axios: typeof axios;
        Pusher: typeof Pusher;
        Echo: Echo<"reverb">;
        Livewire: typeof Livewire;
        ApexCharts: typeof ApexCharts;
    }
}

// Assign ke window (global)
window.$ = window.jQuery = jQuery;
window.axios = axios;

//window.axios.defaults.headers.common['X-CSRF-TOKEN'] = $("meta[name='csrf-token']").attr("content");
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/** Set Locale Menjadi Indonesia **/
moment.locale("id")

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'reverb', // atau 'pusher'
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    forceTLS: false,
    enabledTransports: ['ws', 'wss'],
});

window.ApexCharts = ApexCharts;

// Supaya file ini dianggap sebagai module (wajib di TS kalau pakai declare global)
export {};
