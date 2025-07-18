import axios from 'axios';
window.axios = axios;
// Tambahkan di awal file JS utama
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
