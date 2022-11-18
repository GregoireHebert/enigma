<?php

declare(strict_types=1);

namespace App\Account\Controller;

use App\Core\DependencyInjection\Container;
use App\Core\Http\Request;
use App\Security\Events\SecuredController;
use App\Security\Security;

class Me implements SecuredController
{
    public function __invoke(Request $request, Container $container)
    {
        return $container->getService(Security::class)->getUser();
    }
}
