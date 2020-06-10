<?php

require_once "vendor/autoload.php";

$router = new \Bramus\Router\Router();

$router->setBasePath('/~mlc/nodues/');

$router->get('home', function() { require __DIR__ . '/views/home.php'; });
$router->all('admin', function() { require __DIR__ . '/views/admin.php'; });
$router->get('login', function() { require __DIR__ . '/views/login.php'; });
$router->get('logout', function() { require __DIR__ . '/views/logout.php'; });
$router->get('', function() { require __DIR__ . '/views/index.php'; });

$router->run();

exit();

