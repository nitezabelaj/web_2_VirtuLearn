<?php
session_start();
require_once 'config.php';

// Funksion sanitizeInput nëse nuk e ke në config.php
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Kontrolli i aksesit
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$adminName = sanitizeInput($_SESSION['username']);

$menu_items = [
    "index.php" => "Home",
    "about.php" => "About",
    "skating.php" => "Skating",
    "shop.php" => "Shop",
    "contact.php" => "Contact Us",
    "build_skateboard.php"=>"Build your Skateboard"
];

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        $menu_items['admin_dashboard.php'] = "Admin Panel";
    } else {
        $menu_items['dashboard.php'] = "Dashboard";
    }
    $menu_items['logout.php'] = "Logout";

    unset($menu_items['login.php'], $menu_items['register.php']);
}

function generateMenu($items) {
    $current = basename($_SERVER['PHP_SELF']);
    foreach ($items as $link => $label) {
        $isActive = ($current === basename($link)) ? " active" : "";
        echo "<li class='nav-item$isActive'><a class='nav-link' href='$link'>$label</a></li>";
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard - SkatingBoardSchool</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">SkatingBoardSchool</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php generateMenu($menu_items); ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="container my-5" style="max-width: 600px;">
    <h1 class="mb-4">Paneli i Administratorit</h1>
    <p>Përshëndetje, <strong><?= $adminName ?></strong>! Jeni kyçur si <em>admin</em>.</p>
<br>
<br>
<br>
<br>
    <section>
        <h2>Opsionet e Administrimit</h2>
        <ul class="list-group">
            <li class="list-group-item"><a href="manage_users.php">Menaxho Përdoruesit</a></li>
            <li class="list-group-item"><a href="manage_products.php">Menaxho Produktet</a></li>
            <li class="list-group-item"><a href="contact_messages.php">Shiko Mesazhet e Kontaktit</a></li>
            <li class="list-group-item"><a href="logout.php">Dil</a></li>
        </ul>
    </section>
</main>

 <!--Insertimi i perdorueseve te ri A.Z -->
<section class="container mt-5" style="max-width: 600px;">
    <h2 class="mb-4">Shto Përdorues të Ri</h2>
    <form action="insert_user.php" method="POST" class="border p-4 rounded shadow-sm bg-light">
        <div class="mb-3">
            <label for="username" class="form-label">Emri i përdoruesit</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Fjalëkalimi</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Roli</label>
            <select class="form-select" id="role" name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Shto</button>
    </form>
</section>



<!-- Bootstrap JS bundle -->
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
