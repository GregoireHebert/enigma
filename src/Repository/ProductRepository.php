<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Products;
use App\Model\ProductsInterface;

class ProductRepository {
    public function __construct() {

        $this->pdo = new \PDO('sqlite:'.__DIR__.'/../../var/database.sqlite');
        $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $this->pdo->query(<<<SQL
CREATE TABLE IF NOT EXISTS Product (
    id          INTEGER     PRIMARY KEY AUTOINCREMENT,
    name        VARCHAR,
    price       INTEGER,
    categories  VARCHAR,
);
SQL
        );

    }

    public function insert(ProductsInterface $object) {
        $preparation = $this->pdo->prepare('INSERT INTO Product VALUES (null, :name, :price, :category)');
        $preparation->execute([
            ':name' => $object->getName(),
            ':price' => $object->getPrice(),
            ':category' => $object->getCategories(),
        ]);
    }

    public function update(ProductsInterface $object) {

        $preparation = $this->pdo->prepare('UPDATE Product SET :name, :price, :category WHERE id = :id');
        $preparation->execute([
            ':id' => $object->getId(),
            ':name' => $object->setName(),
            ':price' => $object->setPrice(),
            ':category' => implode(',', array_column($object->setCategories(),'id')),
        ]);
    }

    public function delete(ProductsInterface $object) {

        $preparation = $this->pdo->prepare('DELETE FROM Product WHERE id = :id');
        $preparation->execute([
            ':id' => $object->getId(),
        ]);
    }

    public function getAll() {
        $preparation = $this->pdo->query('SELECT * FROM Product');
        return $preparation->fetchAll(\PDO::FETCH_CLASS, Products::class);
    }

    public function getOne(int $id) {
        $preparation = $this->pdo->prepare('SELECT * FROM Product WHERE id = :id');
        $preparation->execute([':id' => $id,]);
        return $preparation->fetchObject(Products::class);
    }
}