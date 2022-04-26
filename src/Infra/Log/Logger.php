<?php

declare(strict_types=1);

namespace App\Infra\Log;

class Logger
{
    private const LOG_PATH = __DIR__ . '/../../../var/cache/error.log';

    public function log(string $message): void
    {
        file_put_contents(self::LOG_PATH, PHP_EOL.$message, FILE_APPEND);
    }
}
