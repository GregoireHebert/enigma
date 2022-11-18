<?php

declare(strict_types=1);

namespace App\Logger;

use App\Core\Logger\LoggerInterface;

class Logger implements LoggerInterface
{
    public function debug(string|\Stringable $message, array $context = [])
    {
        if (0 !== count($context)) {
            $message .= ' | context : ' . json_encode($context);
        }

        $file = fopen(PROJECT_DIR . '/var/logs/debug.log', 'a+b');
        fwrite($file, $message . PHP_EOL);
        fclose($file);
    }
}
