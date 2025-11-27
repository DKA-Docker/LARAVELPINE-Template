<?php

namespace App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Task;

use App\Services\Resources\Deliveries\Tasks\ResourcesDeliveriesTaksServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class Index extends Controller
{
    protected ResourcesDeliveriesTaksServices $service;

    public function __construct(){
        $this->service = new ResourcesDeliveriesTaksServices();
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json(
            data: array(
                'status' => true,
                'code' => Response::HTTP_OK,
                'msg' => 'Successfully Read Data',
                'data' => $this->service->AutomaticallyPaginationTable($request),
                'meta' => array(
                    'count' => array(
                        'current' => $this->service->AutomaticallyPaginationTable($request)->count(),
                        'total' =>  $this->service->Count(),
                        )
                )
            ),
            status: Response::HTTP_OK,
            headers: array(
                'Content-Type' => 'application/json'
            )
        );
    }
}


