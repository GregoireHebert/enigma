<?php

declare(strict_types=1);

namespace App\Bid\Model;

use App\Security\UserInterface;

final class Winner
{
    public function __construct(public readonly UserInterface $winner, public readonly int $amount)
    {
    }
}
