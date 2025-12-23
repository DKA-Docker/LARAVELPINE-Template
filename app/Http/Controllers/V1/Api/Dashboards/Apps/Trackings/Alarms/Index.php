<?php

namespace App\Http\Controllers\V1\Api\Dashboards\Apps\Trackings\Alarms;

use App\Services\Auth\AuthAccountsServices;
use App\Services\Resources\Trackings\Monitors\ResourcesTrackingsMonitorsServices;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use App\Events\Dashboards\Apps\Trackings\Alarms\Index as AlarmEvent;

class Index extends Controller
{

    protected ResourcesTrackingsMonitorsServices $services;
    protected AuthAccountsServices $auth;

    public function __construct()
    {
        $this->services = new ResourcesTrackingsMonitorsServices();
        $this->auth = new AuthAccountsServices();
    }

    public function store(Request $request)
    {
        // 1. Verifikasi Account Session
        $account = $this->auth->verify();
        $accountId = $account['data']['id'] ?? null;

        // 2. Siapkan Data Default
        $defaults = [
            'id' => (string) Str::uuid(),
            'account' => $accountId, // Pastikan menggunakan account_id agar sinkron dengan tracking.ts
            'created_at' => now()->toDateTimeString(),
        ];

        // 3. Gabungkan data dengan aman (tanpa Splat Operator ...)
        $data = array_merge($defaults, $request->all());

        Log::info("Alarm Payload: " . json_encode($data));

        try {
            // 4. Broadcast ke Frontend
            broadcast(new AlarmEvent($data));

            return response()->json([
                'status' => true,
                'code' => Response::HTTP_OK,
                'msg' => 'Successfully Alert Alarm',
                'data' => $data
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            Log::error("Alarm Broadcast Error: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_BAD_REQUEST,
                'msg' => 'Failed to broadcast alarm',
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
