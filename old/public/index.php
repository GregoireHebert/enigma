<?php

declare(strict_types=1);

openlog('App', LOG_PID|LOG_PERROR, LOG_LOCAL0);
define('APP_DEBUG', true);

spl_autoload_register(static function($className) {
    $path = __DIR__.'/../'.str_replace(['\\', 'App'], ['/', 'src'], $className).'.php';
    if (file_exists($path)) {
        require_once ($path);
    }
});

session_start();

require_once (__DIR__.'/../config/routes.php');

use App\Controller\HttpError;
use App\Controller\Controller;

try {
    $controllerName = $routing->getController();

    $controller = new $controllerName();
    if (!$controller instanceof Controller) {
        throw new LogicException("Controller $controllerName must implement Controller interface");
    }

    $controller->display($routing);

} catch (Error|Exception $e) {

    $controller = new HttpError();
    $controller->display(400, $e);
} finally {
    closelog();
    exit(0);
}
