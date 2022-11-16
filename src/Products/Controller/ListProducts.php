<?php

declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\Http\Request;
use App\Products\Repository\ProductRepository;

class ListProducts
{
    public function __invoke(Request $request)
    {
        return (new ProductRepository())->findAll();
    }
}
