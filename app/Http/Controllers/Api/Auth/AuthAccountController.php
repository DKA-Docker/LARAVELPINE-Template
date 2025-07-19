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
        // Ambil token dari header Authorization
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json([
                'status' => false,
                'code' => 401,
                'msg' => 'Token not provided or invalid format',
            ], 401);
        }

        $token = trim(str_replace('Bearer ', '', $authHeader));

        // Verifikasi token pakai service
        $authenticate = $this->account->verify($token);

        return response()->json(
            data: $authenticate,
            status: $authenticate['code'],
            headers: [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
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
