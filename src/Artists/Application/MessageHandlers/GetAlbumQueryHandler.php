<?php

declare(strict_types=1);

namespace App\Artists\Application\MessageHandlers;

use App\Artists\Application\Messages\GetAlbumQuery;
use App\Artists\Domain\Repository\AlbumRepository;
use App\Artists\Infrastructure\Model\Album;
use App\Artists\Infrastructure\Model\Artist;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetAlbumQueryHandler
{
    public function __construct(private AlbumRepository $repository)
    {
    }

    public function __invoke(GetAlbumQuery $albumQuery)
    {
        $domainAlbum = $this->repository->find($albumQuery->id);
        return Album::fromDomain($domainAlbum, Artist::fromDomain($domainAlbum->getArtist()));
    }
}
