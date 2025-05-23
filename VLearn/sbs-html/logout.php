<?php
require_once 'includes/error_handler.php';//T.G
//AnitaC - P2 / Sessions
session_start();
session_unset();       
session_destroy();     
header('Location: login.php');
exit;
