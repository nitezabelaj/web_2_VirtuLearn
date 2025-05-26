<?php
session_start();

// Kontrollo nëse forma është dërguar
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validimi bazë
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $_SESSION['error_message'] = "Ju lutem plotësoni të gjitha fushat!";
        header("Location: contact.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Email-i nuk është i vlefshëm!";
        header("Location: contact.php");
        exit();
    }

    // Mund të shtosh ruajtje në DB ose dërgim emaili këtu
    // Simulojmë një dërgim të suksesshëm:
    $_SESSION['success_message'] = "Mesazhi u dërgua me sukses!";

    // Kthehu në faqen contact
    header("Location: contact.php");
    exit();
} else {
    // Nëse dikush hyn direkt në këtë faqe
    $_SESSION['error_message'] = "Qasje e palejuar!";
    header("Location: contact.php");
    exit();
}
