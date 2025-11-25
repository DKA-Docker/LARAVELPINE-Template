import $ from "jquery"
import { KTDataTable, type KTDataTableConfigInterface, type KTDataTableDataInterface } from "@keenthemes/ktui/lib/esm"

$(window).on("load", () => {
    // CARI wrapper-nya pas window load, jangan cache di luar
    const $wrapper = $("div.dashboards-apps-deliveries-requests");
    if ($wrapper.length === 0) return;

    const tableEl = document.querySelector<HTMLTableElement>("#tables-request");

    if (!tableEl) {
        console.error("KTDataTable: #tables-request tidak ditemukan atau bukan <table>.");
        return;
    }

    const config: KTDataTableConfigInterface = {
        apiEndpoint: "/api/dashboards/apps/deliveries/requests",
        pageSize: 10,
        columns: {
            id: { title: "ID" },
            account: { title: "Account" },
            name: { title: "Nama Request" },
            created_at: { title: "Dibuat" },
        },
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ request",
        infoEmpty: "Belum ada data request",
    };

    (window as any).deliveriesRequestTable = new KTDataTable<KTDataTableDataInterface>(tableEl, config); // kalau mau dipakai dari console
});
