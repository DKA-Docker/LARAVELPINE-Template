// resources/ts/bootstrap.ts

import axios from 'axios';
import ApexCharts from 'apexcharts';
import jQuery from 'jquery';
import moment from "moment-timezone";
import { Livewire } from '../../../../vendor/livewire/livewire/dist/livewire.esm'
// Biar TypeScript nggak ngamuk kalau kita tempel ke window
declare global {
    interface Window {
        $: typeof jQuery;
        jQuery: typeof jQuery;
        axios: typeof axios;
        Livewire: typeof Livewire;
        ApexCharts: typeof ApexCharts;
    }
}

// Assign ke window (global)
window.$ = window.jQuery = jQuery;
window.axios = axios;
// 👉 tambahkan ini biar global:
window.Livewire = Livewire

Livewire.start()
//window.axios.defaults.headers.common['X-CSRF-TOKEN'] = $("meta[name='csrf-token']").attr("content");
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/** Set Locale Menjadi Indonesia **/
moment.locale("id")

window.ApexCharts = ApexCharts;

// Supaya file ini dianggap sebagai module (wajib di TS kalau pakai declare global)
export {};
