<?php

declare(strict_types=1);

namespace App\Security\Controller;

use App\Core\Http\Request;
use App\Security\Security;

class Disconnect
{
    public function __invoke(Request $request): string
    {
        // TODO handle CSRF attack
        $security = new Security();
        $security->removeUser();

        http_response_code(200);
        return '';
    }
}
