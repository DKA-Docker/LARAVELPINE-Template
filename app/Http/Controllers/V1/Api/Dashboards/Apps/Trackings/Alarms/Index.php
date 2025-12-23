<?php

namespace App\Http\Controllers\V1\Api\Dashboards\Apps\Trackings\Alarms;

use App\Services\Resources\Trackings\Monitors\ResourcesTrackingsMonitorsServices;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Events\Dashboards\Apps\Trackings\Monitors\Index as MonitorEvent;
use App\Events\Dashboards\Apps\Trackings\Alarms\Index as AlarmEvent;

class Index extends Controller
{

    protected ResourcesTrackingsMonitorsServices $services;

    public function __construct()
    {
        $this->services = new ResourcesTrackingsMonitorsServices();
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // Memicu broadcast ke frontend
        // 2. Memicu broadcast dengan proteksi Exception
        try {
            // Karena menggunakan ShouldQueue, ini akan mengirim job ke background worker
            broadcast(new AlarmEvent($data));
            return response()->json(
                data: array(
                    'status' => true,
                    'code' => Response::HTTP_OK,
                    'msg' => 'Successfully Creates Data',
                    'data' => $data
                ),
                status: Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                data: array(
                    'status' => false,
                    'code' => Response::HTTP_BAD_REQUEST,
                    'msg' => 'Successfully Alert Alarm',
                    'data' => $data
                ),
                status: Response::HTTP_OK
            );
        }
    }
}
