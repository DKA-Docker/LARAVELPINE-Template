<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ini_set('max_execution_time', 10);
        /** @var
         * $paths muat semua migration sub dir dan semua dalam dir migration
         */
        $paths = File::directories(database_path('migrations'));
        $this->loadMigrationsFrom($paths);
    }
}
