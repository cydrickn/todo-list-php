<?php

session_start();

use Service\TodoService;
use Service\TodoFileDataProvider;

$todoFolder = __DIR__ . '/data/todo';
$todoIndexTitleFolder = __DIR__ . '/data/index/title';
$todoPropertiesFileName = __DIR__ . '/data/todo_properties.json';
$userFolder = __DIR__ . '/data/user';

require_once __DIR__ . '/src/Authentication.php';
require_once __DIR__ . '/src/Model/Todo.php';
require_once __DIR__ . '/src/Service/TodoService.php';
require_once __DIR__ . '/src/Service/TodoDataProviderInterface.php';
require_once __DIR__ . '/src/Service/TodoFileDataProvider.php';
require_once __DIR__ . '/src/Exceptions/InvalidTodoException.php';

require_once __DIR__ . '/functions/validation.php';
require_once __DIR__ . '/functions/todo_functions.php';
require_once __DIR__ . '/functions/user_functions.php';

$todoProperties = json_decode(file_get_contents($todoPropertiesFileName), true);

$todoDataProvider = new TodoFileDataProvider($todoFolder, $todoIndexTitleFolder, $todoPropertiesFileName);
$services = [
    TodoService::class => new TodoService($todoDataProvider),
];
