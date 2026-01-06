<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Trackings\Monitors;

use App\Services\Resources\Trackings\Monitors\ResourcesTrackingsMonitorsServices;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Symfony\Component\HttpFoundation\Response;

class Index extends Controller
{

    protected ResourcesTrackingsMonitorsServices $services;

    public function __construct()
    {
        $this->services = new ResourcesTrackingsMonitorsServices();
    }
    public function index() : JsonResponse
    {
        $ReadData = $this->services->ReadAll();

        if ($ReadData) {
            return response()->json(
                data: array(
                    'status' => true,
                    'code' => Response::HTTP_OK,
                    'msg' => 'OK',
                    'data' => $ReadData
                ),
                status: Response::HTTP_OK,
                headers: array(
                    'Content-Type' => 'application/json',
                )
            );
        }else{
            return response()->json(
                data: array(
                    'status' => false,
                    'code' => Response::HTTP_BAD_REQUEST,
                    'msg' => "Failed To Read Data",
                ),
                status: Response::HTTP_OK,
                headers: array(
                    'Content-Type' => 'application/json',
                )
            );
        }

    }



    public function ReqLocationUpdate(Request $request) {
        // Validate token exists
        $token = $request->token;
        
        if (!$token) {
            \Log::error('ReqLocationUpdate: Missing FCM token in request', [
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'FCM token is required'
            ], 400);
        }

        try {
            $messaging = Firebase::messaging();
            
            // Build message with Android configuration
            $message = CloudMessage::withTarget('token', $token)
                ->withData([
                    'action' => 'RELOAD_GPS',
                    'timestamp' => now()->toIso8601String(),
                    'driver_name' => $request->driver_name ?? 'Unknown'
                ])
                ->withAndroidConfig([
                    'priority' => 'high',
                    'ttl' => '0s',
                ]);

            $result = $messaging->send($message);
            
            \Log::info('ReqLocationUpdate: FCM location request sent successfully', [
                'token' => substr($token, 0, 20) . '...',
                'result' => $result
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'FCM location request sent with high priority'
            ]);
            
        } catch (\Kreait\Firebase\Exception\Messaging\InvalidArgument $e) {
            \Log::error('ReqLocationUpdate: Invalid FCM token', [
                'token' => substr($token, 0, 20) . '...',
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid FCM token',
                'error' => $e->getMessage()
            ], 400);
            
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            \Log::error('ReqLocationUpdate: Firebase messaging error', [
                'token' => substr($token, 0, 20) . '...',
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send FCM notification',
                'error' => $e->getMessage()
            ], 500);
            
        } catch (Exception $e) {
            \Log::error('ReqLocationUpdate: Unexpected error', [
                'token' => substr($token, 0, 20) . '...',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Unexpected error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function ReqAlarm(Request $request) {
        // Validate token exists
        $token = $request->token;
        
        if (!$token) {
            \Log::error('ReqAlarm: Missing FCM token in request', [
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'FCM token is required'
            ], 400);
        }

        try {
            $messaging = Firebase::messaging();
            
            // Build message with Android configuration
            $message = CloudMessage::withTarget('token', $token)
                ->withData([
                    'action' => 'RINGING',
                    'timestamp' => now()->toIso8601String(),
                    'driver_name' => $request->driver_name ?? 'Unknown'
                ])
                ->withAndroidConfig([
                    'priority' => 'high',
                    'ttl' => '0s',
                ]);

            $result = $messaging->send($message);
            
            \Log::info('ReqAlarm: FCM alarm sent successfully', [
                'token' => substr($token, 0, 20) . '...',
                'result' => $result
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'FCM Alarm sent with high priority'
            ]);
            
        } catch (\Kreait\Firebase\Exception\Messaging\InvalidArgument $e) {
            \Log::error('ReqAlarm: Invalid FCM token', [
                'token' => substr($token, 0, 20) . '...',
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid FCM token',
                'error' => $e->getMessage()
            ], 400);
            
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            \Log::error('ReqAlarm: Firebase messaging error', [
                'token' => substr($token, 0, 20) . '...',
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send FCM notification',
                'error' => $e->getMessage()
            ], 500);
            
        } catch (Exception $e) {
            \Log::error('ReqAlarm: Unexpected error', [
                'token' => substr($token, 0, 20) . '...',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Unexpected error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
