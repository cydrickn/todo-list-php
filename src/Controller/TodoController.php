<?php

namespace Controller;

use Service\TodoService;
use View\ListView;
use Manager\SessionManager;
use Exceptions\InvalidTodoException;
use View\CreateView;
use View\UpdateView;
use View\TodoView;
use Http\Request;

class TodoController
{
    private TodoService $todoService;
    private SessionManager $sessionManager;

    public function __construct(TodoService $todoService, SessionManager $sessionManager)
    {
        $this->todoService = $todoService;
        $this->sessionManager = $sessionManager;
    }

    public function list(Request $request)
    {
        $todos = $this->todoService->getTodoList($request->getQuery('search', ''));
        $view = new ListView();

        return $view->render([
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
                header('Location: ./index.php?action=view&id=' . $todo->getId());
            } catch (InvalidTodoException $exception) {
                $errors = $exception->getErrors();
            }
        }

        $view = new CreateView();

        return $view->render([
            'title' => $title,
            'todoTitle' => $todoTitle,
            'todoDescription' => $todoDescription,
            'errors' => $errors,
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->getQuery('id');

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

        return $view->render([
            'title' => $title,
            'description' => $description,
            'errors' => $errors,
        ]);
    }

    public function view(Request $request)
    {
        $id = $request->getQuery('id');
        $todo = $this->todoService->getTodo($id);
        $view = new TodoView();

        return $view->render(['todo' => $todo]);
    }
}