<?php

namespace Tests;

use Illuminate\Http\JsonResponse;
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
    public function test_it_returns_a_validation_error_response(): void
    {
        $message = 'Validation failed';
        $errors = ['field' => 'error'];

        $response = Api::validation($message, $errors);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->status());

        $this->assertEquals([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
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
    public function test_it_returns_a_server_error_response(): void
    {
        $message = 'Server error';

        $response = Api::serverError($message);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(500, $response->status());

        $this->assertEquals([
            'success' => false,
            'message' => $message,
        ], $response->getData(true));
    }

    #[Test]
    public function test_it_returns_an_error_response(): void
    {
        $message = 'Something went wrong';
        $errors = ['error' => 'details'];

        $response = Api::error($message, $errors);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->status());

        $this->assertEquals([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $response->getData(true));
    }

    #[Test]
    public function test_it_returns_a_server_error_response_when_using_response(): void
    {
        $message = 'Server error';
        $status = 503;

        $response = Api::response(message: $message, status: $status);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($status, $response->status());

        $this->assertEquals([
            'success' => false,
            'message' => $message,
        ], $response->getData(true));
    }
}
