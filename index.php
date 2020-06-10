<?php

require_once "vendor/autoload.php";

$router = new \Bramus\Router\Router();

$router->setBasePath('/~mlc/nodues/');

$router->get('home', function() { require __DIR__ . '/views/home.php'; });
$router->get('', function() { require __DIR__ . '/views/index.php'; });

$router->run();

exit();

