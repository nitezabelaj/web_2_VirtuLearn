<?php
require 'config.php';

if (!isset($_GET['id'])) {
    echo "ID e përdoruesit mungon!";
    exit;
}

$id = $_GET['id'];

// Merr të dhënat ekzistuese të përdoruesit
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Përdoruesi nuk u gjet.";
    exit;
}
if (isset($_POST['update'])) {
    $newUsername = $_POST['username'];

    $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
    $stmt->execute([$newUsername, $id]);

    header("Location: admin_dashboard.php");
    exit;
}
?>

<h2>Përditëso Përdoruesin</h2>
<form method="POST" action="update_user.php?id=<?= $id ?>">
    <label>Emri i ri:</label>
    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
    <button type="submit" name="update">Përditëso</button>
</form>
