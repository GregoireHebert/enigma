<?php

declare(strict_types=1);

namespace App\Bid\Repository;

use App\Bid\Model\Bid;
use App\Bid\Model\BidInterface;
use App\Bid\Model\NullBid;
use App\Bid\Model\Winner;
use App\Core\Database\Repository;
use App\Products\Model\ProductInterface;
use App\Products\Repository\ProductRepository;
use App\Security\Repository\UserRepository;

class BidRepository extends Repository
{
    public function createTable(): void
    {
        $this->connection->query('
            CREATE TABLE IF NOT EXISTS `bids` (
                `id` varchar(36) primary key, 
                `product` varchar(36), 
                `user` varchar(36), 
                `amount` int(24), 
                `datetime` text,
                FOREIGN KEY(`product`) REFERENCES `products`(`id`),
                FOREIGN KEY(`user`) REFERENCES `user`(`id`)
            );   
        ');
    }

    public function getHighestBidForProduct(ProductInterface $product): BidInterface
    {
        $id = $product->getId();

        $prepare = $this->connection->prepare('SELECT * FROM bids WHERE product = :product ORDER BY amount DESC LIMIT 1;');
        $prepare->bindParam(':product', $id);
        $prepare->execute();
        $prepare->setFetchMode(\PDO::FETCH_ASSOC);

        $productRepository = new ProductRepository();
        $userRepository = new UserRepository();

        $bidValues = $prepare->fetch();

        if ($bidValues) {
            $bidValues['user'] = $userRepository->findUserById($bidValues['user']);
            $bidValues['datetime'] = new \DateTimeImmutable($bidValues['datetime']);
            $bidValues['product'] = $productRepository->findOneById($bidValues['product']);

            return new Bid(...$bidValues);
        }

        return new NullBid();
    }

    public function save(BidInterface $bid): void
    {
        $preparation = $this->connection->prepare(<<<SQL
INSERT INTO bids (id, user, product, amount, datetime) VALUES (:id, :user, :product, :amount, :datetime);
SQL);

        $id = $bid->getId();
        $user = $bid->getUser()->getId();
        $product = $bid->getProduct()->getId();
        $amount = $bid->getAmount();
        $dateTime = $bid->getDateTime()->format('Y-m-dTH:i:s');

        $preparation->bindParam(':id', $id);
        $preparation->bindParam(':user', $user);
        $preparation->bindParam(':product', $product);
        $preparation->bindParam(':amount', $amount);
        $preparation->bindParam(':datetime', $dateTime);

        $preparation->execute();
    }

    public function getWinner(ProductInterface $product): ?Winner
    {
        $id = $product->getId();

        $prepare = $this->connection->prepare('SELECT * FROM bids WHERE product = :product ORDER BY amount DESC LIMIT 2;');
        $prepare->bindParam(':product', $id);
        $prepare->execute();
        $prepare->setFetchMode(\PDO::FETCH_ASSOC);

        $productRepository = new ProductRepository();
        $userRepository = new UserRepository();

        $bidsValues = $prepare->fetchAll();

        if (count($bidsValues) !== 2) {
            return null;
        }

        foreach ($bidsValues as &$bidValues) {
            $bidValues['user'] = $userRepository->findUserById($bidValues['user']);
            $bidValues['datetime'] = new \DateTimeImmutable($bidValues['datetime']);
            $bidValues['product'] = $productRepository->findOneById($bidValues['product']);

            $bidValues = new Bid(...$bidValues);
        }

        return new Winner($bidsValues[0]->getUser(), $bidsValues[1]->getAmount());
    }
}
