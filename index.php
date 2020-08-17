<?php

include __DIR__ . '/bootstrap.php';

$frontController = new FrontController($services);
$request = \Http\Request::createFromGlobal();
echo $frontController->process($request);