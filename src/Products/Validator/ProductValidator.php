<?php

declare(strict_types=1);

namespace App\Products\Validator;

use App\Products\Model\Product;
use App\Validator\ConstraintViolation;
use App\Validator\Validator;

class ProductValidator implements Validator
{
    /**
     * @inheritDoc
     */
    public function validate(object $object): void
    {
        if (!$object instanceof Product) {
            throw new \LogicException('Expected '.Product::class.' object got '.$object::class);
        }

        assert('' !== $object->getName(), new ConstraintViolation('name', 'The name cannot be empty'));
        assert('' !== $object->getDescription(), new ConstraintViolation('description', 'The description cannot be empty'));
        assert($object->getStartingPrice() >= 1000, new ConstraintViolation('startingPrice', 'The startingPrice must be at least 1000 (= 1,000€)'));
    }
}
