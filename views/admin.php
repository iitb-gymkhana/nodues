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

    // Get section CSV
    if ($_POST['action'] === 'section_data') {
        // Get payments objects
        $payments = $entityManager->createQueryBuilder()
            ->select('p')
            ->from('Payment', 'p')
            ->where('IDENTITY(p.section) = :sectionId')
            ->setParameter('sectionId', $_POST['section_id'])
            ->getQuery()
            ->getResult();

        // Construct data
        $data = array(array(
            'Roll No', 'Amount', 'Transaction ID', 'Comments'
        ));
        foreach ($payments as $payment) {
            $point = array(
                $payment->getRollNo(),
                $payment->getAmount(),
                $payment->getTransactionId(),
                $payment->getComments(),
            );
            array_push($data, $point);
        }
        array_to_csv_download($data, 'dues.csv');
        die;
    }

    // Get master CSV
    if ($_POST['action'] === 'master') {
        // Get sections
        $sections = $entityManager->getRepository('Section')->findAll();

        // Array to store dues
        $dues = array();

        // Section anmes
        $snames = array();
        foreach($sections as $s) {
            array_push($snames, $s->getDisplayName());

            // Get dues
            $iterableResult = $entityManager->createQueryBuilder()
                ->select('d')
                ->from('Due', 'd')
                ->where('IDENTITY(d.section) = :sectionId')
                ->setParameter('sectionId', $s->getId())
                ->getQuery()->iterate();
            foreach ($iterableResult as $row) {
                $due = $row[0];

                // Ensure key exists
                if (!array_key_exists($due->getRollNo(), $dues)) {
                    $dues[$due->getRollNo()] = array();
                }

                // Ensure subkey exists
                if (!array_key_exists($s->getDisplayName(), $dues[$due->getRollNo()])) {
                    $dues[$due->getRollNo()][$s->getDisplayName()] = 0;
                }

                // Add due
                $dues[$due->getRollNo()][$s->getDisplayName()] += $due->getAmount();
            }

            // Get payments
            $iterableResult = $entityManager->createQueryBuilder()
                ->select('p')
                ->from('Payment', 'p')
                ->where('IDENTITY(p.section) = :sectionId')
                ->setParameter('sectionId', $s->getId())
                ->getQuery()->iterate();
            foreach ($iterableResult as $row) {
                $pay = $row[0];

                // Ensure key exists
                if (!array_key_exists($pay->getRollNo(), $dues)) {
                    $dues[$pay->getRollNo()] = array();
                }

                // Ensure subkey exists
                if (!array_key_exists($s->getDisplayName(), $dues[$pay->getRollNo()])) {
                    $dues[$pay->getRollNo()][$s->getDisplayName()] = 0;
                }

                // Reduce due
                $dues[$pay->getRollNo()][$s->getDisplayName()] -= $pay->getAmount();
            }
        }

        // Compile the results
        $result = array();
        $header = array(
            'Roll No', 'Total Due',
        );
        foreach ($snames as $sn) {
            array_push($header, $sn);
        }
        array_push($result, $header);

        // Compute table
        foreach ($dues as $r => $due) {
            $point = array(
                $r, 0,
            );

            foreach ($snames as $sn) {
                $am = isset($due[$sn]) ? $due[$sn] : 0;
                array_push($point, $am);
                $point[1] += $am;
            }

            array_push($result, $point);
        }

        array_to_csv_download($result, 'dues_master.csv');
        die();
    }

    $entityManager->flush();
    header("HTTP/1.1 303 See Other");
    if (!isset($link)) $link = $_SERVER['REQUEST_URI'];
    header("Location: $link");
    die();
}

echo $twig->render('admin.html', [
    'admins' => $admins,
]);
