<?php

declare(strict_types=1);

namespace App\Account\Controller;

use App\Core\Http\Request;
use App\Security\Events\SecuredController;
use App\Security\Security;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Me implements SecuredController
{
    public function __invoke(Request $request): string
    {
        $security = new Security();
        $user = $security->getUser();

        http_response_code(200);
        header('Content-Type: application/json');

        $serializer = new Serializer(
            [new ObjectNormalizer()],
            [new JsonEncoder()]
        );

        return $serializer->serialize($user, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['password']]);
    }
}
