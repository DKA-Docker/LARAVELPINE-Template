<?php

namespace App\Http\Controllers\V1\Api\Base\Accounts\Firebase;

use App\Services\Resources\Accounts\ResourcesAccountsServices;
use App\Services\Resources\Deliveries\Tasks\ResourcesDeliveriesTaksServices;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Index
{

    protected ResourcesAccountsServices $service;

    public function __construct()
    {
        $this->service = new ResourcesAccountsServices();
    }

    public function edit(Request $request){
        $data = $request->all();
        $responseUpdate = $this->service->Update($data);

        if (!$responseUpdate['status']){
            return response()->json(
                data: array(
                    'status' => false,
                    'code' => Response::HTTP_BAD_REQUEST,
                    'data' => $responseUpdate
                ),
                status: Response::HTTP_BAD_REQUEST,
                headers: array(
                    'Content-Type' => 'application/json'
                )
            );
        }
        return response()->json(
            data: array(
                'status' => true,
                'code' => Response::HTTP_OK,
                'data' => $responseUpdate
            ),
            status: Response::HTTP_OK,
            headers: array(
                'Content-Type' => 'application/json'
            )
        );
    }
}
