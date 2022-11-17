<?php

declare(strict_types=1);

namespace App\Core\Logger;

interface LoggerInterface
{
    public function debug(string|\Stringable $message, array $context = []);
}
