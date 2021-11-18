<?php

declare(strict_types=1);

require_once ('src/Database/Connector.php');

$pdo = \src\Database\Connector::getPDO();

$pdo->query('
    CREATE TABLE IF NOT EXISTS `mood` (
        `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        `mood` VARCHAR NOT NULL
    );
')->execute();

$pdo->query('
    CREATE TABLE IF NOT EXISTS `messages` (
        `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        `author` VARCHAR NOT NULL,
        `message` VARCHAR NOT NULL
    );
')->execute();
