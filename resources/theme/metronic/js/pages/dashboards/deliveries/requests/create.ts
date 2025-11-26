import $ from "jquery";
import "moment/locale/id.js"
import { KTAccordion } from "@keenthemes/ktui/src"

const elementExists = $("div.dashboards-apps-deliveries-requests-create");

/** Menunggu Semua Assets Load **/
$(window).on('load', function () {
    if (elementExists.length > 0) {
        KTAccordion.init();
    }

});
