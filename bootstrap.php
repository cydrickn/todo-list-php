<?php

session_start();

$todoFolder = __DIR__ . '/data/todo';
$todoIndexTitleFolder = __DIR__ . '/data/index/title';
$todoPropertiesFileName = __DIR__ . '/data/todo_properties.json';
$userFolder = __DIR__ . '/data/user';

require_once __DIR__ . '/functions/validation.php';
require_once __DIR__ . '/functions/todo_functions.php';
require_once __DIR__ . '/functions/user_functions.php';
