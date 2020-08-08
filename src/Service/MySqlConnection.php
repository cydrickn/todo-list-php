<?php

namespace Service;

use PDO;
use PDOStatement;

class MySqlConnection
{
    private $pdo;

    public function __construct(string $dbHost, string $dbName, string $username, string $password)
    {
        $dsn = 'mysql:dbname=' . $dbName . ';host=' . $dbHost . ';charset=utf8';
        $options = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET SQL_MODE = "NO_BACKSLASH_ESCAPES"'
        ];
        $this->pdo = new PDO($dsn,$username, $password, $options);
    }

    public function select(string $query, array $parameters): array
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($parameters);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function exec(string $query, array $parameters): void
    {
        $statement = $this->pdo->prepare($query);
        foreach ($parameters as $key => $value) {
            $statement->bindValue($key, $value);
        }

        $statement->execute();
    }

    public function lastInsertId(): int
    {
        return $this->pdo->lastInsertId();
    }
}