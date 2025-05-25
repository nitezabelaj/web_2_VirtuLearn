<?php
require_once __DIR__ . '/../config.php'; // sigurohu që rruga është e saktë

header("Content-Type: application/json");

// Verifikimi i kërkesës (GET, POST, etj.)
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Merr të gjitha produktet nga DB
    $sql = "SELECT * FROM products";
    try {
        $stmt = $pdo->query($sql);
        $products = $stmt->fetchAll();
        echo json_encode($products);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Gabim gjatë marrjes së produkteve: " . $e->getMessage()]);
    }
} else {
    http_response_code(405); // Metoda jo e lejuar
    echo json_encode(["error" => "Metoda $method nuk lejohet."]);
}
?>
