<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Menaxho Përdoruesin</title>
</head>
<body>
  <h2>Menaxho Username-in e një Përdoruesi</h2>

  <label for="userId">ID e Përdoruesit:</label>
  <input type="number" id="userId" />
  <button onclick="getUser()">Shfaq</button>

  <div id="userSection" style="display:none; margin-top: 20px;">
    <p>Email: <span id="userEmail"></span></p>
    <label for="username">Username:</label>
    <input type="text" id="username" />
    <button onclick="updateUsername()">Përditëso</button>
  </div>

  <div id="message"></div>

  <script>
    function getUser() {
      const id = document.getElementById('userId').value;
      fetch('get_user.php?id=' + id)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            document.getElementById('userEmail').innerText = data.email;
            document.getElementById('username').value = data.username;
            document.getElementById('userSection').style.display = 'block';
          } else {
            document.getElementById('message').innerText = data.message;
            document.getElementById('userSection').style.display = 'none';
          }
        });
    }

    function updateUsername() {
      const id = document.getElementById('userId').value;
      const username = document.getElementById('username').value;

      fetch('updatee_user.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}&username=${encodeURIComponent(username)}`
      })
      .then(response => response.json())
      .then(data => {
        document.getElementById('message').innerText = data.message;
      });
    }
  </script>
</body>
</html>