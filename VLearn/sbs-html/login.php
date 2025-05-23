<?php
session_start(); // DUHET të jetë i pari në skedar

// AnitaC - P2 / Sessions

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

const SITE_TIME = "SkatingBoardSchool";

// Menu dinamike
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

    // Hiq "Login" dhe "Register"
    unset($menu_items['login.php'], $menu_items['register.php']);
}

// Funksion për të krijuar menunë
function generateMenu($items) {
    $current = basename($_SERVER['PHP_SELF']);
    foreach ($items as $link => $label) {
        $isActive = ($current === basename($link)) ? " active" : "";
        echo "<li class='nav-item$isActive'><a class='nav-link' href='$link'>$label</a></li>";
    }
}

// Funksion për redirektim sipas rolit
function redirect_logged_user($role) {
    if ($role === 'admin') {
        header('Location: admin_dashboard.php');
    } else {
        header('Location: dashboard.php');
    }
    exit;
}

// Login logjika
$errors = [];
$email_or_username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_or_username = trim($_POST['email_or_username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email_or_username || !$password) {
        $errors[] = "Ju lutem plotësoni të gjitha fushat.";
    }

    if (empty($errors)) {
        // Kërko përdoruesin me email ose username
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email OR username = :username LIMIT 1");
        $stmt->execute([
            'email' => $email_or_username,
            'username' => $email_or_username
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $errors[] = "Përdoruesi nuk ekziston.";
        } elseif (!password_verify($password, $user['password'])) {
            $errors[] = "Fjalëkalimi është i gabuar.";
        } else {
            // Sukses – ruaj sesionin
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            redirect_logged_user($user['role']);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Login - <?= SITE_TIME ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <nav>
        <ul style="list-style: none; display: flex; gap: 10px;">
            <?php generateMenu($menu_items); ?>
        </ul>
    </nav>
</header>

<main>
    <h2>Kyçu</h2>

    <?php if ($errors): ?>
        <ul style="color:red;">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="">
        <input type="text" name="email_or_username" placeholder="Email ose Username" required
               value="<?= htmlspecialchars($email_or_username) ?>"><br>
        <input type="password" name="password" placeholder="Fjalëkalimi" required><br>
        <button type="submit">Kyçu</button>
    </form>

    <p>Nuk ke llogari? <a href="register.php">Regjistrohu këtu</a>.</p>
</main>

</body>
</html>