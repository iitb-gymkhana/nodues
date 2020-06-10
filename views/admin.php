<?php
require_once "bootstrap.php";
require_once "need_admin.php";

if (!$IS_ADMIN) {
    echo 'Not an admin';
    exit;
}

echo $twig->render('admin.html', []);
