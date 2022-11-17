<?php

declare(strict_types=1);

namespace App\Core\Logger;

class DatedLogger implements LoggerInterface
{
    public function __construct(private LoggerInterface $decorated)
    {
    }

    public function debug(string|\Stringable $message, array $context = [])
    {
        $dateTime = new \DateTime();
        $date = $dateTime->format('[Y-m-dTH:i:s] ');

        $file = fopen(PROJECT_DIR . '/var/logs/debug.log', 'a+b');
        fwrite($file, $date);
        fclose($file);

        $this->decorated->debug($message, $context);
    }
}
