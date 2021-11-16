<?php

declare(strict_types=1);

namespace App\Security;

use App\Helper\LogTrait;
use App\Routing\Routing;

class Security
{
    use LogTrait;

    public static function denyUnlessLoggedOut(Routing $routing)
    {
        if ($_SESSION['connected'] ?? null) {
            self::info('redirection : déjà connecté');
            header('location: '.$routing->getPath('home'));
            exit(0);
        }
    }

    public static function denyUnlessLoggedIn(Routing $routing)
    {
        if (null === $_SESSION['connected'] ?? null) {
            self::info('redirection : non connecté');
            header('location: '.$routing->getPath('login'));
            exit(0);
        }
    }
}
