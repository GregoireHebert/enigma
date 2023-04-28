<?php

namespace App\Artists\Infrastructure\Model;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\HttpFoundation\File\File;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection()
    ]
)]
class Song
{
    #[ApiProperty(identifier: true)]
    private ?int $id = null;

    private ?string $name = null;

    private ?int $duration = null;

    private ?string $filePath = null;

    private ?File $file = null;

    private ?Album $album = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): self
    {
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @param File|null $file
     */
    public function setFile(?File $file): void
    {
        $this->file = $file;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    public static function fromDomain(\App\Artists\Domain\Entity\Song $song, ?Album $album = null)
    {
        $self = new self();
        $self->setId($song->getId());
        $self->setName($song->getName());
        $self->setDuration($song->getDuration());
        $self->setFilePath($song->getFilePath());

        if ($album instanceof Album) {
            $self->setAlbum($album);
        }

        return $self;
    }
}
