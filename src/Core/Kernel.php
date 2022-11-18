<?php

declare(strict_types=1);

namespace App\Core;

use App\Account\Validator\UserValidator;
use App\Api\Events\SerializeListener;
use App\Api\Events\StatusHttpListener;
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
use App\Core\Validator\ConstraintViolation;
use App\Security\Events\ContentNegociationListener;
use App\Security\Events\SecurityListener;

class Kernel
{
    private const SERVICES_EXCLUSIONS = ['Exception', 'Model', 'Command', 'Core', '.',  '..'];

    private Container $container;
    private Request $request;
    private EventDispatcher $eventDispatcher;
    private array $configurationModifiers = [];

    private function boot()
    {
        $this->findServicesDefinitions(servicesDefinitions: $servicesDefinitions);
        array_filter($servicesDefinitions);
        $this->container = new Container($servicesDefinitions);

        $this->eventDispatcher = new EventDispatcher();
        $this->eventDispatcher->addListener(new ContentNegociationListener(), RequestEvent::class);
        $this->eventDispatcher->addListener(new SecurityListener(), ControllerEvent::class);
        $this->eventDispatcher->addListener(new SerializeListener(), RespondEvent::class);
        $this->eventDispatcher->addListener(new StatusHttpListener(), RespondEvent::class);

        $this->request = Request::createFromGlobals();

        $this->configure();
        $this->container->isBooted = true;
    }

    private function findServicesDefinitions(string $path  = PROJECT_DIR . '/src', ?array &$servicesDefinitions = [])
    {
        /** @var \SplFileInfo $fileInfo */
        foreach (new \DirectoryIterator($path) as $fileInfo) {
            $filename = $fileInfo->getFilename();
            if (in_array($filename, self::SERVICES_EXCLUSIONS)) {
                continue;
            }

            $filePath = $path . '/'.  $filename;

            if (is_dir($filePath)) {
                // recursive
                $this->findServicesDefinitions($filePath, $servicesDefinitions);
                continue;
            }

            if ($fileInfo->getExtension() !== 'php') {
                continue;
            }

            [$prefix, $suffix] = explode('/../', $filePath);
            $className = str_replace(['src', '/', '.php'], ['App', '\\', ''], $suffix);

            if (!class_exists($className)) {
                continue;
            }

            $reflexion = new \ReflectionClass($className);
            $interfaces = $reflexion->getInterfaceNames();

            if (count($interfaces) !== 1) {
                $servicesDefinitions[$className] = new ServiceDefinition($className);
            } elseif (array_key_exists($interfaces[0], $servicesDefinitions)) {
                /** @var ServiceDefinition $removedService */
                if (null !== $removedService = $servicesDefinitions[$interfaces[0]]) {
                    $servicesDefinitions[$removedService->className] = new ServiceDefinition($removedService->className);
                    $servicesDefinitions[$interfaces[0]] = null;
                }

                $servicesDefinitions[$className] = new ServiceDefinition($className);
            } else {
                $servicesDefinitions[$interfaces[0]] = new ServiceDefinition($className);
            }
        }
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
