<?php

declare(strict_types=1);

namespace App\Products;

use App\Core\Http\Request;
use App\Products\Model\Product;
use App\Products\Model\ProductInterface;
use Symfony\Component\Uid\Uuid;

class ProductFactory
{
    public function createProductFromRequest(Request $request): ProductInterface
    {
        $parameters = $request->getRequests();

        $parameters['id'] = (string) Uuid::v4();
        $parameters['estimation'] = (int) ($parameters['estimation'] ?? 0);
        $parameters['startingPrice'] = $this->calculateStartingPrice($parameters['estimation']);

        return new Product(...$parameters);
    }

    /*
     * Return 2/3 of the estimation to get the starting price
     */
    private function calculateStartingPrice(int $estimation): int
    {
        return (int) ceil($estimation * 0.66);
    }
}
