<?php

declare(strict_types=1);

namespace App\Security\Exception;

use App\Core\Http\Exception\HttpException;

class AuthenticationException extends HttpException
{
    public function __construct(int $statusCode = 401, string $message = '{ "code": 401, "message": "Invalid credentials." }', int $code = 0, ?\Throwable $previous = null)
    {
        header('Content-Type: application/json');
        parent::__construct($statusCode, $message, $code, $previous);
    }
}
