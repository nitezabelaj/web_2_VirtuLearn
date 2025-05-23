<?php
require_once 'config.php';
session_start();

// Sigurohu që është admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID e përdoruesit mungon ose është e pavlefshme!";
    exit;
}

$id = intval($_GET['id']);

// Merr të dhënat ekzistuese të përdoruesit
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Përdoruesi nuk u gjet.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = trim($_POST['username'] ?? '');

    if ($newUsername !== '') {
        $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->execute([$newUsername, $id]);

        header("Location: manage_users.php");
        exit;
    } else {
        $error = "Emri nuk mund të jetë bosh.";
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Përditëso Përdoruesin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Përditëso Përdoruesin</h1>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="post">
        <label for="username">Emri i ri i përdoruesit:</label><br>
        <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>" required><br><br>
        <button type="submit">Përditëso</button>
    </form>

    <br>
    <a href="manage_users.php">⟵ Kthehu te Menaxho Përdoruesit</a>
</body>
</html>
