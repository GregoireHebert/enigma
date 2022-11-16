<?php

declare(strict_types=1);

namespace App\Account\Controller;

use App\Core\Http\Request;
use App\Security\Events\SecuredController;
use App\Security\Security;

class Me implements SecuredController
{
    public function __invoke(Request $request)
    {
        return (new Security())->getUser();
    }
}
