<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Trackings\Monitors;

use App\Services\Resources\Trackings\Monitors\ResourcesTrackingsMonitorsServices;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Symfony\Component\HttpFoundation\Response;

class Index extends Controller
{

    protected ResourcesTrackingsMonitorsServices $services;

    public function __construct()
    {
        $this->services = new ResourcesTrackingsMonitorsServices();
    }
    public function index() : JsonResponse
    {
        $ReadData = $this->services->ReadAll();

        if ($ReadData) {
            return response()->json(
                data: array(
                    'status' => true,
                    'code' => Response::HTTP_OK,
                    'msg' => 'OK',
                    'data' => $ReadData
                ),
                status: Response::HTTP_OK,
                headers: array(
                    'Content-Type' => 'application/json',
                )
            );
        }else{
            return response()->json(
                data: array(
                    'status' => false,
                    'code' => Response::HTTP_BAD_REQUEST,
                    'msg' => "Failed To Read Data",
                ),
                status: Response::HTTP_OK,
                headers: array(
                    'Content-Type' => 'application/json',
                )
            );
        }

    }



    public function ReqLocationUpdate(Request $request) {
        // Ambil data token dari request
        $token = $request->token;

        $messaging = Firebase::messaging();

        // Membangun pesan dengan konfigurasi Android khusus
        $message = CloudMessage::withTarget('token', $token)
            ->withData([
                'action' => 'RELOAD_GPS',
                // Kamu bisa tambah data lain jika perlu
            ])
            ->withAndroidConfig([
                'priority' => 'high', // MEMAKSA Android untuk bangun dari Doze Mode
                'ttl' => '0s',        // Pesan langsung hangus jika tidak terkirim saat itu juga (opsional)
            ]);

        try {
            $messaging->send($message);
            return response()->json([
                'status' => 'success',
                'message' => 'FCM Sent with High Priority'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function ReqAlarm(Request $request) {
        // Ambil data token dari request
        $token = $request->token;
        $messaging = Firebase::messaging();

        // Membangun pesan dengan konfigurasi Android khusus
        $message = CloudMessage::withTarget('token', $token)
            ->withData([
                'action' => 'RING_ALARM',
                // Kamu bisa tambah data lain jika perlu
            ])
            ->withAndroidConfig([
                'priority' => 'high', // MEMAKSA Android untuk bangun dari Doze Mode
                'ttl' => '0s',        // Pesan langsung hangus jika tidak terkirim saat itu juga (opsional)
            ]);

        try {
            $messaging->send($message);
            return response()->json([
                'status' => 'success',
                'message' => 'FCM Sent with High Priority'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
