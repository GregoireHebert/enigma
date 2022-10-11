<?php

declare(strict_types=1);

namespace App\Command;

use App\Security\Repository\UserRepository;

class InitDb
{
    public function execute()
    {
        $userRepository = new UserRepository();
        $userRepository->createTable();
    }
}
