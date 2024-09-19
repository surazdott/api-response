<?php

namespace Tests;

use SurazDott\ApiResponse\ApiResponseServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Get the package providers required for testing.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getPackageProviders($app): array
    {
        return [
            ApiResponseServiceProvider::class,
        ];
    }
}
