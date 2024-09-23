<?php

namespace SurazDott\ApiResponse\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiResponseException extends Exception
{
    /**
     * Create a new exception instance.
     */
    public function __construct(
        string $message,
        protected int $status = 500
    ) {
        parent::__construct($message);
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'success' => $this->status >= 200 && $this->status < 300,
            'message' => $this->message,
        ], $this->status);
    }
}
