<?php

namespace App\Http\Controllers\V1\Api\Dashboards\Apps\Trackings\Monitors;

use App\Services\Resources\Trackings\Monitors\ResourcesTrackingsMonitorsServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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

    public function show(): JsonResponse
    {
        return response()->json(
            data: array(
                'status' => true,
                'code' => Response::HTTP_OK,
                'msg' => 'OK',

            ),
            status: Response::HTTP_OK,
            headers: array(
                'Content-Type' => 'application/json',
            )
        );
    }

    public function store(Request $request)
    {
        $CreateAct = $this->services->Create($request);
        return response()->json(
            data: array(
                'status' => true,
                'code' => Response::HTTP_OK,
                'msg' => 'Successfully Creates Data',
                'data' => $CreateAct
            ),
            status: Response::HTTP_OK,
            headers: array(
                'Content-Type' => 'application/json',
            )
        );
    }
}
