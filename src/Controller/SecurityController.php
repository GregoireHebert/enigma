<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route(name="login", path="/login", methods={"GET", "POST"})
 */
class SecurityController extends AbstractController
{
    public function __invoke(AuthenticationUtils $authenticationUtils)
    {
        return $this->render('security/login.html.twig', [
            // Nom d'utilisateur entré (si il existe)
            'last_username' => $authenticationUtils->getLastUsername(),
            // Erreur d'authentification (si elle existe)
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }
}
