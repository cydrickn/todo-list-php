<?php

namespace Controller;

use Service\TodoService;
use View\ListView;
use Manager\SessionManager;
use Exceptions\InvalidTodoException;
use View\CreateView;
use View\UpdateView;
use View\TodoView;

class TodoController
{
    private TodoService $todoService;
    private SessionManager $sessionManager;

    public function __construct(TodoService $todoService, SessionManager $sessionManager)
    {
        $this->todoService = $todoService;
        $this->sessionManager = $sessionManager;
    }

    public function list()
    {
        $todos = $this->todoService->getTodoList($_GET['search'] ?? '');
        $view = new ListView();
        echo $view->render([
            'todoList' => $todos,
            'user' => $this->sessionManager->getCurrentUser(),
            'title' => 'Todo List',
        ]);
    }

    public function create()
    {
        $title = 'Create Todo';
        $todo = $_POST;
        $errors = [];

        $todoTitle = '';
        $todoDescription = '';
        if (!empty($todo)) {
            $todoTitle = $_POST['title'];
            $todoDescription = $_POST['description'];
            try {
                $todo = $this->todoService->createTodo($todoTitle, $todoDescription);
                header('Location: ./view.php?id=' . $todo->getId());
            } catch (InvalidTodoException $exception) {
                $errors = $exception->getErrors();
            }
        }

        $view = new CreateView();

        echo $view->render([
            'title' => $title,
            'todoTitle' => $todoTitle,
            'todoDescription' => $todoDescription,
            'errors' => $errors,
        ]);
    }

    public function update()
    {
        $id = $_GET['id'];

        $todo = $this->todoService->getTodo($id);

        $errors = [];
        $title = trim($_POST['title'] ?? $todo->getTitle());
        $description = trim($_POST['description'] ?? $todo->getDescription());

        if (!empty($_POST)) {
            try {
                $this->todoService->updateTodo($id, $title, $description);
            } catch (InvalidTodoException $exception) {
                $errors = $exception->getErrors();
            }
        }

        $view = new UpdateView();
        echo $view->render([
            'title' => $title,
            'description' => $description,
            'errors' => $errors,
        ]);
    }

    public function view()
    {
        $todo = $this->todoService->getTodo($_GET['id']);
        $view = new TodoView();
        echo $view->render(['todo' => $todo]);
    }
}