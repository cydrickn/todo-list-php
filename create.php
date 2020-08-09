<?php
    include __DIR__ . '/bootstrap.php';

  $controller = new \Controller\TodoController(
      $services[\Service\TodoService::class],
      $services[\Manager\SessionManager::class]
  );

  $controller->create();