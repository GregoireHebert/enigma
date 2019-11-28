<?php

namespace App\Services;

use App\Entity\Cart;
use App\Entity\State;
use App\Repository\StateRepository;
use Doctrine\ORM\EntityManagerInterface;

class CartStateUpdateService
{
    private $stateRepository;
    private $manager;

    public function __construct(StateRepository $stateRepository, EntityManagerInterface $manager)
    {
        $this->stateRepository = $stateRepository;
        $this->manager = $manager;
    }

    public function updateStateForward(Cart $cart): void
    {
        $cart->setState(
            $this->stateRepository->findByLabel($cart->getNextState())
        );

        $this->manager->persist($cart);
        $this->manager->flush();
    }
}