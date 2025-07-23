<?php

require_once __DIR__ . '/../App/Core/Router.php';

$router = new Router();

require_once __DIR__ . '/../routes/web.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$basePath = '/TaskManager/public';
$path = substr($requestUri, strlen($basePath));
if ($path === false || $path === '') {
    $path = '/';
}

$router->dispatch($path);
