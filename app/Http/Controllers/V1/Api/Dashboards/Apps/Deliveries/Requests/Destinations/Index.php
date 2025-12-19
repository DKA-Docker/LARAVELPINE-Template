<?php

namespace App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Requests\Destinations;

use App\Services\Resources\Deliveries\Requests\Destinations\ResourcesDeliveriesRequestsDestinationsServices;
use App\Services\Resources\Deliveries\Requests\ResourcesDeliveriesRequestsServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class Index extends Controller
{
    /**
     * @var ResourcesDeliveriesRequestsDestinationsServices $service
     * @desc create request Repository
     */
    protected ResourcesDeliveriesRequestsDestinationsServices $service;

    public function __construct()
    {
        /**
         * Ambil Service Request
         */
        $this->service = new ResourcesDeliveriesRequestsDestinationsServices();
    }

    /**
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        return response()->json(
            data: array(
                'status' => true,
                'code' => Response::HTTP_OK,
                'msg' => 'Successfully Read Data',
                'data' => $this->service->ReadAll(),
            ),
            status: Response::HTTP_OK,
            headers: array(
                'Content-Type' => 'application/json',
            )
        );
    }
}
