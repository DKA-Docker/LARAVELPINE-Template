<?php

namespace App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries;

use App\Repositories\Apps\Deliveries\Requests\RequestsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class Requests extends Controller
{
    /**
     * @var RequestsRepository $repository
     * @desc create request Repository
     */
    protected RequestsRepository $repository;

    public function __construct()
    {
        $this->repository = new RequestsRepository();
    }

    /**
     * @param Request $request For GET / Requests
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse {
        return response()->json(
            data: array(
                'status' => true,
                'code' => Response::HTTP_OK,
                'msg' => 'Successfully Read Data',
                'data' => $this->repository->ReadAll(),
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
                'data' => $this->repository->ReadAll()
            ),
            status: Response::HTTP_OK,
            headers: array(
                'Content-Type' => 'application/json',
            )
        );
    }
}
