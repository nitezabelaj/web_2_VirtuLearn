<?php
$conn = new mysqli("localhost", "root", "", "virtu_learn");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed"]);
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        "success" => true,
        "username" => $row['username'],
        "email" => $row['email']
    ]);
} else {
    echo json_encode(["success" => false, "message" => "User not found"]);
}
$conn->close();