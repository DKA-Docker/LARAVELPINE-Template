<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Jose\Component\Core\JWT;
use Symfony\Component\HttpFoundation\Response;
/**
 * @deprecated
 */

class CheckAuthorizationHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek dulu header Authorization ada atau tidak
        $authHeader = $request->header('Authorization');
        if (!$authHeader) {
            return response()->json(
                data: [
                    'status' => false,
                    'code'   => Response::HTTP_UNAUTHORIZED,
                    'msg'    => 'This request requires Authorization header',
                ],
                status: Response::HTTP_UNAUTHORIZED,
                headers: [
                    'Content-Type' => 'application/json',
                ]
            );
        }

        // Pecah "Bearer xxxxx" jadi [type, token]
        $parts = preg_split('/\s+/', trim($authHeader), 2);

        if (count($parts) !== 2) {
            return response()->json(
                data: [
                    'status' => false,
                    'code'   => Response::HTTP_UNAUTHORIZED,
                    'msg'    => 'Invalid Authorization header format',
                ],
                status: Response::HTTP_UNAUTHORIZED,
                headers: [
                    'Content-Type' => 'application/json',
                ]
            );
        }

        [$type, $token] = $parts;

        // Pastikan typenya Bearer (case-insensitive) dan token tidak kosong
        if (strcasecmp($type, 'Bearer') !== 0 || empty($token)) {
            return response()->json(
                data: [
                    'status' => false,
                    'code'   => Response::HTTP_UNAUTHORIZED,
                    'msg'    => 'Invalid Authorization type or token',
                ],
                status: Response::HTTP_UNAUTHORIZED,
                headers: [
                    'Content-Type' => 'application/json',
                ]
            );
        }

        // (opsional) simpan token ke attribute biar bisa dipakai di controller / service
        $request->attributes->set('auth_type', $type);
        $request->attributes->set('auth_token', $token);

        return $next($request);
    }
}
