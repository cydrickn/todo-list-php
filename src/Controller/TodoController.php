<?php

namespace Controller;

use Service\TodoService;
use View\ListView;
use Manager\SessionManager;
use Exceptions\InvalidTodoException;
use View\CreateView;
use View\UpdateView;
use View\TodoView;
use Http\Response;
use Http\ServerRequest;
use View\View;

class TodoController extends AbstractController
{
    private TodoService $todoService;
    private SessionManager $sessionManager;

    public function __construct(TodoService $todoService, SessionManager $sessionManager)
    {
        $this->todoService = $todoService;
        $this->sessionManager = $sessionManager;
    }

    public function list(ServerRequest $request)
    {
        $todos = $this->todoService->getTodoList($request->getQueryParam('search', ''));

        return $this->responseAsView('list.php', [
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

        return $this->responseAsView('create.php', [
            'title' => $title,
            'todoTitle' => $todoTitle,
            'todoDescription' => $todoDescription,
            'errors' => $errors,
        ]);
    }

    public function update(ServerRequest $request)
    {
        $id = $request->getQueryParam('id');

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

        return $this->responseAsView('update.php', [
            'title' => $title,
            'description' => $description,
            'errors' => $errors,
        ]);
    }

    public function view(ServerRequest $request)
    {
        $id = $request->getQueryParam('id');
        $todo = $this->todoService->getTodo($id);

        return $this->responseAsView('view.php', ['todo' => $todo]);
    }
}
