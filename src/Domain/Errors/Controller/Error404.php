<?php

declare(strict_types=1);

namespace App\Domain\Errors\Controller;

class Error404
{
    public function __invoke()
    {
        return 'Error 404 ! la page demandée n\'existe pas';
    }
}
