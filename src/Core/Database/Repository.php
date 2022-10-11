<?php

declare(strict_types=1);

namespace App\Core\Database;

class Repository
{
    protected \PDO $connection;

    public function __construct()
    {
        $this->connection = (new ConnectionManager())->getConnection();
    }
}
