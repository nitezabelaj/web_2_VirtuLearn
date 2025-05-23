<?php
//AnitaC - P2 / Sessions
session_start();
session_unset();       
session_destroy();     
header('Location: login.php');
exit;
