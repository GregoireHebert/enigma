<?php

declare(strict_types=1);

namespace App\Command;

use App\Products\Repository\ProductRepository;
use App\Security\Repository\UserRepository;

class InitDb
{
    public function execute(): void
    {
        $userRepository = new UserRepository();
        $userRepository->createTable();

        $productRepository = new ProductRepository();
        $productRepository->createTable();

        exit (0);
    }
}
