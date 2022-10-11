<?php

declare(strict_types=1);

namespace App\Core\Database;

class ConnectionManager
{
    private static ?\PDO $connection = null;

    public function getConnection(): \PDO
    {
        if (!static::$connection instanceof \PDO) {
            static::$connection = new \PDO(DATABASE_DSN);
        }

        return static::$connection;
    }
}
