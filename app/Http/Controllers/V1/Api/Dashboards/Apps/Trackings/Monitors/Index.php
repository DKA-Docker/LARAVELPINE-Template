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

class Index extends Controller
{

    protected ResourcesTrackingsMonitorsServices $services;

    public function __construct()
    {
        $this->services = new ResourcesTrackingsMonitorsServices();
    }

    public function store(Request $request)
    {
        // 1. Simpan data ke Database melalui Service
        $CreateAct = $this->services->Create($request);
        return response()->json(
            data: array(
                'status' => true,
                'code' => Response::HTTP_OK,
                'msg' => 'Successfully Creates Data',
                'data' => $CreateAct
            ),
            status: Response::HTTP_OK
        );
    }
}
