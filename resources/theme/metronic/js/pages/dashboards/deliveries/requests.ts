import axios from "axios";
import $ from "jquery";
import URI from "urijs";

const elementExists = $("div.dashboards-apps-deliveries-requests");

$(window).on('load', function () {
    if (elementExists.length > 0){
        /**
         * GET Full URI Current URL Saat Ini
         */
        const FullUriCurrentURL = URI(window.location);
        /** Memecah Slash (/) menjadi Array **/
        const segs = FullUriCurrentURL.segment(); //
        /** Tambah Api Segment "api". di index 0 aray **/
        segs.unshift('api');
        /** Set kembali Segment URL **/
        FullUriCurrentURL.segment(segs);
        /** Make A Requests with Axios **/
        axios({
            url: `${FullUriCurrentURL}`,
            method: "GET",
            headers: {
                Accept: "application/json",

            }
        }).then((res) => {
            console.log(res.data);
        }).catch((error) => {
            console.error(error);
        })
    }
});
