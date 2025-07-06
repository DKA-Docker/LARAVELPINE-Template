<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\AuthAccountsRequest;
use App\Services\Auth\AuthAccountsServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthAccountController
{
    protected AuthAccountsServices $account;

    public function __construct()
    {
        $this->account = new AuthAccountsServices();
    }

    public function store(AuthAccountsRequest $request): JsonResponse
    {
        /** Get All Request Data */
        $validated = $request->validated(); // hanya data tervalidasi
        $authenticate = $this->account->authenticate($validated);
        return response()->json(
            data : $authenticate,
            headers: [
                'Content-Type' => 'application/json'
            ]
        );
    }
}
