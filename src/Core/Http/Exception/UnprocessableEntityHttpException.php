<?php

declare(strict_types=1);

namespace App\Core\Http\Exception;

class UnprocessableEntityHttpException extends HttpException
{
    public function __construct(int $httpStatusCode = 422, string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($httpStatusCode, $message, $code, $previous);
    }
}
