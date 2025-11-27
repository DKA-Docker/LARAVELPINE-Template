<?php

namespace App\Http\Controllers\V1\Api\Dashboards\Apps\Trackings\Monitors;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class Index extends Controller
{

    public function index() : JsonResponse
    {
        return response()->json(
            data: array(
                'status' => true,
                'code' => Response::HTTP_OK,
                'msg' => 'OK',
            ),
            status: Response::HTTP_OK,
            headers: array(
                'Content-Type' => 'application/json',
            )
        );
    }
}
