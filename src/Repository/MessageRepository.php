<?php

declare(strict_types=1);

namespace src\Repository;

use src\Database\Connector;
use src\Entity\Message;

class MessageRepository
{
    /**
     * @return array<Message>
     */
    public function fetchAll(): array
    {
        $pdo = Connector::getPDO();

        $statement = $pdo->query('SELECT * FROM `messages`');
        $statement->execute();

        $statement->setFetchMode(\PDO::FETCH_CLASS, Message::class);
        return $statement->fetchAll();
    }

    public function insert(Message $mood)
    {
        $pdo = Connector::getPDO();

        $statement = $pdo->prepare('INSERT INTO `messages` VALUES (null, :author, :message)');
        $statement->bindParam('message', $mood->message);
        $statement->bindParam('author', $mood->author);
        $statement->execute();
    }
}
