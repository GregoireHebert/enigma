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

    public function save(?Cart $cart = null): void
    {
      $this->getEntityManager()->flush($cart);
    }

    public function persistAndSave(?Cart $cart = null): void
    {
      $this->getEntityManager()->persist($cart);
      $this->save($cart);
    }
}
