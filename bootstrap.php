<?php

session_start();

use Service\TodoService;
use Service\TodoFileDataProvider;
use Service\TodoMysqlDataProvider;
use Service\UserService;
use Service\UserFileDataProvider;
use Service\MySqlConnection;
use Service\UserMysqlDataProvider;
use Manager\SessionManager;
use Manager\PHPSessionDataProvider;
use Service\Authentication;

$todoFolder = __DIR__ . '/data/todo';
$todoIndexTitleFolder = __DIR__ . '/data/index/title';
$todoPropertiesFileName = __DIR__ . '/data/todo_properties.json';
$userFolder = __DIR__ . '/data/user';

require_once __DIR__ . '/src/Service/Authentication.php';
require_once __DIR__ . '/src/Model/Todo.php';
require_once __DIR__ . '/src/Service/TodoService.php';
require_once __DIR__ . '/src/Service/TodoDataProviderInterface.php';
require_once __DIR__ . '/src/Service/TodoFileDataProvider.php';
require_once __DIR__ . '/src/Service/TodoMysqlDataProvider.php';
require_once __DIR__ . '/src/Exceptions/InvalidTodoException.php';
require_once __DIR__ . '/src/Model/User.php';
require_once __DIR__ . '/src/Service/UserService.php';
require_once __DIR__ . '/src/Service/UserDataProviderInterface.php';
require_once __DIR__ . '/src/Service/UserFileDataProvider.php';
require_once __DIR__ . '/src/Service/UserMysqlDataProvider.php';
require_once __DIR__ . '/src/Service/MySqlConnection.php';
require_once __DIR__ . '/src/Manager/SessionManager.php';
require_once __DIR__ . '/src/Manager/SessionDataProviderInterface.php';
require_once __DIR__ . '/src/Manager/PHPSessionDataProvider.php';
require_once __DIR__ . '/src/Validator/Validator.php';
require_once __DIR__ . '/src/Validator/RuleInterface.php';
require_once __DIR__ . '/src/Validator/LengthRule.php';

require_once __DIR__ . '/functions/validation.php';

$todoProperties = json_decode(file_get_contents($todoPropertiesFileName), true);
$connection = new MySqlConnection('database', 'todo', 'root', 'root');
//$todoDataProvider = new TodoFileDataProvider($todoFolder, $todoIndexTitleFolder, $todoPropertiesFileName);
$todoDataProvider = new TodoMysqlDataProvider($connection);
// $userDataProvider = new UserFileDataProvider($userFolder);
$userDataProvider = new UserMysqlDataProvider($connection);
$sessionDataProvider = new PHPSessionDataProvider();
$sessionManager = new SessionManager($sessionDataProvider, $userDataProvider, '/login.php');
$services = [
    SessionManager::class => $sessionManager,
    UserService::class => new UserService($userDataProvider),
    TodoService::class => new TodoService($todoDataProvider),
    Authentication::class => new Authentication($sessionManager, $userDataProvider),
];
