<?php

declare(strict_types=1);

namespace App\Validator;

/**
 * @template T of object
 */
interface Validator
{
    /**
     * @throw ConstraintViolation
     * @param T $object
     */
    public function validate(object $object): void;
}
