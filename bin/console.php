<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

// ex : php bin/console.php InitDb
$commandName = $argv[1] ?? null;

if ($commandName === null) {
    throw new RuntimeException('Command mame missing');
}

$commandClass = 'App\\Command\\'.$commandName;
$command = new $commandClass;

$command->execute();
