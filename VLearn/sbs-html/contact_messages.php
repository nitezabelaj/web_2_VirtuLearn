<?php
// Lidhja me databazën
$conn = new mysqli("localhost", "root", "", "virtu_learn");

$result = $conn->query("SELECT * FROM contacts");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Mesazhet e Kontaktit</title>
  <style>
    table, th, td {
      border: 1px solid #999;
      border-collapse: collapse;
      padding: 8px;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      width: 400px;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
    }

    .close {
      float: right;
      font-size: 24px;
      cursor: pointer;
    }

    button {
      padding: 6px 12px;
      background-color: #2a8;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background-color: #1a6;
    }
  </style>
</head>
<body>

<h2>Mesazhet e Kontaktit</h2>

<table>
  <tr>
    <th>Emri</th>
    <th>Email</th>
    <th>Telefoni</th>
    <th>Subjekti</th>
    <th>Mesazhi</th>
    <th>Veprimi</th>
  </tr>

  <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= htmlspecialchars($row['phone']) ?></td>
      <td><?= htmlspecialchars($row['subject']) ?></td>
      <td><?= htmlspecialchars($row['message']) ?></td>
      <td><button onclick="openModal('<?= $row['email'] ?>')">Përgjigju</button></td>
    </tr>
  <?php } ?>
</table>

<!-- Modal -->
<div id="replyModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h3>Përgjigju përdoruesit</h3>
    <form method="POST" action="send_reply.php">
      <input type="hidden" name="to_email" id="to_email">
      <label>Mesazhi:</label><br>
      <textarea name="reply_message" rows="6" style="width: 100%;" required></textarea><br><br>
      <input type="submit" name="submit_reply" value="Dërgo Përgjigjen">
    </form>
  </div>
</div>

<script>
  function openModal(email) {
    document.getElementById('to_email').value = email;
    document.getElementById('replyModal').style.display = 'flex';
  }

  function closeModal() {
    document.getElementById('replyModal').style.display = 'none';
  }

  // Opsionale: mbyll modal kur klikon jashtë tij
  window.onclick = function(event) {
    const modal = document.getElementById('replyModal');
    if (event.target === modal) {
      closeModal();
    }
  }
</script>

</body>
</html>
