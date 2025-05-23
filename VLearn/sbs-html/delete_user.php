<?php
require_once 'config.php';
 // Lidhja me databazën A.Z

if (isset($_GET['id'])) {
    $id = $_GET['id']; // Merr ID-në nga URL

    // Përgatit dhe ekzekuto query për fshirje
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);

    // Rikthehu në dashboard pas fshirjes
    header("Location: admin_dashboard.php");
    exit;
} else {
    echo "ID e përdoruesit nuk u dërgua!";
}
?>
