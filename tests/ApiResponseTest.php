<?php

namespace Tests;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use PHPUnit\Framework\Attributes\Test;
use SurazDott\ApiResponse\Facades\Api;

final class ApiResponseTest extends TestCase
{
    #[Test]
    public function test_it_returns_a_generic_response(): void
    {
        $message = 'Generic response';
        $data = ['key' => 'value'];
        $status = 202;

        $response = Api::response($message, $data, $status);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($status, $response->status());
        $this->assertEquals([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $response->getData(true));
    }

    #[Test]
    public function test_it_returns_a_success_response(): void
    {
        $message = 'Operation successful';
        $data = ['key' => 'value'];

        $response = Api::success($message, $data);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $response->getData(true));
    }

    #[Test]
    public function test_it_returns_a_paginated_response(): void
    {
        $message = 'Paginated response';

        $data = new JsonResource(new LengthAwarePaginator(
            ['item1', 'item2'], // Items
            100, // Total records
            10, // Per page
            1, // Current page
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        ));

        $response = Api::paginate($message, $data);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());

        $responseData = $response->getData(true);

        $this->assertEquals([
            'success' => true,
            'message' => $message,
            'data' => $responseData['data'],
            'links' => [
                'first' => $responseData['links']['first'],
                'last' => $responseData['links']['last'],
                'prev' => $responseData['links']['prev'],
                'next' => $responseData['links']['next'],
            ],
            'meta' => [
                'total' => $responseData['meta']['total'],
                'current_page' => $responseData['meta']['current_page'],
                'total_pages' => $responseData['meta']['total_pages'],
                'per_page' => $responseData['meta']['per_page'],
            ],
        ], $responseData);
    }

    #[Test]
    public function test_it_returns_a_created_response(): void
    {
        $message = 'Resource created';
        $data = ['id' => 1];

        $response = Api::created($message, $data);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->status());
        $this->assertEquals([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $response->getData(true));
    }

    #[Test]
    public function test_it_returns_a_bad_request_error_response(): void
    {
        $message = 'Bad request';
        $status = 400;

        $response = Api::error($message, $status);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->status());
        $this->assertEquals([
            'success' => false,
            'message' => $message,
        ], $response->getData(true));
    }

    #[Test]
    public function test_it_returns_an_unauthorized_response(): void
    {
        $message = 'Unauthorized';

        $response = Api::unauthorized($message);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(401, $response->status());
        $this->assertEquals([
            'success' => false,
            'message' => $message,
        ], $response->getData(true));
    }

    #[Test]
    public function test_it_returns_a_forbidden_response(): void
    {
        $message = 'Forbidden';

        $response = Api::forbidden($message);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(403, $response->status());
        $this->assertEquals([
            'success' => false,
            'message' => $message,
        ], $response->getData(true));
    }

    #[Test]
    public function test_it_returns_a_not_found_response(): void
    {
        $message = 'Resource not found';

        $response = Api::notFound($message);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $response->status());
        $this->assertEquals([
            'success' => false,
            'message' => $message,
        ], $response->getData(true));
    }

    #[Test]
    public function test_it_returns_a_method_not_allowed_response(): void
    {
        $message = 'Method not allowed';

        $response = Api::notAllowed($message);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(405, $response->status());
        $this->assertEquals([
            'success' => false,
            'message' => $message,
        ], $response->getData(true));
    }

    #[Test]
    public function test_it_returns_a_validation_error_response(): void
    {
        $message = 'Validation failed';
        $errors = ['field' => 'error'];

        $response = Api::validation($message, $errors);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(422, $response->status());
        $this->assertEquals([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $response->getData(true));
    }

    #[Test]
    public function test_it_returns_a_server_error_response(): void
    {
        $message = 'Server error';
        $status = 500;

        $response = Api::serverError($message, $status);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(500, $response->status());
        $this->assertEquals([
            'success' => false,
            'message' => $message,
        ], $response->getData(true));
    }

    #[Test]
    public function test_it_returns_a_server_error_response_when_using_response(): void
    {
        $message = 'Server error';
        $status = 503;

        $response = Api::response($message, [], $status);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($status, $response->status());
        $this->assertEquals([
            'success' => false,
            'message' => $message,
            'data' => [],
        ], $response->getData(true));
    }
}
