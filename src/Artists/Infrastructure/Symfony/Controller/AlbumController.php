<?php

namespace App\Artists\Infrastructure\Symfony\Controller;

use App\Artists\Application\Messages\DeleteAlbumCommand;
use App\Artists\Application\Messages\GetAuthArtistAlbumsQuery;
use App\Artists\Application\Messages\ProcessAlbumCommand;
use App\Artists\Application\Messages\GetAlbumQuery;
use App\Artists\Infrastructure\Symfony\Form\AlbumType;
use App\Artists\Infrastructure\Symfony\Helpers\UserHelper;
use App\Artists\Infrastructure\Model\Album;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/albums')]
class AlbumController extends AbstractController
{
    use UserHelper;
    use HandleTrait;

    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    #[Route('/', name: 'app_album_index', methods: ['GET'])]
    public function index(): Response
    {
        $enveloppe = $this->messageBus->dispatch(new GetAuthArtistAlbumsQuery($this->getDomainUser()));
        $stamp = $enveloppe->last(HandledStamp::class);

        return $this->render('album/index.html.twig', [
            'albums' => $stamp->getResult(),
        ]);
    }

    #[Route('/new', name: 'app_album_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ARTIST')]
    public function new(Request $request): Response
    {
        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album, ['user' => $this->getDomainUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->messageBus->dispatch(new ProcessAlbumCommand($album));

            return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('album/new.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_album_show', methods: ['GET'])]
    public function show(string $id): Response
    {
        return $this->render('album/show.html.twig', [
            'album' => $this->query(new GetAlbumQuery($id)),
        ]);
    }

    private function query(GetAlbumQuery $query): Album
    {
        return $this->handle($query);
    }

    #[Route('/{id}/edit', name: 'app_album_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ARTIST')]
    public function edit(Request $request, string $id): Response
    {
        $album = $this->query(new GetAlbumQuery($id));

        $form = $this->createForm(AlbumType::class, $album, ['user' => $this->getDomainUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->messageBus->dispatch(new ProcessAlbumCommand($album));

            return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('album/edit.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_album_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ARTIST')]
    public function delete(string $id): Response
    {
        $this->messageBus->dispatch(new DeleteAlbumCommand($id));

        return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
    }
}
