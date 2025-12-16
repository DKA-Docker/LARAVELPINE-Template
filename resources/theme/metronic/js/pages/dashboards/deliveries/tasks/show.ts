import $ from "jquery";
import URI from "urijs";
import moment from "moment-timezone";
import "moment/locale/id.js"

const elementExists = $("div.dashboards-apps-deliveries-tasks-show");

if(elementExists.length > 0) {
    $(window).on('load', function(){
    /** Set Locale Menjadi Indonesia **/
    moment.locale("id")
    /** Ambil URL dimana JS Ini Dimuat**/
    const FullUriCurrentURL = URI(window.location);
    /**
     * Ubah URL Menjadi Array Segment
     * misal /dashboards/apps/deliveries menjadi
     * ['dashboards','apps','deliveries'];
     * **/
    const UriCurrentTask = URI(window.location);
    const segs = FullUriCurrentURL.segment();

    //mengambil url : api/dashboards/apps/deliveries
    const truncatedSegs = segs.slice(0, 3);
        // tambahkan 'api' di depan url
        truncatedSegs.unshift('api');

        // tambahkan requests dibelakang url
        truncatedSegs.push('requests');

        UriCurrentTask.segment(truncatedSegs);

        const apiRequest = UriCurrentTask.toString();

        // ambil data simpan di dalam array/cache
        let requestDataCache: object[] = [];

        // MENGAMBIL SEMUA DATA REQUEST
        // api/dashboards/apps/deliveries/requests/
        async function fetchRequestOptions(apiRequest: string | URL | Request){
            try{
                const res = await fetch(apiRequest);
                const json = await res.json();

                if(!json.status || !json.data){
                    requestDataCache = [];
                }else{
                    requestDataCache = json.data;
                }

                return requestDataCache;
            }catch (err){
                console.error("fetch error", err);
                return [];
            }
        }


    /**
     * Tambahkan Data Di Dalam Array
     * ['api','dashboards','apps','deliveries'];
     * **/
    segs.unshift('api');
    /**
     * ['api','dashboards','apps','deliveries'];
     * Ambil Kembali Semua Segment dan ubah menjadi URL Kembali
     * /api/dashboards/apps/deliveries
     * **/
    FullUriCurrentURL.segment(segs);

        // console.log(FullUriCurrentURL);

    // ambil data simpan di dalam array/cache
    let taskDataCache: object[] = [];

    const apiUrl = FullUriCurrentURL.toString();
        // console.log(apiUrl);

        // MENGAMBIL DATA BERDASARKAN ID TASK
        // api/dashboards/apps/deliveries/tasks/show/{id}
        async function fetchTaskOptions(apiUrl: string | URL | Request){
            try{
                const res = await fetch(apiUrl);
                const json = await res.json();

                if(!json.status || !json.data){
                    taskDataCache = [];
                }else{
                    taskDataCache = json.data;
                }

                return taskDataCache;
            }catch (err){
                console.error("fetch error", err);
                return [];
            }
        }

        (async() => {
            const taskResponse = await fetchTaskOptions(apiUrl);
            const reqResponse = await fetchRequestOptions(apiRequest);

            // @ts-ignore
            const taskReqId = taskResponse.request.id;
            // @ts-ignore
            const taskName = taskResponse.name;
            // @ts-ignore
            const accName = taskResponse.account.information.first_name;
            // const productName;
            const requestData = reqResponse.find(
            // @ts-ignore
                (request) => request.id === taskReqId
            );

            // definisikan element target
            const $selectTarget = $('#request');
            const $hiddenRequest = $('#hidden_request_id');
            const $account = $('#account');
            const $taskName = $('#name');

            // Data penuh hanya di load sekali
            let isFullDataLoaded = false;

            // reset isi select dan tbhkan opsi default "PIlih Request"
            $selectTarget.empty();
            $selectTarget.append(`<option value="">Pilih Request</option>`);

            $account.empty();
            $account.val(accName);

            $taskName.empty();
            $taskName.val(taskName);

            if(requestData){
                // munculkan by id 1 request
                $selectTarget.append(
                    // @ts-ignore
                    `<option value="${requestData.id}" selected>${requestData.name}</option>`
                );

                // Atur hidden input (penting untuk menyimpan ID yang dipilih)
                // @ts-ignore
                $hiddenRequest.val(requestData.id);

                // // Opsional : Disable  select jika hanya ada satu opsi yang relevan
                // $selectTarget.prop('disabled', true);
            }else{
                // apabila tidak ada, munculkan banyak nama2 request
                reqResponse.forEach(request => {
                    $selectTarget.append(
                        // @ts-ignore
                        `<option value="${request.id}">${request.name}</option>`
                    )
                })

            }

            // Implementasi Logika 'Load on Click' (Menggunakan event 'focus')
            $selectTarget.on('focus', function(){
                if(!isFullDataLoaded){
                    // Hapus semua opsi saat ini (kecuali mungkin opsi default)
                    $selectTarget.empty();
                    $selectTarget.append(`<option value="">Pilih Request</option>`);

                    // Iterasi dan tambahkan semua request
                    reqResponse.forEach(request => {
                        $selectTarget.append(
                            // @ts-ignore
                            `<option value="${request.id}">${request.name}</option>`
                        )
                    })

                    // set flag agar tidak terulang pada klik berikutnya
                    isFullDataLoaded = true;

                    // Penting: Memastikan elemen terpilih saat ini tetap tercermin pada hidden input
                    $hiddenRequest.val($selectTarget.val());
                }
            })

        })();

    });
}
