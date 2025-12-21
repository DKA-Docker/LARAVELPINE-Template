<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;

class JSONCheckRequest extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /*if (!$request->isJson() || !str_contains((string) $request->header('Accept'), 'application/json')) {
            return response()->json(
                data: array(
                    'status' => false,
                    'code' => Response::HTTP_NOT_ACCEPTABLE,
                    'msg' => 'Invalid request method.',
                ),
                status: Response::HTTP_NOT_ACCEPTABLE,
                headers: array(
                    'Content-Type' => 'application/json',
                )
            );
        }*/
        return $next($request);
    }
}
