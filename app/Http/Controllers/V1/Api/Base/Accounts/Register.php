<?php

namespace App\Http\Controllers\V1\Api\Base\Accounts;

use App\Services\Resources\Accounts\ResourcesAccountsServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class Register extends Controller
{
    protected ResourcesAccountsServices $service;

    public function __construct(ResourcesAccountsServices $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'credential.username' => ['required', 'string', 'unique:accounts_credentials,username'],
            'credential.password' => ['required', 'string', 'min:8'],
            'information.first_name' => ['required', 'string'],
            'information.last_name' => ['nullable', 'string'],
            'contact.email' => ['required', 'email', 'unique:accounts_contacts,email'],
            'contact.phone' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'code'   => Response::HTTP_UNPROCESSABLE_ENTITY,
                'msg'    => 'Validation Error',
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $result = $this->service->Register($request->all());

        return response()->json(
            data: $result,
            status: $result['code'] ?: Response::HTTP_CREATED,
            headers: ['Content-Type' => 'application/json']
        );
    }
}
