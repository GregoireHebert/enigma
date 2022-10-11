<?php

declare(strict_types=1);

namespace App\Security\Exception;

use App\Core\Http\Exception\HttpException;

class ForbiddenHttpException extends HttpException
{
    public function __construct(int $statusCode = 403, string $message = '{ "code": 403, "message": "Access forbidden" }', int $code = 0, ?\Throwable $previous = null)
    {
        header('Content-Type: application/json');
        parent::__construct($statusCode, $message, $code, $previous);
    }
}
