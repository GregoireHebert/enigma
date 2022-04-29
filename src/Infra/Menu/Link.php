<?php

declare(strict_types=1);

namespace App\Infra\Menu;

interface Link
{
    public function getLabel(): string;
    public function getPath(): string;
    public function getTarget(): string;
}
