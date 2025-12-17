<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Trackings\Monitors;

use App\Services\Resources\Trackings\Monitors\ResourcesTrackingsMonitorsServices;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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

    public function token(Request $request) {
        // Ambil data dari Vite
        $token = $request->token;
        $name = $request->driver_name;

        $messaging = Firebase::messaging();
        $message = CloudMessage::withTarget('token', $token)
            ->withData(['action' => 'RELOAD_GPS']); // Data khusus untuk aplikasi driver

        try {
            $messaging->send($message);
            return response()->json(['status' => 'success']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
