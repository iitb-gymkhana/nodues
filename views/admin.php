<?php
require_once "bootstrap.php";
require_once "need_admin.php";

// Check if admin
if (!$IS_ADMIN) {
    echo 'Not an admin';
    exit;
}

// POST actions
if (isset($_POST['action'])) {
    // Create payment
    if ($_POST['action'] === 'pay') {
        // Check section
        $section = $entityManager->find('Section', $_POST['section_id']);
        assertSectionAdmin($admins, $section);

        // Create payment
        $payment = new Payment();
        $payment->setRollNo($_POST['roll']);
        $payment->setAmount((float)$_POST['amount']);
        $payment->setSection($section);
        $payment->setTransactionId($_POST['tid']);
        $payment->setComments($_POST['comments']);
        $payment->setUpdatedBy($USER_ROLL);
        $payment->setUpdatedOn(new \DateTime());
        $entityManager->persist($payment);
        $link = $_POST['next'];
    }

    // Delete
    if ($_POST['action'] === 'unpay') {
        $payment = $entityManager->find('Payment', $_POST['id']);
        assertSectionAdmin($admins, $payment->getSection());
        $entityManager->remove($payment);
        $link = $_POST['next'];
    }

    $entityManager->flush();
    header("HTTP/1.1 303 See Other");
    if (!isset($link)) $link = $_SERVER['REQUEST_URI'];
    header("Location: $link");
    die();
}

echo $twig->render('admin.html', []);
