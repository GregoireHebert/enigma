<?php

declare(strict_types=1);

namespace App\Artists\Domain\Entity;

use App\Artists\Domain\Repository\ArtistRepository;
use App\Customers\Domain\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Uid\UuidV4;

#[Entity(repositoryClass: ArtistRepository::class)]
class Artist
{
    #[Id, Column(type: 'string')]
    private string $id;

    #[Column]
    private ?string $name = null;

    #[ManyToOne(targetEntity: User::class, inversedBy: 'artists')]
    private ?User $user = null;

    /**
     * @var Collection<Song>
     */
    private ?Collection $songs = null;

    #[OneToMany(mappedBy: 'artist', targetEntity: Album::class, orphanRemoval: true)]
    private ?Collection $albums = null;

    public function __construct()
    {
        $this->id = (string) (new UuidV4());
        $this->songs = new ArrayCollection();
        $this->albums = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
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

    /**
     * @return Collection<Song>
     */
    public function getSongs(): Collection
    {
        return $this->songs ?? new ArrayCollection();
    }

    public function setSongs(Collection $songs): void
    {
        $this->songs = $songs;
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
}