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
        protected mixed $errors,
        string $message = null,
    ) {
        parent::__construct($message);
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        if (empty($this->message)) {
            $message = __('api-response::api.validation');
        } else {
            $message = $this->message;
        }

        return api()->validation($this->errors, $message);
    }
}
