<?php

declare(strict_types=1);

namespace App\Core\Events;

final class ControllerEvent
{
    public function __construct(
        private $controller
    )
    {
    }

    public function getController(): callable
    {
        return $this->controller;
    }

    public function setController(callable $controller): void
    {
        $this->controller = $controller;
    }
}
