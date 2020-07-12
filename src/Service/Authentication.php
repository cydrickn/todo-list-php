<?php

namespace Service;

use Manager\SessionManager;

class Authentication
{
    private SessionManager $sessionManager;
    private UserDataProviderInterface $userDataProvider;

    public function __construct(SessionManager $sessionManager, UserDataProviderInterface $userDataProvider)
    {
        $this->sessionManager = $sessionManager;
        $this->userDataProvider = $userDataProvider;
    }

    public function login(string $username, string $password): array
    {
        $result = $this->validateLogin($username, $password);
        $user = $this->userDataProvider->findUserByUsername($username);
        $this->sessionManager->setCurrentUser($user);

        return $result;
    }

    public function validateLogin(string $username, string $password): array
    {
        $user = $this->userDataProvider->findUserByUsername($username);
        if ($user === null) {
            return ['message' => 'Username does not exists.', 'valid' => false];
        } elseif (!$user->checkPasswordIsCorrect($password)) {
            return ['message' => 'Password incorrect.', 'valid' => false];
        }

        return ['valid' => true];
    }
}