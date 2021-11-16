<?php

declare(strict_types=1);

namespace App\Controller;

use App\Database\Connector;
use App\Entity\Inscrit;
use App\Routing\Routing;
use App\Security\Security;

class LoginCheck implements Controller
{
    public function display(?Routing $routing = null)
    {
        Security::denyUnlessLoggedOut($routing);

        $_SESSION['last_username'] = $_POST['username'] ?? null;

        if (!empty($_POST['username'])) {
            $pdo = Connector::getPdo();

            $preparation = $pdo->prepare('select `id`, `pseudo`, `password`, `avatar` from `inscrits` where `pseudo` = :pseudo');
            $preparation->bindParam('pseudo', $_POST['username']);
            $preparation->execute();

            $preparation->setFetchMode(\PDO::FETCH_CLASS, Inscrit::class);
            $user = $preparation->fetch();

            if ($user !== false && password_verify($_POST['password'], $user->password)) {
                $_SESSION['connected'] = true;
                $_SESSION['user'] = $user;

                header('location: '.$routing?->getPath('home'));
                return;
            }
        }

        header('location: /'.$routing?->getPath('login').'?error=true');
    }
}
