<?php

declare(strict_types=1);

namespace App\Validator;

use App\Security\User;

class UserValidator implements Validator
{
    private const PASSWORD_REGEX = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';

    public function validate(object $object): void
    {
        if (!$object instanceof User) {
            throw new \LogicException('Expected '.User::class.' object got '.$object::class);
        }

        assert(!empty($object->getUsername()), new ConstraintViolation('username', 'Username must be a non empty string.'));
        assert(filter_var($object->getEmail(), FILTER_VALIDATE_EMAIL), new ConstraintViolation('email', 'Email is not valid.'));
        assert(preg_match(self::PASSWORD_REGEX, $object->getPassword()), new ConstraintViolation('password', 'Password must be 8 characters long, 1 upper case, 1 lower case, 1 digit and 1 special character (ex: -Secr3t.).'));
    }
}
