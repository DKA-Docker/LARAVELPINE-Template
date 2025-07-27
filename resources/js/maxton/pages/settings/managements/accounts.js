// accounts.js
import $ from 'jquery';
import axios from "axios";
import Datatables from 'datatables.net-dt';
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/src/sweetalert2.scss'
import "datatables.net-dt/css/dataTables.dataTables.min.css"

function ShowDatas() {
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
}

function ActionDelete() {
    $(document).on('click', '.act-del', function (e) {
        e.preventDefault();
        const dataId = $(this).attr('data');
        Swal.fire({
            title: 'Yakin mau hapus?',
            text: `Data akan dihapus permanen!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                axios({
                    url : `${location.pathname}/${dataId}`,
                    method : 'DELETE',
                    headers: {
                        'Accept': 'application/json'
                    },
                }).then(response => {
                    $('#example').DataTable().ajax.reload(null, false); // ⬅️ ganti ini
                    Swal.fire('Berhasil!', 'Data sudah dihapus.', 'success');
                }).catch(error => {
                    Swal.fire('Gagal!', error.response.data.msg, 'error');
                });
            }
        });
    });
}

$(function () {
    ShowDatas();
    ActionDelete();
    const timeoutMessage = $('.timeout-msg');
    if (timeoutMessage.length){
        setTimeout(() => {
            timeoutMessage.fadeOut('slow');
        })
    }
});
