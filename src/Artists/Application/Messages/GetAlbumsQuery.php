<?php

declare(strict_types=1);

namespace App\Artists\Application\Messages;

use App\Customers\Domain\Entity\User;

class GetAlbumsQuery
{
    public function __construct(public readonly User $user)
    {
    }
}
