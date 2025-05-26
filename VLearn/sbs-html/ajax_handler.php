<?php
session_start();

if (!isset($_SESSION['myValue'])) {
    $_SESSION['myValue'] = "Duke përditësuar këtë fjali,
      ti mund te shkruash nje fjali moivuese per veten qe sa here hyn ne kete faqe ta shohesh.";
}

if (isset($_GET['action'])) {
    header('Content-Type: application/json');
    $action = $_GET['action'];

    switch ($action) {
        case 'read':
            echo json_encode(['value' => $_SESSION['myValue']]);
            break;

        case 'update':
            $newValue = trim($_POST['value'] ?? '');
            if ($newValue !== '') {
                $_SESSION['myValue'] = $newValue;
                echo json_encode(['success' => true, 'newValue' => $_SESSION['myValue']]);
            } else {
                echo json_encode(['error' => 'Vlera është bosh']);
            }
            break;

        default:
            echo json_encode(['error' => 'Veprim i pavlefshëm']);
    }
    exit;
}
