<?php

declare(strict_types=1);

namespace src\Controller;

interface Controller
{
    /**
     * affiche (echo) le contenu de la page
     */
    public function display(): void;
}
