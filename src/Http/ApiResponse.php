<?php

namespace SurazDott\ApiResponse\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

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
    public function response(string $message, mixed $data = [], int $status = 200): JsonResponse
    {
        $response = [
            'success' => $status >= 200 && $status < 300,
            'message' => $message,
        ];

        if (! empty($data)) {
            $response['data'] = $data;
        }

        return $this->toJson($response, $status);
    }

    /**
     * Create a new JSON success response instance.
     */
    public function success(string $message, mixed $data = []): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if (! empty($data)) {
            $response['data'] = $data;
        }

        return $this->toJson($response, 200);
    }

    /**
     * Create a new paginated JSON response instance.
     */
    public function paginate(string $message, mixed $data = []): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        $resource = $data;

        if ($resource instanceof JsonResource) {
            $response['total'] = $data->total();
            $response['total_pages'] = $data->lastPage();
            $response['per_page'] = $data->perPage();
            $response['data'] = $data;
        }

        $response['data'] = $data;

        return $this->toJson($response, 200);
    }

    /**
     * Method to return a response for successful resource creation.
     */
    public function created(string $message, mixed $data = []): JsonResponse
    {
        return $this->toJson([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], 201);
    }

    /**
     * Method to return a error response.
     */
    public function error(string $message, int $status = 400): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message,
        ], $status);
    }

    /**
     * Method to return an unauthorized response.
     */
    public function unauthorized(string $message): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message,
        ], 401);
    }

    /**
     * Method to return a forbidden response.
     */
    public function forbidden(string $message): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message,
        ], 403);
    }

    /**
     * Method to return a not found response.
     */
    public function notFound(string $message): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message,
        ], 404);
    }

    /**
     * Method to return a method not allowed response.
     */
    public function notAllowed(string $message): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message,
        ], 405);
    }

    /**
     * Method to return a validation response.
     */
    public function validation(string $message, mixed $errors = []): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], 422);
    }

    /**
     * Method to return a unprocessable response.
     */
    public function unprocessable(string $message, mixed $errors = []): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (! empty($errors)) {
            $response['errors'] = $errors;
        }

        return $this->toJson($response, 422);
    }

    /**
     * Method to return a server error response.
     */
    public function serverError(string $message, int $status = 500): JsonResponse
    {
        return $this->toJson([
            'success' => false,
            'message' => $message,
        ], $status);
    }
}
