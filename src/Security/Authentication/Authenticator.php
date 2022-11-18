<?php

declare(strict_types=1);

namespace App\Security\Authentication;

use App\Core\Http\Request;
use App\Security\Exception\AuthenticationException;
use App\Security\Repository\UserRepository;
use App\Security\Security;
use App\Security\UserInterface;

class Authenticator
{
    private Security $security;

    public function __construct(private readonly Request $request)
    {
        $this->security = new Security();
    }

    public function authenticate(): void
    {
        $this->security->removeUser();

        $credentials = $this->getCredentials();
        $user = $this->getUser($credentials);

        $this->validatePassword($credentials, $user);

        $this->security->storeAuthenticatedUser($user);
    }

    /**
     * @throws AuthenticationException
     */
    private function validatePassword(UsernamePasswordCredential $credentials, UserInterface $user): void
    {
        if (false === password_verify($credentials->password, $user->getPassword())) {
            throw new AuthenticationException();
        }
    }

    /**
     * @throws AuthenticationException
     */
    private function getUser(UsernamePasswordCredential $credentials): UserInterface
    {
        $userRepository = new UserRepository();

        if (null === $user = $userRepository->getUserByUsername($credentials->username)) {
            throw new AuthenticationException();
        }

        return $user;
    }

    /**
     * @throws AuthenticationException
     */
    private function getCredentials(): UsernamePasswordCredential
    {
        $username = $this->request->getRequest('username');
        $password = $this->request->getRequest('password');

        if (null === $username || null === $password) {
            throw new AuthenticationException();
        }

        return new UsernamePasswordCredential($username, $password);
    }
}
