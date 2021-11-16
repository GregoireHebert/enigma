<?php

declare(strict_types=1);

namespace App\Entity;

class Message extends AbstractMessage
{
    public int $date;

    public function getDate(): \DateTime
    {
        return new \DateTime("@$this->date");
    }

    public function hydrate(string $pseudo, string $message, string $avatar, int $id, int $timestamp = 0): self
    {
        $this->date = $timestamp;
        return parent::hydrate($pseudo, $message, $avatar, $id);
    }
}
