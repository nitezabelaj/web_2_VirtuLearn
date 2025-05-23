

<?php
function error_handler($errno, $errstr, $errfile, $errline, $errcontext = null) {
    switch ($errno) {
        case E_USER_ERROR:
            $mesazhi = "Gabim kritik [$errno]: $errstr në linjën $errline në file $errfile \n";
            break;
        case E_USER_WARNING:
            $mesazhi = "Paralajmërim [$errno]: $errstr në linjën $errline në file $errfile \n";
            break;
        case E_USER_NOTICE:
            $mesazhi = "Njoftim [$errno]: $errstr në linjën $errline në file $errfile \n";
            break;
        default:
            $mesazhi = "Gabim [$errno]: $errstr në linjën $errline në file $errfile \n";
            break;
    }

    if (!is_dir("WebsiteErrors")) {
        mkdir("WebsiteErrors", 0777, true);
    }

    error_log($mesazhi, 3, "WebsiteErrors/errorLogs.log");

    if ($errno == E_USER_ERROR) {
        exit(1);
    }

    return true;
}

error_reporting(E_ALL);
set_error_handler("error_handler");

trigger_error("Ky është një njoftim testues", E_USER_NOTICE);
trigger_error("Ky është një paralajmërim testues", E_USER_WARNING);
trigger_error("Ky është një gabim kritik testues", E_USER_ERROR);

echo "Kjo nuk do të shfaqet";
?>
