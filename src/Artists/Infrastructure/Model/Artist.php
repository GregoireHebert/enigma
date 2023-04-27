<?php

declare(strict_types=1);

namespace App\Artists\Infrastructure\Model;

use App\Customers\Domain\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Artist
{
    private ?string $id = null;

    private ?string $name = null;

    private ?User $user = null;

    /**
     * @var Collection<Song>
     */
    private Collection $songs;

    private Collection $albums;

    public function __construct()
    {
        $this->songs = new ArrayCollection();
        $this->albums = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @param Collection $albums
     */
    public function setAlbums(Collection $albums): void
    {
        $this->albums = $albums;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getSongs(): Collection
    {
        return $this->songs;
    }

    public function setSongs(Collection $songs): void
    {
        $this->songs = $songs;
    }

    public function addSong(Song $song): self
    {
        if (!$this->songs->contains($song)) {
            $this->songs->add($song);
        }

        return $this;
    }

    /**
     * @return Collection<int, Album>
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums->add($album);
            $album->setArtist($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getArtist() === $this) {
                $album->setArtist(null);
            }
        }

        return $this;
    }

    public static function fromDomain(\App\Artists\Domain\Entity\Artist $artist)
    {
        $self = new self();
        $self->setId($artist->getId());
        $self->setName($artist->getName());

        foreach($artist->getSongs() as $song) {
            $self->addSong(Song::fromDomain($song));
        }

        foreach($artist->getAlbums() as $album) {
            $self->addAlbum(Album::fromDomain($album, $self));
        }

        return $self;
    }
}
