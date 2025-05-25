<?php
require_once 'includes/error_handler.php';//T.G
session_start(); // DUHET të jetë i pari në skedar
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
        //perdorimi i try catch throw...
       try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email OR username = :username LIMIT 1");
    $stmt->execute([
        'email' => $email_or_username,
        'username' => $email_or_username
    ]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception("Përdoruesi nuk u gjet.");
    }

    if (!password_verify($password, $user['password'])) {
        throw new Exception("Fjalëkalimi nuk përputhet.");
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];
    redirect_logged_user($user['role']);

} catch (Exception $e) {
    $errors[] = $e->getMessage();
}

        ?>
        
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Login - <?= SITE_TIME ?></title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Custom Style -->
    <link rel="stylesheet" href="css/style.css">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php"><?= SITE_TIME ?></a>
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

<main class="container my-5" style="max-width: 420px;">
    <h2 class="mb-4">Kyçu</h2>

    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="email_or_username" class="form-label">Email ose Username</label>
            <input type="text" class="form-control" id="email_or_username" name="email_or_username" required
                   value="<?= htmlspecialchars($email_or_username) ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Fjalëkalimi</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Kyçu</button>
    </form>

    <p class="mt-3 text-center">Nuk ke llogari? <a href="register.php">Regjistrohu këtu</a>.</p>
</main>
<!-- Bootstrap JS dhe Popper.js (nëse përdor Bootstrap 5) -->
<script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>
