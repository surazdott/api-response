<?php

namespace SurazDott\ApiResponse;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use SurazDott\ApiResponse\Exceptions\Handler as ApiExceptionHandler;
use SurazDott\ApiResponse\Http\ApiResponse;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function register(): void
    {
        $this->registerFacades();
        $this->app->singleton(ExceptionHandler::class, ApiExceptionHandler::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerHelpers();
        $this->setupTranslations();
    }

    /**
     * Register facades.
     */
    public function registerFacades(): void
    {
        $this->app->bind('api', function () {
            return new ApiResponse;
        });
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

    /**
     * Register transalations.
     */
    private function setupTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'api-response');

        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/api-response'),
        ], 'api-response');
    }
}
