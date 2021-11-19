<?php

declare(strict_types=1);

namespace src\Templating;

interface RenderFunction
{
    public function setNext(RenderFunction $renderFunction): void;
    public function apply(string &$content, array $context): ?RenderFunction;
}
