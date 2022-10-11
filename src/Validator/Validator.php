<?php

declare(strict_types=1);

namespace App\Validator;

interface Validator
{
    /**
     * @throw ConstraintViolation
     */
    public function validate(object $object): void;
}
