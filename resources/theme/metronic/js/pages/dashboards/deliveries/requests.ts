import axios from "axios";
import $ from "jquery";
import URI from "urijs";
import { KTDataTable } from "@keenthemes/ktui/lib/esm"

const elementExists = $("div.dashboards-apps-deliveries-requests");

$(window).on('load', function () {
    if (elementExists.length > 0) {
        const FullUriCurrentURL = URI(window.location);
        const segs = FullUriCurrentURL.segment();
        segs.unshift('api');
        FullUriCurrentURL.segment(segs);

        // 👇 ambil CONTAINER, bukan TABLE
        const container = document.querySelector(
            '.dashboards-apps-deliveries-requests .kt-scrollable-x-auto'
        ) as HTMLElement;

        const datatable = new KTDataTable(container, {
            apiEndpoint: `${FullUriCurrentURL}`,
            pageSize: 20,
            columns: {
                name: {
                    title: 'Name',
                },
                email: {
                    title: 'Email',
                    render: (value, row: any) => row.account?.contact?.email ?? '-'
                },
                created_at: { title: 'Created At' },
            },
            mapResponse: (res) => {
                // res = response JSON mentah dari API
                // sesuaikan sama format Laravel kamu
                // misal: { data: [...], total: 123, ... }
                return {
                    data: res.data ?? [],
                    totalCount: res.data.length ?? 0,
                };
            },
        });

        datatable.reload();
    }
});
