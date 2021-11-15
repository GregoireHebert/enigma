<?php

declare(strict_types=1);

namespace App\Controller;

use App\Database\Connector;
use App\Entity\Post;
use App\Routing\Routing;
use App\Security\Security;

class ForumNew implements Controller
{
    public function display(?Routing $routing = null
    ) {
        Security::denyUnlessLoggedIn($routing);

        if (isset($_POST['texte']) && !empty($_POST['texte'])){
            $pdo = Connector::getPdo();
            $texte = $_POST['texte'];

            $preparation = $pdo->prepare('INSERT INTO post VALUES (null, :author, :texte, :sujet)');
            $preparation->bindParam('texte', $_POST['texte']);
            $preparation->bindParam('sujet', $_POST['sujet']);
            $preparation->bindParam('author', $_SESSION['user']->id, \PDO::PARAM_INT);
            $preparation->execute();

            header('location: '.$routing->getPath('post').'?id='.$pdo->lastInsertId());
        }

        require_once (__DIR__.'/../../templates/newPost.phtml');
    }
}
