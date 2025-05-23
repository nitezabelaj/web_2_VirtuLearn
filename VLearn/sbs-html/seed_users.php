<?php
require_once 'config.php';
require_once 'includes/error_handler.php';//per trajtimin e gabimeve

$adminPassword = password_hash("admin123", PASSWORD_DEFAULT);
$userPassword = password_hash("user123", PASSWORD_DEFAULT);

try {
    $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES 
        ('admin3', 'admin3@example.com', ?, 'admin'),
        ('user3', 'user3@example.com', ?, 'user')
    ")->execute([$adminPassword, $userPassword]);

    echo "Përdoruesit testues u shtuan me sukses!";
} catch (PDOException $e) {
    echo "Gabim gjatë shtimit: " . $e->getMessage();
}
