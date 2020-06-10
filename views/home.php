<?php
require_once "bootstrap.php";
require_once "need_admin.php";

// Check if roll number is set
if (!isset($USER_ROLL)) {
    echo 'Not logged in';
    exit;
}

// Check if admin
if ($IS_ADMIN && isset($_GET['roll'])) {
    $ROLL = $_GET['roll'];
} else {
    $ROLL = $USER_ROLL;
}

// Get dues objects
$dues = $entityManager->createQueryBuilder()
        ->select('d')
        ->from('Due', 'd')
        ->where('d.rollNo = :rollNo')
        ->setParameter('rollNo', $ROLL)
        ->getQuery()
        ->getResult();

// Get total dues
$total = 0;
foreach ($dues as $due) {
    $total += $due->getAmount();
}

echo $twig->render('home.html', [
    'roll' => $ROLL,
    'dues' => $dues,
    'total' => $total,
    'is_admin' => $IS_ADMIN,
]);

