<?php
//Anita C
require 'config.php'; // test përfshin funksionin sanitizeInput()

$input = "<script>alert('hacked')</script> Hello world!";
$clean = sanitizeInput($input);

echo "Para pastrimit: $input<br>";
echo "Pas pastrimit: $clean";

