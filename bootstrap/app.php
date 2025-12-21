<?php

use App\Http\Middleware\Api\JSONCheckRequest;
use App\Http\Middleware\Frontend\Authenticate;
use App\Http\Middleware\Frontend\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) { // Hapus : void untuk testing
        // Masukkan SetLocale ke grup web
        $middleware->web(append: [
            SetLocale::class,
        ]);

        $middleware->alias([
            'auth' => Authenticate::class,
        ]);

        $middleware->group('Api', [
            JSONCheckRequest::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
