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

    public function findByState(string $stateLabel) {
        return $this
            ->createQueryBuilder('c')
            ->join('c.state', 's')
            ->where('s.label = :label')
            ->setParameter('label', $stateLabel)
            ->getQuery()
            ->getResult()
        ;
    }
}
