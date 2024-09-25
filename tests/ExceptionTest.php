<?php

namespace Tests;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Test;
use SurazDott\ApiResponse\Exceptions\ApiResponseException;
use SurazDott\ApiResponse\Exceptions\ApiValidationException;

final class ExceptionTest extends TestCase
{
    #[Test]
    public function test_api_response_exception_render(): void
    {
        $errors = ['field' => 'error'];
        $message = 'An error occurred';

        $exception = new ApiResponseException($message);
        $request = new Request();

        $response = $exception->render($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(500, $response->status());

        $this->assertEquals([
            'success' => false,
            'message' => $message,
        ], $response->getData(true));
    }

    #[Test]
    public function test_api_validation_exception_render(): void
    {
        $errors = ['email' => 'Email is required'];
        $message = 'Validation failed';

        $exception = new ApiValidationException($message, $errors);
        $request = new Request();

        $response = $exception->render($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(422, $response->status());

        $this->assertEquals([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $response->getData(true));
    }
}
