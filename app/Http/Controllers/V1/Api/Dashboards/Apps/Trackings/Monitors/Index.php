<?php

namespace App\Http\Controllers\V1\Api\Dashboards\Apps\Trackings\Monitors;

use App\Services\Resources\Trackings\Monitors\ResourcesTrackingsMonitorsServices;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Symfony\Component\HttpFoundation\Response;
use App\Events\Dashboards\Apps\Trackings\Monitors\Index as MonitorEvent;
use function React\Promise\all;

class Index extends Controller
{

    protected ResourcesTrackingsMonitorsServices $services;

    public function __construct()
    {
        $this->services = new ResourcesTrackingsMonitorsServices();
    }

    public function store(Request $request)
    {
        $incommingRequest = $request->all();
        Log::info(json_encode($incommingRequest));
        if ($incommingRequest['status']){
            // 1. Simpan data ke Database melalui Service
            $CreateAct = $this->services->Create($incommingRequest['data']);

            // Memicu broadcast ke frontend
            // 2. Memicu broadcast dengan proteksi Exception
            try {
                // Karena menggunakan ShouldQueue, ini akan mengirim job ke background worker
                broadcast(new MonitorEvent($CreateAct));
            } catch (Exception $e) {
                // Jika broadcast/queue gagal, kita hanya mencatat log.
                // Proses utama (simpan data) TIDAK akan terhenti (rollback).
                Log::error("Broadcast MonitorEvent failed: " . $e->getMessage(), [
                    'data' => $CreateAct,
                    'trace' => $e->getTraceAsString()
                ]);
            }

            return response()->json(
                data: array(
                    'status' => true,
                    'code' => Response::HTTP_OK,
                    'msg' => 'Successfully Creates Data',
                    'data' => $CreateAct
                ),
                status: Response::HTTP_OK
            );
        }else{
            // Memicu broadcast ke frontend
            // 2. Memicu broadcast dengan proteksi Exception
            try {
                // Karena menggunakan ShouldQueue, ini akan mengirim job ke background worker
                broadcast(new MonitorEvent($incommingRequest));
            } catch (Exception $e) {
                // Jika broadcast/queue gagal, kita hanya mencatat log.
                // Proses utama (simpan data) TIDAK akan terhenti (rollback).
                Log::error("Broadcast MonitorEvent failed: " . $e->getMessage(), [
                    'data' => $incommingRequest,
                    'trace' => $e->getTraceAsString()
                ]);
            }

            return response()->json(
                data: array(
                    'status' => false,
                    'code' => Response::HTTP_BAD_REQUEST,
                    'msg' => 'Failed Sending Data',
                ),
                status: Response::HTTP_OK
            );
        }

    }
}
