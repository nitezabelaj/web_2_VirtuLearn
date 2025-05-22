<?php
session_start();

//AnitaC - P2 / Sessions
require 'config.php';


const SITE_TIME = "SkatingBoardSchool";

$menu_items = [
   "index.php" => "Home",
   "about.php" => "About",
   "skating.php" => "Skating",
   "shop.php" => "Shop",
   "contact.php" => "Contact Us",
   "login.php" => "Login",
   "register.php" => "Register"
];

if (isset($_SESSION['user_id'])) {
   if ($_SESSION['role'] === 'admin') {
       $menu_items['admin_dashboard.php'] = "Admin Panel";
   } else {
       $menu_items['dashboard.php'] = "Dashboard";
   }
   $menu_items['logout.php'] = "Logout";
}

function generateMenu($items) {
   $current = basename($_SERVER['PHP_SELF']);
   foreach ($items as $link => $label) {
       $isActive = ($current === basename($link)) ? " active" : "";
       echo "<li class='nav-item$isActive'><a class='nav-link' href='$link'>$label</a></li>";
   }
}

// Formulari i regjistrimit
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if (!$username || !$email || !$password) {
        $errors[] = "Të gjitha fushat janë të detyrueshme.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email i pavlefshëm.";
    }
    if ($password !== $password_confirm) {
        $errors[] = "Fjalëkalimet nuk përputhen.";
    }

    if (empty($errors)) {
        // Kontrollo nëse emaili ekziston
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "Emaili është përdorur më parë.";
        } else {
            // Shto në databazë
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, 'user', NOW())");
            $stmt->execute([$username, $email, $password_hash]);

            header('Location: login.php?registered=1');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Regjistrimi</title>
    <link rel="stylesheet" href="style.css"> <!-- Opsionale nëse ke CSS -->
</head>
<body>

<!-- Header me menu -->
<header>
    <nav>
        <ul style="list-style: none; display: flex; gap: 10px;">
            <?php generateMenu($menu_items); ?>
        </ul>
    </nav>
</header>

<main>
    <h2>Regjistrimi</h2>

    <?php if ($errors): ?>
        <ul style="color:red;">
            <?php foreach ($errors as $error) echo "<li>$error</li>"; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" required value="<?=htmlspecialchars($username ?? '')?>"><br>
        <input type="email" name="email" placeholder="Email" required value="<?=htmlspecialchars($email ?? '')?>"><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="password_confirm" placeholder="Confirm Password" required><br>
        <button type="submit">Regjistrohu</button>
    </form>

    <p><a href="login.php">Keni llogari? Kyçu këtu.</a></p>
</main>

</body>
</html>
