<?php

declare(strict_types=1);

namespace App\Products\Repository;

use App\Core\Database\Repository;
use App\Products\Model\Product;

class ProductRepository extends Repository
{
    public function createTable(): void
    {
        $this->connection->query('CREATE TABLE IF NOT EXISTS `products` (`id` varchar(36) primary key, `name` varchar(255), `description` varchar(255), `starting_price` int(24), `estimation` int(24));');
    }

    /**
     * @return array<Product>
     */
    public function findAll(): array
    {
        $prepare = $this->connection->query('SELECT id, name, estimation, description, starting_price as startingPrice FROM products');
        $prepare->setFetchMode(\PDO::FETCH_ASSOC);
        $products = $prepare->fetchAll();

        foreach ($products as &$product) {
            $product = new Product(...$product);
        }

        return $products;
    }

    public function findOneById(string $id): ?Product
    {
        $prepare = $this->connection->prepare('SELECT id, name, estimation, description, starting_price as startingPrice FROM products WHERE id = :id');
        $prepare->bindParam(':id', $id);
        $prepare->setFetchMode(\PDO::FETCH_ASSOC);
        $prepare->execute();

        if (false === $product = $prepare->fetch()) {
            return null;
        }

        return new Product(...$product);
    }

    public function remove(Product $product): void
    {
        $preparation = $this->connection->prepare(<<<SQL
DELETE FROM products WHERE id = :id;
SQL);

        $id = $product->id;
        $preparation->bindParam(':id', $id);

        $preparation->execute();
    }

    public function save(Product $product): void
    {
        $preparation = $this->connection->prepare(<<<SQL
INSERT OR REPLACE INTO products (id, name, description, starting_price, estimation) VALUES (:id, :name, :description, :starting_price, :estimation);
SQL);

        $id = $product->id;
        $name = $product->getName();
        $description = $product->getDescription();
        $starting_price = $product->getStartingPrice();
        $estimation = $product->getEstimation();

        $preparation->bindParam(':id', $id);
        $preparation->bindParam(':name', $name);
        $preparation->bindParam(':description', $description);
        $preparation->bindParam(':starting_price', $starting_price);
        $preparation->bindParam(':estimation', $estimation);

        $preparation->execute();
    }
}
