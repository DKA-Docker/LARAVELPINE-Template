import ApexCharts from "apexcharts";
import $ from "jquery";

// Listen for Livewire component lazy load event
document.addEventListener('overview-ready', () => {
    initCharts();
});

const initCharts = () => {
    const commonOptions = {
        fontFamily: 'inherit',
    };

    // --- DONUT CHART ---
    const donutEl = document.getElementById('chart-donut');
    if (donutEl) {
        const donutOptions = {
            ...commonOptions,
            series: [44, 55, 41, 17],
            labels: ['Delivered', 'In Transit', 'Pending', 'Failed'],
            chart: {
                type: 'donut',
                height: 350,
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                }
            },
            colors: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '12px',
                                fontFamily: 'inherit',
                            },
                            value: {
                                show: true,
                                fontSize: '24px',
                                fontFamily: 'inherit',
                                fontWeight: 700,
                            },
                            total: {
                                show: true,
                                label: 'Total',
                                fontSize: '14px',
                                formatter: function (w: any) {
                                    return w.globals.seriesTotals.reduce((a: any, b: any) => a + b, 0)
                                }
                            }
                        }
                    }
                }
            },
            stroke: { show: false },
            dataLabels: { enabled: false },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                markers: { radius: 12 },
                itemMargin: { horizontal: 10, vertical: 5 }
            },
            tooltip: {
                theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
            }
        };
        new ApexCharts(donutEl, donutOptions).render();
    }

    // --- LINE CHART (AREA) ---
    const lineEl = document.getElementById('chart-line');
    if (lineEl) {
        const lineOptions = {
            ...commonOptions,
            series: [{
                name: "Deliveries",
                data: [30, 40, 35, 50, 49, 60, 70, 91, 125, 140, 135, 150]
            }],
            chart: {
                height: 350,
                type: 'area', // Area looks more "attractive" usually
                toolbar: { show: false },
                zoom: { enabled: false }
            },
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: { colors: '#9ca3af', fontSize: '12px' }
                }
            },
            yaxis: {
                labels: {
                    style: { colors: '#9ca3af', fontSize: '12px' }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            colors: ['#3b82f6'], // Blue
            grid: {
                borderColor: 'rgba(255, 255, 255, 0.1)', // Subtle grid
                strokeDashArray: 4,
                yaxis: { lines: { show: true } },
                xaxis: { lines: { show: false } }
            },
            tooltip: {
                theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
            }
        };
        new ApexCharts(lineEl, lineOptions).render();
    }

    // --- DEMOGRAPHY CHART (BAR) ---
    const demoEl = document.getElementById('chart-demography');
    if (demoEl) {
        const demoOptions = {
            ...commonOptions,
            series: [{
                name: 'Deliveries',
                data: [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380]
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true,
                    distributed: true,
                    barHeight: '70%'
                }
            },
            colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e', '#f48024', '#69d2e7'],
            dataLabels: { enabled: false },
            xaxis: {
                categories: ['South Jakarta', 'Bandung', 'Semarang', 'Surabaya', 'Medan', 'Makassar', 'Denpasar', 'West Jakarta', 'East Jakarta', 'Central Jakarta'],
                labels: {
                    style: { colors: '#9ca3af', fontSize: '12px' }
                }
            },
            yaxis: {
                labels: {
                    style: { colors: '#9ca3af', fontSize: '12px' }
                }
            },
            grid: {
                borderColor: 'rgba(255, 255, 255, 0.1)',
                xaxis: { lines: { show: true } },
                yaxis: { lines: { show: false } }
            },
            legend: { show: false },
            tooltip: {
                theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
                y: {
                    formatter: function (val: number) {
                        return val + " orders"
                    }
                }
            }
        };
        new ApexCharts(demoEl, demoOptions).render();
    }
};
