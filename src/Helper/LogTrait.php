<?php

declare(strict_types=1);

namespace App\Helper;

trait LogTrait
{
    public static function info(string $message)
    {
        if (APP_DEBUG) {
            var_dump(LOG_INFO, $message);
        }

        syslog(LOG_INFO, $message);
    }

    public static function emergency(string $message)
    {
        if (APP_DEBUG) {
            var_dump(LOG_EMERG, $message);
        }

        syslog(LOG_EMERG, $message);
    }
}
