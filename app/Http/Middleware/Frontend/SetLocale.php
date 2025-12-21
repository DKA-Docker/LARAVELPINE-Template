<?php

namespace App\Http\Middleware\Frontend;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App; // Pastikan ini ada
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->query('lang');

        // Tambahkan id_Makassar ke dalam array validasi
        $availableLocales = ['en', 'zh', 'id', 'id_Makassar', 'id_Java'];

        if ($lang && in_array($lang, $availableLocales)) {
            session()->put('locale', $lang);
        }

        App::setLocale(session('locale', config('app.locale')));

        return $next($request);
    }
}
