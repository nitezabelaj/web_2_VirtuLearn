<?php
require_once 'includes/error_handler.php';//T.G
session_start();
require_once 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Përgjigja me email
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_submit'])) {
    $reply_to = filter_var($_POST['reply_to_email'], FILTER_VALIDATE_EMAIL);
    $reply_message = trim($_POST['reply_message']);
    $reply_name = htmlspecialchars($_POST['reply_name']);

    if ($reply_to && $reply_message) {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'anitacacaaj@gmail.com';  // vendos Gmail-in tënd
            $mail->Password = 'tibm pqxn noic eevj';    // app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('anitacacaaj@gmail.com', 'Admin SkatingBoardSchool');
            $mail->addAddress($reply_to, $reply_name);

            $mail->isHTML(true);
            $mail->Subject = "Përgjigje nga SkatingBoardSchool";
            $mail->Body = nl2br(htmlspecialchars($reply_message));

            $mail->send();
            $success_message = "Përgjigja u dërgua me sukses tek $reply_to";
        } catch (Exception $e) {
            $error_message = "Gabim gjatë dërgimit të përgjigjes: {$mail->ErrorInfo}";
        }
    } else {
        $error_message = "Ju lutem plotësoni të gjitha fushat e përgjigjes!";
    }
}

// Fshirja e mesazhit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
    if ($stmt->execute([$delete_id])) {
        $success_message = "Mesazhi me ID $delete_id u fshi me sukses.";
    } else {
        $error_message = "Gabim gjatë fshirjes së mesazhit.";
    }
}

// Nxirr mesazhet
$stmt = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC");
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Shiko Mesazhet e Kontaktit</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .modal {
            display: none; position: fixed; z-index: 10; padding-top: 100px; 
            left: 0; top: 0; width: 100%; height: 100%; overflow: auto; 
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fff; margin: auto; padding: 20px;
            border: 1px solid #888; width: 400px; border-radius: 5px;
        }
        .close {
            color: #aaa; float: right; font-size: 28px; font-weight: bold;
        }
        .close:hover, .close:focus { color: black; cursor: pointer; }
        form.inline { display: inline; }
        button.deleteBtn {
            background-color: #f44336; 
            color: white; border: none; padding: 6px 12px; cursor: pointer;
            border-radius: 3px;
        }
        button.deleteBtn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <h1>Mesazhet e Kontaktit</h1>

    <?php if (!empty($success_message)): ?>
        <p style="color:green;"><?= htmlspecialchars($success_message) ?></p>
    <?php endif; ?>
    <?php if (!empty($error_message)): ?>
        <p style="color:red;"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th><th>Emri</th><th>Email</th><th>Telefoni</th><th>Subjekti</th><th>Mesazhi</th><th>Data</th><th>Veprime</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $msg): ?>
                <tr>
                    <td><?= htmlspecialchars($msg['id']) ?></td>
                    <td><?= htmlspecialchars($msg['name']) ?></td>
                    <td><?= htmlspecialchars($msg['email']) ?></td>
                    <td><?= htmlspecialchars($msg['phone']) ?></td>
                    <td><?= htmlspecialchars($msg['subject']) ?></td>
                    <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
                    <td><?= htmlspecialchars($msg['created_at']) ?></td>
                    <td>
                        <button class="replyBtn"
                            data-email="<?= htmlspecialchars($msg['email']) ?>"
                            data-name="<?= htmlspecialchars($msg['name']) ?>"
                        >Përgjigju</button>

                        <form method="POST" class="inline" onsubmit="return confirm('A jeni i sigurt që doni ta fshini këtë mesazh?');">
                            <input type="hidden" name="delete_id" value="<?= $msg['id'] ?>">
                            <button type="submit" class="deleteBtn">Fshi</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p><a href="admin_dashboard.php">Kthehu në Dashboard</a></p>

    <!-- Modal për përgjigjen -->
    <div id="replyModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Përgjigju përdoruesit</h2>
            <form method="POST" id="replyForm">
                <input type="hidden" name="reply_to_email" id="reply_to_email" required>
                <input type="hidden" name="reply_name" id="reply_name">
                <label for="reply_message">Mesazhi:</label><br>
                <textarea name="reply_message" id="reply_message" rows="6" style="width: 100%;" required></textarea><br><br>
                <button type="submit" name="reply_submit">Dërgo Përgjigjen</button>
            </form>
        </div>
    </div>

    <script>
        var modal = document.getElementById("replyModal");
        var span = document.getElementsByClassName("close")[0];

        document.querySelectorAll('.replyBtn').forEach(function(btn){
            btn.onclick = function() {
                document.getElementById('reply_to_email').value = btn.getAttribute('data-email');
                document.getElementById('reply_name').value = btn.getAttribute('data-name');
                document.getElementById('reply_message').value = "";
                modal.style.display = "block";
            };
        });

        span.onclick = function() {
            modal.style.display = "none";
        };

        window.onclick = function(event) {
            if(event.target == modal) {
                modal.style.display = "none";
            }
        };
    </script>
</body>
</html>
