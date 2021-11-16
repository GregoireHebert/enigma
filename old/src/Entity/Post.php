<?php

declare(strict_types=1);

namespace App\Entity;

class Post extends AbstractMessage
{
    public string $sujet;
    public int $sender;
    public Inscrit $author;
}
