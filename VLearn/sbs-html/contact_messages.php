<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Fshirja e mesazhit me ID
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
    $stmt->execute([$delete_id]);
    header("Location: contact_messages.php");
    exit;
}

// Nxjerr mesazhet nga DB
$stmt = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC");
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Shiko Mesazhet e Kontaktit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Mesazhet e Kontaktit</h1>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Emri</th>
            <th>Email</th>
            <th>Telefoni</th>
            <th>Subjekti</th>
            <th>Mesazhi</th>
            <th>Krijuar më</th>
            <th>Veprime</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($messages as $msg): ?>
            <tr>
                <td><?= htmlspecialchars($msg['name']) ?></td>
                <td><?= htmlspecialchars($msg['email']) ?></td>
                <td><?= htmlspecialchars($msg['phone']) ?></td>
                <td><?= htmlspecialchars($msg['subject']) ?></td>
                <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
                <td><?= $msg['created_at'] ?></td>
                <td>
                    <a href="edit_contact_message.php?id=<?= $msg['id'] ?>">Edit</a> |
                    <a href="contact_messages.php?delete_id=<?= $msg['id'] ?>" onclick="return confirm('A jeni të sigurt që doni ta fshini këtë mesazh?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="admin_dashboard.php">Kthehu te Paneli i Adminit</a>
</body>
</html>
