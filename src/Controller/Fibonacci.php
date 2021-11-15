<?php

declare(strict_types=1);

namespace App\Controller;

use App\Routing\Routing;
use App\Security\Security;

class Fibonacci implements Controller
{
    private function generateFibonnacci()
    {
        return [1, 1, 3, 5, 8];
    }

    public function display(?Routing $routing = null)
    {
        Security::denyUnlessLoggedIn($routing);

        $error = false;

        if (!empty($_POST['nombre'])) {
            $error = !is_numeric($_POST['nombre']);
        }

        $suite = $error || empty($_POST['nombre']) ? [] : $this->generateFibonnacci($_POST['nombre']);

        require_once(__DIR__.'/../../templates/fibonacci.phtml');
    }
}
