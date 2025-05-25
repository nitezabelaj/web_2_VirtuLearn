<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["newsletterName"]) &&
    isset($_POST["newsletterEmail"])) {
 
    $name = trim($_POST["newsletterName"]);
    $email = trim($_POST["newsletterEmail"]);

    
    $errors = [];

    if (!preg_match("/^[a-zA-Z\\s]{2,50}$/", $name)) {
        $errors[] = "Emri nuk është valid.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email-i nuk është valid.";
    }

    if (!empty($errors)) {
        foreach ($errors as $err) {
            echo "<p style='color: red;'>$err</p>";
        }
        exit;
    }

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'amatraci1@gmail.com'; 
        $mail->Password   = 'zpusgflwjmjfrsbd'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('amatraci1@gmail.com', 'VirtuLearn Newsletter');
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Abonimi në Newsletter - VirtuLearn';
        $mail->Body    = "Faleminderit që u abonuat në newsletter-in tonë, $name!<br>Do të njoftoheni për kurset më të fundit.";
        $mail->AltBody = "Faleminderit që u abonuat në newsletter-in tonë, $name! Do të njoftoheni për kurset më të fundit.";

        $mail->send();
        echo "<p style='color: green;'>Email-i u dërgua me sukses.</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>Dërgimi i email-it dështoi: {$mail->ErrorInfo}</p>";
    }
}
?>