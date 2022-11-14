<?php

declare(strict_types=1);

namespace App\Validator;

class ConstraintViolation extends \RuntimeException
{
    public function __construct(public string $fieldName, string $message, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
