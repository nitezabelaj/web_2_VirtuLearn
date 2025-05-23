<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    header("Location: contact_messages.php");
    exit;
}

// Ngarko të dhënat ekzistuese
$stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
$stmt->execute([$id]);
$message = $stmt->fetch();

if (!$message) {
    header("Location: contact_messages.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $msgText = htmlspecialchars(trim($_POST['message']));

    $stmt = $pdo->prepare("UPDATE contacts SET name = ?, email = ?, phone = ?, subject = ?, message = ? WHERE id = ?");
    $stmt->execute([$name, $email, $phone, $subject, $msgText, $id]);

    header("Location: contact_messages.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Edit Mesazhin e Kontaktit</title>
</head>
<body>
<h1>Edit Mesazhin</h1>

<form method="post">
    <label>Emri:<br><input type="text" name="name" value="<?= htmlspecialchars($message['name']) ?>" required></label><br><br>
    <label>Email:<br><input type="email" name="email" value="<?= htmlspecialchars($message['email']) ?>" required></label><br><br>
    <label>Telefoni:<br><input type="text" name="phone" value="<?= htmlspecialchars($message['phone']) ?>" required></label><br><br>
    <label>Subjekti:<br><input type="text" name="subject" value="<?= htmlspecialchars($message['subject']) ?>"></label><br><br>
    <label>Mesazhi:<br><textarea name="message" rows="5"><?= htmlspecialchars($message['message']) ?></textarea></label><br><br>
    <button type="submit">Përditëso</button>
</form>

<a href="contact_messages.php">Kthehu te Mesazhet</a>
</body>
</html>
