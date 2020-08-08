<?php

namespace Service;

use Model\Todo;
use PDO;

class TodoMysqlDataProvider implements TodoDataProviderInterface
{
    private $connection;

    public function __construct(MySqlConnection $connection)
    {
        $this->connection = $connection;
    }

    public function find(int $id): ?Todo
    {
        $todos = $this->connection->select('SELECT * FROM `todo` WHERE `id` = ? LIMIT 1', [$id]);
        if (count($todos) === 0) {
            return null;
        }

        return new Todo(
            $todos[0]['id'],
            $todos[0]['title'],
            $todos[0]['description'],
            $todos[0]['done_at'] !== null
        );
    }

    public function list(string $search = ''): array
    {
        $result = $this->connection->select(
            'SELECT * FROM `todo` WHERE `title` LIKE :search',
            ['search' => $search . '%']
        );
        $todos = [];
        foreach ($result as $todo) {
            $todos[] = new Todo($todo['id'], $todo['title'], $todo['description'], $todo['done_at'] !== null);
        }

        return $todos;
    }

    public function save(?int $id, string $title, string $description): Todo
    {
        $now = new \DateTimeImmutable('now');
        $nowFormated = $now->format('Y-m-d H:i:s');
        if ($id === null) {
            $this->connection->exec(
                'INSERT INTO `todo` (`title`, `description`, `created_at`, `updated_at`)'
                . 'VALUES (:title, :desc, :createdAt, :updatedAt)',
                [
                    'title' => $title,
                    'desc' => $description,
                    'createdAt' => $nowFormated,
                    'updatedAt' => $nowFormated,
                ]
            );

            $id = $this->connection->lastInsertId();
        } else{
            $this->connection->exec(
                'UPDATE `todo` SET `title` = :title, `description` = :desc, `updated_at` = :updatedAt WHERE `id` = :id',
                [
                    'title' => $title,
                    'desc' => $description,
                    'updatedAt' => $nowFormated,
                    'id' => $id,
                ]
            );
        }

        return new Todo($id, $title, $description, false);
    }
}