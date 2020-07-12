<?php

namespace Service;

use Exceptions\InvalidTodoException;
use Model\Todo;

class TodoService
{
    private TodoDataProviderInterface $todoDataProvider;

    public function __construct(TodoDataProviderInterface $todoDataProvider)
    {
        $this->todoDataProvider = $todoDataProvider;
    }

    /**
     * Get todo list
     *
     * @param string $title
     * @return Todo[]|array
     */
    public function getTodoList(string $title = ''): array
    {
        return $this->todoDataProvider->list($title);
    }

    public function getTodo(int $id): ?Todo
    {
        return $this->todoDataProvider->find($id);
    }

    public function createTodo(string $title, string $description): Todo
    {
        $errors = validateTodo($title, $description);
        if (!empty($errors)) {
            throw new InvalidTodoException($errors);
        }

        return $this->todoDataProvider->save(null, $title, $description);
    }

    public function updateTodo(int $id, string $title, string $description): Todo
    {
        $errors = validateTodo($title, $description);
        if (!empty($errors)) {
            throw new InvalidTodoException($errors);
        }

        return $this->todoDataProvider->save($id, $title, $description);
    }
}