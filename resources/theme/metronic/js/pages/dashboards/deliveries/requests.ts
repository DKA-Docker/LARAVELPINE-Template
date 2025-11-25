import axios from "axios";
import $ from "jquery";
import URI from "urijs";

const elementExists = $("div.dashboards-apps-deliveries-requests");

$(window).on('load', function () {
    if (elementExists.length > 0) {
        /**
         * GET Full URI Current URL Saat Ini
         */
            const FullUriCurrentURL = URI(window.location);
            // /** Memecah Slash (/) menjadi Array **/
            const segs = FullUriCurrentURL.segment(); //
            // /** Tambah Api Segment "api". di index 0 aray **/
            segs.unshift('api');
            // /** Set kembali Segment URL **/
            FullUriCurrentURL.segment(segs);
            // /** Make A Requests with Axios **/
            // axios({
            //     url: `${FullUriCurrentURL}`,
            //     method: "GET",
            //     headers: {
            //         Accept: "application/json",
            //
            //     }
            // }).then((res) => {
            //     console.log(res.data);
            // }).catch((error) => {
            //     console.error(error);
            // })

        axios.get(`${FullUriCurrentURL}`, {
            headers: {Accept: "application/json"}
        }).then((res) => {
            const rows = res.data.data ?? [];

            //     1 definisikan kolom
            const columns = [
                {
                    name: 'No',
                    width: '40px',
                    render: (row, index) => index + 1,
                },
                {
                    name: 'Name',
                    key: 'name',
                },
                {
                    name: 'Email',
                    key: 'email',
                    render: (row) => {
                        return row.account.contact.email
                    }
                },
                {
                    name: 'Created At',
                    key: 'created_at',
                }
            ];

            // 2) Render header
            const $table = $("#table-delivery-request");
            const theadHtml = `
            <thead>
                <tr>
                    ${columns.map(col => `<th class="px-4 py-2 text-left text-xs font-semibold">${col.name}</th>`).join('')}
                </tr>
            </thead>
        `;
            const tbodyHtml = `
            <tbody>
                ${rows.map((row, index) => `
                    <tr>
                        ${columns.map(col => {
                if (typeof col.render === 'function') {
                    return `<td class="px-4 py-2 text-sm">${col.render(row, index)}</td>`;
                }
                return `<td class="px-4 py-2 text-sm">${row[col.key] ?? ''}</td>`;
            }).join('')}
                    </tr>
                `).join('')}
            </tbody>
        `;

            $table.html(theadHtml + tbodyHtml);

            // 3) Kalau mau, di sini kamu bisa panggil inisialisasi KT Datatable versi Metronic (kalau ada)
            // contoh pseudo:
            // KTDatatable.init('#table-delivery-request', {
            //     pageSize: 10,
            //     // opsional config lain
            // });
        }).catch((error) => {
            console.error(error);

        });
    }
});
