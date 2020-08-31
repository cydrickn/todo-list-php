<?php

use Controller\TodoController;
use Service\TodoService;
use Manager\SessionManager;
use Http\ServerRequest;

class FrontController
{
    private array $actions;
    private array $controllers;
    private array $services;

    public function __construct(array $services)
    {
        $this->services = $services;
        $this->actions = [];
        $this->controllers = [];

        $this->init();
    }

    private function init()
    {
        $this->controllers[TodoController::class] = new TodoController(
            $this->services[TodoService::class],
            $this->services[SessionManager::class]
        );
        $this->actions = [
            'list' => TodoController::class . '@list', // TodoController@list
            'create' => TodoController::class . '@create',
            'view' => TodoController::class . '@view',
            'update' => TodoController::class . '@update',
        ];
    }

    public function process(ServerRequest $request): string
    {
        $action = $request->getQueryParam('action');
        if ($action === null) {
            $action = 'list';
        }
        $handlerName = $this->getHandlerName($action);
        if ($handlerName === null) {
            return 'Not Found';
        }
        list($controllerName, $actionName) = explode('@', $handlerName);

        $response = call_user_func([$this->controllers[$controllerName], $actionName], $request);

        foreach ($response->getHeaders() as $header => $value) {
            header($header . ': ' . $response->getHeaderLine($header));
        }

        return (string) $response->getBody();
    }

    private function getHandlerName($action): ?string
    {
        if (!array_key_exists($action, $this->actions)) {
            return null;
        }

        return $this->actions[$action];
    }
}
