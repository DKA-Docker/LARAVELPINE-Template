<?php

namespace App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries;

use App\Repositories\Apps\Deliveries\Tasks\TasksRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class Tasks extends Controller {
    /**
     * @var TasksRepository $repository
     * @desc create request Repository
     */
    protected TasksRepository $repository;

    public function __construct() {
        $this->repository = new TasksRepository();
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
