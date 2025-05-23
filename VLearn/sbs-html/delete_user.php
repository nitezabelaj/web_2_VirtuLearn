<?php
require_once 'includes/error_handler.php';//T.G
require_once 'config.php';
session_start();

// Sigurohu që është admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Parandalon fshirjen e vetvetes
    if ($id == $_SESSION['user_id']) {
        echo "Nuk mund ta fshish veten!";
        exit;
    }

    // Fshi përdoruesin
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: manage_users.php");
    exit;
} else {
    echo "ID e përdoruesit nuk u dërgua ose është e pavlefshme!";
}
?>

