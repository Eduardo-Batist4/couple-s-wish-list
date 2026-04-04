<?php

declare(strict_types=1);

namespace App\Helpers;

class ResponseHelper
{
    public static function success(mixed $data, int $code = 200): void
    {
        http_response_code($code);
        echo json_encode(['data' => $data]);
    }

    public static function error(string $message, int $code): void
    {
        http_response_code($code);
        echo json_encode(['error' => $message]);
    }

    public static function notFound(string $message = 'Resource not found'): void
    {
        self::error($message, 404);
    }

    public static function unprocessable(string $message = 'Validation error'): void
    {
        self::error($message, 422);
    }

    public static function conflict(string $message = 'Conflict'): void
    {
        self::error($message, 409);
    }

    public static function unauthorized(string $message = 'Unauthorized'): void
    {
        self::error($message, 401);
    }

    public static function created(mixed $data): void
    {
        self::success($data, 201);
    }
}