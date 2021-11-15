<?php

declare(strict_types=1);

namespace App\Controller;

use App\Routing\Routing;

class Home implements Controller
{
    public function display(?Routing $routing = null)
    {
        require_once(__DIR__.'/../../templates/home.phtml');
    }
}
