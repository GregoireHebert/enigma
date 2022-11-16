<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

session_start();
openlog('app', LOG_CONS|LOG_PERROR|LOG_PID, LOG_USER);

use App\Core\Events\ControllerEvent;
use App\Core\Events\EventDispatcher;
use App\Core\Events\RespondEvent;
use App\Core\Http\Exception\HttpException;
use App\Core\Http\Request;
use App\Core\Http\Router\Router;
use App\Core\Validator\ConstraintViolation;
use App\Security\Events\SecurityListener;
use App\Core\Api\Events\SerializeListener;
use App\Core\Events\RequestEvent;
use App\Core\Api\Events\StatusHttpListener;
use App\Security\Events\ContentNegociationListener;

try {
    $eventDispatcher = new EventDispatcher();
    $eventDispatcher->addListener(new ContentNegociationListener(), RequestEvent::class);
    $eventDispatcher->addListener(new SecurityListener(), ControllerEvent::class);
    $eventDispatcher->addListener(new SerializeListener(), RespondEvent::class);
    $eventDispatcher->addListener(new StatusHttpListener(), RespondEvent::class);

    $request = Request::createFromGlobals();

    $requestEvent = new RequestEvent($request);
    $eventDispatcher->dispatch($requestEvent);
    $request = $requestEvent->getRequest();

    $router = new Router();

    $controller = $router->getController($request);

    $controllerEvent = new ControllerEvent($controller);
    $eventDispatcher->dispatch($controllerEvent);
    $controller = $controllerEvent->getController();

    $controllerResult = $controller($request);

    $respondEvent = new RespondEvent($controllerResult, $request);
    $eventDispatcher->dispatch($respondEvent);
    $controllerResult = $respondEvent->getControllerResult();

    echo $controllerResult;
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
