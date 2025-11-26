<?php

namespace App\Http\Middleware\Frontend;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Redirect ke path tertentu kalau request bukan JSON.
     */
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            // bisa pakai path langsung
            return '/auth';

            // atau kalau kamu punya route name:
            // return route('auth.login');
        }

        return null; // biar API tetap dapat 401 tanpa redirect
    }
}
