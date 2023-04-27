<?php

declare(strict_types=1);

namespace App\Artists\Application\MessageHandlers;

use App\Artists\Application\Messages\DeleteAlbumCommand;
use App\Artists\Domain\Repository\AlbumRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteAlbumCommandHandler
{
    public function __construct(private AlbumRepository $repository)
    {
    }

    public function __invoke(DeleteAlbumCommand $deleteAlbumCommand)
    {
        $album = $this->repository->find($deleteAlbumCommand->id);
        $this->repository->remove($album, true);
    }
}
