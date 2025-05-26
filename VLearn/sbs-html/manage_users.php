<?php
require_once 'includes/error_handler.php'; // T.G
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

//$stmt = $pdo->query("SELECT id, username FROM users");
//$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Menaxho Përdoruesit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
   <h1>Lista e Përdoruesve (AJAX)</h1>

<table id="users-table" class="user-table" border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Emri i përdoruesit</th>
            <th>Email</th>
            <th>Roli</th>
            <th>Veprime</th>
        </tr>
    </thead>
    <tbody>
        <!-- Mbushet automatikisht nga AJAX -->
    </tbody>
</table>

    <br><br>
    <a href="insert_user.php">➕ Shto Përdorues të Ri</a>
    <br><br>
    <a href="admin_dashboard.php">⟵ Kthehu te Paneli</a>
</body>
</html>
