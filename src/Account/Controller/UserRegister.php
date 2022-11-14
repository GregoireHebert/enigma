<?php

declare(strict_types=1);

namespace App\Account\Controller;

use App\Account\Validator\UserValidator;
use App\Core\Http\Request;
use App\Security\Repository\UserRepository;
use App\Security\UserFactory;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UserRegister
{
    public function __invoke(Request $request): string
    {
        $userFactory = new UserFactory();
        $user = $userFactory->createUserFromRequest($request);

        $validator = new UserValidator();
        $validator->validate($user);

        $user->setPassword(password_hash($user->getPassword(), 'argon2id'));

        $userRepository = new UserRepository();
        $userRepository->save($user);

        http_response_code(201);
        header('Content-Type: application/json');

        $serializer = new Serializer(
            [new ObjectNormalizer()],
            [new JsonEncoder()]
        );

        return $serializer->serialize($user, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['password']]);
    }
}
