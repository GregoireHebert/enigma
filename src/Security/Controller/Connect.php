<?php

declare(strict_types=1);

namespace App\Security\Controller;

use App\Core\Http\Request;
use App\Security\Authentication\Authenticator;

class Connect
{
    public function __invoke(Request $request): string
    {
        $authenticator = new Authenticator($request);
        $authenticator->authenticate();

        http_response_code(200);
        return '';
    }
}
