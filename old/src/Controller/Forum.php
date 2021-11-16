<?php

declare(strict_types=1);

namespace App\Controller;

use App\Database\Connector;
use App\Entity\Post;
use App\Routing\Routing;
use App\Security\Security;

class Forum implements Controller
{
    public function display(?Routing $routing = null
    ) {
        $pdo = Connector::getPdo();

        $statement = $pdo->query('SELECT * FROM post');
        $statement->execute();

        $posts = $statement->fetchAll(\PDO::FETCH_CLASS, Post::class);

        require_once (__DIR__.'/../../templates/forum.phtml');
    }
}
