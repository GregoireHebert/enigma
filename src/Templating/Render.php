<?php

declare(strict_types=1);

namespace src\Templating;

use src\Templating\Functions\EscapedReplacement;
use src\Templating\Functions\Path;
use src\Templating\Functions\RawReplacement;

class Render
{
    private ?RenderFunction $function = null;

    public function __construct()
    {
        $this->function = new RawReplacement();

        $pathFunction = new Path();

        $escapedReplacement = new EscapedReplacement();
        $escapedReplacement->setNext($pathFunction);

        $this->function->setNext($escapedReplacement);
    }

    public function render(string $template, array $context = [])
    {
        $path = __DIR__.'/../../templates/'.$template.'.phtml';
        if (!file_exists($path)) {
            throw new \LogicException("template '$path' not found");
        }

        $content = file_get_contents($path);

        $function = $this->function;
        while ($function instanceof RenderFunction) {
            $function = $function->apply(content: $content, context: $context);
        }

        return $content;
    }
}
