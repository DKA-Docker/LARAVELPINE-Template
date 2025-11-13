import axios from 'axios';
import ApexCharts from 'apexcharts';
import $ from "jquery";

window.$ = window.jQuery = $;
window.axios = axios;
window.ApexCharts = ApexCharts; // return apex chart
// Tambahkan di awal file JS utama
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
