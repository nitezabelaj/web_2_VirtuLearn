<?php
require_once 'includes/error_handler.php'; // T.G
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->query("SELECT id, username FROM users");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Menaxho Përdoruesit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Lista e Përdoruesve</h1>
    <table class="user-table" border="1">
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
                <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('A je i sigurt që do ta fshish këtë përdorues?');">🗑️ Fshi</a>
                |
                <a href="update_user.php?id=<?= $user['id'] ?>">✏️ Përditëso</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <br><br>
    <a href="insert_user.php">➕ Shto Përdorues të Ri</a>
    <br><br>
    <a href="admin_dashboard.php">⟵ Kthehu te Paneli</a>
</body>
</html>
