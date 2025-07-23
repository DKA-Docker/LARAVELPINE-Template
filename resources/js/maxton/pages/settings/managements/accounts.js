// accounts.js
import $ from 'jquery';
import axios from "axios";
import Datatables from 'datatables.net-dt';
import "datatables.net-dt/css/dataTables.dataTables.min.css"

$(function () {
    $('#example').DataTable({
        processing: true,
        serverSide: true,
        ajax: function (data, callback) {
            axios.post(location.pathname, data)
                .then(response => callback(response.data))
                .catch(error => {
                    console.error('Error:', error);
                    callback({
                        draw: data.draw,
                        recordsTotal: 0,
                        recordsFiltered: 0,
                        data: []
                    });
                });
        },
        columns: [
            { data: 'information.first_name' },
            { data: 'contact.email' },
            { data: 'created_at' },
            { data: 'action' },
        ]
    });
});
