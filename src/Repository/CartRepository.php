<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Cart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    /**
     * @return Cart[]|array
     */
    public function findAll(): array
    {
        return parent::findAll();
    }

    public function updateCart(int $id, string $status)
    {
        $queryBuilder = $this->createQueryBuilder('c');

        return $queryBuilder
            ->update()
            ->set('c.status', '?1')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->setParameter(1, $status)

            ->getQuery()->execute();
    }
}
