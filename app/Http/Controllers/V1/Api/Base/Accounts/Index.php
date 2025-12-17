<?php

namespace App\Http\Controllers\V1\Api\Base\Accounts;

use App\Services\Resources\Accounts\ResourcesAccountsServices;
use App\Services\Resources\Deliveries\Tasks\ResourcesDeliveriesTaksServices;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class Index extends Controller
{
    protected ResourcesAccountsServices $service;

    public function __construct()
    {
        $this->service = new ResourcesAccountsServices();
    }

    public function index(Request $request){
        $data = $this->service->ReadAll();
        return response()->json(
            array(
                'status' => true,
                'code' => Response::HTTP_OK,
                'msg' => 'Successfully Read Data',
                'data' => $data,
            )
        );
    }
}
