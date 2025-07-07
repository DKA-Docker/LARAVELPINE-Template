<?php

namespace App\Http\Controllers\Api\Auth;

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

    public function login(AuthAccountsRequest $request): JsonResponse
    {
        /** Get All Request Data */
        $validated = $request->validated(); // hanya data tervalidasi
        $authenticate = $this->account->authenticate($validated);
        return response()->json(
            data : $authenticate,
            headers: [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        );
    }

    public function verify(Request $request): JsonResponse
    {
        /** Verify Session */
        $authenticate = $this->account->verify();
        return response()->json(
            data : $authenticate,
            status: $authenticate['code'],
            headers: [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        );
    }

    public function logout(Request $request): JsonResponse
    {
        /** Get All Request Data */
        $authenticate = $this->account->revoke($request);
        return response()->json(
            data : $authenticate,
            headers: [
                'Content-Type' => 'application/json'
            ]
        );
    }
}
