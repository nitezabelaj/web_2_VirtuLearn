<?php
// admin_dashboard.php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require 'config.php';

$adminName = htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Paneli i Administratorit</h1>
    </header>

    <main>
        <p>Përshëndetje, <strong><?= $adminName ?></strong>! Jeni kyçur si <em>admin</em>.</p>
        
        <section>
            <h2>Opsionet e Administrimit</h2>
            <ul>
                <li><a href="manage_users.php">Menaxho Përdoruesit</a></li>
                <li><a href="manage_products.php">Menaxho Produktet</a></li>
                <li><a href="contact_messages.php">Shiko Mesazhet e Kontaktit</a></li>
                <li><a href="logout.php">Dil</a></li>
            </ul>
        </section>
    </main>
</body>
</html>
