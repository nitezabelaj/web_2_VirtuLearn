<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "virtu_learn"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $newUsername = isset($_POST['username']) ? trim($_POST['username']) : '';

    if ($id > 0 && $newUsername !== '') {
        
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
        $stmt->bind_param("si", $newUsername, $id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Username ekziston tashmë.']);
            exit;
        }
        $stmt->close();

      
        $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->bind_param("si", $newUsername, $id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Username u përditësua me sukses.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gabim gjatë përditësimit.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Të dhënat nuk janë të plota.']);
    }
    $conn->close();
    exit;
}



$sql = "SELECT id, username, email, role, created_at FROM users";
$result = $conn->query($sql);

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
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td><input type='text' value='" . htmlspecialchars($row['username']) . "' onchange='updateUsername(" . intval($row['id']) . ", this.value)'></td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['role']) . "</td>";
            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Nuk u gjet asnjë përdorues</td></tr>";
    }
    $conn->close();
    ?>
</table>

<script>
function updateUsername(id, newUsername) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "manage_users.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        console.log("Përgjigjja nga serveri:", this.responseText);
     try {
    const response = JSON.parse(this.responseText);
    if (response.status === "success") {
        alert(response.message);
    } else {
        alert("Gabim: " + response.message);
    }
} catch (e) {
    alert("Gabim i paparashikuar nga serveri");
    console.error("Gabimi JSON:", e);
    console.log("Përgjigja e serverit:", this.responseText);
}
    }
    xhr.send("id=" + id + "&username=" + encodeURIComponent(newUsername));
}
</script>

</body>
</html>
