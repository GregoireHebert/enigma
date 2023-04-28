<?php

declare(strict_types=1);

namespace App\Artists\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Artists\Application\Messages\GetAlbumQuery;
use App\Artists\Application\Messages\GetAlbumsQuery;
use App\Artists\Domain\Entity\Album;
use App\Artists\Infrastructure\Model\Artist;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class AlbumProvider implements ProviderInterface
{
    use HandleTrait;

    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof Get) {
            return $this->handle(new GetAlbumQuery($uriVariables['id']));
        }

        if ($operation instanceof GetCollection) {
            return array_map(
                static function (Album $album) {
                    $artist = Artist::fromDomain($album->getArtist());
                    return \App\Artists\Infrastructure\Model\Album::fromDomain($album, $artist);
                },
                $this->handle(new GetAlbumsQuery())
            );
        }

        throw new \LogicException("Wrong configuration.");
    }
}
