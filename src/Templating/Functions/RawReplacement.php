<?php

declare(strict_types=1);

namespace src\Templating\Functions;

use src\Templating\RenderFunction;

class RawReplacement extends AbstractFunction
{
    public function apply(string &$content, array $context): ?RenderFunction
    {
        foreach ($context as $replacementKey => $replacementValue) {
            $content = str_replace("{{ $replacementKey|raw }}", $replacementValue, $content);
        }

        return $this->next;
    }
}
