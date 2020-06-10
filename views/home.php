<?php
require_once "bootstrap.php";

$dues = $entityManager->createQueryBuilder()
        ->select('d')
        ->from('Due', 'd')
        ->where('d.rollNo = :rollNo')
        ->setParameter('rollNo', '160010005')
        ->getQuery()
        ->getResult();

// Get total dues
$total = 0;
foreach ($dues as $due) {
    $total += $due->getAmount();
}

echo $twig->render('home.html', [
    'dues' => $dues,
    'total' => $total,
]);

