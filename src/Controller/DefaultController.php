<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class DefaultController
{
    public function __invoke(AuthorizationCheckerInterface $authorizationChecker, TokenStorageInterface $tokenStorage): Response
    {
        if ($authorizationChecker->isGranted(
                'firstLetter',
                $user = $tokenStorage->getToken()->getUser()
            )
        ) {
            return new Response("Hello $user!");
        }

        return new Response('Vous n\'avez pas accès à cette page.');
    }
}
