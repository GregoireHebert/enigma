<?php

declare(strict_types=1);

namespace App\Database;

use \PDO;

class Connector
{
    public static function getPdo(): PDO
    {
        $pdo = new PDO('sqlite://'.__DIR__.'/../../var/db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
}
