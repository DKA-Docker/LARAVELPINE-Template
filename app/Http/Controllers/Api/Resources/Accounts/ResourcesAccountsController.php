<?php

namespace App\Http\Controllers\Api\Resources\Accounts;
use App\Services\Auth\AuthAccountsServices;
use App\Services\Resources\ResourcesAccountsServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ResourcesAccountsController extends Controller {

    protected ResourcesAccountsServices $account;
    protected AuthAccountsServices $auth;

    public function __construct()
    {
        $this->account = new ResourcesAccountsServices();
        $this->auth = new AuthAccountsServices();
    }

    public function index(): JsonResponse
    {
        // Function untuk mendapatkan data user dari auth data
        $data = $this->account->ReadAll();

        return response()->json(
            data : $data,
            status: $data['code'],
            headers: [
                'Content-Type' => 'application/json'
            ]
        );
    }

    public function store(Request $request): JsonResponse
    {
        /** Get All Request Data */
        $data = $request->all();
        /**  $action
         * @desc ambil logic Bisnis dari Services
         */
        $action = $this->account->Create($data);
        return response()->json(
            data : $action,
            status: $action["code"],
            headers: [
                'Content-Type' => 'application/json'
            ]
        );
    }
}
