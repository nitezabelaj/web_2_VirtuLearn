<?php
// config.php
//Anita C - Opsionale: Lidhja me DB përmes një PHP skripte të jashtme
// Parametrat e lidhjes me DB
$host = 'localhost';
$dbname = 'virtu_learn';
$username = 'root';
$password = '';

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
    PDO::ATTR_EMULATE_PREPARES   => false,                  
];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, $options);
} catch (PDOException $e) {
    die("Lidhja me databazën dështoi: " . $e->getMessage());
}


function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
?>