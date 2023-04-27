<?php

declare(strict_types=1);

namespace App\Artists\Application\MessageHandlers;

use App\Artists\Application\Messages\ProcessAlbumCommand;
use App\Artists\Domain\Entity\Album;
use App\Artists\Domain\Repository\AlbumRepository;
use App\Artists\Domain\Repository\ArtistRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ProcessAlbumCommandHandler
{
    public function __construct(private AlbumRepository $albumRepository, private ArtistRepository $artistRepository)
    {
    }

    public function __invoke(ProcessAlbumCommand $createAlbumCommand)
    {
        if ($createAlbumCommand->album->getId() !== null) {
            $album = $this->albumRepository->find($createAlbumCommand->album->getId());
        } else {
            $album = new Album();
        }

        $album->setName($createAlbumCommand->album->getName());
        $album->setArtist($this->artistRepository->find($createAlbumCommand->album->getArtist()?->getId()));

        $this->albumRepository->save($album, true);
    }
}
