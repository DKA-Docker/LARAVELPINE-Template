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
            '.table-container'
        ) as HTMLElement;

        const datatable = new KTDataTable(container, {
            apiEndpoint: `${FullUriCurrentURL}`,
            pageSize: 5,
            columns: {
                account: {
                    title: 'Name',
                    render: (value, row) => {
                        return `${row.account.information.first_name} ${row.account.information.last_name}`
                    }
                },
                email: {
                    title: 'Email',
                    render: (value, row: any) => row.account?.contact?.email ?? '-'
                },
                created_at: { title: 'Created At' },
            },
            mapRequest: (queryParams: URLSearchParams) => {
                // KTDataTable sudah isi page & size disini
                const page = queryParams.get('page');
                const size = queryParams.get('size');

                $(".show_from").html(size);
                return queryParams;
            },
            mapResponse: (res) => {
                // res = response JSON mentah dari API
                // sesuaikan sama format Laravel kamu
                // misal: { data: [...], total: 123, ... }
                $(".show_total").html(res.meta.count)
                return {
                    data: res.data ?? [],
                    totalCount: res.meta.count ?? 0,
                };
            },
        });

        datatable.reload();
    }
});
