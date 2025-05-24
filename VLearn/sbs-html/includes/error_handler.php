<?php
// Funksioni për regjistrimin e trajtuesit të gabimeve të personalizuara
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    $errorTypes = [
        E_ERROR => 'Gabim Kritik',
        E_WARNING => 'Paralajmërim',
        E_PARSE => 'Gabim Sintaksor',
        E_NOTICE => 'Njoftim',
        E_USER_ERROR => 'Gabim i Përdoruesit',
        E_USER_WARNING => 'Paralajmërim i Përdoruesit',
        E_USER_NOTICE => 'Njoftim i Përdoruesit'
    ];
    
    $errorType = $errorTypes[$errno] ?? 'Gabim i Panjohur';
    
    $errorMessage = "<div class='custom-error'>";
    $errorMessage .= "<strong>$errorType:</strong> $errstr<br>";
    $errorMessage .= "<small>Në skedarin: $errfile, rreshti: $errline</small>";
    $errorMessage .= "</div>";
    
    echo $errorMessage;
    
    // Mos lejo ekzekutimin e mëtejshëm për gabime kritike
    if ($errno == E_USER_ERROR) {
        die();
    }
    
    return true;
}

// Funksioni për shfaqjen e gabimeve të personalizuara
function shfaqGabim($mesazh, $tipi = 'e rregullt') {
    $klasa = '';
    switch ($tipi) {
        case 'kritike':
            $klasa = 'error-critical';
            break;
        case 'paralajmerim':
            $klasa = 'error-warning';
            break;
        case 'sukses':
            $klasa = 'error-success';
            break;
        default:
            $klasa = 'error-regular';
    }
    
    echo "<div class='custom-error $klasa'>";
    echo "<strong>Gabim:</strong> $mesazh";
    echo "</div>";
}

// Funksioni për shfaqjen e mesazheve të suksesit
function shfaqSukses($mesazh) {
    echo "<div class='custom-success'>";
    echo "<strong>Sukses:</strong> $mesazh";
    echo "</div>";
}

// Regjistro trajtuesin e gabimeve
set_error_handler("customErrorHandler");

// Përkufizime për gabimet e personalizuara
define('GABIM_DB_LIDHJE', 'Lidhja me bazën e të dhënave dështoi! Ju lutem kontaktoni administratorin.');
define('GABIM_PERDORUES_EKZISTON', 'Ky përdorues ekziston tashmë në sistem!');
define('GABIM_FJALEKALIMI', 'Fjalëkalimi duhet të ketë të paktën 6 karaktere!');
define('GABIM_EMAIL', 'Emaili i dhënë nuk është valid!');
define('GABIM_TE_DHENA', 'Ju lutem plotësoni të gjitha fushat e kërkuara!');

// Stilizimi i gabimeve
echo "<style>
    .custom-error {
        padding: 15px;
        margin: 10px 0;
        border-radius: 5px;
        font-family: Arial, sans-serif;
    }
    .error-regular {
        background-color: #ffe6e6;
        border-left: 5px solid #ff3333;
        color: #cc0000;
    }
    .error-critical {
        background-color: #ffcccc;
        border-left: 5px solid #ff0000;
        color: #990000;
        font-weight: bold;
    }
    .error-warning {
        background-color: #fff3cd;
        border-left: 5px solid #ffc107;
        color: #856404;
    }
    .error-success {
        background-color: #d4edda;
        border-left: 5px solid #28a745;
        color: #155724;
    }
    .custom-success {
        padding: 15px;
        margin: 10px 0;
        border-radius: 5px;
        background-color: #d4edda;
        border-left: 5px solid #28a745;
        color: #155724;
        font-family: Arial, sans-serif;
    }
</style>";
?>