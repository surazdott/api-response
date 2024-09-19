<?php

use SurazDott\ApiResponse\Http\ApiResponse;

if (! function_exists('api')) {
    /**
     * Create a new API response instance.
     */
    function api(): ApiResponse
    {
        return app(ApiResponse::class);
    }
}
