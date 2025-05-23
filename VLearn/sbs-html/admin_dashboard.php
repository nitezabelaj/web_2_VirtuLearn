<?php
// admin_dashboard.php

session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}



$adminName = sanitizeInput($_SESSION['username']);
?>

<!-- Tani fillon HTML jashtë PHP-së -->
<td>
    <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('A je i sigurt që do ta fshish këtë përdorues?');">🗑️ Fshi</a>
    |
    <a href="update_user.php?id=<?= $user['id'] ?>">✏️ Përditëso</a>
</td>

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

<?php
// fshirja e perdorueseve nga DB
require 'config.php';

$stmt = $pdo->query("SELECT id, username FROM users");
$users = $stmt->fetchAll();
?>

<h2>Lista e Përdoruesve</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Emri</th>
        <th>Veprime</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= htmlspecialchars($user['id']) ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td>
            <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('A je i sigurt që do ta fshish këtë përdorues?');">Fshi</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

