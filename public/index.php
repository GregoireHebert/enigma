<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

session_start();
openlog('app', LOG_CONS|LOG_PERROR|LOG_PID, LOG_USER);

use App\Core\Events\EventDispatcher;
use App\Core\Http\Exception\HttpException;
use App\Core\Http\Request;
use App\Core\Http\Router\Router;
use App\Core\Validator\ConstraintViolation;
use App\Core\Events\ControllerEvent;
use App\Security\Events\SecurityListener;

$request = Request::createFromGlobals();
$router = new Router();

try {
    $eventDispatcher = new EventDispatcher();
    $eventDispatcher->addListener(new SecurityListener(), ControllerEvent::class);

    $controller = $router->getController($request);

    $controllerEvent = new ControllerEvent($controller);
    $eventDispatcher->dispatch($controllerEvent);
    $controller = $controllerEvent->getController();

    echo $controller($request);
} catch (ConstraintViolation $violation) {
    http_response_code(422);
    header('Content-Type: application/json');

    echo sprintf('{"field": "%s", "description": "%s"}', $violation->fieldName, $violation->getMessage());
} catch (HttpException $exception) {
    http_response_code($exception->httpStatusCode);
    echo $exception->getMessage();
} finally {
    closelog();
}
