<?php
require_once 'includes/error_handler.php';//T.G
// AnitaC - P2 / Sessions
session_start();
require_once 'config.php';


// Nëse përdoruesi nuk është i kyçur, ridrejtoje në login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Lista e faqeve në menu
$menu_items = [
    "index.php" => "Home",
    "about.php" => "About",
    "skating.php" => "Skating",
    "shop.php" => "Shop",
    "contact.php" => "Contact Us",
    "build_skateboard.php"=>"Build your Skateboard",
      "build_skateboard.php"=>"Build your Skateboard"
];

// Shto menunë sipas rolit të përdoruesit
if ($_SESSION['role'] === 'admin') {
    $menu_items['admin_dashboard.php'] = "Admin Panel";
} else {
    $menu_items['dashboard.php'] = "Dashboard";
}

$menu_items['logout.php'] = "Logout";

// Funksioni për menunë dinamike
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
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        nav ul { list-style: none; padding: 0; display: flex; gap: 10px; }
        nav li { display: inline; }
        nav a { text-decoration: none; color: #007BFF; }
        nav a:hover { text-decoration: underline; }
        .active a { font-weight: bold; }
    </style>
</head>
<body>

<nav>
    <ul>
        <?php generateMenu($menu_items); ?>
    </ul>
</nav>

<h2>Mirësevini, <?= htmlspecialchars($_SESSION['username']) ?></h2>
<p>Roli juaj: <?= htmlspecialchars($_SESSION['role']) ?></p>

</body>
</html>
