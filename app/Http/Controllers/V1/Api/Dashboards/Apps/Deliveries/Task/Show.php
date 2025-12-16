<?php

namespace App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Task;

use App\Services\Resources\Deliveries\Tasks\ResourcesDeliveriesTaksServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class Show extends Controller
{
    protected ResourcesDeliveriesTaksServices $service;

    public function __construct(){
        $this->service = new ResourcesDeliveriesTaksServices();
    }

    //api/dashboards/apps/deliveries/tasks/show
    public function index(Request $request) {
        $data = $this->service->ReadAllRequest();
        return response()->json(
            data: array(
                'status' => true,
                'code' => Response::HTTP_OK,
                'data' => $data
            ),
            status: Response::HTTP_OK,
            headers: array(
                'Content-Type' => 'application/json'
            )
        );
    }

    public  function show(Request $request, $id): JsonResponse {
        $data = $this->service->Find($id);
        return response()->json(
            data: array(
                'status' => true,
                'code' => Response::HTTP_OK,
                'data' => $data
            ),
            status: Response::HTTP_OK,
            headers: array(
                'Content-Type' => 'application/json'
            )
        );
    }
}
