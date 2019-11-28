<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Statuts;
use App\Repository\StatutRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route(path="/statuts/list", name="statuts_list", methods={"GET"})
 */
class ListStatuts
{
    public function __invoke(Environment $twig, StatutRepository $statutRepository)
    {
        $statuts = $statutRepository->findAll();

        return new Response($twig->render('listStatuts.html.twig', [
            'statuts' => $statuts
        ]));
    }
}
