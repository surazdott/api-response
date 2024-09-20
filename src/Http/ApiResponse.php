<?php

namespace SurazDott\ApiResponse\Http;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Helper method to return a JSON,
     */
    private function toJson(mixed $data, int $status = 200): JsonResponse
    {
        return response()->json($data, $status);
    }

    /**
     * Create a new JSON response instance.
     */
    public function response(string $message, mixed $data = [], int $status = 200): JsonResponse
    {
        $success = $status >= 200 && $status < 300;

        $response = [
            'success' => $success,
            'message' => $message,
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return $this->toJson($response, $status);
    }

    /**
     * Create a new JSON success response instance.
     */
    public function success(string $message, mixed $data = []): JsonResponse
    {
        return $this->toJson([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], 200);
    }

    /**
     * Method to return a response for successful resource creation.
     */
    public function created(string $message, mixed $data = [], int $status = 201): JsonResponse
    {
        return $this->toJson([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Method to return a validation response.
     */
    public function validation(string $message, mixed $errors = [], int $status = 400): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }

    /**
     * Method to return an unauthorized response.
     */
    public function unauthorized(string $message, int $status = 401): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message,
        ], $status);
    }

    /**
     * Method to return a forbidden response.
     */
    public function forbidden(string $message, int $status = 403): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message,
        ], $status);
    }

    /**
     * Method to return a not found response.
     */
    public function notFound(string $message, int $status = 404): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message,
        ], $status);
    }

    /**
     * Method to return a method not allowed response.
     */
    public function notAllowed(string $message, int $status = 405): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message,
        ], $status);
    }

    /**
     * Method to return an error response.
     */
    public function error(string $message, mixed $errors = [], int $status = 400): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }

    /**
     * Method to return a server error response.
     *
     * @param string $message
     * @param int $status
     */
    public function serverError(string $message, int $status = 500): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message,
        ], $status);
    }
}
