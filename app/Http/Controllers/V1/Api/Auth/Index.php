<?php

namespace App\Http\Controllers\V1\Api\Auth;

use App\Services\Auth\AuthAccountsServices;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response; // Pastikan ini di-import

class Index extends Controller
{

    protected AuthAccountsServices $authServices;

    public function __construct(AuthAccountsServices $authServices) {
        /**
         * 🟢 Gunakan Dependency Injection di constructor untuk inisialisasi service
         */
        $this->authServices = $authServices;
    }

    public function index(): JsonResponse
    {
        /** @var object $AuthVerification
         * ambil method verifikasi di services auth
         */
        $result = $this->authServices->verify();
        /**
         *
         * if response status === false.
         * show the login.
         */
        if (!$result['status']) {
            // Kegagalan Login (e.g., Invalid credentials)
            return response()->json(
                data: $result,
                status: $result['code'] ?: Response::HTTP_UNAUTHORIZED, // Gunakan 401
                headers: ['Content-Type' => 'application/json']
            );
        }
        /** if status verification true. redirect to home */
        return response()->json(
            data: array_merge($result),
            status: $result['code'] ?: Response::HTTP_OK,
            headers: ['Content-Type' => 'application/json']
        );
    }

    /**
     * Menangani permintaan autentikasi (Login API) dan mengembalikan Token Sanctum.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        // 1. Validasi Input menggunakan Request object
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'msg' => 'Validation Error',
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // 2. Memanggil service untuk autentikasi API (Minta token)
        $result = $this->authServices->authenticate(
            array(
                'username' => $request->username,
                'password' => $request->password,
                'guard' => 'api', // 🟢 PASTIKAN INI DITAMBAHKAN UNTUK MENDAPATKAN TOKEN
            )
        );

        // 3. Mengembalikan Respons
        if (!$result['status']){
            // Kegagalan Login (e.g., Invalid credentials)
            return response()->json(
                data: $result,
                status: $result['code'] ?: Response::HTTP_UNAUTHORIZED, // Gunakan 401
                headers: ['Content-Type' => 'application/json']
            );
        }

        // Login Berhasil (Mengembalikan token)
        return response()->json(
            data: array_merge($result, [
                // Token sudah ada di $result['token'] dari service
                'token_type' => 'Bearer'
            ]),
            status: $result['code'] ?: Response::HTTP_OK,
            headers: ['Content-Type' => 'application/json']
        );
    }

    /**
     * Menangani pencabutan sesi atau token (Logout API).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        // Panggil revoke() dari service.
        // Service akan mendeteksi apakah ini sesi web atau token API dan menanganinya.
        $result = $this->authServices->revoke();

        // Mengembalikan respons JSON sesuai standar API
        if (!$result['status']){
            // Kegagalan pencabutan (biasanya karena tidak ada sesi/token yang aktif)
            return response()->json(
                data: $result,
                status: $result['code'] ?: Response::HTTP_UNAUTHORIZED, // 401 jika tidak ada yang login
                headers: ['Content-Type' => 'application/json']
            );
        }

        // Berhasil mencabut token/sesi
        return response()->json(
            data: $result,
            status: $result['code'] ?: Response::HTTP_OK,
            headers: ['Content-Type' => 'application/json']
        );
    }
}
