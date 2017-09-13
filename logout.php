<?php ob_start();

session_start();

session_unset();

session_destroy();

//reconnect to login
header('location:login.php');