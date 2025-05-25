<?php
require_once 'config.php';
header('Content-Type: application/json');

// Lexo të dhënat JSON nga AJAX
$data = json_decode(file_get_contents("php://input"), true);

// Kontrolli nëse të dhënat ekzistojnë
if (!isset($data['id']) || !isset($data['role'])) {
    echo json_encode(['success' => false, 'error' => 'Të dhëna të paplota.']);
    exit;
}

$id = intval($data['id']);
$role = $conn->real_escape_string($data['role']);

// Verifiko që roli është valid
if (!in_array($role, ['admin', 'user'])) {
    echo json_encode(['success' => false, 'error' => 'Roli i pavlefshëm.']);
    exit;
}

// Përditëso rolin në databazë
$sql = "UPDATE users SET role = '$role' WHERE id = $id";
if ($conn->query($sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Gabim gjatë përditësimit.']);
}
?>
