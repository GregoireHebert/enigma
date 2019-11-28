<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Status;
use App\Repository\CartRepository;
use App\Repository\StatusRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route(path="carts", name="carts", methods={"GET"})
 */
class ListCartsController
{

    public function __invoke(Environment $twig, CartRepository $cartRepository, StatusRepository $statusRepository)
    {

        //var_dump($statusRepository->findAll());

        return new Response($twig->render('cartList.html.twig', [
            'carts' => $cartRepository->findAll()
            //'status' => $statusRepository->findId()
        ]));
    }
}
