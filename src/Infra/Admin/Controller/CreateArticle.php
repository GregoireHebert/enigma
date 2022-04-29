<?php

declare(strict_types=1);

namespace App\Infra\Admin\Controller;

use App\Domain\Blog\Entity\Article;
use App\Domain\Blog\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[Route(path: '/admin/articles')]
class CreateArticle extends AbstractController
{
    public function __construct(private Environment $twig, private RequestStack $requestStack, private ArticleRepository $articleRepository)
    {
    }

    #[Route(path: '/create', name: 'article_create')]
    public function create()
    {
        $article = new Article();

        $formBuilder = $this->createFormBuilder($article);
        $formBuilder
            ->add('titre', TextType::class)
            ->add('auteur', TextType::class)
            ->add('contenu', TextareaType::class)
            ->add('creer', SubmitType::class, ['label' => 'créer']);

        $form = $formBuilder->getForm();

        $request = $this->requestStack->getCurrentRequest();
        $form->handleRequest($request);

        // déclenche l'enregistrement
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $this->articleRepository->persist($article);
            $this->articleRepository->flush();
        }

        $formView = $form->createView();

        return new Response($this->twig->render('Admin/create.html.twig', ['form' => $formView]));
    }
}
