<?php

namespace SurazDott\ApiResponse\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Http\JsonResponse response(string $message, mixed $data = [], int $status = 200)
 * @method static \Illuminate\Http\JsonResponse success(string $message, mixed $data = [])
 * @method static \Illuminate\Http\JsonResponse created(string $message, mixed $data = [], int $status = 201)
 * @method static \Illuminate\Http\JsonResponse validation(string $message, mixed $errors = [], int $status = 400)
 * @method static \Illuminate\Http\JsonResponse unauthorized(string $message, int $status = 401)
 * @method static \Illuminate\Http\JsonResponse forbidden(string $message, int $status = 403)
 * @method static \Illuminate\Http\JsonResponse notFound(string $message, int $status = 404)
 * @method static \Illuminate\Http\JsonResponse notAllowed(string $message, int $status = 405)
 * @method static \Illuminate\Http\JsonResponse error(string $message, mixed $errors = [], int $status = 400)
 * @method static \Illuminate\Http\JsonResponse serverError(string $message, int $status = 500)
 *
 * @see \SurazDott\ApiResponse\Http\ApiResponse
 */
final class Api extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'api';
    }
}
