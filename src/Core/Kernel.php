<?php

declare(strict_types=1);

namespace App\Core;

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
use App\Core\DependencyInjection\Container;
use App\Core\DependencyInjection\ServiceDefinition;
use App\Security\UserFactory;
use App\Account\Validator\UserValidator;
use App\Security\Repository\UserRepository;

class Kernel
{
    private Container $container;
    private Request $request;
    private EventDispatcher $eventDispatcher;

    public function __construct()
    {
        $this->boot();
    }

    private function boot()
    {
        $userFactoryService = new ServiceDefinition(UserFactory::class);
        $userValidatorService = new ServiceDefinition(UserValidator::class);
        $userRepositoryService = new ServiceDefinition(UserRepository::class);
        $this->container = new Container([
            UserFactory::class => $userFactoryService,
            UserValidator::class => $userValidatorService,
            UserRepository::class => $userRepositoryService,
        ]);

        $this->eventDispatcher = new EventDispatcher();
        $this->eventDispatcher->addListener(new ContentNegociationListener(), RequestEvent::class);
        $this->eventDispatcher->addListener(new SecurityListener(), ControllerEvent::class);
        $this->eventDispatcher->addListener(new SerializeListener(), RespondEvent::class);
        $this->eventDispatcher->addListener(new StatusHttpListener(), RespondEvent::class);

        $this->request = Request::createFromGlobals();
    }

    public function handleRequest()
    {
        $requestEvent = new RequestEvent($this->request);
        $this->eventDispatcher->dispatch($requestEvent);
        $this->request = $requestEvent->getRequest();

        $router = new Router();

        $controller = $router->getController($this->request);

        $controllerEvent = new ControllerEvent($controller);
        $this->eventDispatcher->dispatch($controllerEvent);
        $controller = $controllerEvent->getController();

        $controllerResult = $controller($this->request, $this->container);

        $respondEvent = new RespondEvent($controllerResult, $this->request);
        $this->eventDispatcher->dispatch($respondEvent);
        $controllerResult = $respondEvent->getControllerResult();

        echo $controllerResult;
    }

    public function handle()
    {
        try {
            $this->handleRequest();
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
    }
}
