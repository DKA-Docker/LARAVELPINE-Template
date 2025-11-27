import axios from "axios";
import $ from "jquery";
import URI from "urijs";

const elementExists = $("div.dashboards");

$(window).on('load', function () {
    if (elementExists.length > 0) {
        $('#test').html('teststs');
        console.log('tedsjd');

    }
});
