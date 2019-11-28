<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Statuts;
use App\Form\CreateStatutsType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route(path="/statuts", methods={"POST", "GET"}, name="statuts_create")
 * @Security("is_granted('ROLE_MANAGER')")
 */
class CreateStatuts
{

    public function __invoke(Request $request, Environment $twig, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager)
    {
        $statut = new Statuts();
        $form = $formFactory->create(CreateStatutsType::class, $statut);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $statut = $form->getData();

            $entityManager->persist($statut);
            $entityManager->flush();
        }

        return new Response($twig->render('createMyStatuts.html.twig', [
            'form' => $form->createView()
        ]));
    }
}