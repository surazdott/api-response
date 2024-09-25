<?php

namespace SurazDott\ApiResponse\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiValidationException extends Exception
{
    /**
     * Create a new exception instance.
     */
    public function __construct(
        string $message,
        protected mixed $errors
    ) {
        parent::__construct($message);
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return api()->validation($this->message, $this->errors);
    }
}
