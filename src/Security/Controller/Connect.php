<?php

declare(strict_types=1);

namespace App\Security\Controller;

use App\Core\Http\Request;
use App\Security\Authentication\Authenticator;
use App\Security\Repository\UserRepository;
use App\Security\UserFactory;
use App\Validator\UserValidator;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
