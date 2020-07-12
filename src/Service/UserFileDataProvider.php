<?php

namespace Service;

use Model\User;

class UserFileDataProvider implements UserDataProviderInterface
{
    private $userDirectory;

    public function __construct(string $userDirectory)
    {
        $this->userDirectory = $userDirectory;
    }

    public function findUserByUsername(string $username): ?User
    {
        $filepath = $this->userDirectory . '/' . $username . '.json';
        if (file_exists($filepath)) {
            $userJson = file_get_contents($filepath);
            $userData = json_decode($userJson, true);
            return new User($userData['id'], $userData['username'], $userData['password'], $userData['name']);
        } else {
            return null;
        }
    }
}