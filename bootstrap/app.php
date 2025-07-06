<?php

use App\Models\SessionsAccounts;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'code' => 404,
                    'msg' => 'PAGE NOT FOUND',
                ], 404);
            }
            return null;
        });
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'code' => 501,
                    'msg' => 'UNIMPLEMENTED',
                ], 501);
            }
            return null;
        });
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->call(function () {
            SessionsAccounts::query()
                ->where('last_activity', '<', now()->timestamp - (config('session.lifetime') * 60))
                ->delete();
        })->weekly(); // ← 🗓️ prune setiap minggu
    })
    ->create();
