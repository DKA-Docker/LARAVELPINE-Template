import $ from 'jquery';
import ApexCharts from "apexcharts";

$(function () {
    const charts = [
        {
            id: '#chart1',
            options: {
                series: [78],
                chart: {
                    height: 180,
                    type: 'radialBar',
                    toolbar: { show: false }
                },
                plotOptions: {
                    radialBar: {
                        startAngle: -115,
                        endAngle: 115,
                        hollow: {
                            size: '80%',
                            background: 'transparent',
                            dropShadow: { enabled: false }
                        },
                        track: {
                            background: 'rgba(0, 0, 0, 0.1)',
                            strokeWidth: '67%',
                            dropShadow: { enabled: false }
                        },
                        dataLabels: {
                            show: true,
                            name: { show: false },
                            value: {
                                offsetY: 10,
                                color: '#111',
                                fontSize: '24px',
                                show: true
                            }
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        type: 'horizontal',
                        gradientToColors: ['#ffd200'],
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100]
                    }
                },
                colors: ["#ee0979"],
                stroke: { lineCap: 'round' },
                labels: ['Total Orders']
            }
        },
        {
            id: '#chart2',
            options: {
                series: [{ name: "Net Sales", data: [4, 10, 25, 12, 25, 18, 40, 22, 7] }],
                chart: {
                    height: 105,
                    type: 'area',
                    sparkline: { enabled: true },
                    zoom: { enabled: false }
                },
                dataLabels: { enabled: false },
                stroke: { width: 3, curve: 'smooth' },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        gradientToColors: ['#0866ff'],
                        opacityFrom: 0.5,
                        opacityTo: 0.0,
                        type: 'vertical'
                    }
                },
                colors: ["#02c27a"],
                tooltip: {
                    theme: "dark",
                    x: { show: false },
                    y: { title: { formatter: () => "" } },
                    marker: { show: false }
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
                }
            }
        },
        {
            id: '#chart3',
            options: {
                series: [{ name: "Net Sales", data: [4, 10, 12, 17, 25, 30, 40, 55, 68] }],
                chart: {
                    height: 120,
                    type: 'bar',
                    sparkline: { enabled: true },
                    zoom: { enabled: false }
                },
                dataLabels: { enabled: false },
                stroke: { width: 1, curve: 'smooth', color: ['transparent'] },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        gradientToColors: ['#7928ca'],
                        opacityFrom: 1,
                        opacityTo: 1,
                        type: 'vertical',
                        stops: [0, 100]
                    }
                },
                colors: ["#ff0080"],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 4,
                        borderRadiusApplication: 'around',
                        borderRadiusWhenStacked: 'last',
                        columnWidth: '45%'
                    }
                },
                tooltip: {
                    theme: "dark",
                    x: { show: false },
                    y: { title: { formatter: () => "" } },
                    marker: { show: false }
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
                }
            }
        },
        {
            id: '#chart4',
            options: {
                series: [{ name: "Net Sales", data: [4, 25, 14, 34, 10, 39] }],
                chart: {
                    height: 105,
                    type: 'line',
                    sparkline: { enabled: true },
                    zoom: { enabled: false }
                },
                dataLabels: { enabled: false },
                stroke: { width: 3, curve: 'straight' },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        gradientToColors: ['#00f2fe'],
                        opacityFrom: 1,
                        opacityTo: 1,
                        type: 'vertical',
                        stops: [0, 100]
                    }
                },
                colors: ["#ee0979"],
                tooltip: {
                    theme: "dark",
                    x: { show: false },
                    y: { title: { formatter: () => "" } },
                    marker: { show: false }
                },
                markers: { show: false, size: 5 },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
                }
            }
        },
        {
            id: '#chart5',
            options: {
                series: [{ name: "Desktops", data: [14, 41, 35, 51, 25, 18, 21, 35, 15] }],
                chart: {
                    foreColor: "#9ba7b2",
                    height: 280,
                    type: 'bar',
                    toolbar: { show: false },
                    sparkline: { enabled: false },
                    zoom: { enabled: false }
                },
                dataLabels: { enabled: false },
                stroke: { width: 1, curve: 'smooth' },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 4,
                        borderRadiusApplication: 'around',
                        borderRadiusWhenStacked: 'last',
                        columnWidth: '45%'
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        gradientToColors: ['#009efd'],
                        opacityFrom: 1,
                        opacityTo: 1,
                        type: 'vertical',
                        stops: [0, 100]
                    }
                },
                colors: ["#2af598"],
                grid: {
                    show: true,
                    borderColor: 'rgba(255, 255, 255, 0.1)'
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
                },
                tooltip: {
                    theme: "dark",
                    marker: { show: false }
                }
            }
        },
        {
            id: '#chart6',
            options: {
                series: [58, 25, 25],
                chart: {
                    height: 290,
                    type: 'donut'
                },
                legend: { position: 'bottom', show: false },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        gradientToColors: ['#ee0979', '#17ad37', '#ec6ead'],
                        opacityFrom: 1,
                        opacityTo: 1,
                        type: 'vertical'
                    }
                },
                colors: ["#ff6a00", "#98ec2d", "#3494e6"],
                dataLabels: { enabled: false },
                plotOptions: {
                    pie: {
                        donut: { size: "85%" }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: { height: 270 },
                        legend: { position: 'bottom', show: false }
                    }
                }]
            }
        },
        {
            id: '#chart7',
            options: {
                series: [{ name: "Total Accounts", data: [4, 10, 25, 12, 25, 18, 40, 22, 7] }],
                chart: {
                    height: 105,
                    type: 'area',
                    sparkline: { enabled: true },
                    zoom: { enabled: false }
                },
                dataLabels: { enabled: false },
                stroke: { width: 3, curve: 'smooth' },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        gradientToColors: ['#fc185a'],
                        opacityFrom: 0.8,
                        opacityTo: 0.2,
                        type: 'vertical'
                    }
                },
                colors: ["#ffc107"],
                tooltip: {
                    theme: "dark",
                    x: { show: false },
                    y: { title: { formatter: () => "" } },
                    marker: { show: false }
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
                }
            }
        },
        {
            id: '#chart8',
            options: {
                series: [{ name: "Total Sales", data: [4, 10, 25, 12, 25, 18, 40, 22, 7] }],
                chart: {
                    height: 210,
                    type: 'area',
                    sparkline: { enabled: true },
                    zoom: { enabled: false }
                },
                dataLabels: { enabled: false },
                stroke: { width: 3, curve: 'straight' },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        gradientToColors: ['#17ad37'],
                        opacityFrom: 0.7,
                        opacityTo: 0.0,
                        type: 'vertical'
                    }
                },
                colors: ["#98ec2d"],
                tooltip: {
                    theme: "dark",
                    x: { show: false },
                    y: { title: { formatter: () => "" } },
                    marker: { show: false }
                },
                markers: { show: false, size: 5 },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
                }
            }
        }
    ];
    // Render only if element exists
    charts.forEach(({ id, options }) => {
        const elementsChart = $(id);
        if (elementsChart.length) {
            new ApexCharts(elementsChart, options).render();
        }
    });
});
