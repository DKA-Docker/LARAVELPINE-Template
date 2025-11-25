<?php

namespace App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries;

use App\Repositories\Apps\Deliveries\Requests\RequestsRepository;
use App\Services\Resources\Deliveries\Requests\ResourcesDeliveriesRequestsServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class Requests extends Controller
{
    /**
     * @var ResourcesDeliveriesRequestsServices $service
     * @desc create request Repository
     */
    protected ResourcesDeliveriesRequestsServices $service;

    public function __construct()
    {
        $this->service = new ResourcesDeliveriesRequestsServices();
    }

    /**
     * @param Request $request For GET / Requests
     * @return JsonResponse
     */
    public function index(Request $request)
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

    /**
     * @param Request $request For POST / Requests
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse {
        return response()->json(
            data: array(
                'status' => true,
                'code' => Response::HTTP_OK,
                'msg' => 'Successfully Read Data',
                'data' => $this->service->ReadAll()
            ),
            status: Response::HTTP_OK,
            headers: array(
                'Content-Type' => 'application/json',
            )
        );
    }

    /**
     * is endpoint for update or patch data for data updating
     * @param Request $request
     * @return void
     */
    public function update(Request $request) {

    }

    /**
     * is endpoint for deleted data for this data request
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request) {

    }
}
