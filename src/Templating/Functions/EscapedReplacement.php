<?php

declare(strict_types=1);

namespace src\Templating\Functions;

use src\Templating\RenderFunction;

class EscapedReplacement extends AbstractFunction
{
    public function apply(string &$content, array $context): ?RenderFunction
    {
        foreach ($context as $replacementKey => $replacementValue) {
            $escapedValue = htmlspecialchars($replacementValue, ENT_QUOTES);
            $content = str_replace("{{ $replacementKey }}", $escapedValue, $content);
        }

        return $this->next;
    }
}
