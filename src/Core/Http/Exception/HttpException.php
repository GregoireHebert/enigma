<?php

declare(strict_types=1);

namespace App\Core\Http\Exception;

class HttpException extends \RuntimeException
{
    public function __construct(int $statusCode, string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
