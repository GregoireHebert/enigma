<?php

declare(strict_types=1);

namespace src\Database;

class Connector
{
    private static ?\PDO $pdo = null;

    private function __construct()
    {
    }

    public static function getPDO(): \PDO
    {
        if (self::$pdo instanceof \PDO) {
            return self::$pdo;
        }

        $dir = __DIR__.'/../../var/db';
        self::$pdo = new \PDO('sqlite:'.$dir);

        return self::$pdo;
    }
}
