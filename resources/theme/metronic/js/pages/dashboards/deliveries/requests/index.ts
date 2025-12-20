/*
import axios from "axios";
import $ from "jquery";
import URI from "urijs";
import moment from "moment-timezone";
import "moment/locale/id.js"
// @ts-ignore
import { KTDataTable } from "@keenthemes/ktui/lib/esm"

const initDeliveryTable = () => {
    const elementExists = $("div.dashboards-apps-deliveries-requests");
    const container = document.querySelector('#table-container') as HTMLElement;

    if (elementExists.length > 0 && container) {
        moment.locale("id");

        // Construct API URL secara dinamis dari URL saat ini
        const currentUri = URI(window.location);
        const segments = currentUri.segment();
        segments.unshift('api');
        const apiEndpoint = currentUri.segment(segments).toString();

        const datatable = new KTDataTable(container, {
            apiEndpoint: apiEndpoint,
            pageSize: 5,
            requestHeaders: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest', // Memberitahu Laravel ini AJAX (Penting untuk Sanctum Session)
                'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content,
            },
            columns: {
                account: {
                    title: 'Name',
                    render: (value: any, row: any) => {
                        const first = row.account?.information?.first_name ?? '';
                        const last = row.account?.information?.last_name ?? '';
                        return `${first} ${last}`.trim() || 'No Name';
                    }
                },
                email: {
                    title: 'Email',
                    render: (value: any, row: any) => row.account?.contact?.email ?? '-'
                },
                created_at: {
                    title: 'Dibuat',
                    render: (value: any, row: any) => {
                        return row.created_at ? moment(row.created_at).format("HH:mm:ss DD MMMM YYYY") : '-'
                    }
                },
            },
            mapRequest: (queryParams: URLSearchParams) => {
                const size = queryParams.get('size');
                $(".show_from").html(`${size}`);
                return queryParams;
            },
            mapResponse: (res: any) => {
                const total = res.meta?.count?.total ?? 0;
                $(".show_total").html(total);
                return {
                    data: res.data ?? [],
                    totalCount: total,
                };
            },
        });

        // Trigger Reload Manual
        $('#reload-btn').on('click', () => datatable.reload());
    }
};

/!** * Lifecycle Hooks
 *!/
// Untuk pertama kali load
$(window).on('load', initDeliveryTable);

// Untuk navigasi Livewire (jika menggunakan wire:navigate)
document.addEventListener('livewire:navigated', () => {
    initDeliveryTable();
});
*/
