// resources/ts/bootstrap.ts

import axios from 'axios';
import ApexCharts from 'apexcharts';
import jQuery from 'jquery';

// Biar TypeScript nggak ngamuk kalau kita tempel ke window
declare global {
    interface Window {
        $: typeof jQuery;
        jQuery: typeof jQuery;
        axios: typeof axios;
        ApexCharts: typeof ApexCharts;
    }
}

// Assign ke window (global)
window.$ = window.jQuery = jQuery;

window.axios = axios;
//window.axios.defaults.headers.common['X-CSRF-TOKEN'] = $("meta[name='csrf-token']").attr("content");
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.ApexCharts = ApexCharts;

// Supaya file ini dianggap sebagai module (wajib di TS kalau pakai declare global)
export {};
