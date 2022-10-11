<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Http\Request;
use App\Security\Authentication\Authenticator;
use App\Security\Exception\AuthenticationException;
use App\Security\Repository\UserRepository;
use App\Security\Security;
use App\Security\UserFactory;
use App\Validator\UserValidator;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Me
{
    public function __invoke(Request $request): string
    {
        $security = new Security();
        if (null === $user = $security->getUser()) {
            throw new AuthenticationException();
        }

        http_response_code(200);
        header('Content-Type: application/json');

        $serializer = new Serializer(
            [new ObjectNormalizer()],
            [new JsonEncoder()]
        );

        return $serializer->serialize($user, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['password']]);
    }
}
