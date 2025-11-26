import axios from "axios"
import $ from "jquery";
import URI from "urijs";
import "moment/locale/id.js"

const elementExists = $("div.frontends-auth");

/** Menunggu Semua Assets Load **/
$(window).on('load', function () {
    /** Check Jika Element Trigger Page ada**/
    if (elementExists.length > 0) {
        /** Function Auth In Here **/

    }
});
