<?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=virtu_learn", "root", "");

$stmt = $pdo->query("
    SELECT sc.user_id, u.username, sc.product_name, sc.product_price, sc.product_image_url, sc.added_at
    FROM shopping_cart sc
    JOIN users u ON sc.user_id = u.id
    ORDER BY sc.added_at DESC
");
$shoppingData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin View - Shopping Cart</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        img { width: 80px; }
        h2 { margin-top: 30px; }
    </style>
</head>
<body>

<h2>Users who have added products to the shopping cart</h2>

<table>
    <thead>
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Product</th>
            <th>Price</th>
            <th>Image</th>
            <th>Added At</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($shoppingData as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['user_id']) ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['product_name']) ?></td>
                <td>$<?= number_format($row['product_price'], 2) ?></td>
                <td><img src="<?= htmlspecialchars($row['product_image_url']) ?>" alt=""></td>
                <td><?= $row['added_at'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
