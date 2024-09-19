<?php

namespace SurazDott\ApiResponse;

use Illuminate\Support\ServiceProvider;
use SurazDott\ApiResponse\Http\ApiResponse;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function register(): void
    {
        $this->app->bind('api', function () {
            return new ApiResponse;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerHelpers();
    }

    /**
     * Register helpers.
     */
    protected function registerHelpers(): void
    {
        if (file_exists($helperFile = __DIR__.'/helpers.php')) {
            require_once $helperFile;
        }
    }
}
