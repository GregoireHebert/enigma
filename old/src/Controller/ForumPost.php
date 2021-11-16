<?php

declare(strict_types=1);

namespace App\Controller;

use App\Database\Connector;
use App\Entity\Comment;
use App\Entity\Inscrit;
use App\Entity\Post;
use App\Routing\Routing;
use App\Security\Security;

class ForumPost implements Controller
{
    public function display(?Routing $routing = null)
    {
        $post = $this->getPost((int) $routing->get('id'));
        $post->author = $this->getAuthor($post->sender);

        if (isset($_POST['commentaire']) && !empty($_POST['commentaire'])){
            Security::denyUnlessLoggedIn($routing);

            $pdo = Connector::getPdo();
            $commentaire = $_POST['commentaire'];

            $preparation = $pdo->prepare('INSERT INTO comments VALUES (null, :post, :comment, :sender)');
            $preparation->bindParam('post', $post->id, \PDO::PARAM_INT);
            $preparation->bindParam('comment', $commentaire);
            $preparation->bindParam('sender', $_SESSION['user']->id, \PDO::PARAM_INT);
            $preparation->execute();
        }

        $commentaires = $this->getComments($post);

        require_once (__DIR__.'/../../templates/post.phtml');
    }

    private function getPost(int $id): Post
    {
        $pdo = Connector::getPdo();

        $statement = $pdo->prepare('SELECT * FROM post WHERE id = :id');
        $statement->bindParam('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        $statement->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        return $statement->fetch();
    }

    private function getAuthor(int $id): Inscrit
    {
        $pdo = Connector::getPdo();

        $statement = $pdo->prepare('SELECT * FROM inscrits WHERE id = :id');
        $statement->bindParam('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        $statement->setFetchMode(\PDO::FETCH_CLASS, Inscrit::class);
        return $statement->fetch();
    }

    private function getComments(Post $post): array
    {
        $pdo = Connector::getPdo();

        $statement = $pdo->prepare('SELECT * FROM comments WHERE post = :id');
        $statement->bindParam('id', $post->id, \PDO::PARAM_INT);
        $statement->execute();

        $commentaires =$statement->fetchAll(\PDO::FETCH_CLASS, Comment::class);

        foreach ($commentaires as $commentaire) {
            $commentaire->author = $this->getAuthor($commentaire->sender);
        }

        return $commentaires;
    }
}
