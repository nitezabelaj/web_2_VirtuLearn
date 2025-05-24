<?php
require_once 'includes/error_handler.php';
session_start();

// Kontrollo nëse përdoruesi është tashmë i kyçur
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin_dashboard.php');
    } else {
        header('Location: dashboard.php');
    }
    exit;
}

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
    "register.php" => "Register",
    "build_skateboard.php" => "Build your Skateboard"
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
$email_or_username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_or_username = trim($_POST['email_or_username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email_or_username) || empty($password)) {
        shfaqGabim("Ju lutem plotësoni të gjitha fushat.", 'kritike');
    } else {
        try {
            // Kërko përdoruesin me email ose username
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email OR username = :username LIMIT 1");
            $stmt->execute([
                'email' => $email_or_username,
                'username' => $email_or_username
            ]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                shfaqGabim("Përdoruesi nuk u gjet. Kontrolloni emailin ose username-in.", 'paralajmerim');
            } elseif (!password_verify($password, $user['password'])) {
                shfaqGabim("Fjalëkalimi i dhënë është i pasaktë.", 'paralajmerim');
            } elseif ($user['is_active'] == 0) {
                shfaqGabim("Llogaria juaj është e çaktivizuar. Ju lutem kontaktoni administratorin.", 'kritike');
            } else {
                // Kyçja e suksesshme
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                // Regjistro hyrjen e suksesshme
                $stmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                $stmt->execute([$user['id']]);
                
                shfaqSukses("Mirësevini, " . htmlspecialchars($user['username']) . "! Ju jeni kyçur me sukses.");
                
        } catch (PDOException $e) {
            shfaqGabim("Gabim në lidhje me bazën e të dhënave. Ju lutem provoni përsëri më vonë.", 'kritike');
            error_log("Gabim në login: " . $e->getMessage());
        }
    }
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

    <div class="mt-3 text-center">
        <p>Nuk ke llogari? <a href="register.php">Regjistrohu këtu</a>.</p>
        <p><a href="forgot_password.php">Keni harruar fjalëkalimin?</a></p>
    </div>
</main>

<!-- Bootstrap JS dhe Popper.js -->
<script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>