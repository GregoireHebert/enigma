<?php

declare(strict_types=1);

namespace App\Core\Logger;

class NullLogger implements LoggerInterface
{
    public function debug(string|\Stringable $message, array $context = [])
    {
        // do nothing
    }
}
