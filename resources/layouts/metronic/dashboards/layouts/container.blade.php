<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="dark" dir="ltr" lang="en">
    <head>
        <title>{{ config("app.name", "Laravel") }}</title>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="reverb-key" content="{{ env('VITE_REVERB_APP_KEY') }}">
        <meta name="reverb-host" content="{{ env('VITE_REVERB_HOST') }}">
        <meta name="reverb-port" content="{{ env('VITE_REVERB_PORT') }}">
        <meta name="reverb-scheme" content="{{ env('VITE_REVERB_SCHEME') }}">
        <meta name="mapbox-token" content="{{ config('services.mapbox.token') }}">
        <meta content="follow, index" name="robots" />
        <link href="#" rel="canonical" />
        <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
        <meta content="" name="description" />
        <meta content="@keenthemes" name="twitter:site" />
        <meta content="@keenthemes" name="twitter:creator" />
        <meta content="summary_large_image" name="twitter:card" />
        <meta content="Metronic - Tailwind CSS " name="twitter:title" />
        <meta content="" name="twitter:description" />
        <meta content="assets/media/app/og-image.png" name="twitter:image" />
        <meta content="https://127.0.0.1:8001/metronic-tailwind-html/demo1/index.html" property="og:url" />
        <meta content="en_US" property="og:locale" />
        <meta content="website" property="og:type" />
        <meta content="@keenthemes" property="og:site_name" />
        <meta content="Metronic - Tailwind CSS " property="og:title" />
        <meta content="" property="og:description" />
        <meta content="assets/media/app/og-image.png" property="og:image" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
        <!-- Styles / Scripts -->
        @if (file_exists(public_path("build/manifest.json")) || file_exists(public_path("hot")))
            @vite(["resources/theme/" . config("theme.name", "laravel") . "/css/app.css", "resources/theme/" . config("theme.name", "laravel") . "/js/app.ts"])
        @endif

        @livewireStyles
    </head>
    {{ $slot }}
</html>
