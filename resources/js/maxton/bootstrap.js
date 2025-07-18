import axios from 'axios';
import $ from "jquery";

window.$ = window.jQuery = $;
window.axios = axios;
// Tambahkan di awal file JS utama
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
