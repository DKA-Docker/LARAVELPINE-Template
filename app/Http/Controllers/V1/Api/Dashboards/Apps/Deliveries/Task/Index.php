<?php

namespace App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Task;

use App\Services\Resources\Deliveries\Tasks\ResourcesDeliveriesTasksServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Index extends Controller
{
    protected ResourcesDeliveriesTasksServices $service;

    public function __construct(){
        $this->service = new ResourcesDeliveriesTasksServices();
    }

    public function index(Request $request): JsonResponse
    {
        // For API: Automatically filter by logged-in user's assigned tasks
        // If 'account' parameter is provided, use it; otherwise use authenticated user ID
        // This ensures drivers only see tasks assigned to them
        if (!$request->filled('assigned') && Auth::check()) {
            $request->merge(['assigned' => Auth::id()]);
        }
        
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

    public function show(string $id): JsonResponse
    {
        $data = $this->service->Find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_NOT_FOUND,
                'msg' => 'Task not found',
                'data' => null
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'msg' => 'Successfully Read Data',
            'data' => $data
        ], Response::HTTP_OK);
    }
}


