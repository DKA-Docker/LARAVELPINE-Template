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
            axios.get(location.pathname, {
                params: data, // <- FIXED disini
                headers: {
                    'Accept': 'application/json'
                },
            })
                .then(response => {
                    console.log('✅ DataTables response:', response);
                    callback(response.data);
                })
                .catch(error => {
                    console.error('❌ Error in DataTables:', error);
                    callback({
                        draw: data.draw,
                        recordsTotal: 0,
                        recordsFiltered: 0,
                        data: []
                    });
                });
        },
        columns: [
            { data: 'full_name' },
            { data: 'credential.username' },
            { data: 'contact.email' },
            { data: 'roles' },
            { data: 'created_at' },
            { data: 'action' },
        ]
    });


    const timeoutMessage = $('.timeout-msg');
    if (timeoutMessage.length){
        setTimeout(() => {
            timeoutMessage.fadeOut('slow');
        })
    }
});
