<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Ky seksion është vetëm për administratorë.");
}

$mysqli = new mysqli("localhost", "root", "", "virtu_learn");
if ($mysqli->connect_error) {
    die("Lidhja me DB dështoi: " . $mysqli->connect_error);
}

$query = "
    SELECT u.username, ub.deck, ub.wheels, ub.trucks, ub.color, ub.updated_at
    FROM user_builds ub
    JOIN users u ON u.id = ub.user_id
    ORDER BY ub.updated_at DESC
";

$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Preferencat e Përdoruesve</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container my-5">
    <h1 class="mb-4">🛹 Preferencat e Përdoruesve për Skateboard</h1>

    <?php if ($result && $result->num_rows > 0): ?>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Përdoruesi</th>
                    <th>Deck</th>
                    <th>Wheels</th>
                    <th>Trucks</th>
                    <th>Ngjyra</th>
                    <th>Ndryshuar më</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['deck']) ?></td>
                        <td><?= htmlspecialchars($row['wheels']) ?></td>
                        <td><?= htmlspecialchars($row['trucks']) ?></td>
                        <td>
                            <div style="width: 20px; height: 20px; background-color: <?= htmlspecialchars($row['color']) ?>; border: 1px solid #000;"></div>
                            <?= htmlspecialchars($row['color']) ?>
                        </td>
                        <td><?= htmlspecialchars($row['updated_at']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Asnjë përdorues nuk ka konfiguruar ende skateboard-in e tij.</div>
    <?php endif; ?>
</div>
</body>
</html>
