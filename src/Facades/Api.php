<?php

namespace SurazDott\ApiResponse\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Http\JsonResponse response(mixed $data = [], ?string $message, int $status = 200)
 * @method static \Illuminate\Http\JsonResponse success(mixed $data = [], ?string $message)
 * @method static \Illuminate\Http\JsonResponse created(mixed $data = [], ?string $message)
 * @method static \Illuminate\Http\JsonResponse validation(mixed $errors = [], ?string $message)
 * @method static \Illuminate\Http\JsonResponse unprocessable(mixed $errors = [], ?string $message)
 * @method static \Illuminate\Http\JsonResponse unauthorized(?string $message)
 * @method static \Illuminate\Http\JsonResponse forbidden(?string $message)
 * @method static \Illuminate\Http\JsonResponse notFound(?string $message)
 * @method static \Illuminate\Http\JsonResponse notAllowed(?string $message)
 * @method static \Illuminate\Http\JsonResponse error(?string $message = null, int $status = 500)
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
