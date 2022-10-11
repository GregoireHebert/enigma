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
