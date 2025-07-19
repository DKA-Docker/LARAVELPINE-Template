<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Di sini kamu bisa mengatur siapa saja yang boleh akses API kamu
    | dari domain berbeda. Ini penting banget kalau kamu pakai
    | frontend dan backend terpisah (misalnya React + Laravel).
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie', '/*', 'logout'],

    'allowed_methods' => ['*'], // ['GET', 'POST', ...] bisa diganti juga

    'allowed_origins' => ['*'], // ['https://example.com'], bisa wildcard

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // ['Content-Type', 'X-Requested-With']

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
