<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log; // 🟢 Tambahkan ini
// ...
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken; // Jika Anda menggunakan Sanctum

/**
 * @deprecated
 */
class VerifyBearerTokenAuthorization
{
    public function handle(Request $request, Closure $next): Response
    {
        $authType = $request->attributes->get('auth_type');
        $token = $request->attributes->get('auth_token');

        $header = $request->header('Authorization');
        if (str_starts_with($header, 'Bearer ')) {
            $rawToken = substr($header, 7);
            // Cari token di database
            $token = PersonalAccessToken::findToken($rawToken);
            if ($token && $token->tokenable) {
                // Autentikasi pengguna
                Auth::login($token->tokenable);
                return $next($request);
            }
        }

        // Jika gagal atau tidak ada token
        return response()->json(
            data: array(
                'status' => false,
                'code' => Response::HTTP_UNAUTHORIZED,
                'msg' => 'Unauthorized',
            ),
            status: Response::HTTP_UNAUTHORIZED,
            headers: array(
                'Content-Type' => 'application/json',
            )
        );
    }
}
