<?php
require_once "bootstrap.php";
require_once "need_admin.php";

// Check if admin
if (!$IS_ADMIN) {
    echo 'Not an admin';
    exit;
}

// Create payment
if (isset($_POST['action'])) {

    if ($_POST['action'] === 'pay') {
        $payment = new Payment();
        $payment->setRollNo($_POST['roll']);
        $payment->setAmount((float)$_POST['amount']);
        $payment->setSection($entityManager->find('Section', $_POST['section_id']));
        $payment->setTransactionId($_POST['tid']);
        $payment->setComments($_POST['comments']);
        $payment->setUpdatedBy($USER_ROLL);
        $payment->setUpdatedOn(new \DateTime());
        $entityManager->persist($payment);
        $link = $_POST['next'];
    }

    $entityManager->flush();
    header("HTTP/1.1 303 See Other");
    if (!isset($link)) $link = $_SERVER['REQUEST_URI'];
    header("Location: $link");
    die();
}

echo $twig->render('admin.html', []);
