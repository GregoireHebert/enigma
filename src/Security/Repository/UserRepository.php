<?php

declare(strict_types=1);

namespace App\Security\Repository;

use App\Core\Database\Repository;
use App\Security\Model\User;
use App\Security\UserInterface;

class UserRepository extends Repository
{
    public function createTable(): void
    {
        $this->connection->query('CREATE TABLE IF NOT EXISTS `user` (`id` varchar(36), `username` varchar(255), `password` varchar(255), `email` varchar(255), `roles` varchar(255));');
    }

    public function findUserById(string $id): ?UserInterface
    {
        $preparation = $this->connection->prepare('SELECT * FROM `user` WHERE `id` = :id;');
        $preparation->bindParam(':id', $id);
        $preparation->setFetchMode(\PDO::FETCH_ASSOC);
        $preparation->execute();

        if (!is_array($userArray = $preparation->fetch())) {
            return null;
        }

        $userArray['roles'] = json_decode($userArray['roles']);
        return new User(...$userArray);
    }

    public function save(UserInterface $user): void
    {
        $preparation = $this->connection->prepare('
            INSERT INTO `user` VALUES (
                :id, :username, :password, :email, :roles
            )
        ');

        $id = $user->getId();
        $username = $user->getUsername();
        $password = $user->getPassword();
        $email = $user->getEmail();
        $roles = json_encode($user->getRoles());

        $preparation->bindParam(':id', $id);
        $preparation->bindParam(':username', $username);
        $preparation->bindParam(':password', $password);
        $preparation->bindParam(':email', $email);
        $preparation->bindParam(':roles', $roles);

        $preparation->execute();
    }

    public function getUserByUsername(string $username): ?UserInterface
    {
        $preparation = $this->connection->prepare('SELECT * FROM `user` WHERE `username` = :username;');
        $preparation->bindParam(':username', $username);
        $preparation->setFetchMode(\PDO::FETCH_ASSOC);
        $preparation->execute();

        if (!is_array($userArray = $preparation->fetch())) {
            return null;
        }

        $userArray['roles'] = json_decode($userArray['roles']);
        return new User(...$userArray);
    }
}
