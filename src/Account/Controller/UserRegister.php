<?php

declare(strict_types=1);

namespace App\Account\Controller;

use App\Account\Validator\UserValidator;
use App\Core\DependencyInjection\Container;
use App\Core\Http\Request;
use App\Core\Logger\Logger;
use App\Core\Logger\LoggerInterface;
use App\Security\Repository\UserRepository;
use App\Security\UserFactory;

class UserRegister
{
    public function __invoke(Request $request, Container $container)
    {
        $userFactory = $container->getService(UserFactory::class);
        $user = $userFactory->createUserFromRequest($request);

        $validator = $container->getService(UserValidator::class);
        $validator->validate($user);

        $user->setPassword(password_hash($user->getPassword(), 'argon2id'));

        $userRepository = $container->getService(UserRepository::class);
        $userRepository->save($user);

        $logger = $container->getService(LoggerInterface::class);
        $logger->debug('User created successfully.');

        return $user;
    }
}
