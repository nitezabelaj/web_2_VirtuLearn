<?php
$host = 'localhost';
$dbname = 'virtu_learn';
$username = 'root';  
$password = '';      

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Lidhja me databazën dështoi: " . $e->getMessage());
}

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>