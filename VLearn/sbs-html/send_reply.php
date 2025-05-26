<?php
session_start();
require_once 'config.php';
require_once 'includes/error_handler.php';

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit_reply'])) {
    $toEmail = sanitizeInput($_POST['to_email'] ?? '');
    $replyMessage = sanitizeInput($_POST['reply_message'] ?? '');

    if (!$toEmail || !$replyMessage) {
        echo "<script>alert('Emaili ose mesazhi mungon!'); window.history.back();</script>";
        exit;
    }

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // rregulluar
        $mail->SMTPAuth = true;
        $mail->Username = 'anitacacaaj@gmail.com';
        $mail->Password = 'tibm pqxn noic eevj'; // sigurohu që është App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('anitacacaaj@gmail.com', 'VirtuLearn - Admin');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = "Përgjigje nga VirtuLearn";
        $mail->Body    = "
            <p><strong>Përshëndetje,</strong></p>
            <p>$replyMessage</p>
            <br>
            <p>Me respekt,<br>Administrata e VirtuLearn</p>
        ";

        $mail->send();

        $_SESSION['success_message'] = "Përgjigjja u dërgua me sukses!";
        header("Location: contact_messages.php");
        exit;

    } catch (Exception $e) {
        echo "<script>alert('Dështoi dërgimi i emailit: {$mail->ErrorInfo}'); window.history.back();</script>";
    }
}
