// accounts.js
import $ from 'jquery';
import Datatables from 'datatables.net-dt';
import "datatables.net-dt/css/dataTables.dataTables.min.css"

$(function () {
    let table = new Datatables($('#example'));
    table.row.add([
        "test",'test','test'
    ]).draw();
});
