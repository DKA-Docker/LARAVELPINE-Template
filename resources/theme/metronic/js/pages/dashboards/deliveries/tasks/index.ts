import axios from "axios";
import $ from "jquery";
import URI from "urijs";
import moment from "moment-timezone";
import "moment/locale/id.js"
import { KTDataTable } from "@keenthemes/ktui/lib/esm"

const elementExists = $("div.dashboards-apps-deliveries-tasks");

/** Menunggu Semua Assets Load **/
$(window).on('load', function () {
    /** Check Jika Element Trigger Page ada**/
    if (elementExists.length > 0) {
        /** Set Locale Menjadi Indonesia **/
        moment.locale("id")
        /** Ambil URL dimana JS Ini Dimuat**/
        const FullUriCurrentURL = URI(window.location);
        /**
         * Ubah URL Menjadi Array Segment
         * misal /dashboards/apps/deliveries menjadi
         * ['dashboards','apps','deliveries'];
         * **/
        const segs = FullUriCurrentURL.segment();
        /**
         * Tambahkan Data Di Dalam Array
         * ['api','dashboards','apps','deliveries'];
         * **/
        segs.unshift('api');
        /**
         * ['api','dashboards','apps','deliveries'];
         * Ambil Kembali Semua Segment dan ubah menjadi URL Kembali
         * /api/dashboards/apps/deliveries
         * **/
        FullUriCurrentURL.segment(segs);
        /**
         * Pastikan ID Query Selector yang Diambil Membungkus class kt-data-datatable api
         */
        const container = document.querySelector(
            '#table-container'
        ) as HTMLElement;
        /**
         *
         */
        const datatable = new KTDataTable(container, {
            apiEndpoint: `${FullUriCurrentURL}`,
            pageSize: 5,
            /** wajib **/
            requestHeaders: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            columns: {
                requested: {
                    title: 'Requested',
                    render: (value, row) => {
                        return `${row.account.information.first_name} ${row.account.information.last_name}`
                    }
                },
                name: {
                    title: 'Name',
                    render: (value, row) => {
                        return `<a href="./tasks/${row.id}">${row.name}</a>`;
                    }
                },
                assigned: {
                    title: 'Assigned',
                    render: (value, row) => {
                        return `${row.account.information.first_name} ${row.account.information.last_name}`
                    }
                },
                origin: {
                    title: 'Origin',
                    render: (value, row) => {
                        return row.route?.origins?.address ?? '-';
                    }
                },
                destinations: {
                    title: 'Destinations',
                    render: (value, row) => {
                        return `${row.route?.destinations?.length ?? '-'}`;
                    }
                },
                created_at: {
                    title: 'Dibuat',
                    render: (value, row) => {
                        return moment(row.created_at).format("HH:mm:ss DD-MMMM-YYYY")
                    }
                },
                actions: {
                    title: 'Aksi',
                    render: (value, row) => {
                        return `-`;
                    }
                },
            },
            /**
             * @param queryParams
             * Expand Function Request bawaan dari @themeskeen/kui datatabase request
             */
            mapRequest: (queryParams: URLSearchParams) => {
                // KTDataTable sudah isi page & size disini
                const page = queryParams.get('page');
                const size = queryParams.get('size');

                $(".show_from").html(size);
                return queryParams;
            },
            /**
             * @param res any
             * Expand Function Response bawaan dari @themeskeen/kui datatabase Response
             */
            mapResponse: (res: any) => {
                // res = response JSON mentah dari API
                // sesuaikan sama format Laravel kamu
                // misal: { data: [...], total: 123, ... }
                $(".show_total").html(res.meta.count.total ?? 0)
                return {
                    data: res.data ?? [],
                    totalCount: res.meta.count.total ?? 0,
                };
            },
        });
        datatable.reload();
    }
});
