<?php

declare(strict_types=1);

namespace App\Infra\Http;

use App\Domain\HelloWorld\EventListeners\RequestEventListener;
use App\Infra\DependencyInjection\Container;
use App\Infra\DependencyInjection\ContainerBuilder;
use App\Infra\EventDispatcher\EventDispatcher;
use App\Infra\EventDispatcher\Events\RequestEvent;
use App\Infra\Routing\Router;

class HttpKernel
{
    private ?Request $request = null;
    private ?Router $router = null;
    private ?EventDispatcher $eventDispatcher = null;
    private ?Container $container = null;
    private bool $booted = false;

    public function handle()
    {
        $this->boot();

        $requestEvent = new RequestEvent($this->request);
        $this->eventDispatcher->dispatch($requestEvent);
        $request = $requestEvent->getRequest();

        if ($request instanceof Response) {
            $request->send();
            exit(1);
        }

        $controller = $this->router->getController($request->getPath());

        $controller = $this->container->get($controller);
        $response = $controller();

        if (!$response instanceof Response) {
            throw new \LogicException('Controller must return a '.Response::class.' object, '.gettype($response).'given.');
        }

        $response->send();
    }

    private function boot()
    {
        if ($this->booted) {
            return;
        }

        $this->request = Request::createFromGlobals();
        $this->router = new Router();

        $this->eventDispatcher = new EventDispatcher();
        $this->eventDispatcher->addListener(new RequestEventListener());

        $this->container = (new ContainerBuilder())->build();
        $this->container->addService(Request::class, $this->request);

        $this->booted = true;
    }
}
