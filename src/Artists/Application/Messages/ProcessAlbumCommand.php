<?php

declare(strict_types=1);

namespace App\Artists\Application\Messages;

use App\Artists\Infrastructure\Model\Album;

class ProcessAlbumCommand
{
    public function __construct(public readonly Album $album)
    {
    }
}
