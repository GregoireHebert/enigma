<?php

declare(strict_types=1);

namespace App\Artists\Application\MessageHandlers;

use App\Artists\Application\Messages\GetAlbumsQuery;
use App\Artists\Application\Messages\GetAuthArtistAlbumsQuery;
use App\Artists\Domain\Repository\AlbumRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetAlbumsQueryHandler
{
    public function __construct(private AlbumRepository $repository)
    {
    }

    public function __invoke(GetAlbumsQuery $albumsQuery)
    {
        return $this->repository->findAll();
    }
}
