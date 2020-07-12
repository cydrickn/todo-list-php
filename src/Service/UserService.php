<?php

namespace Service;

use Model\User;

class UserService
{
    private UserDataProviderInterface $userDataProvider;

    public function __construct(UserDataProviderInterface $userDataProvider)
    {
        $this->userDataProvider = $userDataProvider;
    }

    public function getUserByUsername(string $username): ?User
    {
        return $this->userDataProvider->findUserByUsername($username);
    }
}