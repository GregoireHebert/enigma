<?php

declare(strict_types=1);

namespace App\Infra\Http;

class Response
{
    public function __construct(private string $content)
    {
    }

    public function send(): void
    {
        echo $this->content;
    }
}
