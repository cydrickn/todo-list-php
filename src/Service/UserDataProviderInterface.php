<?php

namespace Service;

use Model\User;

interface UserDataProviderInterface
{
    public function findUserByUsername(string $username): ?User;
}