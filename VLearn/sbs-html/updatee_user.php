<?php
$conn = new mysqli("localhost", "root", "", "virtu_learn");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed"]);
    exit;
}

$id = intval($_POST['id']);
$username = trim($_POST['username']);

if (empty($username)) {
    echo json_encode(["success" => false, "message" => "Username cannot be empty"]);
    exit;
}


$check = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
$check->bind_param("si", $username, $id);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Username already taken"]);
} else {
    $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
    $stmt->bind_param("si", $username, $id);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Username updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Update failed"]);
    }
}
$conn->close();