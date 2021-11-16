<?php

declare(strict_types=1);

namespace App\Controller;

use App\Routing\Routing;
use App\Security\Security;

class Login implements Controller
{
    public function display(?Routing $routing = null)
    {
        Security::denyUnlessLoggedOut($routing);
        require_once(__DIR__.'/../../templates/login.phtml');
    }
}


