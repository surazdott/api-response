<?php

namespace SurazDott\ApiResponse\Http;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Helper method to return a JSON,
     */
    private function toJson(mixed $data, int $status): JsonResponse
    {
        return response()->json($data, $status);
    }

    /**
     * Create a new JSON response instance.
     */
    public function response(mixed $data = [], ?string $message = null, int $status = 200): JsonResponse
    {
        $response = [
            'success' => $status >= 200 && $status < 300,
            'message' => $message ?? __('api-response::api.success'),
        ];

        if (! empty($data)) {
            $response['data'] = $data;
        }

        return $this->toJson($response, $status);
    }

    /**
     * Create a new JSON success response instance.
     */
    public function success(mixed $data = [], ?string $message = null): JsonResponse
    {
        return $this->toJson([
            'success' => true,
            'message' => $message ? $message : __('api-response::api.success'),
            'data' => $data,
        ], 200);
    }

    /**
     * Method to return a response for successful resource creation.
     */
    public function created(mixed $data = [], ?string $message = null): JsonResponse
    {
        return $this->toJson([
            'success' => true,
            'message' => $message ? $message : __('api-response::api.created'),
            'data' => $data,
        ], 201);
    }

    /**
     * Method to return a validation response.
     */
    public function validation(mixed $errors = [], ?string $message = null): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message ?? __('api-response::api.validation'),
            'errors' => $errors,
        ], 422);
    }

    /**
     * Method to return a unprocessable response.
     */
    public function unprocessable(mixed $errors = [], ?string $message = null): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message ?? __('api-response::api.unprocessable'),
            'errors' => $errors,
        ], 422);
    }

    /**
     * Method to return an unauthorized response.
     */
    public function unauthorized(?string $message = null): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message ?? __('api-response::api.unauthorized'),
        ], 401);
    }

    /**
     * Method to return a forbidden response.
     */
    public function forbidden(?string $message = null): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message ?? __('api-response::api.forbidden'),
        ], 403);
    }

    /**
     * Method to return a not found response.
     */
    public function notFound(?string $message = null): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message ?? __('api-response::api.not_found'),
        ], 404);
    }

    /**
     * Method to return a method not allowed response.
     */
    public function notAllowed(?string $message = null): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message ?? __('api-response::api.not_allowed'),
        ], 405);
    }

    /**
     * Method to return a error response.
     */
    public function error(?string $message = null, int $status = 400): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message ?? __('api-response::api.error'),
        ], $status);
    }
}
