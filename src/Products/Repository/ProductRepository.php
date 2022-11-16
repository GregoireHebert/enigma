<?php

declare(strict_types=1);

namespace App\Products\Repository;

use App\Core\Database\Repository;
use App\Products\Model\Product;
use App\Products\Model\ProductInterface;
use App\Security\Repository\UserRepository;

class ProductRepository extends Repository
{
    public function createTable(): void
    {
        $this->connection->query('CREATE TABLE IF NOT EXISTS `products` (`id` varchar(36) primary key, `name` varchar(255), `description` varchar(255), `starting_price` int(24), `estimation` int(24), `finalPrice` int(24), `end` Text, `winner` varchar(36), FOREIGN KEY(`winner`) REFERENCES `user`(`id`) );');
    }

    /**
     * @return array<ProductInterface>
     */
    public function findAll(): array
    {
        if (false === $prepare = $this->connection->query('SELECT id, name, estimation, finalPrice, description, starting_price as startingPrice, end, winner FROM products')) {
            return [];
        }

        $prepare->setFetchMode(\PDO::FETCH_ASSOC);
        $products = $prepare->fetchAll();

        $userRepository = new UserRepository();

        foreach ($products as &$product) {
            $product['winner'] = $product['winner'] ? $userRepository->findUserById($product['winner']) : null;
            $product['end'] = $product['end'] ? new \DateTimeImmutable($product['end']) : null;

            $product = new Product(...$product);
        }

        return $products;
    }

    public function findOneById(string $id): ?ProductInterface
    {
        $prepare = $this->connection->prepare('SELECT id, name, estimation, description, starting_price as startingPrice, finalPrice, end, winner FROM products WHERE id = :id');
        $prepare->bindParam(':id', $id);
        $prepare->setFetchMode(\PDO::FETCH_ASSOC);
        $prepare->execute();

        if (false === $product = $prepare->fetch()) {
            return null;
        }

        $userRepository = new UserRepository();

        $product['winner'] = $product['winner'] ? $userRepository->findUserById($product['winner']) : null;
        $product['end'] = $product['end'] ? new \DateTimeImmutable($product['end']) : null;

        return new Product(...$product);
    }

    public function remove(ProductInterface $product): void
    {
        $preparation = $this->connection->prepare(<<<SQL
DELETE FROM products WHERE id = :id;
SQL);

        $id = $product->getId();
        $preparation->bindParam(':id', $id);

        $preparation->execute();
    }

    public function save(ProductInterface $product): void
    {
        $preparation = $this->connection->prepare(<<<SQL
INSERT OR REPLACE INTO products (id, name, description, starting_price, estimation, finalPrice, end, winner) 
    VALUES (:id, :name, :description, :starting_price, :estimation, :finalPrice, :end, :winner);
SQL);

        $id = $product->getId();
        $name = $product->getName();
        $description = $product->getDescription();
        $starting_price = $product->getStartingPrice();
        $estimation = $product->getEstimation();
        $finalPrice = $product->getFinalPrice();
        $end = $product->getEnd()->format('Y-m-dTH:i:s');
        $winner = $product->getWinner()?->getId();

        $preparation->bindParam(':id', $id);
        $preparation->bindParam(':name', $name);
        $preparation->bindParam(':description', $description);
        $preparation->bindParam(':starting_price', $starting_price);
        $preparation->bindParam(':estimation', $estimation);
        $preparation->bindParam(':finalPrice', $finalPrice);
        $preparation->bindParam(':end', $end);
        $preparation->bindParam(':winner', $winner);

        $preparation->execute();
    }

    /**
     * @return array<Product>
     */
    public function getFinishedBids(): array
    {
        if (false === $statement = $this->connection->query('SELECT id, name, estimation, description, starting_price as startingPrice, end, winner, finalPrice FROM products WHERE end < date("now") AND winner is null')) {
            syslog(LOG_CRIT, 'SQL failure for "SELECT id, name, estimation, description, starting_price as startingPrice, end, winner, finalPrice FROM products WHERE end < date(\'now\') AND winner is null"');
            return [];
        }

        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        $products = $statement->fetchAll();

        foreach ($products as &$product) {
            $product['end'] = $product['end'] ? new \DateTimeImmutable($product['end']) : null;

            $product = new Product(...$product);
        }

        return $products;
    }
}
