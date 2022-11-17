<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

session_start();
openlog('app', LOG_CONS|LOG_PERROR|LOG_PID, LOG_USER);

use App\Core\Kernel;

(new Kernel())->handle();
