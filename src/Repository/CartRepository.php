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
   /* public function getCart(int $id) {
        $queryBuilder = $this->createQueryBuilder('c');
        return $queryBuilder->select('c')
            ->join('')
            ->where('c.cart_status_id = : someId')
            ->setParameter('someId',$id)->getQuery();
    }*/
}
