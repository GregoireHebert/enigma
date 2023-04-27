<?php

declare(strict_types=1);

namespace App\Artists\Application\Messages;

class GetAlbumQuery
{
    public function __construct(public readonly string $id)
    {
    }
}
