<?php
require_once 'includes/error_handler.php';//A.Z
//Anita C
require_once 'config.php';
// test përfshin funksionin sanitizeInput()

$input = "<script>alert('hacked')</script> Hello world!";
$clean = sanitizeInput($input);

echo "Para pastrimit: $input<br>";
echo "Pas pastrimit: $clean";

