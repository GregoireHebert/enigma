<?php

declare(strict_types=1);

namespace App\Controller;

use App\Database\Connector;
use App\Routing\Routing;
use App\Security\Security;

class Register implements Controller
{
    public function display(?Routing $routing = null)
    {
        Security::denyUnlessLoggedOut($routing);

        if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_FILES['avatar'])) {

            $user = [
                'username' => $_POST['username'],
                'password' => password_hash($_POST['password'], PASSWORD_ARGON2ID)
            ];

            $_POST['password'] = '';

            if (empty($_FILES['avatar']['tmp_name']) || !is_uploaded_file($_FILES['avatar']['tmp_name']) || UPLOAD_ERR_OK !== $_FILES['avatar']['error']) {
                throw new \RuntimeException('impossible de récupérer l\'image');
            }

            $name = uniqid('', true);
            $extension = explode('/', $_FILES['avatar']['type'])[1];

            $target = __DIR__ . '/../../public/upload/' . $name . '.' . $extension;
            if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
                throw new \LogicException('impossible de déplacer le fichier avatar, vérifier les droits');
            }

            $user['avatar'] = $name . '.' . $extension;

            $pdo = Connector::getPdo();

            $preparation = $pdo->prepare('INSERT INTO `inscrits` VALUES (null, :pseudo, :password, :avatar)');
            $preparation->bindParam('pseudo', $user['username']);
            $preparation->bindParam('password', $user['password']);
            $preparation->bindParam('avatar', $user['avatar']);
            $preparation->execute();

            header('location: /'.$routing->getPath('login'));
            return;
        }

        require_once(__DIR__.'/../../templates/register.phtml');
    }
}
