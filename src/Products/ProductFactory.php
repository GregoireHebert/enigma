<?php

declare(strict_types=1);

namespace App\Products;

use App\Core\Http\Request;
use App\Products\Model\Product;
use Symfony\Component\Uid\Uuid;

class ProductFactory
{
    public function createProductFromRequest(Request $request): Product
    {
        $parameters = $request->getRequests();

        $parameters['id'] = (string) Uuid::v4();
        $parameters['startingPrice'] = (int) ($parameters['startingPrice'] ?? 0);
        $parameters['estimation'] = $this->calculateEstimation($parameters['startingPrice']);

        return new Product(...$parameters);
    }

    /*
     * Return 2/3 of the starting price
     */
    private function calculateEstimation(int $startingPrice): int
    {
        return (int) ceil($startingPrice * 0.66);
    }
}
