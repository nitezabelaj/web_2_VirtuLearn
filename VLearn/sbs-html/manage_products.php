<?php
// menaxho_produktet.php
require_once 'config.php';

try {
    $stmt = $pdo->query("
        SELECT 
    u.username AS user,
    p.name AS product,
    p.price,
    up.quantity,
    (p.price * up.quantity) AS total_price
FROM 
    user_products up
JOIN 
    users u ON up.user_id = u.id
JOIN 
    products p ON up.product_id = p.id
ORDER BY 
    u.username ASC, p.name ASC;

    ");
    $results = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Gabim gjatë marrjes së të dhënave: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Menaxho Produktet</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="text-center text-primary mb-4">Menaxho Produktet</h1>

    <div class="table-responsive">
        <table class="table table-striped table-hover shadow">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Përdoruesi</th>
                    <th scope="col">Produkti</th>
                    <th scope="col">Çmimi</th>
                    <th scope="col">Sasia</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['product_name']) ?></td>
                        <td><?= number_format($row['price'], 2) ?> €</td>
                        <td><?= htmlspecialchars($row['quantity']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer class="text-center mt-4 text-muted">
        &copy; <?= date("Y") ?> SkatingBoardSchool - Të drejtat e rezervuara.
    </footer>
</div>

<!-- Bootstrap 5 JS (Opsionale për funksione si collapse, modal, etj.) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>