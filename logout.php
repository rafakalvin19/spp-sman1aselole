<?php
session_start();
session_destroy();
$_SESSION['icon'] = "success";
$_SESSION['title'] = "Berhasil";
$_SESSION['text'] = "Anda Berhasil Logout !";
header('location: sign-in.php');
