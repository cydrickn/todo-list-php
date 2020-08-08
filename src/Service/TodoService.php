<?php

namespace Service;

use Exceptions\InvalidTodoException;
use Model\Todo;
use Validator\LengthRule;
use Validator\Validator;

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

        $titleValidator = new Validator([new LengthRule(4, 16)]);
        $descriptionValidator = new Validator([new LengthRule(15)]);
        $titleValidator->validate($title, 'Title');
        $descriptionValidator->validate($description, 'Description');
        $errors = [];
        if ($titleValidator->failed()) {
            $errors['title'] = $titleValidator->getMessage();
        }
        if ($descriptionValidator->failed()) {
            $errors['description'] = $titleValidator->getMessage();
        }

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