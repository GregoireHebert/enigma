<?php

namespace App\Artists\Infrastructure\Model;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Artists\Infrastructure\ApiPlatform\State\Provider\AlbumProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'album',
    operations: [
        new Get(),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['Album:Read']],
    provider: AlbumProvider::class
)]
class Album
{
    #[ApiProperty(identifier: true)]
    private ?string $id = null;

    #[Groups('Album:Read')]
    private ?string $name = null;

    #[Groups('Album:Read')]
    private ?Artist $artist = null;

    #[Groups('Album:Read')]
    private Collection $songs;

    public function __construct()
    {
        $this->songs = new ArrayCollection();
    }

    public function getId(): ?string
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
