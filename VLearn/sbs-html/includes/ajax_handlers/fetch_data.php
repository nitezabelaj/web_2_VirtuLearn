<?php
require_once __DIR__ . '/../../config.php';
header('Content-Type: application/json');

try {
    session_start();
    
    // Kontrollo aksesin e administratorit
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        throw new Exception('Akses i paautorizuar', 403);
    }

    $requestType = $_GET['type'] ?? '';

    switch($requestType) {
        case 'users':
            $stmt = $pdo->prepare("SELECT id, username, role FROM users ORDER BY created_at DESC");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;
            
        case 'products':
            $stmt = $pdo->prepare("SELECT id, name, price FROM products ORDER BY created_at DESC");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;
            
        default:
            throw new Exception('Lloj i pavlefshëm i kërkesës', 400);
    }

    echo json_encode([
        'status' => 'success',
        'data' => $data,
        'timestamp' => time()
    ]);
    
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
        'error_code' => $e->getCode()
    ]);
}
case 'delete_user':
    $userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    
    if (!$userId) {
        throw new Exception('ID e përdoruesit është e pavlefshme', 400);
    }
    
    // Kontrollo nëse përdoruesi po fshin vetveten
    if ($userId == $_SESSION['user_id']) {
        throw new Exception('Nuk mund të fshini llogarinë tuaj', 400);
    }
    
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Përdoruesi u fshi me sukses'
    ]);
    break;
?>