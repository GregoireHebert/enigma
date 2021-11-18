<?php

declare(strict_types=1);

namespace src\Logger;

trait LoggerAware
{
    public string $logsDir = __DIR__.'/../../var/logs';

    public function log(string $message, string $level = 'info', array $context = []): void
    {
        $path = $this->logsDir.'/'.$level.'.log';

        if (!$handle = fopen($path, 'a+')){
            throw new \LogicException("Impossible to open log file in '$path'");
        }

        $message = (new \DateTime())->format('Y-m-d H:i:s') . ' - ' . $message;

        if (!empty($context)) {
            $message .= PHP_EOL . var_export($context, true);
        }

        if(false === fwrite($handle, $message.PHP_EOL)) {
            throw new \LogicException("Impossible to write in log file '$path'");
        }

        fclose($handle);
    }
}
