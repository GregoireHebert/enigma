<?php

namespace App\Artists\Infrastructure\Symfony\Controller;

use App\Artists\Application\Messages\GetAlbumQuery;
use App\Artists\Application\Messages\GetArtistQuery;
use App\Artists\Application\Messages\GetAuthArtistAlbumsQuery;
use App\Artists\Domain\Repository\AlbumRepository;
use App\Artists\Infrastructure\Symfony\Helpers\UserHelper;
use App\Customers\Domain\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/artist')]
class ArtistController extends AbstractController
{
    use UserHelper;
    use HandleTrait;

    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    #[Route('/albums', name: 'app_album_artist_index', methods: ['GET'])]
    #[IsGranted('ROLE_ARTIST')]
    public function album(AlbumRepository $albumRepository): Response
    {
        $enveloppe = $this->messageBus->dispatch(new GetAuthArtistAlbumsQuery($this->getDomainUser()));
        $stamp = $enveloppe->last(HandledStamp::class);

        return $this->render('album/index.html.twig', [
            'albums' => $stamp->getResult(),
        ]);
    }

    #[Route('/{id}', name: 'app_artist_show', methods: ['GET'])]
    public function index(string $id): Response
    {
        return $this->render('artist/show.html.twig', [
            'artist' => $this->handle(new GetArtistQuery($id)),
        ]);
    }
}
