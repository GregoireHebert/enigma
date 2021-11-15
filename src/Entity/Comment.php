<?php

declare(strict_types=1);

namespace App\Entity;

class Comment
{
    public int $sender;
    public int $post;
    public string $message;
    public Inscrit $author;
}
