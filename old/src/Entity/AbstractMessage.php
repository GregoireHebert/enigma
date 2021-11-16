<?php

declare(strict_types=1);

namespace App\Entity;

abstract class AbstractMessage
{
    public string $pseudo = '';

    public string $avatar = '';

    public string $message = '';

    public ?int $id = null;

    public function hydrate(string $pseudo, string $message, string $avatar, int $id): self
    {
        $this->pseudo = $pseudo;
        $this->message = $message;
        $this->avatar = $avatar;
        $this->id = $id;

        return $this;
    }
}
