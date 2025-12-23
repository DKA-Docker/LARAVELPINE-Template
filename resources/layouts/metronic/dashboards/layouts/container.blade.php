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
        <meta name="google-maps-key" content="{{ config('services.google.map.token') }}">
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
        {{-- Global Loader --}}
        <div x-data="{ loading: false }"
             x-show="loading"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-on:livewire:navigating.window="loading = true"
             x-on:livewire:navigated.window="loading = false"
             class="fixed inset-0 z-[9999] flex items-center justify-center bg-white/50 backdrop-blur-sm"
             style="display: none;">
            
            <div class="relative flex flex-col items-center justify-center gap-6">
                 {{-- Main Spinner --}}
                <div class="relative w-24 h-24">
                    {{-- Outer Ring --}}
                    <div class="absolute inset-0 rounded-full border-4 border-gray-100"></div>
                    {{-- Spinning Gradient Ring --}}
                    <div class="absolute inset-0 rounded-full border-4 border-transparent border-t-emerald-500 border-r-blue-500 animate-spin"></div>
                    {{-- Inner Pulsing Circle --}}
                    <div class="absolute inset-4 rounded-full bg-gradient-to-tr from-gray-50 to-white shadow-inner animate-pulse flex items-center justify-center">
                        <i class="ki-filled ki-rocket text-2xl text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-emerald-500"></i>
                    </div>
                    
                    {{-- Orbiting Dots --}}
                    <div class="absolute inset-0 animate-spin-slow">
                        <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.5)]"></div>
                    </div>
                    <div class="absolute inset-0 animate-spin-reverse-slow">
                        <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
                    </div>
                </div>

                {{-- Loading Text --}}
                <div class="text-center space-y-2 animate-fade-in-up">
                    <h3 class="text-lg font-black text-gray-800 tracking-tight">Memuat Data...</h3>
                    <div class="flex items-center justify-center gap-1">
                        <span class="w-1 h-1 rounded-full bg-gray-400 animate-bounce delay-0"></span>
                        <span class="w-1 h-1 rounded-full bg-gray-400 animate-bounce delay-100"></span>
                        <span class="w-1 h-1 rounded-full bg-gray-400 animate-bounce delay-200"></span>
                    </div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Mohon Tunggu Sebentar</p>
                </div>
            </div>
            
            <style>
                @keyframes spin-slow { to { transform: rotate(360deg); } }
                @keyframes spin-reverse-slow { to { transform: rotate(-360deg); } }
                @keyframes fade-in-up { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
                .animate-spin-slow { animation: spin-slow 3s linear infinite; }
                .animate-spin-reverse-slow { animation: spin-reverse-slow 4s linear infinite; }
                .animate-fade-in-up { animation: fade-in-up 0.5s ease-out forwards; }
            </style>
        </div>

        {{ $slot }}
</html>
