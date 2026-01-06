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
};

// Register Alpine component for interactive Demography Chart
document.addEventListener('alpine:init', () => {
    // @ts-ignore
    Alpine.data('overviewChart', (initialData: any) => ({
        demographics: initialData,
        chart: null as any,

        init() {
            this.renderChart();

            // Listen for Livewire event
            // @ts-ignore
            this.$wire.on('overview-update-chart', (event: any) => {
                this.demographics = event.data;
                this.updateChart();
            });
        },

        renderChart() {
            const element = document.getElementById('chart-demography');
            if (!element) return;

            // @ts-ignore
            const data = this.demographics;

            const options = {
                series: [{
                    name: 'Tasks',
                    data: data.series
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: { show: false },
                    events: {
                        dataPointSelection: (event: any, chartContext: any, config: any) => {
                            // @ts-ignore
                            const data = this.demographics;
                            if (data && data.ids && data.target_property) {
                                const index = config.dataPointIndex;
                                const id = data.ids[index];
                                const property = data.target_property;

                                // @ts-ignore
                                if (this.$wire && property) {
                                    // @ts-ignore
                                    this.$wire.set(property, id);
                                }
                            }
                        }
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                        distributed: true, // Enable distributed colors
                    }
                },
                legend: {
                    show: false // Often better to hide legend when distributed
                },
                dataLabels: { enabled: false },
                xaxis: {
                    categories: data.labels,
                },
                // Use a diverse palette
                colors: [
                    '#3E97FF', // Primary
                    '#F1416C', // Danger
                    '#50CD89', // Success
                    '#FFC700', // Warning
                    '#7239EA', // Info
                    '#009EF7', // Azure
                    '#181C32', // Dark
                    '#D83556', // Rose
                    '#F6C000', // Yellow-ish
                    '#3F4254'  // Gray-ish
                ],
                grid: {
                    borderColor: '#f1f1f1',
                },
                tooltip: {
                    theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
                    y: {
                        formatter: function (val: any) {
                            return val
                        }
                    }
                }
            };

            // @ts-ignore
            this.chart = new ApexCharts(element, options);
            this.chart.render();
        },

        updateChart() {
            // @ts-ignore
            if (!this.chart) return;
            // @ts-ignore
            const data = this.demographics;

            // @ts-ignore
            this.chart.updateOptions({
                xaxis: {
                    categories: data.labels
                }
            });

            // @ts-ignore
            this.chart.updateSeries([{
                data: data.series
            }]);
        }
    }));
});
