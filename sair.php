<?php


session_start();

unset($_SESSION['funcionarioRai']);

header('Location: index.php');
//echo "<script>window.location='../../login.php';</script>";
