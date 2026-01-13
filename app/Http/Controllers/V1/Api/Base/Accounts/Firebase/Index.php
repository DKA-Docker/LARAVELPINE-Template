<?php

namespace App\Http\Controllers\V1\Api\Base\Accounts\Firebase;

use App\Services\Auth\AuthAccountsServices;
use App\Services\Resources\Accounts\ResourcesAccountsServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Index
{

    protected ResourcesAccountsServices $service;
    protected AuthAccountsServices $authService;

    public function __construct()
    {
        $this->service = new ResourcesAccountsServices();
        $this->authService = new AuthAccountsServices();
    }

    /* @throws Throwable **/
    public function edit(Request $request){
        $req = $request->all();
        $session = $this->authService->verify();
        /** @var $defaults
         * jika data inputan kosong maka semua variable di set null
         */
        $defaults = [
            'id' => $session['data']['id'],
        ];
        /** @var $req $data lakukan merge data untuk payload dengan data default */
        $data = array_merge($defaults, $req);

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
