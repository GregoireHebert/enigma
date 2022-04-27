<?php

declare(strict_types=1);

namespace App\Infra\Blog\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[Route(path: '/', name: 'home')]
class Home /* extends AbstractController */
{
    public function __invoke(Environment $twig)
    {
        return new Response($twig->render('blog/home.html.twig'));
    }
}
