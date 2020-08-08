<?php

namespace Service;

use Model\Todo;
use PDO;

class TodoMysqlDataProvider implements TodoDataProviderInterface
{
    private $pdo;

    public function __construct(string $dbHost, string $dbName, string $username, string $password)
    {
        $dsn = 'mysql:dbname=' . $dbName . ';host=' . $dbHost;
        $this->pdo = new PDO($dsn,$username, $password);
    }

    public function find(int $id): ?Todo
    {
        $statement = $this->pdo->query('SELECT * FROM `todo` WHERE `id` = ' . $id);
        $todo = $statement->fetch();

        return new Todo($todo['id'], $todo['title'], $todo['description'], $todo['done_at'] !== null);
    }

    public function list(): array
    {
        $statement = $this->pdo->query('SELECT * FROM `todo`');
        $todos = [];
        foreach ($statement->fetchAll() as $todo) {
            $todos[] = new Todo($todo['id'], $todo['title'], $todo['description'], $todo['done_at'] !== null);
        }

        return $todos;
    }

    public function save(?int $id, string $title, string $description): Todo
    {
        $now = new \DateTimeImmutable('now');
        $nowFormated = $now->format('Y-m-d H:i:s');
        if ($id === null) {
            $this->pdo->exec('INSERT INTO `todo` (`title`, `description`, `created_at`, `updated_at`)'
                . 'VALUES ("' . $title . '", "' . $description . '", "' .  $nowFormated . '", "' . $nowFormated . '")');
            $id = $this->pdo->lastInsertId();
        } else{
            $this->pdo->exec('UPDATE `todo` SET `title` = "' . $title. '", `description` = "' . $description . '"'
                . ', `updated_at` = "' . $nowFormated . '" WHERE `id` = ' . $id);
        }

        return new Todo($id, $title, $description, false);
    }
}