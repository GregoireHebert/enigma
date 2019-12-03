<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Client;

class ClientRepository
{
    public function __construct()
    {
        $this->pdo = new \PDO('sqlite:' . __DIR__ . '/../../var/database.sqlite');
        $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $this->pdo->query(<<<SQL
CREATE TABLE IF NOT EXISTS Client (
    id          INTEGER     PRIMARY KEY AUTOINCREMENT,
    nom         VARCHAR,
    adresse     TEXT,
    orders      VARCHAR,
);
SQL
        );
    }

    public function delete(Client $client)
    {
        $result = $this->pdo->prepare('DELETE FROM Client WHERE id = :id');
        $result->execute([
            ':id' => $client->getId(),
        ]);
    }

    public function update(Client $client)
    {
        $result = $this->pdo->prepare('UPDATE Client set nom = :nom, adresse = :adresse, orders = :orders WHERE id = :id');
        $result->execute([
            ':id' => $client->getId(),
            ':nom' => $client->getNom(),
            ':adresse' => $client->getAdresse(),
            ':orders' => implode(',',array_column($client->getOrders(),'id')),
        ]);
    } 
    public function getOne(Client $client): Client 
    {
        $result = $this->pdo->prepare('SELECT * FROM Client WHERE id = :id');
        $result->execute([
            'id' => $client->getId(),
        ]);
        return $result->fetchObject(Client::class);
    }
    public function insert(Client $client)
    {
        $result = $this->pdo->prepare('INSERT INTO client VALUES(null, :nom, :adresse, :orders)');
        $result->execute([
        ':nom' => $client->getNom(),
        ':adresse' => $client->getAdresse(),
        ':orders' => $client->getOrders(),
        ':orders' => implode (',',array_column($client->getSelection(),'id'))
    ]);
}
    public function getAll():Client 
    {
        $result = $this->pdo->prepare('SELECT * FROM Client');
        $result->execute();
        return $result->fetchAll(\PDO::FETCH_CLASS,Client::class);
    }
}
