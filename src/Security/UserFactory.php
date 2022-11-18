<?php

declare(strict_types=1);

namespace App\Security;

use App\Core\Http\Request;
use App\Security\Model\User;
use Symfony\Component\Uid\Uuid;

class UserFactory
{
    public function createUserFromRequest(Request $request): UserInterface
    {
        return new User(
            (string) Uuid::v4(),
            $request->getRequest('email', ''),
            $request->getRequest('username', ''),
            $request->getRequest('password', ''),
            ['ROLE_USER']
        );
    }
}
