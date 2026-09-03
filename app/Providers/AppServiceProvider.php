<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // ponytail: app is served from a subdirectory in production
        // (https://kemahasiswaan.gunadarma.ac.id/prestasi), so url()/route()
        // must keep that prefix. Driven by APP_URL; no-op when it has no path.
        $root = rtrim((string) config('app.url'), '/');

        if (trim((string) parse_url($root, PHP_URL_PATH), '/') !== '') {
            URL::forceRootUrl($root);
        }
    }
}
