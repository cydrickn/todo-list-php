<?php

session_start();

spl_autoload_register(function (string $class) {
    $psrMessageLengthNamespace = strlen('Psr\Http\Message');
    if (substr($class, 0, $psrMessageLengthNamespace) === 'Psr\Http\Message') {
        $path = __DIR__ . '/libs/http-message/src/' . str_replace('Psr\\Http\\Message\\', '', $class) . '.php';
    } else {
        $path = __DIR__ . '/src/'. str_replace('\\', '/', $class) . '.php';
    }

    include_once $path;
});

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
require_once __DIR__ . '/functions/validation.php';

$todoProperties = json_decode(file_get_contents($todoPropertiesFileName), true);
$connection = new MySqlConnection('database', 'todo', 'root', 'root');
$todoDataProvider = new TodoMysqlDataProvider($connection);
$userDataProvider = new UserMysqlDataProvider($connection);
$sessionDataProvider = new PHPSessionDataProvider();
$sessionManager = new SessionManager($sessionDataProvider, $userDataProvider, '/login.php');
$services = [
    SessionManager::class => $sessionManager,
    UserService::class => new UserService($userDataProvider),
    TodoService::class => new TodoService($todoDataProvider),
    Authentication::class => new Authentication($sessionManager, $userDataProvider),
];
