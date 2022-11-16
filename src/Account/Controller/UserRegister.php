<?php

declare(strict_types=1);

namespace App\Account\Controller;

use App\Account\Validator\UserValidator;
use App\Core\Http\Request;
use App\Security\Repository\UserRepository;
use App\Security\UserFactory;

class UserRegister
{
    public function __invoke(Request $request)
    {
        $userFactory = new UserFactory();
        $user = $userFactory->createUserFromRequest($request);

        $validator = new UserValidator();
        $validator->validate($user);

        $user->setPassword(password_hash($user->getPassword(), 'argon2id'));

        $userRepository = new UserRepository();
        $userRepository->save($user);

        return $user;
    }
}
