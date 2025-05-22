<?php
//AnitaC - P2 / Sessions
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'config.php';
session_start();


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
   $menu_items['dashboard.php'] = "Dashboard";
   $menu_items['logout.php'] = "Logout";
}


function generateMenu($items) {
   $current = basename($_SERVER['PHP_SELF']);
   foreach ($items as $link => $label) {
       $isActive = ($current === basename($link)) ? " active" : "";
       echo "<li class='nav-item$isActive'><a class='nav-link' href='$link'>$label</a></li>";
   }
}



// ========== Login Logjika ==========
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        $errors[] = "Ju lutem plotësoni të gjitha fushat.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header('Location: dashboard.php');
            exit;
        } else {
            $errors[] = "Email ose fjalëkalim i gabuar.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Login | <?= SITE_TIME ?></title>
    <link rel="stylesheet" href="styles.css"> <!-- Shto nëse ke file CSS -->
</head>
<body>

<!-- Header / Navbar -->
<header>
    <nav>
        <ul style="list-style:none; display:flex; gap:15px;">
            <?php generateMenu($menu_items); ?>
        </ul>
    </nav>
</header>

<!-- Përmbajtja -->
<main>
    <h2>Kyçja</h2>

    <?php if (isset($_GET['registered'])): ?>
        <p style='color:green;'>Regjistrimi u krye me sukses. Kyçu tani.</p>
    <?php endif; ?>

    <?php if ($errors): ?>
        <ul style="color:red;">
            <?php foreach ($errors as $error) echo "<li>$error</li>"; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="">
        <input type="email" name="email" placeholder="Email" required value="<?= htmlspecialchars($email ?? '') ?>"><br><br>
        <input type="password" name="password" placeholder="Fjalëkalimi" required><br><br>
        <button type="submit">Kyçu</button>
    </form>
    <p>Nuk ke llogari? <a href="register.php">Regjistrohu</a></p>
</main>

</body>
</html>
