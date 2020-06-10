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

function assertSectionAdmin($admins, $section) {
    $has_admin = false;
    foreach ($admins as $admin) {
        if ($admin->getSection() === $section) $has_admin = true;
    }
    if (!$has_admin) {
        echo 'Not an admin for this section'; exit;
    }
}

function array_to_csv_download($array, $filename = "export.csv", $delimiter=",") {
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://memory', 'w');
    // loop over the input array
    foreach ($array as $line) {
        // generate csv lines from the inner arrays
        fputcsv($f, $line, $delimiter);
    }
    // reset the file pointer to the start of the file
    fseek($f, 0);
    // tell the browser it's going to be a csv file
    header('Content-Type: application/csv');
    // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachment; filename="'.$filename.'";');
    // make php send the generated csv lines to the browser
    fpassthru($f);
}
