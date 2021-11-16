<?php

declare(strict_types=1);

namespace src\Templating;

class Render
{
    public function render(string $template, array $context = [])
    {
        $path = __DIR__.'/../../templates/'.$template.'.phtml';
        if (!file_exists($path)) {
            throw new \LogicException("template '$path' not found");
        }

        $content = file_get_contents($path);

        foreach ($context as $replacementKey => $replacementValue) {
            $escapedValue = htmlspecialchars($replacementValue, ENT_QUOTES);
            $content = str_replace("{{ $replacementKey|raw }}", $replacementValue, $content);
            $content = str_replace("{{ $replacementKey }}", $escapedValue, $content);
        }

        return $content;
    }
}
