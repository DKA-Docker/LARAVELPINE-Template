<?php

namespace App\Http\Controllers\V1\Api\Dashboards\Managements\Accounts;

use App\Services\Resources\Accounts\ResourcesAccountsServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class Index extends Controller
{
    protected ResourcesAccountsServices $services;

    public function __construct()
    {
        $this->services = new ResourcesAccountsServices();
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json(
            data: array(
                'status' => true,
                'code' => Response::HTTP_OK,
                'message'=> 'Successfully Load Data Accounts',
                'data' => $this->services->AutomaticallyPaginationTable($request),
                'meta' => array(
                    'count' => array(
                        'current' => $this->services->AutomaticallyPaginationTable($request),
                        'total' => $this->services->Count()
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
