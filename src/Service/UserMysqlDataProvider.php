<?php

namespace Service;

use Model\User;
use PDO;

class UserMysqlDataProvider implements UserDataProviderInterface
{
    private $connection;

    public function __construct(MySqlConnection $connection)
    {
        $this->connection = $connection;
    }

    public function findUserByUsername(string $username): ?User
    {
        $result = $this->connection->select('SELECT * FROM `users` WHERE `username` = ? LIMIT 1', [$username]);
        if (count($result) === 0) {
            return null;
        }
        $userData = $result[0];

        return new User($userData['id'], $userData['username'], $userData['password'], $userData['name']);
    }
}