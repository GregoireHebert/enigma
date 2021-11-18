<?php

declare(strict_types=1);

namespace src\Repository;

use src\Database\Connector;
use src\Entity\Mood;

class MoodRepository
{
    /**
     * @return array<Mood>
     */
    public function fetchAll(): array
    {
        $pdo = Connector::getPDO();

        $statement = $pdo->query('SELECT * FROM `mood`');
        $statement->execute();

        $statement->setFetchMode(\PDO::FETCH_CLASS, Mood::class);
        return $statement->fetchAll();
    }

    public function insert(Mood $mood)
    {
        $pdo = Connector::getPDO();

        $statement = $pdo->prepare('INSERT INTO `mood` VALUES (null, :mood )');
        $statement->bindParam('mood', $mood->mood);
        $statement->execute();
    }

    public function delete($moodId)
    {
        $pdo = Connector::getPDO();

        $statement = $pdo->prepare('DELETE FROM `mood` where id = :mood');
        $statement->bindParam('mood', $moodId);
        $statement->execute();
    }
}
