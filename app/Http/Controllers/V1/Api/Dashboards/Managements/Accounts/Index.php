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
            $data = $this->services->ReadAll()
        );
    }

}
