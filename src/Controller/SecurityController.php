<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

class SecurityController
{
    /**
     * @Route(path="/login", name="login", methods={"POST", "GET"})
     */
   public function login(AuthenticationUtils $authenticationUtils, Environment $twig): Response
   {
       return new Response($twig->render('security/login.html.twig',
           [
               'last_username' => $authenticationUtils->getLastUsername(),
               // Erreur d'authentification (si elle existe)
               'error' => $authenticationUtils->getLastAuthenticationError(),
           ]
       ));
   }
}
