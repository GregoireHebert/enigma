<?php

declare(strict_types=1);

namespace App\Customers\Application\MessageHandler;

use App\Customers\Application\Message\VerifyUserEmail;
use App\Customers\Infrastructure\Symfony\Security\EmailVerifier;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

#[AsMessageHandler]
class VerifyUserEmailHandler
{
    public function __construct(private EmailVerifier $emailVerifier)
    {
    }

    public function __invoke(VerifyUserEmail $verifyUserEmail): bool|VerifyEmailExceptionInterface
    {
        try {
            // validate email confirmation link, sets User::isVerified=true and persists
            $this->emailVerifier->handleEmailConfirmation($verifyUserEmail->request, $verifyUserEmail->user);
            return true;
        } catch (VerifyEmailExceptionInterface $exception) {
            return $exception;
        }
    }
}
