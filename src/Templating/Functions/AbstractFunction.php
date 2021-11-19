<?php

declare(strict_types=1);

namespace src\Templating\Functions;

use src\Templating\RenderFunction;

abstract class AbstractFunction implements RenderFunction
{
    protected ?RenderFunction $next = null;

    public function setNext(RenderFunction $renderFunction): void
    {
        $this->next = $renderFunction;
    }

    public abstract function apply(string &$content, array $context): ?RenderFunction;
}
