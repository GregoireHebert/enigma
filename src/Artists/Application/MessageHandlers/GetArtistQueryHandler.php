<?php

declare(strict_types=1);

namespace App\Artists\Application\MessageHandlers;

use App\Artists\Application\Messages\GetArtistQuery;
use App\Artists\Domain\Repository\ArtistRepository;
use App\Artists\Infrastructure\Model\Artist;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetArtistQueryHandler
{
    public function __construct(private ArtistRepository $repository)
    {
    }

    public function __invoke(GetArtistQuery $artistQuery)
    {
        $domainArtist = $this->repository->find($artistQuery->id);
        dump($artistQuery, $domainArtist);
        return Artist::fromDomain($domainArtist);
    }
}
