<?php

namespace App\Artists\Infrastructure\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\UuidV4;

class Album
{
    private ?string $id = null;

    private ?string $name = null;

    private ?Artist $artist = null;

    private Collection $songs;

    public function __construct()
    {
        $this->songs = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
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

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * @return Collection<int, Song>
     */
    public function getSongs(): Collection
    {
        return $this->songs;
    }

    public function addSong(Song $song): self
    {
        if (!$this->songs->contains($song)) {
            $this->songs->add($song);
            $song->setAlbum($this);
        }

        return $this;
    }

    public function removeSong(Song $song): self
    {
        if ($this->songs->removeElement($song)) {
            // set the owning side to null (unless already changed)
            if ($song->getAlbum() === $this) {
                $song->setAlbum(null);
            }
        }

        return $this;
    }

    /**
     * @param string|null $id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * @param Collection<Song> $songs
     */
    public function setSongs(Collection $songs): void
    {
        $this->songs = $songs;
    }

    public static function fromDomain(\App\Artists\Domain\Entity\Album $album, Artist $artist)
    {
        $self = new self();
        $self->setId($album->getId());
        $self->setName($album->getName());
        $self->setArtist($artist);

        foreach($album->getSongs() as $song) {
            $self->addSong(Song::fromDomain($song, $self));
        }

        return $self;
    }
}
