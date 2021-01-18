<?php

session_start();
$_SESSION["lres"] = 'logout';
session_destroy();
header("Location: login.php");
?>
