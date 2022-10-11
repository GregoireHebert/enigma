<?php

declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\Http\Request;
use App\Security\Security;

class AddProduct
{
    public function __invoke(Request $request)
    {
        $security = new Security();
        $security->hasRole('ROLE_ADMIN');

        // TODO recuperation des donnees
        // TODO mapping avec une factory
        // TODO validation donnees
        // TODO sauvegarde
        // TODO seria
    }
}
