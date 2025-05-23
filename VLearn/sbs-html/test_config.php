<?php
require_once 'config.php';

//Anita C - test qe lidhja e config.php me databazen eshte ne rregull

try {
    $stmt = $pdo->query("SELECT COUNT(*) AS total_users FROM users");
    $row = $stmt->fetch();
    echo "Numri total i përdoruesve: " . $row['total_users'];
} catch (PDOException $e) {
    echo "Gabim në query: " . $e->getMessage();
}
?>

