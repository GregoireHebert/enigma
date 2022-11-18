<?php

declare(strict_types=1);

namespace App\Products\Validator;

use App\Core\Validator\ConstraintViolation;
use App\Core\Validator\Validator;
use App\Products\Model\ProductInterface;

/**
 * @implements Validator<ProductInterface>
 */
class ProductValidator implements Validator
{
    /**
     * @inheritDoc
     */
    public function validate(object $object): void
    {
        if (!$object instanceof ProductInterface) {
            throw new \LogicException('Expected '.ProductInterface::class.' object got '.$object::class);
        }

        assert('' !== $object->getName(), new ConstraintViolation('name', 'The name cannot be empty'));
        assert('' !== $object->getDescription(), new ConstraintViolation('description', 'The description cannot be empty'));
        assert($object->getEstimation() >= 1000, new ConstraintViolation('estimation', 'The estimate price must be at least 1000 (= 1,000€)'));
    }
}
