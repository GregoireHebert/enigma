<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Statuts;
use App\Form\CreateProductType;
use App\Form\CreateStatutsType;
use App\Voters\ProductResponsibilityVoter;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

/**
 * @Route(path="statuts/{id}/update", methods={"GET", "POST"}, name="statuts_update")
 * @Security("is_granted('ROLE_MANAGER')")
 */
class UpdateStatut extends AbstractController
{
    public function __invoke(RouterInterface $router, Request $request, Statuts $statut, Environment $twig, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager)
    {
        $this->denyAccessUnlessGranted(ProductResponsibilityVoter::VOTER_ATTRIBUTE, $statut, 'Vous ne pouvez pas modifier ce statut.');

        $form = $formFactory->create(CreateStatutsType::class, $statut);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return new RedirectResponse($router->generate('statuts_list'));
        }

        return new Response($twig->render('updateStatut.html.twig', [
            'form' => $form->createView()
        ]));
    }
}
