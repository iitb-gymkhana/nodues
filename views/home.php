<?php
require_once "bootstrap.php";
require_once "need_admin.php";

// Check if roll number is set
if (!isset($USER_ROLL)) {
    header('location:login');
    exit;
}

// Take admins to admin
if ($IS_ADMIN && !isset($_GET['roll'])) {
    header('location:admin');
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

// Get payments objects
$payments = $entityManager->createQueryBuilder()
        ->select('p')
        ->from('Payment', 'p')
        ->where('p.rollNo = :rollNo')
        ->setParameter('rollNo', $ROLL)
        ->getQuery()
        ->getResult();

// Process dues to subtract payments
foreach ($payments as $payment) {
    foreach ($dues as $due) {
        if ($payment->getSection() === $due->getSection()) {
            $due->setAmount($due->getAmount() - $payment->getAmount());
            break;
        }
    }
}

// Get total dues
$total = 0;
foreach ($dues as $due) {
    $total += $due->getAmount();
}

// Get CN of user
$cn = 'USER NOT PRESENT IN LDAP?';
if ($LDAP_SERVER !== null) {
    $ds = ldap_connect($LDAP_SERVER) or die("Unable to connect to LDAP server. Please try again later.");
    $sr = ldap_search($ds, "dc=iitb,dc=ac,dc=in", "(employeeNumber=$ROLL)", array("cn"));
    $entries = ldap_get_entries($ds, $sr);
    if ($entries['count'] > 0) {
        $cn = $entries[0]["cn"][0];
    }
}

echo $twig->render('home.html', [
    'roll' => $ROLL,
    'name' => $cn,
    'dues' => $dues,
    'total' => $total,
    'is_admin' => $IS_ADMIN,
    'admins' => $admins,
    'payments' => $payments,
]);

