<?php

declare(strict_types=1);

namespace App\Controller;

use App\Routing\Routing;
use App\Security\Security;

class Logout implements Controller
{
    public function display(?Routing $routing = null)
    {
        Security::denyUnlessLoggedIn($routing);

        session_destroy();
        header('location: '.$routing?->getPath('home'));
    }
}
