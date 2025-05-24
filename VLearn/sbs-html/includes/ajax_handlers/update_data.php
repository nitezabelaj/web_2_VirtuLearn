<?php
//ajax p2 A.Z
require_once __DIR__ . '/../../config.php';
header('Content-Type: application/json');

try {
    session_start();
    
    // Kontrollo CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        throw new Exception('Token CSRF i pavlefshëm', 403);
    }

    // Kontrollo aksesin e administratorit
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        throw new Exception('Akses i paautorizuar', 403);
    }

    $action = $_POST['action'] ?? '';

    switch($action) {
        case 'update_user_role':
            $userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
            $newRole = filter_input(INPUT_POST, 'new_role', FILTER_SANITIZE_STRING);
            
            if (!$userId || !in_array($newRole, ['user', 'admin'])) {
                throw new Exception('Të dhëna të pavlefshme', 400);
            }
            
            $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
            $stmt->execute([$newRole, $userId]);
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Roli u përditësua me sukses',
                'user_id' => $userId,
                'new_role' => $newRole
            ]);
            break;
            
        case 'update_product':
            // Implementimi për produktet
            break;
            
        default:
            throw new Exception('Veprim i pavlefshëm', 400);
    }
    
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