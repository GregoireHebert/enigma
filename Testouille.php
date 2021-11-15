<?php

declare(strict_types=1);


class Testouille
{
    private string $name;

    public function __construct($name)
    {
        $this->name = $name;
        echo 'construit' . PHP_EOL;
    }

    public function __get(string $propertyName)
    {
        return $this->{$propertyName};
    }
}

$testouille = new Testouille('ff');
echo $testouille->name;
