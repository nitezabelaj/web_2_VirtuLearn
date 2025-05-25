<?php
//Anita C - Dërgimi i emailave përmes një forme standarde
//ME RËNDËSI: përdorimi i PHP Email për dërgim të emailit nga një
//email i zakonshëm (gmail, yahoo, hotmail. )
require_once 'config.php';
require_once 'includes/error_handler.php';//per trajtimin e gabimeve A.Z
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $name = sanitizeInput($_POST['name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $subject = sanitizeInput($_POST['subject'] ?? '');
    $message = sanitizeInput($_POST['message'] ?? '');

    if (!$name || !$email || !$phone || !$subject) {
        echo "<script>alert('Ju lutem plotësoni të gjitha fushat e kërkuara!'); window.history.back();</script>";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $subject, $message]);

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'anitacacaaj@gmail.com';
            $mail->Password = 'tibm pqxn noic eevj';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('anitacacaaj@gmail.com', 'Contact Form');
            $mail->addAddress('anitacacaaj@gmail.com');

            $mail->isHTML(true);
            $mail->Subject = "Mesazh i ri nga forma e kontaktit";
            $mail->Body    = "
                <strong>Emri:</strong> $name<br>
                <strong>Email:</strong> $email<br>
                <strong>Telefoni:</strong> $phone<br>
                <strong>Subjekti:</strong> $subject<br>
                <strong>Mesazhi:</strong><br>$message
            ";

            $mail->send();
            echo "<script>alert('Mesazhi u dërgua dhe u ruajt me sukses!'); window.location.href='contact.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Gabim gjatë dërgimit të emailit: {$mail->ErrorInfo}'); window.history.back();</script>";
        }
    }
}
/*
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email'], $_POST['subject'], $_POST['message'])) {
    $to = "admin@skatingschool.com";
    $subject = "Kontakt nga: " . $_POST['email'];
    $message = "Subjekti: " . $_POST['subject'] . "\n\nMesazhi:\n" . $_POST['message'];

    $headers = "From: noreply@skatingschool.com\r\n";
    $headers .= "Reply-To: " . $_POST['email'] . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $additional_parameters = "-fwebmaster@skatingschool.com";

    @mail($to, $subject, $message, $headers, $additional_parameters);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email'], $_POST['name'], $_POST['message'])) {
    $to = $_POST['email'];
    $subject = "Faleminderit për mesazhin tuaj!";

    $message = "Përshëndetje " . htmlspecialchars($_POST['name']) . ",\n\n";
    $message .= "Faleminderit që na kontaktuat. Mesazhi juaj u pranua me sukses.\n\n";
    $message .= "Kjo është një kopje e mesazhit që dërguat:\n";
    $message .= "------------------------------------------\n";
    $message .= htmlspecialchars($_POST['message']) . "\n";
    $message .= "------------------------------------------\n\n";
    $message .= "Ne do të përgjigjemi sa më shpejt të jetë e mundur.\n";
    $message .= "Tungjatjeta,\n";
    $message .= "Ekipi i Skating School";

    $headers = "From: noreply@skatingschool.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $additional_parameters = "-fnoreply@skatingschool.com";

    @mail($to, $subject, $message, $headers, $additional_parameters);
}
?>
*/