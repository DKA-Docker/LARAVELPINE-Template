<?php

return [
    'paths' => [
        resource_path('layouts/'.config('theme.name', 'laravel')),
    ],
    'compiled' => env('VIEW_COMPILED_PATH', realpath(storage_path('framework/views'))),
];
