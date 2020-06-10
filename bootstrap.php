<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";
require_once "config.php";

// Register models
require_once "models/due.php";
require_once "models/section.php";
require_once "models/admin.php";
require_once "models/payment.php";

if ($isDevMode) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$cacheDir = dirname(__FILE__).'/.cache';
if (!is_dir($cacheDir)) {
    mkdir($cacheDir);
}

$cache = new \Doctrine\Common\Cache\ApcuCache();
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/models"), $isDevMode, $cacheDir, $cache, false);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);

$loader = new \Twig\Loader\FilesystemLoader('./templates');
$twig = new \Twig\Environment($loader, [
    'cache' => ($isDevMode === true ? false : __DIR__.'/.cache_twig'),
]);

// Current URL
$url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// User roll number
$USER_ROLL = '160010005';
$USER_ROLL = 'root';

// Twig globals
$twig->addGlobal('baseUrl', $BASE_URL);
$twig->addGlobal('userRoll', $USER_ROLL);
$twig->addGlobal('year', date("Y"));
$twig->addGlobal('url', $url);

// Stop cache
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

