<?php

// Check if roll number is set
if (!isset($USER_ROLL)) {
    echo 'Not logged in';
    exit;
}

// Check if admin
$admins = $entityManager->createQueryBuilder()
        ->select('a')
        ->from('Admin', 'a')
        ->where('a.rollNo = :rollNo')
        ->setParameter('rollNo', $USER_ROLL)
        ->getQuery()
        ->getResult();

$IS_ADMIN = count($admins) > 0;
