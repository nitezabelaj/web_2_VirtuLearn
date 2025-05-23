<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // kripton passwordin
    $role = $_POST['role'];

    // Kontroll nëse ekziston përdoruesi
    $check = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $check->execute([$username]);
    if ($check->rowCount() > 0) {
        echo "Përdoruesi ekziston tashmë.";
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$username, $password, $role]);

    header("Location: admin_dashboard.php");
    exit;
} else {
    echo "Kërkesa nuk është POST!";
}
?>
