import axios from 'axios';

const checkSession = () => {
    axios.get('/dashboards/check-session')
        .catch((error) => {
            if (error.response && (error.response.status === 401 || error.response.status === 419)) {
                // Session expired or unauthorized
                window.location.href = '/auth';
            }
        });
};

// Check on Livewire navigation
document.addEventListener('livewire:navigating', () => {
    checkSession();
});

// Optional: Global Axios interceptor for other requests
axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response && (error.response.status === 401 || error.response.status === 419)) {
            window.location.href = '/auth';
        }
        return Promise.reject(error);
    }
);
