<?php
require_once 'includes/error_handler.php';//T.G
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // kripton passwordin
    $role = $_POST['role'];

    // Kontroll nëse ekziston përdoruesi
    $check = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $check->execute([$username]);
    if ($check->rowCount() > 0) {
        echo "Përdoruesi ekziston tashmë.";
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$username, $password, $role]);

    header("Location: admin_dashboard.php");
    exit;
} else {
    echo "Kërkesa nuk është POST!";
}
//trajtimi i gabimeve A.Z
f ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (empty($username) || empty($password)) {
        shfaqGabim("Ju lutem plotësoni të gjitha fushat.");
        exit;
    }
    if (strlen($password) < 6) {
    shfaqGabim("Fjalëkalimi duhet të ketë të paktën 6 karaktere.");
    exit;
}


    // Kontrollo nëse ekziston
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->rowCount() > 0) {
        shfaqGabim("Ky emër përdoruesi është i zënë. Ju lutem provoni një tjetër.");
        exit;
    }

    // Try to insert
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT), $role]);
        header("Location: admin_dashboard.php");
        exit;
    } catch (PDOException $e) {
        shfaqGabim("Ndodhi një gabim gjatë ruajtjes në databazë.");
        exit;
    }
}
?>
<style>
    .gabim {
        color: red;
        background-color: #ffe6e6;
        border: 1px solid red;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        font-weight: bold;
    }
</style>
<?php
function shfaqGabim($mesazh) {
    echo "<div class='gabim'><strong>Gabim:</strong> $mesazh</div>";
}
echo "<div class='gabim'>Ky është një gabim i personalizuar</div>";
?>

