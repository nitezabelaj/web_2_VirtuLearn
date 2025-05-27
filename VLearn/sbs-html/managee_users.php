<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "virtu_learn");
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Lidhja dështoi: " . $conn->connect_error]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $username = trim($_POST['username']);

    if ($username === '') {
        echo json_encode(["status" => "error", "message" => "Username bosh!"]);
        exit;
    }

    $check = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
    $check->bind_param("si", $username, $id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Username ekziston!"]);
    } else {
        $update = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
        $update->bind_param("si", $username, $id);
        if ($update->execute()) {
            echo json_encode(["status" => "success", "message" => "Username u përditësua me sukses!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Gabim gjatë update: " . $conn->error]);
        }
    }

    exit;
}

$result = $conn->query("SELECT id, username, email, role, created_at FROM users");
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Menaxhimi i Përdoruesve</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #f2f2f2; }
        input { width: 90%; padding: 5px; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Paneli i Adminit – Menaxho Përdoruesit</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Roli</th>
        <th>U krijua më</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td>
            <input type="text" value="<?= htmlspecialchars($row['username']) ?>"
                   onchange="updateUsername(<?= $row['id'] ?>, this.value)">
        </td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= $row['role'] ?></td>
        <td><?= $row['created_at'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<script>
function updateUsername(id, newUsername) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "manage_users.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        try {
            const response = JSON.parse(this.responseText);
            if (response.status === "success") {
                alert(response.message);
            } else {
                alert("Gabim: " + response.message);
            }
        } catch {
            alert("Gabim i paparashikuar nga serveri");
        }
    }
    xhr.send("id=" + id + "&username=" + encodeURIComponent(newUsername));
}
</script>

</body>
</html>
