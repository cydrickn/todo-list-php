<?php

include __DIR__ . '/bootstrap.php';

$frontController = new FrontController($services);

$uri = new \Http\Uri(sprintf(
    '%s://%s%s',
    $_SERVER['REQUEST_SCHEME'],
    $_SERVER['HTTP_HOST'],
    $_SERVER['REQUEST_URI'],
));

$request = new \Http\ServerRequest(
    $_SERVER['REQUEST_METHOD'],
    $uri,
    headers_list(),
    $_SERVER,
    $_COOKIE,
    [],
    ''
);
echo $frontController->process($request);
