<?php

declare(strict_types=1);

namespace App\Core;

use App\Account\Validator\UserValidator;
use App\Core\Api\Events\SerializeListener;
use App\Core\Api\Events\StatusHttpListener;
use App\Core\DependencyInjection\ConfigurationModifier;
use App\Core\DependencyInjection\Container;
use App\Core\DependencyInjection\ServiceDefinition;
use App\Core\Events\ControllerEvent;
use App\Core\Events\EventDispatcher;
use App\Core\Events\RequestEvent;
use App\Core\Events\RespondEvent;
use App\Core\Http\Exception\HttpException;
use App\Core\Http\Request;
use App\Core\Http\Router\Router;
use App\Core\Logger\Logger;
use App\Core\Logger\LoggerInterface;
use App\Core\Validator\ConstraintViolation;
use App\Security\Events\ContentNegociationListener;
use App\Security\Events\SecurityListener;
use App\Security\Repository\UserRepository;
use App\Security\UserFactory;

class Kernel
{
    private Container $container;
    private Request $request;
    private EventDispatcher $eventDispatcher;
    private array $configurationModifiers = [];

    private function boot()
    {
        $userFactoryService = new ServiceDefinition(UserFactory::class);
        $userValidatorService = new ServiceDefinition(UserValidator::class);
        $userRepositoryService = new ServiceDefinition(UserRepository::class);
        $loggerService = new ServiceDefinition(Logger::class);

        $this->container = new Container([
            UserFactory::class => $userFactoryService,
            UserValidator::class => $userValidatorService,
            UserRepository::class => $userRepositoryService,
            LoggerInterface::class => $loggerService,
        ]);

        $this->eventDispatcher = new EventDispatcher();
        $this->eventDispatcher->addListener(new ContentNegociationListener(), RequestEvent::class);
        $this->eventDispatcher->addListener(new SecurityListener(), ControllerEvent::class);
        $this->eventDispatcher->addListener(new SerializeListener(), RespondEvent::class);
        $this->eventDispatcher->addListener(new StatusHttpListener(), RespondEvent::class);

        $this->request = Request::createFromGlobals();

        $this->configure();
        $this->container->isBooted = true;
    }

    private function configure(): void
    {
        $this->loadModifiers();

        foreach ($this->configurationModifiers as $configurationModifier) {
            $configurationModifier->modify($this->container);
        }
    }

    public function loadModifiers(): void
    {
        $path = PROJECT_DIR . '/config/Modifiers';
        $files = scandir($path);

        foreach ($files as $modifier) {
            $filePath = $path . '/' . $modifier;

            if (is_dir($filePath)) {
                continue;
            }

            $this->addConfigurationModifier(require($filePath));
        }
    }

    private function addConfigurationModifier(ConfigurationModifier $configurationModifier): void
    {
        $this->configurationModifiers[] = $configurationModifier;
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
            $this->boot();
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
