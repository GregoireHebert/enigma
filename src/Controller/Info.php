<?php

declare(strict_types=1);

namespace src\Controller;

use src\Router\Router;

class Info
{
    public function __construct(private Router $router)
    {
    }

    public function display()
    {
        $routeHome = $this->router->getPath('accueil');
        $routeInfo = $this->router->getPath('info');

        echo <<<HTML
<html>
    <head>
        <title>Mon super site</title>    
    </head>
    <body>
        <h1>Mon super site !</h1>
        <p>
            Welcome :)
        </p>
        <p>
            <a href="$routeHome">Home</a>
            <a href="$routeInfo">Info</a>
        </p>
    </body>
</html>
HTML;
    }
}
